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

        $months = collect(range(5, 0))->map(function (int $monthsAgo) {
            $date = now()->startOfMonth()->subMonths($monthsAgo);

            return [
                'label' => $date->format('M'),
                'start' => $date->copy(),
                'end' => $date->copy()->endOfMonth(),
            ];
        });

        $salesTrend = $months->map(function (array $month) {
            return [
                'label' => $month['label'],
                'revenue' => (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$month['start'], $month['end']])->sum('total'),
                'orders' => Order::whereBetween('created_at', [$month['start'], $month['end']])->count(),
            ];
        });

        $orderStatuses = collect(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])
            ->mapWithKeys(fn (string $status) => [$status => Order::where('status', $status)->count()]);
        $categoryBreakdown = Product::with('category')->get()->groupBy(fn ($product) => $product->category?->name ?? 'Uncategorised')->map->count()->sortDesc()->take(6);

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts', 'salesTrend', 'orderStatuses', 'categoryBreakdown'));
    }
}
