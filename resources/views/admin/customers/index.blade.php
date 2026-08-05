<x-layouts.admin title="Customers">
    <h1 class="text-2xl font-bold mb-8">Customers</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..." class="rounded-md border-gray-300 text-sm">
        <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm hover:border-red-600">Search</button>
    </form>

    <div class="rounded-lg border border-gray-200 bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Orders</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($customers as $customer)
                    <tr class="cursor-pointer hover:bg-gray-50" onclick="window.location='{{ route('admin.customers.show', $customer) }}'">
                        <td class="px-4 py-3 font-medium">{{ $customer->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $customer->email }}</td>
                        <td class="px-4 py-3">{{ $customer->orders_count }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $customer->created_at->format('M j, Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($customer->is_admin)
                                <span class="rounded-full bg-red-50 text-red-600 px-2 py-1 text-xs font-medium">Admin</span>
                            @else
                                <span class="text-gray-400">Customer</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $customers->links() }}
    </div>
</x-layouts.admin>
