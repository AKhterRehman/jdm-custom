<x-layouts.storefront title="Your Wishlist">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8">Your Wishlist</h1>

        @if (session('status'))
            <div class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($wishlists->isEmpty())
            <p class="text-gray-500">Your wishlist is empty. <a href="{{ route('home') }}" class="text-red-600 hover:underline">Browse products</a>.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($wishlists as $wishlist)
                    <div>
                        @include('partials.product-card', ['product' => $wishlist->product])
                        <form action="{{ route('wishlist.destroy', $wishlist->product) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-gray-400 hover:text-red-600">Remove</button>
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
