<x-layouts.storefront :dark="true" :title="$category->name">
    @php $isAutomotive = $category->slug === 'automotive-art'; @endphp

    <section class="page-head relative isolate overflow-hidden bg-ink-900 text-[#ece7da]">
        @if ($isAutomotive)
            <img src="{{ asset('images/luxury-garage-hero.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-90 brightness-105" aria-hidden="true">
            <div class="absolute inset-0 -z-10 bg-[linear-gradient(95deg,rgba(11,11,13,0.92)_0%,rgba(11,11,13,0.6)_45%,rgba(11,11,13,0.25)_100%)]"></div>
            <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-ink-900 to-transparent"></div>
        @endif
        <div class="mx-auto max-w-[88rem] px-5 py-24 sm:px-8 sm:py-32 lg:px-12">
            <div class="flex items-center gap-4">
                <span class="rule-gold"></span>
                <p class="label text-gold-500">{{ $isAutomotive ? 'The Collection' : 'Category' }}</p>
            </div>
            <h1 class="mt-8 font-lux text-[clamp(2.8rem,6vw,5.6rem)] font-normal leading-[1] tracking-[-0.015em]">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="mt-7 max-w-lg font-label text-[1.02rem] font-light leading-relaxed text-[#cfcabd]">{{ $category->description }}</p>
            @endif

            @if ($category->children->isNotEmpty())
                <div class="mt-9 flex flex-wrap gap-x-8 gap-y-3">
                    @foreach ($category->children as $child)
                        <a href="{{ route('category.show', $child) }}" class="link-line">{{ $child->name }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <div class="mx-auto max-w-[88rem] px-5 py-16 sm:px-8 sm:py-24 lg:px-12">
        <div class="grid grid-cols-2 gap-x-5 gap-y-14 lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4">
            @forelse ($products as $product)
                @include('partials.product-card', ['product' => $product, 'dark' => true])
            @empty
                <p class="col-span-full text-[#8f949c]">No pieces in this category yet.</p>
            @endforelse
        </div>

        <div class="mt-16 dark-pagination">
            {{ $products->links() }}
        </div>
    </div>
</x-layouts.storefront>
