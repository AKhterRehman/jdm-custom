<x-layouts.account title="Addresses">
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-heading text-2xl font-bold text-ink-900">Saved Addresses</h1>
        <a href="{{ route('addresses.create') }}" class="rounded-md bg-ink-900 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600 transition">
            Add Address
        </a>
    </div>

    @if ($addresses->isEmpty())
        <p class="text-gray-500">You haven't saved any addresses yet.</p>
    @else
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach ($addresses as $address)
                <div class="rounded-lg border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-2">
                        <p class="font-semibold text-gray-900">{{ $address->label }}</p>
                        @if ($address->is_default)
                            <span class="rounded-full bg-red-50 text-red-600 text-xs font-medium px-2 py-1">Default</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600">{{ $address->full_name }} &middot; {{ $address->phone }}</p>
                    <p class="text-sm text-gray-600">{{ $address->fullAddress() }}</p>

                    <div class="mt-4 flex gap-4 text-sm">
                        <a href="{{ route('addresses.edit', $address) }}" class="text-gray-600 hover:text-red-600">Edit</a>
                        <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $addresses->links() }}
        </div>
    @endif
</x-layouts.account>
