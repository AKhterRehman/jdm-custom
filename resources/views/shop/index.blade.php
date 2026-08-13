<style>
    .price-slider {
        position: relative;
        width: 100%;
        height: 24px;
    }

    .price-slider-track {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 6px;
        transform: translateY(-50%);
        border-radius: 9999px;
        background-color: #d6d3d1;
        z-index: 1;
    }

    .price-slider-fill {
        position: absolute;
        top: 50%;
        height: 6px;
        transform: translateY(-50%);
        border-radius: 9999px;
        background-color: #dc2626;
        z-index: 2;
    }

    .dual-range {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 24px;
        margin: 0;
        padding: 0;
        background: transparent;
        border: 0;
        outline: none;
        pointer-events: none;
        appearance: none;
        -webkit-appearance: none;
        z-index: 3;
    }

    .dual-range::-webkit-slider-runnable-track {
        height: 6px;
        background: transparent;
        border: none;
    }

    .dual-range::-moz-range-track {
        height: 6px;
        background: transparent;
        border: none;
    }

    .dual-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;

        width: 18px;
        height: 18px;

        margin-top: -6px;

        border-radius: 50%;
        border: 2px solid #ffffff;
        background-color: #1c1917;

        cursor: grab;
        pointer-events: auto;

        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
    }

    .dual-range::-moz-range-thumb {
        width: 18px;
        height: 18px;

        border-radius: 50%;
        border: 2px solid #ffffff;
        background-color: #1c1917;

        cursor: grab;
        pointer-events: auto;

        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
    }
</style>
<x-layouts.storefront title="Shop">
    <section class="relative overflow-hidden bg-ink-900 text-white"
        style="background-image: url('{{ asset('images/hero-wood-bg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.18),_transparent_60%)]">
        </div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Full Catalog</p>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold">Shop All <span
                    class="text-gradient-animate">Creations</span></h1>
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
                    @if (request('min_price'))
                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                    @endif
                    @if (request('max_price'))
                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                    @endif
                </form>

                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">Categories</p>
                <ul class="space-y-1 text-sm">
                    <li>
                        <a href="{{ route('shop.index', array_filter([
    'search' => request('search'),
    'min_price' => request('min_price'),
    'max_price' => request('max_price'),
    'sort' => request('sort'),
], fn($value) => $value !== null && $value !== '')) }}"
                            class="block rounded-md px-3 py-2 {{ !request('category_id') ? 'bg-ink-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                            All Categories
                        </a>
                    </li>
                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('shop.index', array_filter([
                            'category_id' => $category->id,
                            'search' => request('search'),
                            'min_price' => request('min_price'),
                            'max_price' => request('max_price'),
                            'sort' => request('sort'),
                        ], fn($value) => $value !== null && $value !== '')) }}"
                                                class="block rounded-md px-3 py-2 {{ request('category_id') == $category->id ? 'bg-ink-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                    @endforeach
                </ul>

                <div x-data="{
        min: {{ (int) request('min_price', 0) }},
        max: {{ (int) request('max_price', 300) }},
        floor: 0,
        ceil: 300,

        get minPercent() {
            return ((this.min - this.floor) / (this.ceil - this.floor)) * 100;
        },

        get maxPercent() {
            return ((this.max - this.floor) / (this.ceil - this.floor)) * 100;
        },

        clamp(value) {
            return Math.max(
                this.floor,
                Math.min(this.ceil, Number(value))
            );
        },

        updateMin(value) {
            this.min = Math.min(
                this.clamp(value),
                this.max
            );
        },

        updateMax(value) {
            this.max = Math.max(
                this.clamp(value),
                this.min
            );
        }
    }" class="mt-6 rounded-lg border border-gray-200 bg-white p-4">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-widest text-gray-400">
                        Filter by Price
                    </p>

                    <div class="mb-4 flex items-center justify-between text-sm text-gray-600">
                        <span class="font-semibold text-ink-900" x-text="'$' + min"></span>

                        <span class="font-semibold text-ink-900" x-text="'$' + max"></span>
                    </div>

                    <form method="GET">

                        <div class="price-slider">

                            {{-- Background track --}}
                            <div class="price-slider-track"></div>

                            {{-- Selected range --}}
                            <div class="price-slider-fill" :style="{
            left: minPercent + '%',
            width: (maxPercent - minPercent) + '%'
        }"></div>

                            {{-- Minimum --}}
                            <input type="range" min="0" max="300" step="5" x-model.number="min"
                                @input="updateMin($event.target.value)" class="dual-range">

                            {{-- Maximum --}}
                            <input type="range" min="0" max="300" step="5" x-model.number="max"
                                @input="updateMax($event.target.value)" class="dual-range">

                        </div>
                        <input type="hidden" name="min_price" :value="min">

                        <input type="hidden" name="max_price" :value="max">

                        @if (request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif

                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        @if (request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <div class="mt-5 flex gap-2">
                            <button type="submit"
                                class="rounded-md bg-ink-900 px-3 py-2 text-sm font-medium text-white hover:bg-ink-800">
                                Apply
                            </button>

                            @php
                                $resetParams = [];

                                if (request('category_id')) {
                                    $resetParams['category_id'] = request('category_id');
                                }

                                if (request('search')) {
                                    $resetParams['search'] = request('search');
                                }

                                if (request('sort')) {
                                    $resetParams['sort'] = request('sort');
                                }
                            @endphp

                            <a href="{{ route('shop.index', $resetParams) }}"
                                class="rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                Reset
                            </a>
                        </div>

                    </form>
                </div>
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
                        @if (request('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if (request('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
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