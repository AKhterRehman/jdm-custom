<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\ShippingOption;
use App\Models\TaxRate;
use App\Services\OrderInventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Stripe\Checkout\Session as StripeSession;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $cart = $request->user()->activeCart();
        $cart->load(['items.product', 'items.variation']);
        $cart->setRelation('items', $this->selectedCartItems($request, $cart));

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $addresses = $request->user()->addresses()->latest()->get();
        $shippingOptions = ShippingOption::where('is_active', true)->get();
        $coupon = $this->sessionCoupon($request);

        $totals = $this->calculateTotals($cart->items->sum(fn ($item) => $item->lineTotal()), $coupon, $shippingOptions->first());

        return view('checkout.index', compact('cart', 'addresses', 'shippingOptions', 'coupon', 'totals'));
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

    public function store(Request $request, OrderInventoryService $inventory): RedirectResponse
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
            'shipping_option_id' => ['required', 'exists:shipping_options,id'],
            'payment_method' => ['required', 'in:cod,stripe'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $request->user()->activeCart();
        $cart->load(['items.product', 'items.variation']);
        $cart->setRelation('items', $this->selectedCartItems($request, $cart));

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $address = $validated['address_id'] ?? null
            ? $request->user()->addresses()->findOrFail($validated['address_id'])
            : $request->user()->addresses()->create($validated['new_address']);

        $shippingOption = ShippingOption::where('is_active', true)->findOrFail($validated['shipping_option_id']);
        $coupon = $this->sessionCoupon($request);
        $subtotal = $cart->items->sum(fn ($item) => $item->lineTotal());
        $totals = $this->calculateTotals($subtotal, $coupon, $shippingOption);

        $order = DB::transaction(function () use ($request, $cart, $address, $shippingOption, $coupon, $totals, $validated, $inventory) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'address_id' => $address->id,
                'shipping_option_id' => $shippingOption->id,
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

            }

            $inventory->reserve($order);

            if ($coupon) {
                $coupon->increment('used_count');
            }

            $cart->items()->whereKey($cart->items->modelKeys())->delete();

            return $order;
        });

        $request->session()->forget(['checkout.coupon_code', 'checkout.selected_cart_item_ids']);

        if ($order->payment_method === 'stripe') {
            try {
                return redirect($this->createStripeSession($order)->url);
            } catch (\Throwable $exception) {
                $this->releaseFailedOrder($order, $inventory);

                report($exception);

                return redirect()->route('orders.show', $order)->with('error', 'We could not start secure card checkout. No payment was taken and your stock reservation was released.');
            }
        }

        return redirect()->route('orders.show', $order)->with('status', 'Order placed successfully!');
    }

    public function retryStripePayment(Request $request, Order $order, OrderInventoryService $inventory): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        abort_unless($order->payment_method === 'stripe' && $order->payment_status !== 'paid', 404);

        DB::transaction(function () use ($order, $inventory) {
            $lockedOrder = Order::query()->with('coupon')->lockForUpdate()->findOrFail($order->id);
            $inventory->reserve($lockedOrder);

            if ($lockedOrder->coupon && $lockedOrder->payment_status === 'failed') {
                $lockedOrder->coupon()->increment('used_count');
            }

            // Ignore late events from the old checkout session while a new one
            // is being created below.
            $lockedOrder->update([
                'payment_status' => 'pending',
                'status' => 'pending',
                'stripe_session_id' => null,
            ]);
        });

        try {
            return redirect($this->createStripeSession($order->fresh('user'))->url);
        } catch (\Throwable $exception) {
            $this->releaseFailedOrder($order, $inventory);

            report($exception);

            return back()->with('error', 'We could not restart card checkout. No payment was taken and your stock reservation was released.');
        }
    }

    public function stripeSuccess(Request $request, Order $order, OrderInventoryService $inventory): RedirectResponse
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
            DB::transaction(function () use ($order, $inventory) {
                $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);

                if ($lockedOrder->payment_status !== 'paid') {
                    $lockedOrder->update(['payment_status' => 'paid', 'status' => 'processing']);
                }
            });

            return redirect()->route('orders.show', $order)->with('status', 'Payment successful! Your order is confirmed.');
        }

        return redirect()->route('orders.show', $order)->with('error', 'Payment was not completed.');
    }

    public function stripeCancel(Request $request, Order $order, OrderInventoryService $inventory): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if ($order->stripe_session_id) {
            try {
                (new StripeClient(config('services.stripe.secret')))->checkout->sessions->expire($order->stripe_session_id);
            } catch (\Throwable $exception) {
                report($exception);

                // If Stripe already expired the session, it is still safe to
                // release. For an open/unknown session we keep the reservation
                // so a real payment can never be discarded.
                try {
                    $session = (new StripeClient(config('services.stripe.secret')))->checkout->sessions->retrieve($order->stripe_session_id);
                } catch (\Throwable) {
                    return redirect()->route('orders.show', $order)->with('error', 'We could not confirm cancellation yet. Please try again shortly.');
                }

                if ($session->payment_status === 'paid') {
                    DB::transaction(function () use ($order, $inventory) {
                        $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);
                        $lockedOrder->update(['payment_status' => 'paid', 'status' => 'processing']);
                    });

                    return redirect()->route('orders.show', $order)->with('status', 'Payment was already successful. Your order is confirmed.');
                }

                if ($session->status === 'open') {
                    return redirect()->route('orders.show', $order)->with('error', 'We could not cancel the secure payment session yet. Please try again shortly.');
                }
            }
        }

        $this->releaseFailedOrder($order, $inventory);

        return redirect()->route('orders.show', $order)->with('error', 'Payment was cancelled. No payment was taken and reserved stock has been returned.');
    }

    private function createStripeSession(Order $order): StripeSession
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'customer_email' => $order->user->email,
            'client_reference_id' => (string) $order->id,
            'metadata' => [
                'order_id' => (string) $order->id,
                'order_number' => $order->order_number,
            ],
            'payment_intent_data' => [
                'metadata' => [
                    'order_id' => (string) $order->id,
                    'order_number' => $order->order_number,
                ],
            ],
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
    private function releaseFailedOrder(Order $order, OrderInventoryService $inventory): void
    {
        DB::transaction(function () use ($order, $inventory) {
            $lockedOrder = Order::query()->with('coupon')->lockForUpdate()->findOrFail($order->id);

            if ($lockedOrder->payment_status === 'paid') {
                return;
            }

            $stockReleased = $inventory->release($lockedOrder);

            if ($stockReleased && $lockedOrder->coupon) {
                $lockedOrder->coupon()->decrement('used_count');
            }

            $lockedOrder->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        });
    }

    private function sessionCoupon(Request $request): ?Coupon
    {
        $code = $request->session()->get('checkout.coupon_code');

        return $code ? Coupon::where('code', $code)->first() : null;
    }

    private function selectedCartItems(Request $request, $cart)
    {
        if ($request->has('cart_item_ids')) {
            $selectedIds = collect($request->input('cart_item_ids', []))
                ->filter(fn ($id) => is_numeric($id))
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all();

            $request->session()->put('checkout.selected_cart_item_ids', $selectedIds);
        }

        $selectedIds = $request->session()->get('checkout.selected_cart_item_ids');

        return empty($selectedIds)
            ? $cart->items
            : $cart->items->whereIn('id', $selectedIds)->values();
    }

    private function calculateTotals(float $subtotal, ?Coupon $coupon, ?ShippingOption $shippingOption): array
    {
        $discount = ($coupon && $coupon->isValidFor($subtotal)) ? $coupon->discountFor($subtotal) : 0.0;
        $shipping = $shippingOption ? (float) $shippingOption->cost : 0.0;
        $taxRate = TaxRate::where('is_active', true)->first();
        $taxable = max($subtotal - $discount, 0);
        $tax = $taxRate ? round($taxable * ((float) $taxRate->rate_percent / 100), 2) : 0.0;
        $total = round($taxable + $shipping + $tax, 2);

        return compact('subtotal', 'discount', 'shipping', 'tax', 'total');
    }
}
