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
            'Engraving' => 'Timeless designs, etched with precision into premium hardwoods.',
            'CNC Creations' => 'Precision-cut frames, plaques, and wall art for intricate, custom designs.',
            'Shadow Boxes' => 'Bring your stories to life with detailed, handcrafted memory displays.',
            'Jewelry Boxes' => 'Elegant handcrafted homes for your cherished treasures.',
            'Custom Epoxy Signs' => 'River-style epoxy pours over hand-carved signage and wall art.',
            '3D CNC Models' => 'Layered, dimensional wood art carved with modern CNC precision.',
            'Custom Murals' => 'Transform a wall into a one-of-a-kind wooden work of art.',
            'Custom Signs' => 'Your vision, beautifully carved and displayed.',
            'Custom Board Games' => 'Fun and memories, handcrafted and personalized for you.',
        ];

        $order = 0;

        foreach ($categories as $name => $description) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $description,
                'is_active' => true,
                'sort_order' => $order++,
            ]);
        }
    }
}
