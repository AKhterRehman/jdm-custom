<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Pieces that lead the hero slider, in this order (left, centre, right of the first slide).
    private const SLIDER_SKUS = ['ETSY-4509718241', 'ETSY-4527500804', 'JDM-PORSCHE-PLACEHOLDER'];

    // Pieces that lead the collection grid, in this order, before everything else.
    private const LEAD_SKUS = ['JDM-PORSCHE-PLACEHOLDER', 'ETSY-4509718241', 'ETSY-4527500804'];

    // Categories surfaced as the quiet "from the workshop" row under the automotive collection.
    private const WORKSHOP_CATEGORIES = ['custom-epoxy-signs', 'cnc-creations', '3d-cnc-models', 'jewelry-boxes'];

    public function index(): View
    {
        $automotive = Category::where('slug', 'automotive-art')->where('is_active', true)->first();

        $pieces = $automotive
            ? Product::with(['images', 'category'])
                ->where('is_active', true)
                ->where('category_id', $automotive->id)
                ->orderByDesc('price')
                ->orderBy('name')
                ->get()
                // Two near-identical AMG listings exist; show one on the homepage.
                ->reject(fn (Product $product) => $product->sku === 'ETSY-4557588163')
                ->values()
            : collect();

        $collection = $this->ordered($pieces, self::LEAD_SKUS);

        $sliderPieces = $this->ordered($pieces, self::SLIDER_SKUS)
            ->filter(fn (Product $product) => $product->images->isNotEmpty())
            ->each(fn (Product $product) => $this->prepareForSlider($product))
            ->values();

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

        return view('home', compact('automotive', 'collection', 'sliderPieces', 'workshop'));
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
     * The slider uses a lighter 900px copy of each photo when one exists, and keeps each
     * piece's natural proportions so wide and tall pieces are never cropped.
     */
    private function prepareForSlider(Product $product): void
    {
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

        $product->setAttribute('slider_src', $src);
        $product->setAttribute('slider_aspect', $aspect);
    }
}
