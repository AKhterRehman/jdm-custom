<x-layouts.storefront :dark="true" title="Your Wishlist">
    <div class="mx-auto max-w-[88rem] px-5 py-16 sm:px-8 sm:py-24 lg:px-12">
        <h1 class="font-lux font-normal text-[#ece7da] mb-8 text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.05] tracking-[-0.01em]">Your Wishlist</h1>

        @if (session('status'))
            <div class="mb-6 rounded-none bg-green-500/10 border border-green-500/30 px-4 py-3 text-sm text-green-400">
                {{ session('status') }}
            </div>
        @endif

        @if ($wishlists->isEmpty())
            <p class="text-[#8f949c]">Your wishlist is empty. <a href="{{ route('home') }}" class="text-gold-400 hover:underline">Browse products</a>.</p>
        @else
            <div class="grid grid-cols-2 gap-x-5 gap-y-14 md:grid-cols-3 lg:grid-cols-4 lg:gap-x-8">
                @foreach ($wishlists as $wishlist)
                    <div>
                        @include('partials.product-card', ['product' => $wishlist->product, 'dark' => true])
                        <form action="{{ route('wishlist.destroy', $wishlist->product) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="label text-[#8f949c] transition hover:text-gold-300">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $wishlists->links() }}
            </div>
        @endif
    </div>
</x-layouts.storefront>
