<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'rate_percent', 'is_active'])]
class TaxRate extends Model
{
    protected function casts(): array
    {
        return [
            'rate_percent' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
