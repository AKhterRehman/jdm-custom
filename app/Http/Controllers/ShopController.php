<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->get('sort', 'newest');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $products = Product::with(['images', 'category'])
            ->where('is_active', true)
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->when($minPrice !== null && $minPrice !== '', fn ($q) => $q->whereRaw('COALESCE(sale_price, price) >= ?', [(float) $minPrice]))
            ->when($maxPrice !== null && $maxPrice !== '', fn ($q) => $q->whereRaw('COALESCE(sale_price, price) <= ?', [(float) $maxPrice]))
            ->when($sort === 'price_asc', fn ($q) => $q->orderByRaw('COALESCE(sale_price, price) asc'))
            ->when($sort === 'price_desc', fn ($q) => $q->orderByRaw('COALESCE(sale_price, price) desc'))
            ->when($sort === 'newest', fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();

        return view('shop.index', compact('products', 'categories', 'sort'));
    }
}
