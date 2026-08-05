<x-layouts.admin :title="$customer->name">
    <a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-500 hover:text-red-600">&larr; Back to customers</a>

    <div class="flex items-start justify-between mt-2 mb-8">
        <div>
            <h1 class="font-heading text-2xl font-bold text-ink-900">{{ $customer->name }}</h1>
            <p class="text-gray-500">{{ $customer->email }} &middot; Joined {{ $customer->created_at->format('M j, Y') }}</p>
        </div>

        @if ($customer->id !== auth()->id())
            <form action="{{ route('admin.customers.toggle-admin', $customer) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm hover:border-red-600">
                    {{ $customer->is_admin ? 'Remove Admin Access' : 'Grant Admin Access' }}
                </button>
            </form>
        @endif
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <div>
            <h2 class="font-semibold mb-4">Orders</h2>
            <div class="rounded-lg border border-gray-200 bg-white divide-y divide-gray-100">
                @forelse ($customer->orders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between px-4 py-3 text-sm hover:bg-gray-50">
                        <div>
                            <p class="font-medium">{{ $order->order_number }}</p>
                            <p class="text-gray-500">{{ $order->created_at->format('M j, Y') }}</p>
                        </div>
                        <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
                        <p class="font-semibold">${{ number_format($order->total, 2) }}</p>
                    </a>
                @empty
                    <p class="px-4 py-3 text-sm text-gray-500">No orders yet.</p>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="font-semibold mb-4">Saved Addresses</h2>
            <div class="rounded-lg border border-gray-200 bg-white divide-y divide-gray-100">
                @forelse ($customer->addresses as $address)
                    <div class="px-4 py-3 text-sm">
                        <p class="font-medium">{{ $address->label }} &middot; {{ $address->full_name }}</p>
                        <p class="text-gray-500">{{ $address->fullAddress() }}</p>
                    </div>
                @empty
                    <p class="px-4 py-3 text-sm text-gray-500">No saved addresses.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.admin>
