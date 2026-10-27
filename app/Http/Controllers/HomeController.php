<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Etsy listing ids of the pieces shown large in the hero, in display order.
    private const HERO_SKUS = ['ETSY-4527500804', 'ETSY-4509718241', 'JDM-PORSCHE-PLACEHOLDER'];

    // Pieces that lead the collection grid, in this order, before everything else.
    private const LEAD_SKUS = ['JDM-PORSCHE-PLACEHOLDER', 'ETSY-4509718241', 'ETSY-4527500804'];

    // Categories surfaced as the quiet "from the workshop" row under the automotive collection.
    private const WORKSHOP_CATEGORIES = ['custom-epoxy-signs', 'cnc-creations', '3d-cnc-models', 'jewelry-boxes'];

    public function index(): View
    {
        $automotive = Category::where('slug', 'automotive-art')->where('is_active', true)->first();

        $collection = $automotive
            ? Product::with(['images', 'category'])
                ->where('is_active', true)
                ->where('category_id', $automotive->id)
                ->orderByDesc('price')
                ->orderBy('name')
                ->get()
                // Two near-identical AMG listings exist; show one on the homepage.
                ->reject(fn (Product $product) => $product->sku === 'ETSY-4557588163')
                ->sortBy(fn (Product $product) => array_search($product->sku, self::LEAD_SKUS, true) === false ? 99 : array_search($product->sku, self::LEAD_SKUS, true))
                ->values()
            : collect();

        $heroPieces = collect(self::HERO_SKUS)
            ->map(fn (string $sku) => $collection->firstWhere('sku', $sku))
            ->filter()
            ->values();

        if ($heroPieces->count() < 3) {
            $heroPieces = $collection->take(3)->values();
        }

        $workshop = Category::whereIn('slug', self::WORKSHOP_CATEGORIES)
            ->where('is_active', true)
            ->get()
            ->sortBy(fn (Category $category) => array_search($category->slug, self::WORKSHOP_CATEGORIES))
            ->map(function (Category $category) {
                $category->setRelation('cover', Product::with('images')
                    ->where('is_active', true)
                    ->where('category_id', $category->id)
                    ->whereHas('images')
                    ->first());

                return $category;
            })
            ->filter(fn (Category $category) => $category->cover)
            ->values();

        return view('home', compact('automotive', 'collection', 'heroPieces', 'workshop'));
    }
}
