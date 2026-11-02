<x-layouts.admin title="Customers">
    <h1 class="font-display text-3xl font-medium text-white mb-8">Customers</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..." class="rounded-md border-white/15 text-sm">
        <button type="submit" class="rounded-md border border-white/15 px-4 py-2 text-sm hover:border-gold-500">Search</button>
    </form>

    <div class="rounded-lg border border-white/10 bg-charcoal-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/5 text-left text-silver-400">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Orders</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse ($customers as $customer)
                    <tr class="cursor-pointer hover:bg-white/5" onclick="window.location='{{ route('admin.customers.show', $customer) }}'">
                        <td class="px-4 py-3 font-medium">{{ $customer->name }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $customer->email }}</td>
                        <td class="px-4 py-3">{{ $customer->orders_count }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $customer->created_at->format('M j, Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($customer->is_admin)
                                <span class="rounded-full bg-gold-500/10 text-gold-400 px-2 py-1 text-xs font-medium">Admin</span>
                            @else
                                <span class="text-silver-500">Customer</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.customers.show', $customer) }}" title="View customer" aria-label="View customer" class="admin-action"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z"/><circle cx="12" cy="12" r="2.5"/></svg></a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-silver-400">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <div class="dark-pagination">{{ $customers->links() }}</div>
    </div>
</x-layouts.admin>
