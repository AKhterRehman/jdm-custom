<x-layouts.storefront title="Your Cart">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8">Your Cart</h1>

        @if (session('status'))
            <div class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($cart->items->isEmpty())
            <p class="text-gray-500">Your cart is empty. <a href="{{ route('home') }}" class="text-red-600 hover:underline">Continue shopping</a>.</p>
        @else
            <div class="divide-y divide-gray-100 border-t border-b border-gray-100">
                @foreach ($cart->items as $item)
                    <div class="flex items-center gap-4 py-4">
                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md bg-gray-100">
                            @if ($item->product->images->first())
                                <img src="{{ $item->product->images->first()->path }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1">
                            <a href="{{ route('product.show', $item->product) }}" class="font-semibold text-gray-900 hover:text-red-600">{{ $item->product->name }}</a>
                            @if ($item->variation)
                                <p class="text-sm text-gray-500">{{ $item->variation->attribute_name }}: {{ $item->variation->attribute_value }}</p>
                            @endif
                            <p class="text-sm text-gray-500">${{ number_format($item->unitPrice(), 2) }} each</p>
                        </div>

                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="w-16 rounded-md border-gray-300 text-sm">
                            <button type="submit" class="text-sm text-gray-500 hover:text-red-600">Update</button>
                        </form>

                        <p class="w-24 text-right font-semibold">${{ number_format($item->lineTotal(), 2) }}</p>

                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-gray-400 hover:text-red-600">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex items-center justify-between">
                <p class="text-lg font-semibold">Subtotal: ${{ number_format($cart->subtotal(), 2) }}</p>
                <a href="{{ route('checkout.index') }}" class="rounded-md bg-gray-900 px-6 py-3 font-semibold text-white hover:bg-red-600 transition">
                    Proceed to Checkout
                </a>
            </div>
        @endif
    </div>
</x-layouts.storefront>
