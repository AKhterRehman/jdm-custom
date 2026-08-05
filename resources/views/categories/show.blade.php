<x-layouts.storefront :title="$category->name">
    <section class="bg-ink-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-3">Category</p>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="mt-4 text-gray-300 max-w-2xl">{{ $category->description }}</p>
            @endif

            @if ($category->children->isNotEmpty())
                <div class="mt-8 flex flex-wrap gap-3">
                    @foreach ($category->children as $child)
                        <a href="{{ route('category.show', $child) }}" class="rounded-full border border-white/20 px-4 py-1.5 text-sm text-gray-200 hover:border-red-600 hover:text-white transition">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            @endif
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
