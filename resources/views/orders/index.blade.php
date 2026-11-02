<x-layouts.account title="My Orders">
    <h1 class="font-display text-3xl font-medium text-white mb-8">My Orders</h1>

    @if ($orders->isEmpty())
        <p class="text-silver-400">You haven't placed any orders yet. <a href="{{ route('home') }}" class="text-gold-400 hover:underline">Start shopping</a>.</p>
    @else
        <div class="divide-y divide-white/10 border-t border-b border-white/5">
            @foreach ($orders as $order)
                @php
                    $firstItem = $order->items->first();
                    $reviewProduct = $firstItem?->product;
                @endphp

                <div class="flex flex-wrap items-center justify-between gap-3 py-4 hover:bg-white/5 px-2 -mx-2 rounded">
                    <a href="{{ route('orders.show', $order) }}" class="flex-1 min-w-[220px]">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <p class="font-medium text-white">{{ $order->order_number }}</p>
                                <p class="text-sm text-silver-400">{{ $order->created_at->format('M j, Y') }} &middot; {{ $order->items->count() }} item(s)</p>
                            </div>
                            <span class="inline-block rounded-full bg-white/5 px-3 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
                            <p class="font-semibold">${{ number_format($order->total, 2) }}</p>
                        </div>
                    </a>

                    @if ($order->status === 'delivered' && $reviewProduct)
                        <a href="{{ route('product.show', $reviewProduct) }}#reviews"
                           class="inline-flex items-center rounded-full border border-gold-500 px-3 py-1.5 text-sm font-medium text-gold-400 transition hover:bg-gold-200/30">
                            Add Review
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <div class="dark-pagination">{{ $orders->links() }}</div>
        </div>
    @endif
</x-layouts.account>
