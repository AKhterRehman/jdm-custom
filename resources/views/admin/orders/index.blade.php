<x-layouts.admin title="Orders">
    <h1 class="font-heading text-2xl font-bold text-ink-900 mb-8">Orders</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order #..." class="rounded-md border-gray-300 text-sm">
        <select name="status" class="rounded-md border-gray-300 text-sm">
            <option value="">All Statuses</option>
            @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm hover:border-red-600">Filter</button>
    </form>

    <div class="rounded-lg border border-gray-200 bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Order #</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($orders as $order)
                    <tr class="cursor-pointer hover:bg-gray-50" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                        <td class="px-4 py-3 font-medium">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $order->user->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $order->created_at->format('M j, Y') }}</td>
                        <td class="px-4 py-3"><span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium capitalize">{{ $order->status }}</span></td>
                        <td class="px-4 py-3 capitalize">{{ $order->payment_status }}</td>
                        <td class="px-4 py-3 font-semibold">${{ number_format($order->total, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</x-layouts.admin>
