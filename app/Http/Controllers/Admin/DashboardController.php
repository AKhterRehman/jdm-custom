<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_customers' => User::where('is_admin', false)->count(),
            'total_products' => Product::count(),
            'low_stock_products' => Product::where('available_stock_quantity', '<=', 5)->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(8)->get();

        $lowStockProducts = Product::where('available_stock_quantity', '<=', 5)
            ->orderBy('available_stock_quantity')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
