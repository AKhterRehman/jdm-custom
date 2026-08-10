<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderInventoryService
{
    /**
     * Reserve product and variation stock for an order.
     *
     * The method owns a transaction, so it remains safe when it is called by a
     * controller or a webhook. Nested Laravel transactions are supported.
     *
     * @throws ValidationException when live inventory is no longer sufficient
     */
    public function reserve(Order $order): void
    {
        DB::transaction(function () use ($order): void {
            $items = $order->items()->get();

            foreach ($items as $item) {
                $product = Product::query()->lockForUpdate()->findOrFail($item->product_id);
                $variation = $item->product_variation_id
                    ? ProductVariation::query()
                        ->whereKey($item->product_variation_id)
                        ->where('product_id', $product->id)
                        ->lockForUpdate()
                        ->firstOrFail()
                    : null;

                $available = $variation
                    ? min((int) $product->available_stock_quantity, (int) $variation->stock_quantity)
                    : (int) $product->available_stock_quantity;

                if ((int) $item->quantity > $available) {
                    throw ValidationException::withMessages([
                        'stock' => 'One or more items are no longer available in the requested quantity. Please update your cart and try again.',
                    ]);
                }

                $product->decrement('available_stock_quantity', $item->quantity);

                if ($variation) {
                    $variation->decrement('stock_quantity', $item->quantity);
                }
            }
        });
    }

    /**
     * Restore a failed/cancelled payment reservation exactly once.
     *
     * Returns true only when stock was actually returned. Callers use this to
     * restore coupon usage only on the first failed event as well.
     */
    public function release(Order $order): bool
    {
        return DB::transaction(function () use ($order): bool {
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);

            if (in_array($lockedOrder->payment_status, ['paid', 'failed'], true) || $lockedOrder->status === 'cancelled') {
                return false;
            }

            foreach ($lockedOrder->items()->get() as $item) {
                $product = Product::query()->lockForUpdate()->findOrFail($item->product_id);
                $product->available_stock_quantity = min(
                    (int) $product->total_stock_quantity,
                    (int) $product->available_stock_quantity + (int) $item->quantity,
                );
                $product->save();

                if ($item->product_variation_id) {
                    ProductVariation::query()
                        ->whereKey($item->product_variation_id)
                        ->where('product_id', $product->id)
                        ->lockForUpdate()
                        ->firstOrFail()
                        ->increment('stock_quantity', $item->quantity);
                }
            }

            return true;
        });
    }
}
