@php
    $dark = $dark ?? false;
    $displayName = \Illuminate\Support\Str::before(\Illuminate\Support\Str::before($product->name, ' | '), ' – ');
    $image = $product->images->first();
    $wide = false;

    if ($image && str_starts_with($image->path, '/images/')) {
        $size = @getimagesize(public_path($image->path));
        $wide = $size && $size[1] > 0 && ($size[0] / $size[1]) > 0.85;
    }
@endphp

<div class="group piece-card">
    <a href="{{ route('product.show', $product) }}" class="block">
        @if ($dark)
            <div class="plate-mat relative aspect-[4/5]">
                <div class="relative h-full w-full overflow-hidden bg-[#0b0b0d]">
                    @if ($product->sale_price)
                        @php $discount = round((1 - $product->sale_price / $product->price) * 100); @endphp
                        <span class="label absolute left-3 top-3 z-10 bg-gold-500 px-2.5 py-1 text-[0.6rem] text-ink-900">-{{ $discount }}%</span>
                    @endif

                    @if ($image)
                        @if ($wide)
                            <img src="{{ $image->url() }}" alt="" aria-hidden="true" loading="lazy" class="absolute inset-0 h-full w-full scale-125 object-cover opacity-70 blur-2xl brightness-[.45]">
                        @endif
                        <img src="{{ $image->url() }}" alt="{{ $image->alt_text }}" loading="lazy" class="relative h-full w-full {{ $wide ? 'object-contain' : 'object-cover' }}">
                    @endif
                </div>
            </div>
            <p class="label mt-5 text-gold-500">{{ $product->category->name }}</p>
            <p class="mt-2 line-clamp-2 font-lux text-[1.35rem] leading-snug text-white transition group-hover:text-gold-300">{{ $displayName }}</p>
            <p class="mt-1.5 font-label text-sm font-light text-[#b9b5ab]">
                @if ($product->sale_price)
                    <span class="text-gold-300">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="ml-2 text-silver-500 line-through">${{ number_format($product->price, 2) }}</span>
                @else
                    From ${{ number_format($product->price, 2) }}
                @endif
            </p>
        @else
            <div class="relative aspect-square overflow-hidden bg-gray-100 shadow-sm transition group-hover:shadow-xl">
                @if ($product->sale_price)
                    @php $discount = round((1 - $product->sale_price / $product->price) * 100); @endphp
                    <span class="absolute left-3 top-3 z-10 bg-gold-600 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-white">-{{ $discount }}%</span>
                @endif

                @if ($image)
                    <img src="{{ $image->url() }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                @endif
            </div>
            <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-gray-400">{{ $product->category->name }}</p>
            <p class="line-clamp-2 font-heading font-semibold text-ink-900 transition group-hover:text-gold-600">{{ $displayName }}</p>
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
            <form action="{{ route('cart.quick-add') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" @disabled($product->available_stock_quantity < 1)
                    class="{{ $dark ? 'btn-line w-full !py-3 !text-[0.66rem]' : 'w-full border border-ink-900 px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-ink-900 transition hover:border-gold-600 hover:bg-gold-600 hover:text-white disabled:cursor-not-allowed disabled:opacity-40' }}">
                    {{ $product->available_stock_quantity > 0 ? 'Add to cart' : 'Out of stock' }}
                </button>
            </form>
        @endif
    @endauth
</div>
