<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
        $this->addItem($request);

        return redirect()->route('cart.index')->with('status', 'Added to cart.');
    }

    public function quickAdd(Request $request): RedirectResponse
    {
        $this->addItem($request);

        return back()->with('status', 'Added to cart.');
    }

    public function buyNow(Request $request): RedirectResponse
    {
        $this->addItem($request);

        return redirect()->route('checkout.index')->with('status', 'Item added. Complete your order below.');
    }

    private function addItem(Request $request): void
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_variation_id' => ['nullable', 'exists:product_variations,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $variation = null;

        if ($validated['product_variation_id'] ?? null) {
            $variation = ProductVariation::where('id', $validated['product_variation_id'])
                ->where('product_id', $product->id)
                ->firstOrFail();
        }

        $cart = $request->user()->activeCart();

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->where('product_variation_id', $validated['product_variation_id'] ?? null)
            ->first();

        $requestedQuantity = (int) $validated['quantity'];
        $newQuantity = ($item?->quantity ?? 0) + $requestedQuantity;
        $availableStock = $this->availableStock($product, $variation);

        if ($newQuantity > $availableStock) {
            throw ValidationException::withMessages([
                'quantity' => $this->stockMessage($availableStock),
            ]);
        }

        if ($item) {
            $item->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'product_variation_id' => $validated['product_variation_id'] ?? null,
                'quantity' => $validated['quantity'],
            ]);
        }

    }

    public function update(Request $request, int $cartItem): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item = $request->user()->activeCart()->items()->with(['product', 'variation'])->findOrFail($cartItem);
        $availableStock = $this->availableStock($item->product, $item->variation);

        if ((int) $validated['quantity'] > $availableStock) {
            return back()->withErrors(['quantity' => $this->stockMessage($availableStock)]);
        }

        $item->update(['quantity' => (int) $validated['quantity']]);

        return back()->with('status', 'Cart updated.');
    }

    public function increment(Request $request, int $cartItem): RedirectResponse
    {
        $item = $request->user()->activeCart()->items()->with(['product', 'variation'])->findOrFail($cartItem);
        $availableStock = $this->availableStock($item->product, $item->variation);

        if ($item->quantity >= $availableStock) {
            return back()->withErrors(['quantity' => $this->stockMessage($availableStock)]);
        }

        $item->increment('quantity');

        return back()->with('status', 'Cart updated.');
    }

    public function decrement(Request $request, int $cartItem): RedirectResponse
    {
        $item = $request->user()->activeCart()->items()->findOrFail($cartItem);

        if ($item->quantity <= 1) {
            $item->delete();

            return back()->with('status', 'Item removed from cart.');
        }

        $item->decrement('quantity');

        return back()->with('status', 'Cart updated.');
    }

    public function destroy(Request $request, int $cartItem): RedirectResponse
    {
        $request->user()->activeCart()->items()->findOrFail($cartItem)->delete();

        return back()->with('status', 'Item removed.');
    }
    public function destroySelected(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cart_item_ids' => ['required', 'array', 'min:1'],
            'cart_item_ids.*' => ['integer'],
        ]);

        $deleted = $request->user()->activeCart()->items()
            ->whereIn('id', $validated['cart_item_ids'])
            ->delete();

        return back()->with('status', $deleted.' selected '.str('item')->plural($deleted).' removed.');
    }
    private function availableStock(Product $product, ?ProductVariation $variation = null): int
    {
        $productStock = max(0, (int) $product->available_stock_quantity);

        return $variation
            ? min($productStock, max(0, (int) $variation->stock_quantity))
            : $productStock;
    }

    private function stockMessage(int $availableStock): string
    {
        return $availableStock > 0
            ? 'The requested quantity is no longer available. Please update your cart quantity.'
            : 'Sorry, this item is now out of stock.';
    }
}
