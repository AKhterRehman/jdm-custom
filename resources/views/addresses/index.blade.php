<x-layouts.account title="Addresses">
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lux text-2xl font-normal text-[#ece7da] text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.05] tracking-[-0.01em]">Saved Addresses</h1>
        <a href="{{ route('addresses.create') }}" class="rounded-none bg-[#ece7da] px-4 py-2 text-sm font-semibold text-ink-900 hover:bg-gold-500 transition">
            Add Address
        </a>
    </div>

    @if ($addresses->isEmpty())
        <p class="text-[#8f949c]">You haven't saved any addresses yet.</p>
    @else
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach ($addresses as $address)
                <div class="rounded-none border border-white/10 p-5">
                    <div class="flex items-center justify-between mb-2">
                        <p class="font-semibold text-[#ece7da]">{{ $address->label }}</p>
                        @if ($address->is_default)
                            <span class="rounded-full bg-gold-500/10 text-gold-400 text-xs font-medium px-2 py-1">Default</span>
                        @endif
                    </div>
                    <p class="text-sm text-[#b9b5ab]">{{ $address->full_name }} &middot; {{ $address->phone }}</p>
                    <p class="text-sm text-[#b9b5ab]">{{ $address->fullAddress() }}</p>

                    <div class="mt-4 flex gap-4 text-sm">
                        <a href="{{ route('addresses.edit', $address) }}" class="text-[#b9b5ab] hover:text-gold-300">Edit</a>
                        <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#8f949c] hover:text-gold-300">Delete</button>
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
