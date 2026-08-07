<x-layouts.storefront :title="$category->name">
    <section class="relative overflow-hidden bg-ink-900 text-white" style="background-image: url('{{ asset('images/hero-wood-bg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.18),_transparent_60%)]"></div>
        <div class="relative mx-auto flex min-h-[280px] max-w-5xl items-center justify-center px-4 sm:px-6 lg:px-8 py-24 text-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Category</p>
                <h1 class="font-heading text-4xl sm:text-5xl font-bold"><span class="text-gradient-animate">{{ $category->name }}</span></h1>
                @if ($category->description)
                    <p class="mt-5 text-gray-300 max-w-2xl mx-auto leading-relaxed">{{ $category->description }}</p>
                @endif

                @if ($category->children->isNotEmpty())
                    <div class="mt-8 flex flex-wrap justify-center gap-3">
                        @foreach ($category->children as $child)
                            <a href="{{ route('category.show', $child) }}" class="rounded-full border border-white/20 px-4 py-1.5 text-sm text-gray-200 hover:border-red-600 hover:text-white transition">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
            @forelse ($products as $product)
                @include('partials.product-card', ['product' => $product])
            @empty
                <p class="col-span-full text-gray-500">No products in this category yet.</p>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</x-layouts.storefront>
