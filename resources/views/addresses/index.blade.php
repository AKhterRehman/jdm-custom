<x-layouts.account title="Addresses">
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-display text-3xl font-medium text-white">Saved Addresses</h1>
        <a href="{{ route('addresses.create') }}" class="rounded-md bg-gold-500 px-4 py-2 text-sm font-semibold text-ink-900 hover:bg-gold-400 transition">
            Add Address
        </a>
    </div>

    @if ($addresses->isEmpty())
        <p class="text-silver-400">You haven't saved any addresses yet.</p>
    @else
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach ($addresses as $address)
                <div class="rounded-lg border border-white/10 p-5">
                    <div class="flex items-center justify-between mb-2">
                        <p class="font-semibold text-white">{{ $address->label }}</p>
                        @if ($address->is_default)
                            <span class="rounded-full bg-gold-200/30 text-gold-400 text-xs font-medium px-2 py-1">Default</span>
                        @endif
                    </div>
                    <p class="text-sm text-silver-300">{{ $address->full_name }} &middot; {{ $address->phone }}</p>
                    <p class="text-sm text-silver-300">{{ $address->fullAddress() }}</p>

                    <div class="mt-4 flex gap-4 text-sm">
                        <a href="{{ route('addresses.edit', $address) }}" class="text-silver-300 hover:text-gold-300">Edit</a>
                        <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-silver-500 hover:text-gold-300">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <div class="dark-pagination">{{ $addresses->links() }}</div>
        </div>
    @endif
</x-layouts.account>
