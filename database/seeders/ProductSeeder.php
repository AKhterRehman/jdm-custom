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
            'Engraving' => [
                [
                    'name' => 'Engraved Walnut Nameplate', 'price' => 65.00, 'sale_price' => null,
                    'description' => 'A hand-engraved walnut nameplate for a desk, door, or gift, clean lettering cut deep into solid hardwood.',
                    'specs' => ['Material' => 'Solid Walnut', 'Finish' => 'Hand-Rubbed Oil', 'Dimensions' => '8in x 3in'],
                ],
                [
                    'name' => 'Custom Engraved Cutting Board', 'price' => 85.00, 'sale_price' => 75.00,
                    'description' => 'A food-safe maple cutting board engraved with a name, date, or design, a lasting piece for the kitchen or a wedding gift.',
                    'specs' => ['Material' => 'Maple Wood', 'Finish' => 'Food-Safe Mineral Oil', 'Dimensions' => '12in x 8in'],
                ],
            ],
            'CNC Creations' => [
                [
                    'name' => 'Alabama Frame', 'price' => 150.00, 'sale_price' => null,
                    'description' => 'A layered wooden state-pride frame, CNC-cut and hand-finished for a bold, dimensional look on any wall.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '16in x 16in'],
                ],
                [
                    'name' => 'Custom Firefighter Maltese Cross', 'price' => 150.00, 'sale_price' => null,
                    'description' => 'A tribute piece for first responders — a Maltese cross CNC-carved with fine detail and a durable protective finish.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Satin Sealant', 'Dimensions' => '18in x 18in'],
                ],
                [
                    'name' => 'Steelers Frame', 'price' => 130.00, 'sale_price' => null,
                    'description' => 'Show your team pride with this layered CNC-cut team frame, built to hang and last.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '14in x 14in'],
                ],
                [
                    'name' => 'Kansas City Chiefs Rounded', 'price' => 35.00, 'sale_price' => null,
                    'description' => 'A compact rounded team-pride piece, perfect for a shelf, office desk, or man cave wall.',
                    'specs' => ['Material' => 'Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '6in diameter'],
                    'variations' => [
                        ['attribute_name' => 'Color', 'attribute_value' => 'Natural Wood', 'price_adjustment' => 0],
                        ['attribute_name' => 'Color', 'attribute_value' => 'Red & Gold', 'price_adjustment' => 10],
                    ],
                ],
                [
                    'name' => 'Custom Band Cover Art', 'price' => 85.00, 'sale_price' => null,
                    'description' => 'A favorite album cover reimagined as layered wood wall art — a striking piece for any music lover.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '12in x 12in'],
                ],
            ],
            'Shadow Boxes' => [
                [
                    'name' => 'Memorial Shadow Box', 'price' => 180.00, 'sale_price' => null,
                    'description' => 'A deep-set display case for medals, photos, and keepsakes — built to preserve and honor a lifetime of memories.',
                    'specs' => ['Material' => 'Solid Oak', 'Finish' => 'Glass Front, Sealed', 'Dimensions' => '20in x 16in x 3in'],
                ],
                [
                    'name' => 'Military Service Shadow Box', 'price' => 220.00, 'sale_price' => 199.00,
                    'description' => 'A custom-built display for service medals, patches, and photographs, finished to honor years of service.',
                    'specs' => ['Material' => 'Solid Walnut', 'Finish' => 'Glass Front, Sealed', 'Dimensions' => '24in x 18in x 3in'],
                ],
            ],
            'Jewelry Boxes' => [
                [
                    'name' => 'Classic Wooden Jewelry Box', 'price' => 120.00, 'sale_price' => null,
                    'description' => 'A multi-compartment jewelry box crafted from premium wood with a soft interior lining to protect your collection.',
                    'specs' => ['Material' => 'Solid Cherry Wood', 'Finish' => 'Hand-Rubbed Oil', 'Dimensions' => '10in x 7in x 4in'],
                ],
                [
                    'name' => 'Elegant Mirror Jewelry Box', 'price' => 160.00, 'sale_price' => 145.00,
                    'description' => 'A jewelry box with a built-in mirrored lid, felt-lined trays, and a timeless design that suits any bedroom decor.',
                    'specs' => ['Material' => 'Solid Maple', 'Finish' => 'Satin Lacquer', 'Dimensions' => '11in x 8in x 5in'],
                ],
                [
                    'name' => 'Personalized Jewelry Box', 'price' => 150.00, 'sale_price' => null,
                    'description' => 'A custom-engraved jewelry box made to order — a name, date, or short message engraved on the lid.',
                    'specs' => ['Material' => 'Solid Walnut', 'Finish' => 'Hand-Rubbed Oil', 'Dimensions' => '9in x 6in x 4in'],
                    'variations' => [
                        ['attribute_name' => 'Size', 'attribute_value' => 'Small', 'price_adjustment' => 0],
                        ['attribute_name' => 'Size', 'attribute_value' => 'Large', 'price_adjustment' => 40],
                    ],
                ],
            ],
            'Custom Epoxy Signs' => [
                [
                    'name' => 'River Epoxy House Sign', 'price' => 190.00, 'sale_price' => null,
                    'description' => 'A house address sign with a hand-poured epoxy river running through hand-carved numbers and wood grain.',
                    'specs' => ['Material' => 'Pine & Epoxy Resin', 'Finish' => 'UV-Resistant Gloss', 'Dimensions' => '18in x 10in'],
                ],
                [
                    'name' => 'Ocean Wave Epoxy Wall Art', 'price' => 240.00, 'sale_price' => 210.00,
                    'description' => 'A wave-patterned epoxy pour over shaped wood, capturing ocean-blue tones for a striking statement piece.',
                    'specs' => ['Material' => 'Birch & Epoxy Resin', 'Finish' => 'High-Gloss Sealant', 'Dimensions' => '30in x 12in'],
                ],
            ],
            '3D CNC Models' => [
                [
                    'name' => 'Classic Scroll 3D CNC Model', 'price' => 270.00, 'sale_price' => null,
                    'description' => 'Intricate scrolling patterns carved for decorative furniture accents, architectural trim, or ornamental wall panels.',
                    'specs' => ['Material' => 'MDF / Hardwood', 'Finish' => 'Ready to Paint or Stain', 'Dimensions' => '24in x 24in'],
                ],
                [
                    'name' => 'Geometric 3D CNC Model', 'price' => 250.00, 'sale_price' => null,
                    'description' => 'A layered geometric relief carving with crisp dimensional lines, suited to modern interiors.',
                    'specs' => ['Material' => 'MDF / Hardwood', 'Finish' => 'Ready to Paint or Stain', 'Dimensions' => '20in x 20in'],
                ],
                [
                    'name' => 'Decorative Floral 3D CNC Model', 'price' => 300.00, 'sale_price' => 270.00,
                    'description' => 'A botanical relief design with deep dimensional carving, ideal as a statement wall piece.',
                    'specs' => ['Material' => 'MDF / Hardwood', 'Finish' => 'Ready to Paint or Stain', 'Dimensions' => '26in x 26in'],
                ],
            ],
            'Custom Murals' => [
                [
                    'name' => 'Family Tree Wall Mural', 'price' => 350.00, 'sale_price' => null,
                    'description' => 'A large-format layered wood mural personalized with family names carved into the branches.',
                    'specs' => ['Material' => 'Plywood Panels', 'Finish' => 'Matte Sealant', 'Dimensions' => '48in x 36in'],
                ],
                [
                    'name' => 'Landscape Wood Mural', 'price' => 400.00, 'sale_price' => 360.00,
                    'description' => 'A multi-panel layered landscape scene, hand-finished to add depth and warmth to any large wall.',
                    'specs' => ['Material' => 'Plywood Panels', 'Finish' => 'Matte Sealant', 'Dimensions' => '60in x 30in'],
                ],
            ],
            'Custom Signs' => [
                [
                    'name' => 'Custom Business Sign', 'price' => 100.00, 'sale_price' => null,
                    'description' => 'A hand-carved wooden sign for a storefront, office, or home business, finished for indoor or outdoor use.',
                    'specs' => ['Material' => 'Cedar', 'Finish' => 'Weather-Resistant Sealant', 'Dimensions' => '24in x 12in'],
                ],
                [
                    'name' => 'Custom Address Sign', 'price' => 95.00, 'sale_price' => null,
                    'description' => 'A carved house-number sign built to hold up outdoors while adding a handcrafted touch to your entryway.',
                    'specs' => ['Material' => 'Cedar', 'Finish' => 'Weather-Resistant Sealant', 'Dimensions' => '16in x 8in'],
                ],
            ],
            'Custom Board Games' => [
                [
                    'name' => 'Build-Your-Own Game Kit', 'price' => 220.00, 'sale_price' => null,
                    'description' => 'A fully custom wooden board game built to your own rules and layout — a one-of-a-kind piece for family game night.',
                    'specs' => ['Material' => 'Hardwood Board & Pieces', 'Finish' => 'Satin Lacquer', 'Dimensions' => '20in x 20in'],
                ],
                [
                    'name' => 'Custom Game Pieces Set', 'price' => 150.00, 'sale_price' => null,
                    'description' => 'A hand-turned set of wooden game pieces, custom-shaped and finished to match your favorite game.',
                    'specs' => ['Material' => 'Hardwood', 'Finish' => 'Satin Lacquer', 'Dimensions' => 'Set of 32 pieces'],
                ],
                [
                    'name' => 'Personalized Game Board', 'price' => 220.00, 'sale_price' => 195.00,
                    'description' => 'A classic game board engraved with a family name and date, built to become a keepsake as much as a game.',
                    'specs' => ['Material' => 'Solid Maple', 'Finish' => 'Satin Lacquer', 'Dimensions' => '18in x 18in'],
                ],
            ],
        ];

        $skuCounter = 1000;

        foreach ($catalog as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->firstOrFail();

            foreach ($products as $index => $data) {
                $slug = Str::slug($data['name']);

                $product = Product::firstOrCreate(['slug' => $slug], [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'slug' => $slug,
                    'short_description' => Str::limit($data['description'], 100),
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'sale_price' => $data['sale_price'],
                    'sku' => 'JDM-'.$skuCounter++,
                    'total_stock_quantity' => $stockQuantity = fake()->numberBetween(0, 25),
                    'available_stock_quantity' => $stockQuantity,
                    'is_active' => true,
                    'is_featured' => $index === 0,
                ]);

                if (! $product->wasRecentlyCreated) {
                    continue;
                }

                $product->images()->create([
                    'path' => 'https://placehold.co/600x600?text='.urlencode($data['name']),
                    'alt_text' => $data['name'],
                    'sort_order' => 0,
                ]);

                $sortOrder = 0;
                foreach ($data['specs'] as $key => $value) {
                    $product->specifications()->create([
                        'spec_key' => $key,
                        'spec_value' => $value,
                        'sort_order' => $sortOrder++,
                    ]);
                }

                if (! empty($data['variations'])) {
                    foreach ($data['variations'] as $variation) {
                        $product->variations()->create($variation + [
                            'sku' => $product->sku.'-'.Str::slug($variation['attribute_value']),
                            'stock_quantity' => fake()->numberBetween(0, 15),
                        ]);
                    }
                }
            }
        }
    }
}
