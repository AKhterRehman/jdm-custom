<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['product_id', 'user_id', 'rating', 'review', 'image_path', 'is_approved'])]
class ProductReview extends Model
{
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_approved' => 'boolean',
        ];
    }

    public function getImagePathsAttribute(): array
    {
        $value = $this->attributes['image_path'] ?? null;

        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        if (is_array($decoded) && isset($decoded['images']) && is_array($decoded['images'])) {
            return $decoded['images'];
        }

        return is_array($decoded) ? $decoded : [$value];
    }

    public function getVideoPathsAttribute(): array
    {
        $value = $this->attributes['image_path'] ?? null;

        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        if (is_array($decoded) && isset($decoded['videos']) && is_array($decoded['videos'])) {
            return $decoded['videos'];
        }

        return [];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
