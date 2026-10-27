<x-layouts.storefront :dark="true">
    @php
        // Hero slider: every slide is the same overlapping composition. The centre piece changes
        // each slide and its neighbours flank it, so every automotive piece gets its turn.
        // [piece offset, left, top, width, floats on the delayed beat, stacking]
        $slots = [
            [1, '28%', '0%', '46%', false, 'z-20'],
            [0, '0%', '30%', '33%', true, 'z-10'],
            [2, '70%', '22%', '30%', true, 'z-10'],
        ];
        $pieceCount = $sliderPieces->count();

        $marques = ['Porsche', 'Lamborghini', 'Mercedes AMG', 'Bentley', 'Rolls Royce', 'Aston Martin', 'BMW M', 'Shelby'];
    @endphp

    {{-- HERO: the artwork leads, copy stays minimal. --}}
    <section class="relative isolate overflow-hidden bg-ink-900 text-white">
        <img src="{{ asset('images/luxury-garage-hero.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-75" aria-hidden="true">
        <div class="absolute inset-0 -z-10 bg-[linear-gradient(90deg,rgba(11,11,13,0.96)_0%,rgba(11,11,13,0.72)_42%,rgba(11,11,13,0.3)_100%)]"></div>
        <div class="absolute inset-x-0 bottom-0 -z-10 h-40 bg-gradient-to-t from-ink-900 to-transparent"></div>

        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 lg:min-h-[calc(100vh-6rem)] lg:grid-cols-12 lg:gap-8 lg:px-8 lg:py-20">
            <div class="lg:col-span-5" data-reveal>
                <p class="lux-eyebrow">JDM Custom Creations</p>
                <h1 class="mt-6 font-display text-5xl font-medium leading-[1.02] tracking-tight sm:text-7xl">
                    Automotive art,<br><span class="text-gradient-animate italic">handcrafted.</span>
                </h1>
                <div class="lux-rule mt-8"></div>
                <p class="mt-8 max-w-md text-base leading-relaxed text-silver-300">
                    Hand-finished hardwood and epoxy crests, made to order for the collector's garage.
                </p>
                <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                    @if ($automotive)
                        <a href="{{ route('category.show', $automotive) }}" class="btn-gold">View the Collection</a>
                    @endif
                    <a href="{{ route('pages.contact') }}?inquiry_type=custom-order" class="btn-ghost">Commission a Piece</a>
                </div>
            </div>

            <div class="lg:col-span-7">
                @if ($pieceCount >= 3)
                    <div class="mx-auto w-full max-w-2xl" data-art-slider>
                        <div class="relative aspect-[6/5] w-full">
                            @for ($k = 0; $k < $pieceCount; $k++)
                                @php $center = $sliderPieces[($k + 1) % $pieceCount]; @endphp
                                <div class="art-slide {{ $k === 0 ? 'is-active' : '' }}"
                                     data-title="{{ \Illuminate\Support\Str::before(\Illuminate\Support\Str::before($center->name, ' | '), ' – ') }}"
                                     data-url="{{ route('product.show', $center) }}"
                                     @if ($k !== 0) aria-hidden="true" @endif>
                                    @foreach ($slots as $slotIndex => [$offset, $left, $top, $width, $delayed, $layer])
                                        @php $piece = $sliderPieces[($k + $offset) % $pieceCount]; @endphp
                                        <a href="{{ route('product.show', $piece) }}" tabindex="{{ $k === 0 ? '0' : '-1' }}"
                                           class="art-card art-piece absolute block {{ $layer }}"
                                           style="left: {{ $left }}; top: {{ $top }}; width: {{ $width }}; transition-delay: {{ $slotIndex * 90 }}ms;"
                                           aria-label="{{ \Illuminate\Support\Str::before(\Illuminate\Support\Str::before($piece->name, ' | '), ' – ') }}">
                                            <div class="lux-float {{ $delayed ? 'lux-float-delay' : '' }}">
                                                <div class="art-plate shadow-[0_40px_80px_-30px_rgba(0,0,0,0.95)]" style="aspect-ratio: {{ $piece->slider_aspect }};">
                                                    <img src="{{ $piece->slider_src }}" alt="{{ \Illuminate\Support\Str::before(\Illuminate\Support\Str::before($piece->name, ' | '), ' – ') }}" class="h-full w-full object-cover" decoding="async">
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endfor
                        </div>

                        <div class="mt-8 flex items-center justify-between gap-4">
                            <button type="button" data-art-prev class="art-arrow" aria-label="Previous piece">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                            </button>
                            <div class="min-w-0 flex-1 text-center">
                                <a href="#" data-art-caption class="block truncate font-display text-2xl italic text-white transition hover:text-gold-300" aria-live="polite"></a>
                                <div class="mt-3 flex flex-wrap items-center justify-center gap-1.5" role="tablist" aria-label="Choose a piece">
                                    @for ($k = 0; $k < $pieceCount; $k++)
                                        <button type="button" data-art-dot class="art-dot {{ $k === 0 ? 'is-active' : '' }}" role="tab" aria-label="Show piece {{ $k + 1 }}" aria-selected="{{ $k === 0 ? 'true' : 'false' }}"></button>
                                    @endfor
                                </div>
                            </div>
                            <button type="button" data-art-next class="art-arrow" aria-label="Next piece">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- MARQUE STRIP --}}
    <div class="border-y border-white/10 bg-ink-900 py-5">
        <div class="marque-strip">
            <div class="marque-strip__track">
                @for ($i = 0; $i < 4; $i++)
                    <div class="flex shrink-0 items-center">
                        @foreach ($marques as $marque)
                            <span class="whitespace-nowrap px-8 font-display text-2xl italic text-silver-400">{{ $marque }}</span>
                            <span class="text-[0.5rem] text-gold-500">&#9670;</span>
                        @endforeach
                    </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- THE COLLECTION --}}
    @if ($collection->isNotEmpty())
        <section id="collection" class="bg-ink-900 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end" data-reveal>
                    <div>
                        <p class="lux-eyebrow">Automotive Art</p>
                        <h2 class="mt-4 font-display text-4xl font-medium text-white sm:text-6xl">The Collection</h2>
                        <div class="lux-rule mt-6"></div>
                    </div>
                    @if ($automotive)
                        <a href="{{ route('category.show', $automotive) }}" class="text-[0.7rem] font-semibold uppercase tracking-[0.28em] text-silver-300 transition hover:text-gold-400">View all &rarr;</a>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-x-5 gap-y-14 lg:grid-cols-3 lg:gap-x-8">
                    @foreach ($collection as $piece)
                        <div data-reveal style="transition-delay: {{ ($loop->index % 3) * 80 }}ms">
                            @include('partials.product-card', ['product' => $piece, 'dark' => true])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- COMMISSION --}}
    <section class="relative isolate overflow-hidden bg-ink-900 py-28 sm:py-36">
        <img src="{{ asset('images/luxury-garage-commission.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-45" loading="lazy" aria-hidden="true">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-ink-900 via-ink-900/70 to-ink-900"></div>
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6" data-reveal>
            <p class="lux-eyebrow">Made to order</p>
            <h2 class="mt-5 font-display text-4xl font-medium leading-tight text-white sm:text-6xl">Your marque. <span class="italic text-gold-300">Your crest.</span></h2>
            <p class="mx-auto mt-6 max-w-lg text-silver-300">Tell us the car. We design, carve, and finish a piece for your garage.</p>
            <div class="mt-10 flex justify-center">
                <a href="{{ route('pages.contact') }}?inquiry_type=custom-order" class="btn-gold">Request a Custom Piece</a>
            </div>
            <div class="mx-auto mt-14 flex max-w-xl flex-wrap items-center justify-center gap-x-8 gap-y-3 border-t border-white/10 pt-8 text-[0.7rem] uppercase tracking-[0.24em] text-silver-400">
                @foreach ([['24"', '$400'], ['30"', '$600'], ['36"', '$800'], ['46"', '$1,200']] as [$size, $price])
                    <span>{{ $size }} <span class="text-gold-400">from {{ $price }}</span></span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ALSO FROM THE WORKSHOP: deliberately small and quiet. --}}
    @if ($workshop->isNotEmpty())
        <section class="bg-charcoal-900 py-20 sm:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex items-end justify-between" data-reveal>
                    <div>
                        <p class="lux-eyebrow">Also from the workshop</p>
                        <h2 class="mt-3 font-display text-3xl text-white sm:text-4xl">Furniture &amp; custom work</h2>
                    </div>
                    <a href="{{ route('shop.index') }}" class="hidden text-[0.7rem] font-semibold uppercase tracking-[0.28em] text-silver-300 transition hover:text-gold-400 sm:block">Shop all &rarr;</a>
                </div>
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 lg:gap-6">
                    @foreach ($workshop as $category)
                        <a href="{{ route('category.show', $category) }}" class="art-card group block" data-reveal style="transition-delay: {{ $loop->index * 70 }}ms">
                            <div class="art-plate aspect-square">
                                <img src="{{ $category->cover->images->first()->url() }}" alt="{{ $category->name }}" class="h-full w-full object-cover opacity-80 transition group-hover:opacity-100" loading="lazy">
                            </div>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-[0.24em] text-silver-300 transition group-hover:text-gold-300">{{ $category->name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- STORY: one line, the full story lives on the About page. --}}
    <section class="border-t border-white/10 bg-ink-900 py-16">
        <div class="mx-auto flex max-w-4xl flex-col items-center gap-6 px-4 text-center sm:px-6" data-reveal>
            <p class="font-display text-2xl italic text-silver-300 sm:text-3xl">Designed, carved, and finished by hand.</p>
            <a href="{{ route('pages.about') }}" class="text-[0.7rem] font-semibold uppercase tracking-[0.3em] text-gold-400 transition hover:text-gold-300">Our story &rarr;</a>
        </div>
    </section>
</x-layouts.storefront>
