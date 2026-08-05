<x-layouts.account title="My Account">
    <h1 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}</h1>
    <p class="text-gray-500 mb-8">Manage your orders, addresses, and account details.</p>

    <div class="grid sm:grid-cols-3 gap-4 mb-10">
        <a href="{{ route('orders.index') }}" class="rounded-lg border border-gray-200 p-5 hover:border-red-600 transition">
            <p class="text-2xl font-bold">{{ auth()->user()->orders()->count() }}</p>
            <p class="text-sm text-gray-500">Orders</p>
        </a>
        <a href="{{ route('addresses.index') }}" class="rounded-lg border border-gray-200 p-5 hover:border-red-600 transition">
            <p class="text-2xl font-bold">{{ $addressCount }}</p>
            <p class="text-sm text-gray-500">Saved Addresses</p>
        </a>
        <a href="{{ route('wishlist.index') }}" class="rounded-lg border border-gray-200 p-5 hover:border-red-600 transition">
            <p class="text-2xl font-bold">{{ $wishlistCount }}</p>
            <p class="text-sm text-gray-500">Wishlist Items</p>
        </a>
    </div>

    <h2 class="text-lg font-semibold mb-4">Recent Orders</h2>

    @if ($recentOrders->isEmpty())
        <p class="text-gray-500">You haven't placed any orders yet. <a href="{{ route('home') }}" class="text-red-600 hover:underline">Start shopping</a>.</p>
    @else
        <div class="divide-y divide-gray-100 border-t border-b border-gray-100">
            @foreach ($recentOrders as $order)
                <a href="{{ route('orders.show', $order) }}" class="flex items-center justify-between py-4 hover:bg-gray-50 px-2 -mx-2 rounded">
                    <div>
                        <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y') }}</p>
                    </div>
                    <span class="inline-block rounded-full bg-gray-100 px-3 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
                    <p class="font-semibold">${{ number_format($order->total, 2) }}</p>
                </a>
            @endforeach
        </div>
    @endif
</x-layouts.account>
