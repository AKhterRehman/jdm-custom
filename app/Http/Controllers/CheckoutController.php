<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ShippingOption;
use App\Models\TaxRate;
use App\Services\ShippoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Stripe\Checkout\Session as StripeSession;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function __construct(private readonly ShippoService $shippo)
    {
    }

    public function index(Request $request): View|RedirectResponse
    {
        $cart = $request->user()->activeCart();
        $cart->load(['items.product', 'items.variation']);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $addresses = $request->user()->addresses()->latest()->get();
        $coupon = $this->sessionCoupon($request);

        $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();
        $shipping = $defaultAddress ? $this->quoteShipping($defaultAddress, $cart->items) : ['amount' => 0.0, 'carrier' => null, 'service_level' => null];

        $totals = $this->calculateTotals($cart->subtotal(), $coupon, $shipping['amount']);

        return view('checkout.index', compact('cart', 'addresses', 'coupon', 'totals', 'shipping'));
    }

    /**
     * Live shipping quote, called via fetch() when the customer picks/edits an address on the
     * checkout page. Purely for display, the authoritative price is recomputed in store().
     */
    public function shippingRate(Request $request): JsonResponse
    {
        $cart = $request->user()->activeCart();
        $cart->load(['items.product', 'items.variation']);

        $address = $this->resolveAddress($request, persist: false);
        $shipping = $this->quoteShipping($address, $cart->items);
        $coupon = $this->sessionCoupon($request);
        $totals = $this->calculateTotals($cart->subtotal(), $coupon, $shipping['amount']);

        return response()->json(['shipping' => $shipping, 'totals' => $totals]);
    }

    public function applyCoupon(Request $request): RedirectResponse
    {
        $validated = $request->validate(['code' => ['required', 'string']]);

        $cart = $request->user()->activeCart();
        $coupon = Coupon::where('code', $validated['code'])->first();

        if (! $coupon || ! $coupon->isValidFor($cart->subtotal())) {
            return back()->withErrors(['code' => 'This coupon is invalid or expired.']);
        }

        $request->session()->put('checkout.coupon_code', $coupon->code);

        return back()->with('status', 'Coupon applied.');
    }

    public function removeCoupon(Request $request): RedirectResponse
    {
        $request->session()->forget('checkout.coupon_code');

        return back()->with('status', 'Coupon removed.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address_id' => ['nullable', 'exists:addresses,id'],
            'new_address.full_name' => ['nullable', 'required_without:address_id', 'string', 'max:255'],
            'new_address.phone' => ['nullable', 'required_without:address_id', 'string', 'max:50'],
            'new_address.address_line1' => ['nullable', 'required_without:address_id', 'string', 'max:255'],
            'new_address.address_line2' => ['nullable', 'string', 'max:255'],
            'new_address.city' => ['nullable', 'required_without:address_id', 'string', 'max:255'],
            'new_address.state' => ['nullable', 'string', 'max:255'],
            'new_address.postal_code' => ['nullable', 'string', 'max:50'],
            'new_address.country' => ['nullable', 'required_without:address_id', 'string', 'max:255'],
            'payment_method' => ['required', 'in:cod,stripe'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $request->user()->activeCart();
        $cart->load(['items.product', 'items.variation']);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $address = $validated['address_id'] ?? null
            ? $request->user()->addresses()->findOrFail($validated['address_id'])
            : $request->user()->addresses()->create($validated['new_address']);

        // Recomputed here rather than trusted from the client, so the charged amount can
        // never be manipulated via the page's hidden fields.
        $shipping = $this->quoteShipping($address, $cart->items);
        $coupon = $this->sessionCoupon($request);
        $subtotal = $cart->subtotal();
        $totals = $this->calculateTotals($subtotal, $coupon, $shipping['amount']);

        $order = DB::transaction(function () use ($request, $cart, $address, $shipping, $coupon, $totals, $validated) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'address_id' => $address->id,
                'coupon_id' => $coupon?->id,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'subtotal' => $totals['subtotal'],
                'discount_amount' => $totals['discount'],
                'shipping_amount' => $totals['shipping'],
                'tax_amount' => $totals['tax'],
                'total' => $totals['total'],
                'notes' => $validated['notes'] ?? null,
                'carrier' => $shipping['carrier'],
                'service_level' => $shipping['service_level'],
                'shippo_shipment_id' => $shipping['shipment_id'] ?? null,
                'shippo_rate_id' => $shipping['rate_id'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_variation_id' => $item->product_variation_id,
                    'product_name' => $item->product->name,
                    'variation_label' => $item->variation?->attribute_value,
                    'unit_price' => $item->unitPrice(),
                    'quantity' => $item->quantity,
                    'line_total' => $item->lineTotal(),
                ]);

                $item->product->decrement('stock_quantity', min($item->quantity, $item->product->stock_quantity));
            }

            if ($coupon) {
                $coupon->increment('used_count');
            }

            $cart->items()->delete();

            return $order;
        });

        $request->session()->forget('checkout.coupon_code');

        if ($order->payment_method === 'stripe') {
            return redirect($this->createStripeSession($order)->url);
        }

        return redirect()->route('orders.show', $order)->with('status', 'Order placed successfully!');
    }

    public function retryStripePayment(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        abort_unless($order->payment_method === 'stripe' && $order->payment_status !== 'paid', 404);

        return redirect($this->createStripeSession($order)->url);
    }

    public function stripeSuccess(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $sessionId = $request->query('session_id');
        $stripe = new StripeClient(config('services.stripe.secret'));

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect()->route('orders.show', $order)->with('error', 'We could not confirm your payment. Please contact support.');
        }

        if ($session->id !== $order->stripe_session_id) {
            return redirect()->route('orders.show', $order)->with('error', 'This payment session does not match this order.');
        }

        if ($session->payment_status === 'paid') {
            $order->update(['payment_status' => 'paid']);

            return redirect()->route('orders.show', $order)->with('status', 'Payment successful! Your order is confirmed.');
        }

        return redirect()->route('orders.show', $order)->with('error', 'Payment was not completed.');
    }

    public function stripeCancel(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        return redirect()->route('orders.show', $order)->with('error', 'Payment was cancelled. You can try again from this order.');
    }

    private function createStripeSession(Order $order): StripeSession
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'customer_email' => $order->user->email,
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => (int) round($order->total * 100),
                    'product_data' => [
                        'name' => "JDM Custom Order {$order->order_number}",
                    ],
                ],
            ]],
            'success_url' => route('checkout.stripe.success', $order).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.stripe.cancel', $order),
        ]);

        $order->update(['stripe_session_id' => $session->id]);

        return $session;
    }

    private function sessionCoupon(Request $request): ?Coupon
    {
        $code = $request->session()->get('checkout.coupon_code');

        return $code ? Coupon::where('code', $code)->first() : null;
    }

    private function calculateTotals(float $subtotal, ?Coupon $coupon, float $shipping): array
    {
        $discount = ($coupon && $coupon->isValidFor($subtotal)) ? $coupon->discountFor($subtotal) : 0.0;
        $taxRate = TaxRate::where('is_active', true)->first();
        $taxable = max($subtotal - $discount, 0);
        $tax = $taxRate ? round($taxable * ((float) $taxRate->rate_percent / 100), 2) : 0.0;
        $total = round($taxable + $shipping + $tax, 2);

        return compact('subtotal', 'discount', 'shipping', 'tax', 'total');
    }

    /**
     * Live rate via Shippo, comparing UPS/USPS/FedEx and auto-picking the cheapest standard
     * service. Falls back to the cheapest active flat rate if Shippo is unreachable, unconfigured,
     * or the address can't be rated, so checkout never breaks.
     */
    private function quoteShipping(Address $address, $cartItems): array
    {
        try {
            if (! config('services.shippo.api_key')) {
                throw new \RuntimeException('Shippo is not configured yet.');
            }

            return $this->shippo->quoteForCart($address, $cartItems);
        } catch (\Throwable $e) {
            Log::warning('Shippo rate quote failed, using flat-rate fallback: '.$e->getMessage());

            $fallback = ShippingOption::where('is_active', true)->orderBy('cost')->first();

            return [
                'amount' => $fallback ? (float) $fallback->cost : 0.0,
                'carrier' => null,
                'service_level' => $fallback ? $fallback->name.' (estimated)' : null,
                'shipment_id' => null,
                'rate_id' => null,
            ];
        }
    }

    private function resolveAddress(Request $request, bool $persist): Address
    {
        if ($request->filled('address_id')) {
            return $request->user()->addresses()->findOrFail($request->input('address_id'));
        }

        $data = $request->validate([
            'new_address.address_line1' => ['required', 'string', 'max:255'],
            'new_address.address_line2' => ['nullable', 'string', 'max:255'],
            'new_address.city' => ['required', 'string', 'max:255'],
            'new_address.state' => ['nullable', 'string', 'max:255'],
            'new_address.postal_code' => ['nullable', 'string', 'max:50'],
            'new_address.country' => ['required', 'string', 'max:255'],
            'new_address.full_name' => ['nullable', 'string', 'max:255'],
            'new_address.phone' => ['nullable', 'string', 'max:50'],
        ])['new_address'];

        if ($persist) {
            return $request->user()->addresses()->create($data);
        }

        return new Address($data);
    }
}
