<x-layouts.storefront :title="$category->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold">{{ $category->name }}</h1>
        @if ($category->description)
            <p class="mt-2 text-gray-600 max-w-2xl">{{ $category->description }}</p>
        @endif

        @if ($category->children->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-3">
                @foreach ($category->children as $child)
                    <a href="{{ route('category.show', $child) }}" class="rounded-full border border-gray-300 px-4 py-1.5 text-sm hover:border-red-600 hover:text-red-600 transition">
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-6">
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
