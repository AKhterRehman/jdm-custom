<x-layouts.storefront :dark="true" :title="$category->name">
    @php $isAutomotive = $category->slug === 'automotive-art'; @endphp

    <section class="relative isolate overflow-hidden border-b border-white/10 bg-ink-900 text-white">
        @if ($isAutomotive)
            <img src="{{ asset('images/luxury-garage-commission.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-50" aria-hidden="true">
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-ink-900/80 via-ink-900/60 to-ink-900"></div>
        @endif
        <div class="relative mx-auto max-w-5xl px-4 py-24 text-center sm:px-6 lg:px-8 sm:py-28">
            <p class="lux-eyebrow">{{ $isAutomotive ? 'The Collection' : 'Category' }}</p>
            <h1 class="mt-5 font-display text-5xl font-medium tracking-tight sm:text-7xl">{{ $category->name }}</h1>
            <div class="lux-rule mx-auto mt-8"></div>
            @if ($category->description)
                <p class="mx-auto mt-6 max-w-xl text-silver-300">{{ $category->description }}</p>
            @endif

            @if ($category->children->isNotEmpty())
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    @foreach ($category->children as $child)
                        <a href="{{ route('category.show', $child) }}" class="border border-white/20 px-4 py-1.5 text-xs uppercase tracking-[0.2em] text-silver-300 transition hover:border-gold-500 hover:text-gold-300">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 sm:py-20">
        <div class="grid grid-cols-2 gap-x-5 gap-y-14 lg:grid-cols-3 lg:gap-x-8">
            @forelse ($products as $product)
                @include('partials.product-card', ['product' => $product, 'dark' => true])
            @empty
                <p class="col-span-full text-silver-400">No pieces in this category yet.</p>
            @endforelse
        </div>

        <div class="mt-16 dark-pagination">
            {{ $products->links() }}
        </div>
    </div>
</x-layouts.storefront>
