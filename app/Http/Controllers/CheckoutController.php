<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\ShippingOption;
use App\Models\TaxRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $cart = $request->user()->activeCart();
        $cart->load(['items.product', 'items.variation']);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $addresses = $request->user()->addresses()->latest()->get();
        $shippingOptions = ShippingOption::where('is_active', true)->get();
        $coupon = $this->sessionCoupon($request);

        $totals = $this->calculateTotals($cart->subtotal(), $coupon, $shippingOptions->first());

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

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address_id' => ['nullable', 'exists:addresses,id'],
            'new_address.full_name' => ['required_without:address_id', 'string', 'max:255'],
            'new_address.phone' => ['required_without:address_id', 'string', 'max:50'],
            'new_address.address_line1' => ['required_without:address_id', 'string', 'max:255'],
            'new_address.address_line2' => ['nullable', 'string', 'max:255'],
            'new_address.city' => ['required_without:address_id', 'string', 'max:255'],
            'new_address.state' => ['nullable', 'string', 'max:255'],
            'new_address.postal_code' => ['nullable', 'string', 'max:50'],
            'new_address.country' => ['required_without:address_id', 'string', 'max:255'],
            'shipping_option_id' => ['required', 'exists:shipping_options,id'],
            'payment_method' => ['required', 'in:cod'],
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

        $shippingOption = ShippingOption::findOrFail($validated['shipping_option_id']);
        $coupon = $this->sessionCoupon($request);
        $subtotal = $cart->subtotal();
        $totals = $this->calculateTotals($subtotal, $coupon, $shippingOption);

        $order = DB::transaction(function () use ($request, $cart, $address, $shippingOption, $coupon, $totals, $validated) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'address_id' => $address->id,
                'shipping_option_id' => $shippingOption->id,
                'coupon_id' => $coupon?->id,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending',
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

                $item->product->decrement('stock_quantity', min($item->quantity, $item->product->stock_quantity));
            }

            if ($coupon) {
                $coupon->increment('used_count');
            }

            $cart->items()->delete();

            return $order;
        });

        $request->session()->forget('checkout.coupon_code');

        return redirect()->route('orders.show', $order)->with('status', 'Order placed successfully!');
    }

    private function sessionCoupon(Request $request): ?Coupon
    {
        $code = $request->session()->get('checkout.coupon_code');

        return $code ? Coupon::where('code', $code)->first() : null;
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
