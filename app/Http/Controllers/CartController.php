<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->user()->activeCart();
        $cart->load(['items.product.images', 'items.variation']);

        return view('cart.index', compact('cart'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_variation_id' => ['nullable', 'exists:product_variations,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['product_variation_id'] ?? null) {
            ProductVariation::where('id', $validated['product_variation_id'])
                ->where('product_id', $product->id)
                ->firstOrFail();
        }

        $cart = $request->user()->activeCart();

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->where('product_variation_id', $validated['product_variation_id'] ?? null)
            ->first();

        if ($item) {
            $item->increment('quantity', $validated['quantity']);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'product_variation_id' => $validated['product_variation_id'] ?? null,
                'quantity' => $validated['quantity'],
            ]);
        }

        return back()->with('status', 'Added to cart.');
    }

    public function update(Request $request, int $cartItem): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $item = $request->user()->activeCart()->items()->findOrFail($cartItem);
        $item->update(['quantity' => $validated['quantity']]);

        return back()->with('status', 'Cart updated.');
    }

    public function destroy(Request $request, int $cartItem): RedirectResponse
    {
        $request->user()->activeCart()->items()->findOrFail($cartItem)->delete();

        return back()->with('status', 'Item removed.');
    }
}
