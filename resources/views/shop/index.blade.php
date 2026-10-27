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
        background-color: #2b2b30;
        z-index: 1;
    }

    .price-slider-fill {
        position: absolute;
        top: 50%;
        height: 6px;
        transform: translateY(-50%);
        border-radius: 9999px;
        background-color: #c0a062;
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
        border: 2px solid #0b0b0d;
        background-color: #c0a062;

        cursor: grab;
        pointer-events: auto;

        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
    }

    .dual-range::-moz-range-thumb {
        width: 18px;
        height: 18px;

        border-radius: 50%;
        border: 2px solid #0b0b0d;
        background-color: #c0a062;

        cursor: grab;
        pointer-events: auto;

        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
    }
</style>
<x-layouts.storefront :dark="true" title="Shop">
    <section class="page-head relative isolate overflow-hidden bg-ink-900 text-[#ece7da]">
        <x-page-bg image="luxury-garage-commission.jpg" />
        <div class="mx-auto max-w-[88rem] px-5 py-24 sm:px-8 sm:py-28 lg:px-12">
            <h1 class="font-lux text-[clamp(2.8rem,6vw,5.2rem)] font-normal leading-[1] tracking-[-0.015em]">The full catalog</h1>
            <p class="mt-4 font-lux text-[clamp(1.5rem,2.6vw,2.4rem)] italic leading-snug text-gold-300">Every piece, in one place.</p>
        </div>
    </section>

    <div class="mx-auto max-w-[88rem] px-5 py-16 sm:px-8 sm:py-20 lg:px-12">
        <div class="grid gap-12 lg:grid-cols-4 lg:gap-12">
            <aside class="lg:col-span-1" x-data="{ open: false }">
                <button type="button" @click="open = !open" :aria-expanded="open" class="btn-line mb-6 w-full lg:hidden">
                    <span x-text="open ? 'Hide filters' : 'Search and filters'"></span>
                </button>
                <div :class="open ? 'block' : 'hidden'" class="lg:block">
                <form method="GET" class="mb-8">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                        class="w-full text-sm">
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

                <p class="mb-4 font-lux text-xl text-[#ece7da]">Categories</p>
                <ul class="space-y-1 text-sm">
                    <li>
                        <a href="{{ route('shop.index', array_filter([
    'search' => request('search'),
    'min_price' => request('min_price'),
    'max_price' => request('max_price'),
    'sort' => request('sort'),
], fn($value) => $value !== null && $value !== '')) }}"
                            class="block px-3 py-2.5 {{ !request('category_id') ? 'border-l border-gold-500 bg-white/5 text-gold-300' : 'border-l border-transparent text-[#b9b5ab] hover:bg-white/5 hover:text-white' }}">
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
                                                class="block px-3 py-2.5 {{ request('category_id') == $category->id ? 'border-l border-gold-500 bg-white/5 text-gold-300' : 'border-l border-transparent text-[#b9b5ab] hover:bg-white/5 hover:text-white' }}">
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
    }" class="mt-8 border border-white/10 p-5">
                    <p class="mb-5 font-lux text-xl text-[#ece7da]">Filter by price</p>

                    <div class="mb-4 flex items-center justify-between text-sm text-silver-300">
                        <span class="font-semibold text-white" x-text="'$' + min"></span>

                        <span class="font-semibold text-white" x-text="'$' + max"></span>
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
                                class="btn-solid !px-5 !py-2.5 !text-[0.66rem]">
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
                                class="btn-line !px-5 !py-2.5 !text-[0.66rem]">
                                Reset
                            </a>
                        </div>

                    </form>
                </div>
                            </div>
            </aside>

            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-8">
                    <p class="label text-[#8f949c]">{{ $products->total() }} pieces</p>
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
                        <select name="sort" onchange="this.form.submit()" class="text-sm">
                            <option value="newest" @selected($sort === 'newest')>Newest</option>
                            <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-2 gap-x-5 gap-y-14 md:grid-cols-3 lg:gap-x-8">
                    @forelse ($products as $product)
                        @include('partials.product-card', ['product' => $product, 'dark' => true])
                    @empty
                        <p class="col-span-full text-[#8f949c]">No pieces found.</p>
                    @endforelse
                </div>

                <div class="mt-16 dark-pagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

</x-layouts.storefront>