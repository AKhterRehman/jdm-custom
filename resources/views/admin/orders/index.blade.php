<x-layouts.admin title="Orders">
    <h1 class="font-display text-3xl font-medium text-white mb-8">Orders</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order #..." class="rounded-md border-white/15 text-sm">
        <select name="status" class="rounded-md border-white/15 text-sm">
            <option value="">All Statuses</option>
            @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-md border border-white/15 px-4 py-2 text-sm hover:border-gold-500">Filter</button>
    </form>

    <div class="rounded-lg border border-white/10 bg-charcoal-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/5 text-left text-silver-400">
                <tr>
                    <th class="px-4 py-3">Order #</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse ($orders as $order)
                    <tr class="cursor-pointer hover:bg-white/5" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                        <td class="px-4 py-3 font-medium">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $order->user->name }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $order->created_at->format('M j, Y') }}</td>
                        <td class="px-4 py-3"><span class="rounded-full bg-white/5 px-2 py-1 text-xs font-medium capitalize">{{ $order->status }}</span></td>
                        <td class="px-4 py-3 capitalize">{{ $order->payment_status }}</td>
                        <td class="px-4 py-3 font-semibold">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.orders.show', $order) }}" title="View order" aria-label="View order" class="admin-action"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z"/><circle cx="12" cy="12" r="2.5"/></svg></a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-silver-400">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <div class="dark-pagination">{{ $orders->links() }}</div>
    </div>
</x-layouts.admin>
