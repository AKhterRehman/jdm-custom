<x-layouts.admin title="Dashboard">
    <h1 class="text-2xl font-bold mb-8">Dashboard</h1>

    <div class="grid sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
        <div class="rounded-lg border border-gray-200 bg-white p-5">
            <p class="text-2xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</p>
            <p class="text-sm text-gray-500">Revenue (Paid)</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5">
            <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
            <p class="text-sm text-gray-500">Total Orders</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5">
            <p class="text-2xl font-bold">{{ $stats['pending_orders'] }}</p>
            <p class="text-sm text-gray-500">Pending Orders</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5">
            <p class="text-2xl font-bold">{{ $stats['total_customers'] }}</p>
            <p class="text-sm text-gray-500">Customers</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5">
            <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
            <p class="text-sm text-gray-500">Products</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5">
            <p class="text-2xl font-bold text-red-600">{{ $stats['low_stock_products'] }}</p>
            <p class="text-sm text-gray-500">Low Stock</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <div>
            <h2 class="text-lg font-semibold mb-4">Recent Orders</h2>
            <div class="rounded-lg border border-gray-200 bg-white divide-y divide-gray-100">
                @forelse ($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between px-4 py-3 text-sm hover:bg-gray-50">
                        <div>
                            <p class="font-medium">{{ $order->order_number }}</p>
                            <p class="text-gray-500">{{ $order->user->name }}</p>
                        </div>
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
                        <p class="font-semibold">${{ number_format($order->total, 2) }}</p>
                    </a>
                @empty
                    <p class="px-4 py-3 text-sm text-gray-500">No orders yet.</p>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold mb-4">Low Stock Products</h2>
            <div class="rounded-lg border border-gray-200 bg-white divide-y divide-gray-100">
                @forelse ($lowStockProducts as $product)
                    <a href="{{ route('admin.products.edit', $product) }}" class="flex items-center justify-between px-4 py-3 text-sm hover:bg-gray-50">
                        <p class="font-medium">{{ $product->name }}</p>
                        <span class="text-red-600 font-semibold">{{ $product->stock_quantity }} left</span>
                    </a>
                @empty
                    <p class="px-4 py-3 text-sm text-gray-500">All products well stocked.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.admin>
