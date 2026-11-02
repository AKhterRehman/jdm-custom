<x-layouts.admin title="Coupons">
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-display text-3xl font-medium text-white">Coupons</h1>
        <a href="{{ route('admin.coupons.create') }}" class="rounded-md bg-gold-500 px-4 py-2 text-sm font-semibold text-ink-900 hover:bg-gold-400 transition">
            Add Coupon
        </a>
    </div>

    <div class="rounded-lg border border-white/10 bg-charcoal-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/5 text-left text-silver-400">
                <tr>
                    <th class="px-4 py-3">Code</th>
                    <th class="px-4 py-3">Discount</th>
                    <th class="px-4 py-3">Uses</th>
                    <th class="px-4 py-3">Expires</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse ($coupons as $coupon)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $coupon->code }}</td>
                        <td class="px-4 py-3">{{ $coupon->type === 'percentage' ? $coupon->value.'%' : '$'.number_format($coupon->value, 2) }}</td>
                        <td class="px-4 py-3">{{ $coupon->used_count }}{{ $coupon->max_uses ? ' / '.$coupon->max_uses : '' }}</td>
                        <td class="px-4 py-3 text-silver-400">{{ $coupon->expires_at?->format('M j, Y') ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-medium {{ $coupon->is_active ? 'bg-green-500/10 text-green-300' : 'bg-white/5 text-silver-400' }}">
                                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-silver-300 hover:text-gold-400">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Delete this coupon?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-silver-500 hover:text-gold-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-silver-400">No coupons yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <div class="dark-pagination">{{ $coupons->links() }}</div>
    </div>
</x-layouts.admin>
