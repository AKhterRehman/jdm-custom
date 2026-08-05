<x-layouts.storefront>
    <section class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">Built for the JDM Faithful</h1>
            <p class="mt-4 text-lg text-gray-300 max-w-2xl mx-auto">
                Premium engine, body, and performance parts sourced and engineered for serious JDM builds.
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl font-bold mb-8">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category) }}" class="group rounded-lg border border-gray-200 p-6 text-center hover:border-red-600 hover:shadow-md transition">
                    <p class="font-semibold text-gray-900 group-hover:text-red-600">{{ $category->name }}</p>
                </a>
            @endforeach
        </div>
    </section>

    @if ($featuredProducts->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100">
            <h2 class="text-2xl font-bold mb-8">Featured Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100">
        <h2 class="text-2xl font-bold mb-8">New Arrivals</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($newArrivals as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
</x-layouts.storefront>
