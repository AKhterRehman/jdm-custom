<x-layouts.storefront :title="$product->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-red-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('category.show', $product->category) }}" class="hover:text-red-600">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">{{ $product->name }}</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-12">
            <div>
                <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
                    @if ($product->images->first())
                        <img src="{{ $product->images->first()->url() }}" alt="{{ $product->images->first()->alt_text }}" class="h-full w-full object-cover">
                    @endif
                </div>

                @if ($product->images->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach ($product->images->skip(1) as $image)
                            <img src="{{ $image->url() }}" alt="{{ $image->alt_text }}" class="aspect-square rounded-md object-cover bg-gray-100">
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                <p class="mt-2 text-gray-600">{{ $product->short_description }}</p>

                <div class="mt-4">
                    @if ($product->sale_price)
                        <span class="text-2xl font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="ml-2 text-lg text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                    @else
                        <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <p class="mt-2 text-sm {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                </p>

                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    @if ($product->variations->isNotEmpty())
                        <div class="mt-6 space-y-4">
                            @foreach ($product->variations->groupBy('attribute_name') as $attributeName => $options)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 mb-2">{{ $attributeName }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($options as $option)
                                            <label class="rounded-md border border-gray-300 px-3 py-1.5 text-sm cursor-pointer has-[:checked]:border-red-600 has-[:checked]:text-red-600">
                                                <input type="radio" name="product_variation_id" value="{{ $option->id }}" required class="sr-only">
                                                {{ $option->attribute_value }}
                                                @if ($option->price_adjustment > 0)
                                                    <span class="text-gray-400">(+${{ number_format($option->price_adjustment, 2) }})</span>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-6 flex items-center gap-4">
                        <input type="number" name="quantity" value="1" min="1" max="99" class="w-20 rounded-md border-gray-300">
                        <button type="submit" @disabled($product->stock_quantity <= 0) class="flex-1 rounded-md bg-gray-900 px-6 py-3 font-semibold text-white hover:bg-red-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Add to Cart
                        </button>
                    </div>
                </form>

                <form action="{{ route('wishlist.store') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600">&hearts; Add to Wishlist</button>
                </form>

                @if ($product->description)
                    <div class="mt-8 border-t border-gray-100 pt-6">
                        <h2 class="font-semibold mb-2">Description</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                @if ($product->specifications->isNotEmpty())
                    <div class="mt-8 border-t border-gray-100 pt-6">
                        <h2 class="font-semibold mb-3">Specifications</h2>
                        <dl class="divide-y divide-gray-100 text-sm">
                            @foreach ($product->specifications as $spec)
                                <div class="flex justify-between py-2">
                                    <dt class="text-gray-500">{{ $spec->spec_key }}</dt>
                                    <dd class="text-gray-900">{{ $spec->spec_value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-20 border-t border-gray-100 pt-12">
                <h2 class="text-2xl font-bold mb-8">Related Products</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        @include('partials.product-card', ['product' => $related])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.storefront>
