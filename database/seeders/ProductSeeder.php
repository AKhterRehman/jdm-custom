<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            'Turbochargers' => [
                ['name' => 'GT2860 Ball Bearing Turbocharger', 'price' => 850.00, 'sale_price' => 749.00, 'variations' => null],
                ['name' => 'Blow-Off Valve Kit', 'price' => 129.99, 'sale_price' => null, 'variations' => null],
            ],
            'Intake Systems' => [
                ['name' => 'Cold Air Intake System', 'price' => 219.00, 'sale_price' => 189.00, 'variations' => null],
                ['name' => 'High-Flow Air Filter', 'price' => 59.99, 'sale_price' => null, 'variations' => null],
            ],
            'Front Bumpers' => [
                ['name' => 'Vented Front Bumper Kit', 'price' => 640.00, 'sale_price' => null, 'variations' => null],
                ['name' => 'Front Splitter Lip', 'price' => 149.00, 'sale_price' => 129.00, 'variations' => null],
            ],
            'Spoilers & Wings' => [
                ['name' => 'Carbon Fiber GT Wing', 'price' => 480.00, 'sale_price' => 429.00, 'variations' => null],
                ['name' => 'Ducktail Trunk Spoiler', 'price' => 189.00, 'sale_price' => null, 'variations' => null],
            ],
            'Wheels & Tires' => [
                ['name' => 'Forged Alloy Racing Wheel', 'price' => 320.00, 'sale_price' => null, 'variations' => [
                    ['attribute_name' => 'Size', 'attribute_value' => '17"', 'price_adjustment' => 0],
                    ['attribute_name' => 'Size', 'attribute_value' => '18"', 'price_adjustment' => 35.00],
                    ['attribute_name' => 'Size', 'attribute_value' => '19"', 'price_adjustment' => 75.00],
                ]],
                ['name' => 'Performance Street Tire', 'price' => 145.00, 'sale_price' => 119.00, 'variations' => null],
            ],
            'Exhaust Systems' => [
                ['name' => 'Cat-Back Exhaust System', 'price' => 560.00, 'sale_price' => 499.00, 'variations' => null],
                ['name' => 'Titanium Muffler Tip', 'price' => 89.00, 'sale_price' => null, 'variations' => null],
            ],
            'Suspension & Brakes' => [
                ['name' => 'Coilover Suspension Kit', 'price' => 780.00, 'sale_price' => 699.00, 'variations' => null],
                ['name' => 'Big Brake Kit (6-Piston)', 'price' => 950.00, 'sale_price' => null, 'variations' => null],
            ],
            'Interior Accessories' => [
                ['name' => 'Racing Bucket Seat', 'price' => 399.00, 'sale_price' => null, 'variations' => [
                    ['attribute_name' => 'Color', 'attribute_value' => 'Black', 'price_adjustment' => 0],
                    ['attribute_name' => 'Color', 'attribute_value' => 'Red', 'price_adjustment' => 0],
                ]],
                ['name' => 'Short Throw Shift Knob', 'price' => 45.00, 'sale_price' => 35.00, 'variations' => null],
            ],
        ];

        $skuCounter = 1000;

        foreach ($catalog as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->firstOrFail();

            foreach ($products as $index => $data) {
                $slug = Str::slug($data['name']);

                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'slug' => $slug,
                    'short_description' => "Premium {$data['name']} built for JDM performance builds.",
                    'description' => "The {$data['name']} delivers OEM-plus fitment and track-proven durability. Engineered and tested for daily-driven and track-day JDM platforms, backed by our quality guarantee.",
                    'price' => $data['price'],
                    'sale_price' => $data['sale_price'],
                    'sku' => 'JDM-'.$skuCounter++,
                    'stock_quantity' => fake()->numberBetween(0, 40),
                    'is_active' => true,
                    'is_featured' => $index === 0,
                ]);

                $product->images()->create([
                    'path' => 'https://placehold.co/600x600?text='.urlencode($data['name']),
                    'alt_text' => $data['name'],
                    'sort_order' => 0,
                ]);

                $product->specifications()->createMany([
                    ['spec_key' => 'Brand', 'spec_value' => 'JDM Custom', 'sort_order' => 0],
                    ['spec_key' => 'Material', 'spec_value' => 'Aircraft-Grade Aluminum', 'sort_order' => 1],
                    ['spec_key' => 'Warranty', 'spec_value' => '2 Years', 'sort_order' => 2],
                ]);

                if ($data['variations']) {
                    foreach ($data['variations'] as $variation) {
                        $product->variations()->create($variation + [
                            'sku' => $product->sku.'-'.Str::slug($variation['attribute_value']),
                            'stock_quantity' => fake()->numberBetween(0, 20),
                        ]);
                    }
                }
            }
        }
    }
}
