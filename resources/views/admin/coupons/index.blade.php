<x-layouts.admin title="Coupons">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">Coupons</h1>
        <a href="{{ route('admin.coupons.create') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600 transition">
            Add Coupon
        </a>
    </div>

    <div class="rounded-lg border border-gray-200 bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Code</th>
                    <th class="px-4 py-3">Discount</th>
                    <th class="px-4 py-3">Uses</th>
                    <th class="px-4 py-3">Expires</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($coupons as $coupon)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $coupon->code }}</td>
                        <td class="px-4 py-3">{{ $coupon->type === 'percentage' ? $coupon->value.'%' : '$'.number_format($coupon->value, 2) }}</td>
                        <td class="px-4 py-3">{{ $coupon->used_count }}{{ $coupon->max_uses ? ' / '.$coupon->max_uses : '' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $coupon->expires_at?->format('M j, Y') ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-medium {{ $coupon->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-gray-600 hover:text-red-600">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Delete this coupon?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No coupons yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $coupons->links() }}
    </div>
</x-layouts.admin>
