<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cart_id', 'product_id', 'product_variation_id', 'quantity'])]
class CartItem extends Model
{
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function unitPrice(): float
    {
        $price = (float) ($this->product->sale_price ?? $this->product->price);

        if ($this->variation) {
            $price += (float) $this->variation->price_adjustment;
        }

        return $price;
    }

    public function lineTotal(): float
    {
        return $this->unitPrice() * $this->quantity;
    }
}
