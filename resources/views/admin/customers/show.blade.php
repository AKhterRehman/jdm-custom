<x-layouts.admin :title="$customer->name">
    <a href="{{ route('admin.customers.index') }}" class="text-sm text-silver-400 hover:text-gold-400">&larr; Back to customers</a>

    <div class="flex items-start justify-between mt-2 mb-8">
        <div>
            <h1 class="font-display text-3xl font-medium text-white">{{ $customer->name }}</h1>
            <p class="text-silver-400">{{ $customer->email }} &middot; Joined {{ $customer->created_at->format('M j, Y') }}</p>
        </div>

        @if ($customer->id !== auth()->id())
            <form action="{{ route('admin.customers.toggle-admin', $customer) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-md border border-white/15 px-4 py-2 text-sm hover:border-gold-500">
                    {{ $customer->is_admin ? 'Remove Admin Access' : 'Grant Admin Access' }}
                </button>
            </form>
        @endif
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <div>
            <h2 class="font-semibold mb-4">Orders</h2>
            <div class="rounded-lg border border-white/10 bg-charcoal-800 divide-y divide-white/10">
                @forelse ($customer->orders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between px-4 py-3 text-sm hover:bg-white/5">
                        <div>
                            <p class="font-medium">{{ $order->order_number }}</p>
                            <p class="text-silver-400">{{ $order->created_at->format('M j, Y') }}</p>
                        </div>
                        <span class="rounded-full bg-white/5 px-2 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
                        <p class="font-semibold">${{ number_format($order->total, 2) }}</p>
                    </a>
                @empty
                    <p class="px-4 py-3 text-sm text-silver-400">No orders yet.</p>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="font-semibold mb-4">Saved Addresses</h2>
            <div class="rounded-lg border border-white/10 bg-charcoal-800 divide-y divide-white/10">
                @forelse ($customer->addresses as $address)
                    <div class="px-4 py-3 text-sm">
                        <p class="font-medium">{{ $address->label }} &middot; {{ $address->full_name }}</p>
                        <p class="text-silver-400">{{ $address->fullAddress() }}</p>
                    </div>
                @empty
                    <p class="px-4 py-3 text-sm text-silver-400">No saved addresses.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.admin>
