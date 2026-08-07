<x-layouts.storefront :title="$product->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <nav class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-red-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('category.show', $product->category) }}" class="hover:text-red-600">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-600">{{ $product->name }}</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-16">
            <div>
                <div class="aspect-square overflow-hidden rounded-xl bg-gray-100 shadow-sm">
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
                <p class="text-xs font-semibold uppercase tracking-widest text-red-600 mb-2">{{ $product->category->name }}</p>
                <h1 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900">{{ $product->name }}</h1>
                <p class="mt-3 text-gray-600 leading-relaxed">{{ $product->short_description }}</p>

                <div class="mt-6">
                    @if ($product->sale_price)
                        <span class="text-3xl font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="ml-2 text-lg text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                    @else
                        <span class="text-3xl font-bold text-ink-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <p class="mt-2 text-sm font-medium {{ $product->available_stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->available_stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                </p>

                <div x-data="{ quantity: 1, available: {{ max(0, (int) $product->available_stock_quantity) }} }">
                @if (auth()->check() && auth()->user()->is_admin)
                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Total Stock Quantity</p>
                            <p class="mt-1 text-lg font-bold text-ink-900">{{ $product->total_stock_quantity }}</p>
                        </div>
                        <div class="rounded-lg border border-green-100 bg-green-50 px-4 py-3">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-green-700">Available Stock Quantity</p>
                            <p class="mt-1 text-lg font-bold text-green-700" x-text="available">{{ $product->available_stock_quantity }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->has('quantity'))
                    <p class="mt-4 text-sm font-medium text-red-600">{{ $errors->first('quantity') }}</p>
                @endif

                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    @if ($product->variations->isNotEmpty())
                        <div class="mt-6 space-y-4">
                            @foreach ($product->variations->groupBy('attribute_name') as $attributeName => $options)
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">{{ $attributeName }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($options as $option)
                                            <label class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium cursor-pointer transition has-[:checked]:border-red-600 has-[:checked]:bg-red-50 has-[:checked]:text-red-600">
                                                <input type="radio" name="product_variation_id" value="{{ $option->id }}" required class="sr-only"
                                                    x-on:change="available = Math.min({{ max(0, (int) $product->available_stock_quantity) }}, {{ max(0, (int) $option->stock_quantity) }}); if (quantity > available) quantity = available">
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

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <input type="number" name="quantity" min="1" :max="available" x-model.number="quantity"
                            @input="quantity = Math.min(Math.max(Number($event.target.value) || 1, 1), available)"
                            class="w-full sm:w-24 rounded-md border-gray-300">
                        <button type="submit" @disabled($product->available_stock_quantity <= 0) :disabled="available < 1"
                            class="flex-1 rounded-md border border-ink-900 bg-white px-6 py-3.5 text-sm font-bold uppercase tracking-wide text-ink-900 hover:border-red-600 hover:text-red-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Add to Cart
                        </button>
                        <button type="submit" formaction="{{ route('cart.buy-now') }}" @disabled($product->available_stock_quantity <= 0) :disabled="available < 1"
                            class="flex-1 rounded-md bg-ink-900 px-6 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Buy Now
                        </button>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">You can add up to <span class="font-semibold text-ink-900" x-text="available"></span> item(s) to your cart.</p>
                </form>
                </div>

                <form action="{{ route('wishlist.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 transition">&hearts; Add to Wishlist</button>
                </form>

                @if ($product->description)
                    <div class="mt-10 border-t border-gray-100 pt-6">
                        <h2 class="font-heading font-semibold text-ink-900 mb-2">Description</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                @if ($product->specifications->isNotEmpty())
                    <div class="mt-8 border-t border-gray-100 pt-6">
                        <h2 class="font-heading font-semibold text-ink-900 mb-3">Specifications</h2>
                        <dl class="divide-y divide-gray-100 text-sm">
                            @foreach ($product->specifications as $spec)
                                <div class="flex justify-between py-2.5">
                                    <dt class="text-gray-500">{{ $spec->spec_key }}</dt>
                                    <dd class="text-ink-900 font-medium">{{ $spec->spec_value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-24 border-t border-gray-100 pt-16">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">You Might Also Like</p>
                <h2 class="font-heading text-2xl sm:text-3xl font-bold text-ink-900 mb-10">Related Products</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach ($relatedProducts as $related)
                        @include('partials.product-card', ['product' => $related])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.storefront>
