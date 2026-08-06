<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::with(['images', 'category'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->get();

        $newArrivals = Product::with(['images', 'category'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $totalProducts = Product::where('is_active', true)->count();

        return view('home', compact('categories', 'featuredProducts', 'newArrivals', 'totalProducts'));
    }
}
