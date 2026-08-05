<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Engine Parts' => ['Turbochargers', 'Intake Systems'],
            'Body Kits & Aero' => ['Front Bumpers', 'Spoilers & Wings'],
            'Wheels & Tires' => [],
            'Exhaust Systems' => [],
            'Suspension & Brakes' => [],
            'Interior Accessories' => [],
        ];

        $order = 0;

        foreach ($categories as $name => $children) {
            $parent = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Shop premium {$name} for your JDM build.",
                'is_active' => true,
                'sort_order' => $order++,
            ]);

            foreach ($children as $childName) {
                Category::create([
                    'parent_id' => $parent->id,
                    'name' => $childName,
                    'slug' => Str::slug($name.' '.$childName),
                    'description' => "{$childName} under {$name}.",
                    'is_active' => true,
                    'sort_order' => $order++,
                ]);
            }
        }
    }
}
