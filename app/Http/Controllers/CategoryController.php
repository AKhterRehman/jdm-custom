<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        $category->load('children');

        $categoryIds = $category->children->pluck('id')->push($category->id);

        $products = Product::with(['images', 'category'])
            ->whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->paginate(12);

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
