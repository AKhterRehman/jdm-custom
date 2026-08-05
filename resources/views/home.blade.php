<x-layouts.storefront>
    <section class="relative overflow-hidden bg-ink-900 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.18),_transparent_60%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_bottom,transparent,rgba(0,0,0,0.4))]"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 sm:py-36 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-5">Handcrafted &middot; Custom &middot; Made Your Way</p>
            <h1 class="font-heading text-5xl sm:text-7xl font-bold tracking-tight leading-[1.05]">
                Wood Art, <span class="text-red-600">Handcrafted</span> for You
            </h1>
            <p class="mt-6 text-lg text-gray-300 max-w-2xl mx-auto leading-relaxed">
                From intricate engravings to CNC art, shadow boxes, and jewelry boxes — custom wooden
                creations shaped with precision and finished by hand.
            </p>
            <div class="mt-10 flex items-center justify-center gap-4">
                <a href="#featured" class="rounded-md bg-red-600 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-500 transition">Shop Now</a>
                <a href="#categories" class="rounded-md border border-white/20 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:border-white/50 transition">Browse Categories</a>
            </div>
        </div>
    </section>

    <section id="categories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Our Expertise</p>
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900">Shop by Category</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category) }}" class="group relative overflow-hidden rounded-xl border border-gray-200 p-6 text-center transition hover:-translate-y-1 hover:border-red-600 hover:shadow-xl">
                    <p class="font-heading font-semibold text-ink-900 group-hover:text-red-600 transition">{{ $category->name }}</p>
                </a>
            @endforeach
        </div>
    </section>

    @if ($featuredProducts->isNotEmpty())
        <section id="featured" class="bg-gray-50 border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="flex items-end justify-between mb-14">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Handpicked</p>
                        <h2 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900">Featured Products</h2>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach ($featuredProducts as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="flex items-end justify-between mb-14">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Just Landed</p>
                <h2 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900">New Arrivals</h2>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
            @foreach ($newArrivals as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    <section class="bg-ink-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <h2 class="font-heading text-3xl sm:text-4xl font-bold">Turning Ideas Into Timeless Pieces</h2>
            <p class="mt-5 text-gray-300 leading-relaxed">
                Every piece we build blends traditional woodworking with modern CNC precision — crafted to be
                functional, meaningful, and made to last. This is custom work, shaped by hand.
            </p>
            <a href="{{ route('home') }}#categories" class="mt-8 inline-block rounded-md bg-red-600 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-500 transition">Start Shopping</a>
        </div>
    </section>
</x-layouts.storefront>
