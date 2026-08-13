<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        $product->load([
            'images',
            'specifications',
            'variations',
            'category',
            'reviews' => fn ($query) => $query->where('is_approved', true)->with('user'),
        ]);

        $reviewCount = $product->reviews->count();
        $averageRating = $reviewCount > 0 ? round($product->reviews->avg('rating'), 1) : 0;
        $hasDeliveredOrder = false;
        $hasReviewed = false;

        if (auth()->check()) {
            $hasDeliveredOrder = $this->userHasDeliveredOrderForProduct(auth()->id(), $product->id);
            $hasReviewed = $product->reviews()
                ->where('user_id', auth()->id())
                ->exists();
        }

        $canReview = $hasDeliveredOrder && ! $hasReviewed;

        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact(
            'product',
            'relatedProducts',
            'reviewCount',
            'averageRating',
            'canReview',
            'hasDeliveredOrder',
            'hasReviewed',
        ));
    }

    public function submitReview(Request $request, Product $product): RedirectResponse
    {
        if ($product->reviews()->where('user_id', $request->user()->id)->exists()) {
            return redirect()
                ->route('product.show', $product)
                ->withFragment('reviews')
                ->withErrors(['review' => 'You have already reviewed this product.'], 'review');
        }

        if (! $this->userHasDeliveredOrderForProduct($request->user()->id, $product->id)) {
            return redirect()
                ->route('product.show', $product)
                ->withFragment('reviews')
                ->withErrors(['review' => 'You can review this product after one of your orders containing it is delivered.'], 'review');
        }

        $validated = $request->validateWithBag('review', [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'string', 'min:10', 'max:1000'],
            'images' => ['nullable', 'array', 'max:6'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'videos' => ['nullable', 'array', 'max:3'],
            'videos.*' => ['file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:20480'],
        ]);

        $imagePaths = [];
        $videoPaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $imagePaths[] = $image->store('product-reviews', 'public');
                }
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                if ($video && $video->isValid()) {
                    $videoPaths[] = $video->store('product-reviews', 'public');
                }
            }
        }

        $payload = [];

        if ($imagePaths !== []) {
            $payload['images'] = $imagePaths;
        }

        if ($videoPaths !== []) {
            $payload['videos'] = $videoPaths;
        }

        $product->reviews()->create([
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'image_path' => $payload !== [] ? json_encode($payload) : null,
            'is_approved' => true,
        ]);

        return redirect()
            ->route('product.show', $product)
            ->withFragment('reviews')
            ->with('review_status', 'Thanks for sharing your review. We appreciate your feedback!');
    }

    private function userHasDeliveredOrderForProduct(int $userId, int $productId): bool
    {
        return Order::where('user_id', $userId)
            ->where('status', 'delivered')
            ->whereHas('items', fn ($query) => $query->where('product_id', $productId))
            ->exists();
    }
}
