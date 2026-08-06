<x-layouts.storefront>
    <style>
        .category-tile { position: relative; display: flex; flex-direction: column; gap: 0.5rem; min-height: 6.75rem; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #fecaca; border-radius: 0.875rem; background: #fff1f2; box-shadow: 0 1px 2px rgba(15, 23, 42, 0.02); transition: transform 220ms ease, border-color 220ms ease, box-shadow 220ms ease; }
        .category-tile::before { position: absolute; inset: 0; background: #fff; content: ''; opacity: 0; transition: opacity 220ms ease; }
        .category-tile::after { position: absolute; top: 0; left: 1.25rem; right: 1.25rem; height: 3px; border-radius: 0 0 999px 999px; background: #dc2626; content: ''; transform: scaleX(0); transition: transform 220ms ease; }
        .category-tile:hover, .category-tile:focus-visible { border-color: #e2e8f0; box-shadow: 0 14px 28px rgba(15, 23, 42, 0.10); transform: translateY(-5px) rotate(-0.4deg); }
        .category-tile:hover::before, .category-tile:focus-visible::before { opacity: 1; }
        .category-tile:hover::after, .category-tile:focus-visible::after { transform: scaleX(1); }
        .category-tile:focus-visible { outline: 2px solid #dc2626; outline-offset: 3px; }
        .category-tile__icon { position: relative; z-index: 1; color: #dc2626; transition: transform 300ms ease; }
        .category-tile:hover .category-tile__icon, .category-tile:focus-visible .category-tile__icon { transform: scale(1.15) rotate(-6deg); }
        .category-tile__name { position: relative; z-index: 1; color: #b91c1c; font-family: Lexend, sans-serif; font-weight: 700; transition: color 220ms ease, transform 220ms ease; }
        .category-tile:hover .category-tile__name, .category-tile:focus-visible .category-tile__name { color: #111827; transform: translateY(-2px); }
    </style>

    @php
        $categoryIcons = [
            'Engraving' => '<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />',
            'CNC' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.526c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.526c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.425-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />',
            'Shadow' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h12A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6Z" /><path stroke-linecap="round" stroke-linejoin="round" d="m9 9 3 3m0 0 3 3m-3-3 3-3m-3 3-3 3" />',
            'Jewelry' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H4.5a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-2.25c0-.621-.504-1.125-1.125-1.125h-18C2.754 6.75 2.25 7.254 2.25 7.875v2.25c0 .621.504 1.125 1.125 1.125Z" />',
            'Epoxy' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12h19.5M12 2.25a15.3 15.3 0 0 1 4.243 10.5 15.3 15.3 0 0 1-4.243 10.5 15.3 15.3 0 0 1-4.243-10.5A15.3 15.3 0 0 1 12 2.25Z" />',
            '3D' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5-9-5.25M21 7.5v9l-9 5.25M21 7.5 12 12.75m0 8.25L3 16.5v-9m9 13.5V12.75m0 0L3 7.5m9 5.25 9-5.25M3 7.5l9-5.25 9 5.25" />',
            'Murals' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75 6 12l3.75 3.75M13.5 8.25 17.25 12l3.75-3.75M3.75 21h16.5A1.5 1.5 0 0 0 21.75 19.5v-15A1.5 1.5 0 0 0 20.25 3H3.75A1.5 1.5 0 0 0 2.25 4.5v15A1.5 1.5 0 0 0 3.75 21Z" /><circle cx="8" cy="8" r="1.5" />',
            'Signs' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5c.414 0 .75-.336.75-.75 0-.231-.035-.454-.1-.664m-5.8 0a2.251 2.251 0 0 1 5.8 0m-5.8 0c-.376.023-.75.05-1.124.08C9.098 4.01 8.25 4.973 8.25 6.108V8.25m8.7-4.414c.376.023.75.05 1.124.08 1.226.098 2.075 1.061 2.075 2.196V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.108c0-1.135.85-2.098 2.075-2.196.374-.03.748-.057 1.124-.08M9.75 12h4.5m-4.5 3.75h4.5" />',
            'Board Games' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h6.75v6.75H3.75V3.75Zm0 9.75h6.75v6.75H3.75v-6.75Zm9.75-9.75h6.75v6.75h-6.75V3.75ZM16.5 16.5h.75v.75h-.75v-.75Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5h.008v.008h-.008V19.5Zm-3-1.5h.008v.008h-.008V18Z" />',
        ];

        $iconFor = function ($name) use ($categoryIcons) {
            foreach ($categoryIcons as $needle => $svg) {
                if (str_contains($name, $needle)) {
                    return $svg;
                }
            }

            return $categoryIcons['CNC'];
        };
    @endphp

    <section class="relative overflow-hidden bg-ink-900 text-white">
        {{-- Real walnut wood-grain photograph as the hero background, with a warm top-right
             highlight and a dark gradient layered on top so the white headline stays readable. --}}
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/hero-wood-bg.jpg') }}');"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_110%_80%_at_85%_-10%,_rgba(255,196,120,0.35),_transparent_55%)] mix-blend-soft-light"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.15),_transparent_60%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(200deg,_rgba(0,0,0,0.35)_0%,_rgba(0,0,0,0.55)_55%,_rgba(0,0,0,0.75)_100%)]"></div>

        {{-- Blueprint drafting grid — a faint CAD/CNC-style measure grid, tying the background
             to the precision-engineering side of the craft rather than pure decoration. --}}
        <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-[0.08]" aria-hidden="true">
            <defs>
                <pattern id="blueprint-grid" width="42" height="42" patternUnits="userSpaceOnUse">
                    <path d="M 42 0 L 0 0 0 42" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#blueprint-grid)" />
        </svg>

        {{-- Corner registration marks, like a CNC toolpath origin/crop reference. --}}
        <div class="absolute top-6 left-6 h-9 w-9 border-t-2 border-l-2 border-red-500/40 hidden sm:block" aria-hidden="true"></div>
        <div class="absolute top-6 right-6 h-9 w-9 border-t-2 border-r-2 border-red-500/40 hidden sm:block" aria-hidden="true"></div>
        <div class="absolute bottom-6 left-6 h-9 w-9 border-b-2 border-l-2 border-red-500/40 hidden sm:block" aria-hidden="true"></div>
        <div class="absolute bottom-6 right-6 h-9 w-9 border-b-2 border-r-2 border-red-500/40 hidden sm:block" aria-hidden="true"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 sm:py-36 text-center">
            <div class="inline-flex items-center gap-2 rounded-full border border-red-500/30 bg-red-500/10 px-4 py-1.5 mb-6" data-reveal>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-3.5 w-3.5 text-red-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.526c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.526c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.425-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-400">Handcrafted &middot; Custom &middot; Made Your Way</p>
            </div>
            <h1 class="font-heading text-5xl sm:text-7xl font-bold tracking-tight leading-[1.05]">
                Wood Art, <span class="text-gradient-animate">Handcrafted</span> for You
            </h1>
            <p class="mt-6 text-lg text-gray-300 max-w-2xl mx-auto leading-relaxed">
                From intricate engravings to CNC art, shadow boxes, and jewelry boxes, custom wooden
                creations shaped with precision and finished by hand.
            </p>
            <div class="mt-10 flex items-center justify-center gap-4">
                <a href="#featured" class="shine-btn rounded-md bg-red-600 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-500 transition">Shop Now</a>
                <a href="#categories" class="rounded-md border border-white/20 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:border-white/50 transition">Browse Categories</a>
            </div>

            {{-- Precision stats strip — real, database-driven numbers rather than stock marketing copy. --}}
            <div class="mt-16 grid grid-cols-2 sm:grid-cols-4 gap-y-8 gap-x-4 max-w-3xl mx-auto border-t border-white/10 pt-10" data-reveal>
                <div>
                    <p class="font-heading text-3xl sm:text-4xl font-bold text-white" data-counter data-value="{{ $totalProducts }}" data-suffix="+">0+</p>
                    <p class="mt-1 text-[11px] uppercase tracking-widest text-gray-400">Pieces Crafted</p>
                </div>
                <div>
                    <p class="font-heading text-3xl sm:text-4xl font-bold text-white" data-counter data-value="{{ $categories->count() }}">0</p>
                    <p class="mt-1 text-[11px] uppercase tracking-widest text-gray-400">Craft Categories</p>
                </div>
                <div>
                    <p class="font-heading text-3xl sm:text-4xl font-bold text-white">&plusmn;0.1<span class="text-lg">mm</span></p>
                    <p class="mt-1 text-[11px] uppercase tracking-widest text-gray-400">CNC Precision</p>
                </div>
                <div>
                    <p class="font-heading text-3xl sm:text-4xl font-bold text-white" data-counter data-value="100" data-suffix="%">0%</p>
                    <p class="mt-1 text-[11px] uppercase tracking-widest text-gray-400">Handfinished</p>
                </div>
            </div>
        </div>
    </section>

    <div class="marquee bg-red-600 py-2.5">
        <div class="marquee__track">
            @for ($i = 0; $i < 2; $i++)
                <div class="flex items-center shrink-0">
                    @foreach (['Handcrafted', 'Made to Order', 'CNC Precision', 'Free Shipping', '9 Craft Categories', 'Built to Last'] as $tag)
                        <span class="px-6 text-xs font-bold uppercase tracking-[0.2em] text-white whitespace-nowrap">{{ $tag }}</span>
                        <span class="text-white/50">&#9670;</span>
                    @endforeach
                </div>
            @endfor
        </div>
    </div>

    <section id="categories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center mb-14" data-reveal>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Our Expertise</p>
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900">Shop by Category</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category) }}" class="category-tile p-6 text-center" data-reveal style="transition-delay: {{ $loop->index * 60 }}ms">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="category-tile__icon h-7 w-7">
                        {!! $iconFor($category->name) !!}
                    </svg>
                    <p class="category-tile__name">{{ $category->name }}</p>
                </a>
            @endforeach
        </div>
    </section>

    @if ($featuredProducts->isNotEmpty())
        <section id="featured" class="bg-gray-50 border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="flex items-end justify-between mb-14" data-reveal>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Handpicked</p>
                        <h2 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900">Featured Products</h2>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach ($featuredProducts as $product)
                        <div data-reveal style="transition-delay: {{ $loop->index * 70 }}ms">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="flex items-end justify-between mb-14" data-reveal>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Just Landed</p>
                <h2 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900">New Arrivals</h2>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
            @foreach ($newArrivals as $product)
                <div data-reveal style="transition-delay: {{ $loop->index * 70 }}ms">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </section>

    <section class="relative overflow-hidden bg-ink-900 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_rgba(220,38,38,0.16),_transparent_55%)]"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center" data-reveal>
            <h2 class="font-heading text-3xl sm:text-4xl font-bold">Turning Ideas Into <span class="text-gradient-animate">Timeless</span> Pieces</h2>
            <p class="mt-5 text-gray-300 leading-relaxed">
                Every piece we build blends traditional woodworking with modern CNC precision,  crafted to be
                functional, meaningful, and made to last. This is custom work, shaped by hand.
            </p>
            <a href="{{ route('home') }}#categories" class="shine-btn mt-8 inline-block rounded-md bg-red-600 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-500 transition">Start Shopping</a>
        </div>
    </section>
</x-layouts.storefront>
