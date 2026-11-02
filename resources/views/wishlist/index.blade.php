<x-layouts.storefront title="Your Wishlist">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="font-display text-4xl font-medium text-white mb-8">Your Wishlist</h1>

        @if (session('status'))
            <div class="mb-6 rounded-md bg-green-500/10 border border-green-500/30 px-4 py-3 text-sm text-green-300">
                {{ session('status') }}
            </div>
        @endif

        @if ($wishlists->isEmpty())
            <p class="text-silver-400">Your wishlist is empty. <a href="{{ route('home') }}" class="text-gold-400 hover:underline">Browse products</a>.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($wishlists as $wishlist)
                    <div>
                        @include('partials.product-card', ['product' => $wishlist->product])
                        <form action="{{ route('wishlist.destroy', $wishlist->product) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-silver-500 hover:text-gold-300">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                <div class="dark-pagination">{{ $wishlists->links() }}</div>
            </div>
        @endif
    </div>
</x-layouts.storefront>
