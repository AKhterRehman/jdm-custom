<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\ShippingOption;
use App\Models\TaxRate;
use Illuminate\Database\Seeder;

class StoreConfigSeeder extends Seeder
{
    public function run(): void
    {
        ShippingOption::create(['name' => 'Standard Shipping', 'description' => '5-7 business days', 'cost' => 15.00, 'is_active' => true]);
        ShippingOption::create(['name' => 'Express Shipping', 'description' => '1-2 business days', 'cost' => 45.00, 'is_active' => true]);

        TaxRate::create(['name' => 'Standard Sales Tax', 'rate_percent' => 5.00, 'is_active' => true]);

        Coupon::create([
            'code' => 'JDM10',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 100,
            'max_uses' => 100,
            'expires_at' => now()->addMonths(6),
            'is_active' => true,
        ]);
    }
}
