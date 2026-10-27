<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'category_id', 'name', 'slug', 'short_description', 'description',
    'price', 'sale_price', 'sku', 'total_stock_quantity', 'available_stock_quantity', 'is_active', 'is_featured',
    'weight_lbs', 'length_in', 'width_in', 'height_in', 'shipping_size_preset', 'uses_standard_size_pricing', 'stock_quantity',
])]
class Product extends Model
{
    /**
     * Imported listings carry long marketplace titles ("Name | keyword | keyword"). Storefront
     * lists and summaries show only the leading name.
     */
    public static function shortenName(string $name): string
    {
        return trim(str($name)->before(' | ')->before(' – ')->toString());
    }

    public function getShortNameAttribute(): string
    {
        return static::shortenName($this->name);
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'weight_lbs' => 'decimal:2',
            'length_in' => 'decimal:2',
            'width_in' => 'decimal:2',
            'height_in' => 'decimal:2',
        ];
    }

    /**
     * Shipping weight/dimensions, falling back to the configured "estimate high" preset
     * for any product that hasn't had its real package info set yet.
     */
    public function shippingParcel(): array
    {
        $fallback = config('shipping.presets.'.config('shipping.fallback_preset'));

        return [
            'weight_lbs' => (float) ($this->weight_lbs ?? $fallback['weight_lbs']),
            'length_in' => (float) ($this->length_in ?? $fallback['length_in']),
            'width_in' => (float) ($this->width_in ?? $fallback['width_in']),
            'height_in' => (float) ($this->height_in ?? $fallback['height_in']),
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class)->latest();
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function displayPrice(): string
    {
        return (string) ($this->sale_price ?? $this->price);
    }
}
