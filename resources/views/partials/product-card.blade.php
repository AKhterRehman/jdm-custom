<a href="{{ route('product.show', $product) }}" class="group block">
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
    <p class="font-heading font-semibold text-ink-900 group-hover:text-red-600 transition">{{ $product->name }}</p>
    <p class="mt-1">
        @if ($product->sale_price)
            <span class="font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
            <span class="ml-2 text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
        @else
            <span class="font-bold text-ink-900">${{ number_format($product->price, 2) }}</span>
        @endif
    </p>
</a>
