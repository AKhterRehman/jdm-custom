<a href="{{ route('product.show', $product) }}" class="group block">
    <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
        @if ($product->images->first())
            <img src="{{ $product->images->first()->path }}" alt="{{ $product->images->first()->alt_text }}" class="h-full w-full object-cover group-hover:scale-105 transition">
        @endif
    </div>
    <p class="mt-3 text-sm text-gray-500">{{ $product->category->name }}</p>
    <p class="font-semibold text-gray-900 group-hover:text-red-600">{{ $product->name }}</p>
    <p class="mt-1">
        @if ($product->sale_price)
            <span class="font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
            <span class="ml-2 text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
        @else
            <span class="font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
        @endif
    </p>
</a>
