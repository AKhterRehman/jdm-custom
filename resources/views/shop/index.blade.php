<x-layouts.storefront title="Shop">
     <section class="relative overflow-hidden bg-ink-900 text-white" style="background-image: url('http://jdm-custom.test/images/hero-wood-bg.jpg'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.18),_transparent_60%)]"></div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Full Catalog</p>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold">Shop All <span class="text-gradient-animate">Creations</span></h1>
            <p class="mt-5 text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Handcrafted wooden creations that blend traditional woodworking with modern CNC precision 
                built by artisans who care about the details.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-4 gap-10">
            <aside class="lg:col-span-1">
                <form method="GET" class="mb-8">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                        class="w-full rounded-md border-gray-300 text-sm">
                    @if (request('category_id'))
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    @endif
                    @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>

                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">Categories</p>
                <ul class="space-y-1 text-sm">
                    <li>
                        <a href="{{ route('shop.index') }}"
                            class="block rounded-md px-3 py-2 {{ !request('category_id') ? 'bg-ink-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                            All Categories
                        </a>
                    </li>
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', ['category_id' => $category->id]) }}"
                                class="block rounded-md px-3 py-2 {{ request('category_id') == $category->id ? 'bg-ink-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-8">
                    <p class="text-sm text-gray-500">{{ $products->total() }} products</p>
                    <form method="GET">
                        @if (request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <select name="sort" onchange="this.form.submit()" class="rounded-md border-gray-300 text-sm">
                            <option value="newest" @selected($sort === 'newest')>Newest</option>
                            <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-10">
                    @forelse ($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @empty
                        <p class="col-span-full text-gray-500">No products found.</p>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.storefront>