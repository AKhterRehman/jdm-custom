<x-layouts.account title="My Account">
    <h1 class="font-lux text-2xl font-normal text-[#ece7da] mb-2 text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.05] tracking-[-0.01em]">Welcome back, {{ auth()->user()->name }}</h1>
    <p class="text-[#8f949c] mb-8">Manage your orders, addresses, and account details.</p>

    <div class="grid sm:grid-cols-3 gap-4 mb-10">
        <a href="{{ route('orders.index') }}" class="rounded-none border border-white/10 p-5 hover:border-gold-500 hover:shadow-md transition">
            <p class="font-lux text-2xl font-normal text-[#ece7da]">{{ auth()->user()->orders()->count() }}</p>
            <p class="text-sm text-[#8f949c]">Orders</p>
        </a>
        <a href="{{ route('addresses.index') }}" class="rounded-none border border-white/10 p-5 hover:border-gold-500 hover:shadow-md transition">
            <p class="font-lux text-2xl font-normal text-[#ece7da]">{{ $addressCount }}</p>
            <p class="text-sm text-[#8f949c]">Saved Addresses</p>
        </a>
        <a href="{{ route('wishlist.index') }}" class="rounded-none border border-white/10 p-5 hover:border-gold-500 hover:shadow-md transition">
            <p class="font-lux text-2xl font-normal text-[#ece7da]">{{ $wishlistCount }}</p>
            <p class="text-sm text-[#8f949c]">Wishlist Items</p>
        </a>
    </div>

    <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-4">Recent Orders</h2>

    @if ($recentOrders->isEmpty())
        <p class="text-[#8f949c]">You haven't placed any orders yet. <a href="{{ route('home') }}" class="text-gold-400 hover:underline">Start shopping</a>.</p>
    @else
        <div class="divide-y divide-white/10 border-t border-b border-white/10">
            @foreach ($recentOrders as $order)
                <a href="{{ route('orders.show', $order) }}" class="flex items-center justify-between py-4 hover:bg-white/5 px-2 -mx-2 rounded">
                    <div>
                        <p class="font-medium text-[#ece7da]">{{ $order->order_number }}</p>
                        <p class="text-sm text-[#8f949c]">{{ $order->created_at->format('M j, Y') }}</p>
                    </div>
                    <span class="inline-block rounded-full bg-[#17171a] px-3 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
                    <p class="font-semibold text-[#ece7da]">${{ number_format($order->total, 2) }}</p>
                </a>
            @endforeach
        </div>
    @endif
</x-layouts.account>
