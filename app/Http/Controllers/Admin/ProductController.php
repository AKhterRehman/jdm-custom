<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->boolean('low_stock'), fn ($q) => $q->where('available_stock_quantity', '<=', 5))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['available_stock_quantity'] = $validated['total_stock_quantity'];

        $product = Product::create($validated);

        return redirect()->route('admin.products.edit', $product)->with('status', 'Product created.');
    }

    public function edit(Product $product): View
    {
        $product->load(['images', 'specifications', 'variations']);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validated($request, $product->id);
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $soldQuantity = max(0, $product->total_stock_quantity - $product->available_stock_quantity);
        $validated['available_stock_quantity'] = max(0, $validated['total_stock_quantity'] - $soldQuantity);

        $product->update($validated);

        return redirect()->route('admin.products.edit', $product)->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    public function storeImage(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:4096'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $path = $request->file('image')->store('products', 'public');

        $product->images()->create([
            'path' => $path,
            'alt_text' => $validated['alt_text'] ?? null,
            'sort_order' => $product->images()->count(),
        ]);

        return back()->with('status', 'Image added.');
    }

    public function destroyImage(Product $product, int $image): RedirectResponse
    {
        $productImage = $product->images()->findOrFail($image);

        if (! Str::startsWith($productImage->path, ['http://', 'https://'])) {
            Storage::disk('public')->delete($productImage->path);
        }

        $productImage->delete();

        return back()->with('status', 'Image removed.');
    }

    public function storeSpecification(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'spec_key' => ['required', 'string', 'max:255'],
            'spec_value' => ['required', 'string', 'max:255'],
        ]);

        $product->specifications()->create($validated + ['sort_order' => $product->specifications()->count()]);

        return back()->with('status', 'Specification added.');
    }

    public function destroySpecification(Product $product, int $specification): RedirectResponse
    {
        $product->specifications()->findOrFail($specification)->delete();

        return back()->with('status', 'Specification removed.');
    }

    public function storeVariation(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'attribute_name' => ['required', 'string', 'max:255'],
            'attribute_value' => ['required', 'string', 'max:255'],
            'price_adjustment' => ['nullable', 'numeric'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['price_adjustment'] = $validated['price_adjustment'] ?? 0;
        $validated['stock_quantity'] = $validated['stock_quantity'] ?? 0;

        $product->variations()->create($validated);

        return back()->with('status', 'Variation added.');
    }

    public function destroyVariation(Product $product, int $variation): RedirectResponse
    {
        $product->variations()->findOrFail($variation)->delete();

        return back()->with('status', 'Variation removed.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:products,slug,'.($ignoreId ?? 'NULL').',id'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'sku' => ['nullable', 'string', 'max:255', 'unique:products,sku,'.($ignoreId ?? 'NULL').',id'],
            'total_stock_quantity' => ['required', 'integer', 'min:0'],
        ]);
    }
}
