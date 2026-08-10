<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ShopTest extends TestCase
{
    public function test_shop_can_filter_products_by_price_range(): void
    {
        $category = Category::create([
            'name' => 'Fixtures',
            'slug' => 'fixtures',
            'is_active' => true,
        ]);

        $inRangeProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'In Range Chair',
            'slug' => 'in-range-chair',
            'price' => 79.99,
            'sku' => 'in-range-chair',
            'total_stock_quantity' => 10,
            'available_stock_quantity' => 10,
            'is_active' => true,
        ]);

        $outOfRangeProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Out of Range Lamp',
            'slug' => 'out-of-range-lamp',
            'price' => 120.00,
            'sku' => 'out-of-range-lamp',
            'total_stock_quantity' => 10,
            'available_stock_quantity' => 10,
            'is_active' => true,
        ]);

        $response = $this->get(route('shop.index', ['min_price' => 50, 'max_price' => 100]));

        $response->assertOk();
        $response->assertSee($inRangeProduct->name);
        $response->assertDontSee($outOfRangeProduct->name);
    }
}
