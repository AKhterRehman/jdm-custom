<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Pieces rotated in the hero, in this order. Portrait photos of finished artwork only.
    private const FEATURED_SKUS = ['ETSY-4527500804', 'ETSY-4509718241', 'ETSY-4557513997', 'ETSY-4572892296', 'ETSY-4536305716'];

    // Pieces that lead the collection index, in this order, before everything else.
    private const LEAD_SKUS = ['JDM-PORSCHE-PLACEHOLDER', 'ETSY-4509718241', 'ETSY-4527500804'];

    // The marque each piece is made for, as it should read in the collection index.
    private const MARQUES = [
        'JDM-PORSCHE-PLACEHOLDER' => 'Porsche',
        'ETSY-4509718241' => 'Mercedes AMG',
        'ETSY-4527500804' => 'Lamborghini',
        'ETSY-4557513997' => 'Rolls Royce',
        'ETSY-4572892296' => 'Shelby Cobra',
        'ETSY-4515830776' => 'Aston Martin',
        'ETSY-4536309588' => 'Bentley',
        'ETSY-4492309936' => 'BMW M',
        'ETSY-4519594017' => 'Harley Davidson',
        'ETSY-4536305716' => 'Rolex',
    ];

    // Categories listed quietly under the automotive work.
    private const WORKSHOP_CATEGORIES = ['custom-epoxy-signs', 'cnc-creations', '3d-cnc-models', 'jewelry-boxes'];

    public function index(): View
    {
        $automotive = Category::where('slug', 'automotive-art')->where('is_active', true)->first();

        $pieces = $automotive
            ? Product::with(['images', 'category', 'variations'])
                ->where('is_active', true)
                ->where('category_id', $automotive->id)
                ->orderByDesc('price')
                ->orderBy('name')
                ->get()
                // Two near identical AMG listings exist; show one on the homepage.
                ->reject(fn (Product $product) => $product->sku === 'ETSY-4557588163')
                ->filter(fn (Product $product) => $product->images->isNotEmpty())
                ->values()
            : collect();

        $pieces->each(fn (Product $product) => $this->prepare($product));

        $collection = $this->ordered($pieces, self::LEAD_SKUS);

        $featured = collect(self::FEATURED_SKUS)
            ->map(fn (string $sku) => $pieces->firstWhere('sku', $sku))
            ->filter()
            ->values();

        if ($featured->isEmpty()) {
            $featured = $collection->take(5)->values();
        }

        $sizes = $this->standardSizes($pieces);

        $workshop = Category::whereIn('slug', self::WORKSHOP_CATEGORIES)
            ->where('is_active', true)
            ->get()
            ->sortBy(fn (Category $category) => array_search($category->slug, self::WORKSHOP_CATEGORIES))
            ->values();

        return view('home', compact('automotive', 'collection', 'featured', 'sizes', 'workshop'));
    }

    /** Put the given SKUs first (in order); everything else keeps its current order. */
    private function ordered(Collection $pieces, array $leadSkus): Collection
    {
        return $pieces
            ->sortBy(function (Product $product) use ($leadSkus) {
                $position = array_search($product->sku, $leadSkus, true);

                return $position === false ? 99 : $position;
            })
            ->values();
    }

    /**
     * Presentation values the homepage needs: a clean name, the marque, a "from" price,
     * and a lighter 900px copy of the photo when one exists.
     */
    private function prepare(Product $product): void
    {
        $name = trim(str($product->name)->before(' | ')->before(' – ')->toString());
        $image = $product->images->first();
        $src = $image->url();
        $aspect = 0.75;

        if (str_starts_with($image->path, '/images/')) {
            $light = '/images/catalog/hero/'.basename($image->path);

            if (is_file(public_path($light))) {
                $src = asset($light);
            }

            $size = @getimagesize(public_path($image->path));
            if ($size && $size[1] > 0) {
                $aspect = round($size[0] / $size[1], 4);
            }
        }

        $sizePrices = $product->variations->whereNotNull('price')->pluck('price');
        $from = $sizePrices->isNotEmpty() ? min((float) $sizePrices->min(), (float) $product->price) : (float) $product->price;

        $product->setAttribute('display_name', $name);
        $product->setAttribute('marque', self::MARQUES[$product->sku] ?? $name);
        $product->setAttribute('plate_src', $src);
        $product->setAttribute('plate_aspect', $aspect);
        $product->setAttribute('from_price', $from);
    }

    /** The standard sizes and prices, read from the pieces so the page never drifts from the shop. */
    private function standardSizes(Collection $pieces): array
    {
        $variations = $pieces->flatMap(fn (Product $product) => $product->variations)
            ->where('attribute_name', 'Size')
            ->whereNotNull('price');

        return $variations
            ->groupBy('attribute_value')
            ->map(fn (Collection $group, string $label) => [
                'label' => $label,
                'inches' => (int) preg_replace('/\D/', '', $label),
                'price' => (float) $group->min('price'),
            ])
            ->filter(fn (array $size) => $size['inches'] > 0)
            ->sortBy('inches')
            ->values()
            ->all();
    }
}
