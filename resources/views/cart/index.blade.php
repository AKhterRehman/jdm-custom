<x-layouts.storefront title="Your Cart">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900 mb-10">Your Cart</h1>

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
                    <div class="flex items-center gap-4 py-5">
                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                            @if ($item->product->images->first())
                                <img src="{{ $item->product->images->first()->url() }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1">
                            <a href="{{ route('product.show', $item->product) }}" class="font-heading font-semibold text-ink-900 hover:text-red-600 transition">{{ $item->product->name }}</a>
                            @if ($item->variation)
                                <p class="text-sm text-gray-500">{{ $item->variation->attribute_name }}: {{ $item->variation->attribute_value }}</p>
                            @endif
                            <p class="text-sm text-gray-500">${{ number_format($item->unitPrice(), 2) }} each</p>
                        </div>

                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="w-16 rounded-md border-gray-300 text-sm">
                            <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 transition">Update</button>
                        </form>

                        <p class="w-24 text-right font-semibold text-ink-900">${{ number_format($item->lineTotal(), 2) }}</p>

                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-gray-400 hover:text-red-600 transition">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex items-center justify-between">
                <p class="font-heading text-lg font-semibold text-ink-900">Subtotal: ${{ number_format($cart->subtotal(), 2) }}</p>
                <a href="{{ route('checkout.index') }}" class="rounded-md bg-ink-900 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-600 transition">
                    Proceed to Checkout
                </a>
            </div>
        @endif
    </div>
</x-layouts.storefront>
