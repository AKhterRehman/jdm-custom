<x-layouts.account title="My Orders">
    <h1 class="font-heading text-2xl font-bold text-ink-900 mb-8">My Orders</h1>

    @if ($orders->isEmpty())
        <p class="text-gray-500">You haven't placed any orders yet. <a href="{{ route('home') }}" class="text-red-600 hover:underline">Start shopping</a>.</p>
    @else
        <div class="divide-y divide-gray-100 border-t border-b border-gray-100">
            @foreach ($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="flex flex-wrap items-center justify-between gap-2 py-4 hover:bg-gray-50 px-2 -mx-2 rounded">
                    <div>
                        <p class="font-medium text-ink-900">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y') }} &middot; {{ $order->items->count() }} item(s)</p>
                    </div>
                    <span class="inline-block rounded-full bg-gray-100 px-3 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
                    <p class="font-semibold">${{ number_format($order->total, 2) }}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</x-layouts.account>
