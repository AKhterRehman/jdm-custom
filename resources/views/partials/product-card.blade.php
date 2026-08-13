<div class="group">
    <a href="{{ route('product.show', $product) }}" class="block">
    <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-100 shadow-sm transition group-hover:shadow-xl">
        @if ($product->sale_price)
            @php $discount = round((1 - $product->sale_price / $product->price) * 100); @endphp
            <span class="absolute top-3 left-3 z-10 rounded-full bg-red-600 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-white">-{{ $discount }}%</span>
        @endif

        @if ($product->images->first())
            <img src="{{ $product->images->first()->url() }}" alt="{{ $product->images->first()->alt_text }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @endif
    </div>
    <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-gray-400">{{ $product->category->name }}</p>
    <p class="font-heading font-semibold text-white-900 group-hover:text-red-600 transition">{{ $product->name }}</p>
    <p class="mt-1">
        @if ($product->sale_price)
            <span class="font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
            <span class="ml-2 text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
        @else
            <span class="font-bold text-ink-900">${{ number_format($product->price, 2) }}</span>
        @endif
    </p>
    </a>

    @auth
        @if ($product->variations->isEmpty())
            <form action="{{ route('cart.quick-add') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" @disabled($product->available_stock_quantity < 1) class="w-full rounded-md border border-ink-900 px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-ink-900 hover:border-red-600 hover:bg-red-600 hover:text-white disabled:cursor-not-allowed disabled:opacity-40 transition">
                    {{ $product->available_stock_quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>
            </form>
        @endif
    @endauth
</div>
