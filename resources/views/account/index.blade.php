<x-layouts.account title="My Account">
    <h1 class="font-display text-3xl font-medium text-white mb-2">Welcome back, {{ auth()->user()->name }}</h1>
    <p class="text-silver-400 mb-8">Manage your orders, addresses, and account details.</p>

    <div class="grid sm:grid-cols-3 gap-4 mb-10">
        <a href="{{ route('orders.index') }}" class="rounded-xl border border-white/10 p-5 hover:border-gold-500 hover:shadow-md transition">
            <p class="font-display text-2xl font-bold text-white">{{ auth()->user()->orders()->count() }}</p>
            <p class="text-sm text-silver-400">Orders</p>
        </a>
        <a href="{{ route('addresses.index') }}" class="rounded-xl border border-white/10 p-5 hover:border-gold-500 hover:shadow-md transition">
            <p class="font-display text-2xl font-bold text-white">{{ $addressCount }}</p>
            <p class="text-sm text-silver-400">Saved Addresses</p>
        </a>
        <a href="{{ route('wishlist.index') }}" class="rounded-xl border border-white/10 p-5 hover:border-gold-500 hover:shadow-md transition">
            <p class="font-display text-2xl font-bold text-white">{{ $wishlistCount }}</p>
            <p class="text-sm text-silver-400">Wishlist Items</p>
        </a>
    </div>

    <h2 class="font-display text-lg font-semibold text-white mb-4">Recent Orders</h2>

    @if ($recentOrders->isEmpty())
        <p class="text-silver-400">You haven't placed any orders yet. <a href="{{ route('home') }}" class="text-gold-400 hover:underline">Start shopping</a>.</p>
    @else
        <div class="divide-y divide-white/10 border-t border-b border-white/5">
            @foreach ($recentOrders as $order)
                <a href="{{ route('orders.show', $order) }}" class="flex items-center justify-between py-4 hover:bg-white/5 px-2 -mx-2 rounded">
                    <div>
                        <p class="font-medium text-white">{{ $order->order_number }}</p>
                        <p class="text-sm text-silver-400">{{ $order->created_at->format('M j, Y') }}</p>
                    </div>
                    <span class="inline-block rounded-full bg-white/5 px-3 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
                    <p class="font-semibold text-white">${{ number_format($order->total, 2) }}</p>
                </a>
            @endforeach
        </div>
    @endif
</x-layouts.account>
