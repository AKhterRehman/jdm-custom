@php
    $dark = $dark ?? false;
    $displayName = \Illuminate\Support\Str::before(\Illuminate\Support\Str::before($product->name, ' | '), ' – ');
    $image = $product->images->first();
@endphp

<div class="group art-card">
    <a href="{{ route('product.show', $product) }}" class="block">
        @if ($dark)
            <div class="art-plate relative aspect-[4/5]">
                @if ($product->sale_price)
                    @php $discount = round((1 - $product->sale_price / $product->price) * 100); @endphp
                    <span class="absolute top-3 left-3 z-10 bg-gold-500 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-ink-900">-{{ $discount }}%</span>
                @endif

                @if ($image)
                    <img src="{{ $image->url() }}" alt="{{ $image->alt_text }}" loading="lazy" class="h-full w-full object-cover">
                @endif
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 transition duration-500 group-hover:opacity-100"></div>
            </div>
            <p class="mt-5 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-gold-500">{{ $product->category->name }}</p>
            <p class="mt-1.5 line-clamp-1 font-display text-xl font-semibold leading-snug text-white transition group-hover:text-gold-300">{{ $displayName }}</p>
            <p class="mt-1 text-sm text-silver-400">
                @if ($product->sale_price)
                    <span class="text-gold-400">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="ml-2 text-silver-500 line-through">${{ number_format($product->price, 2) }}</span>
                @else
                    ${{ number_format($product->price, 2) }}
                @endif
            </p>
        @else
            <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-100 shadow-sm transition group-hover:shadow-xl">
                @if ($product->sale_price)
                    @php $discount = round((1 - $product->sale_price / $product->price) * 100); @endphp
                    <span class="absolute top-3 left-3 z-10 rounded-full bg-gold-600 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-white">-{{ $discount }}%</span>
                @endif

                @if ($image)
                    <img src="{{ $image->url() }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                @endif
            </div>
            <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-gray-400">{{ $product->category->name }}</p>
            <p class="line-clamp-2 font-heading font-semibold text-ink-900 group-hover:text-gold-600 transition">{{ $displayName }}</p>
            <p class="mt-1">
                @if ($product->sale_price)
                    <span class="font-bold text-gold-600">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="ml-2 text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="font-bold text-ink-900">${{ number_format($product->price, 2) }}</span>
                @endif
            </p>
        @endif
    </a>

    @auth
        @if ($product->variations->isEmpty())
            <form action="{{ route('cart.quick-add') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" @disabled($product->available_stock_quantity < 1)
                    class="w-full border px-4 py-2.5 text-[0.65rem] font-bold uppercase tracking-[0.2em] transition disabled:cursor-not-allowed disabled:opacity-40 {{ $dark ? 'border-white/20 text-white hover:border-gold-500 hover:text-gold-300' : 'rounded-md border-ink-900 text-ink-900 hover:border-gold-600 hover:bg-gold-600 hover:text-white' }}">
                    {{ $product->available_stock_quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>
            </form>
        @endif
    @endauth
</div>
