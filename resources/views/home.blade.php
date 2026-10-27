<x-layouts.storefront :dark="true" :overlay="true">
    @php
        $firstSize = $sizes[0] ?? null;
        $lastSize = $sizes ? $sizes[count($sizes) - 1] : null;
        $sizeRange = $firstSize && $lastSize ? $firstSize['inches'].' to '.$lastSize['inches'].' inch' : null;
        $featuredCount = $featured->count();
    @endphp

    {{-- HERO --}}
    <section class="relative isolate overflow-hidden bg-ink-900 text-[#ece7da]" data-hero>
        <img src="{{ asset('images/luxury-garage-hero.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-95 brightness-110 contrast-105" aria-hidden="true">
        <div class="absolute inset-0 -z-10 bg-[linear-gradient(95deg,rgba(11,11,13,0.9)_0%,rgba(11,11,13,0.55)_38%,rgba(11,11,13,0.12)_100%)]"></div>
        <div class="absolute inset-x-0 bottom-0 -z-10 h-40 bg-gradient-to-t from-ink-900 to-transparent"></div>

        <div class="mx-auto grid min-h-[100svh] max-w-[88rem] items-center gap-14 px-5 pb-20 pt-36 sm:px-8 lg:grid-cols-12 lg:gap-10 lg:px-12 lg:pb-16 lg:pt-32">
            <div class="lg:col-span-6 xl:col-span-6" data-reveal>
                <div class="flex items-center gap-4">
                    <span class="rule-gold"></span>
                    <p class="label text-gold-500">JDM Custom Creations</p>
                </div>
                <h1 class="mt-9 font-lux font-normal leading-[0.98] tracking-[-0.015em] text-[clamp(3rem,6.6vw,6.6rem)]">
                    Automotive art<br>for the <em class="font-normal italic text-gold-300">private garage.</em>
                </h1>
                <p class="mt-9 max-w-md font-label text-[1.02rem] font-light leading-relaxed text-[#b9b5ab]">
                    Hand finished crests in hardwood and epoxy. Each piece is made to order, one at a time.
                </p>
                <div class="mt-11 flex flex-col items-start gap-6 sm:flex-row sm:items-center sm:gap-9">
                    @if ($automotive)
                        <a href="{{ route('category.show', $automotive) }}" class="btn-solid">View the collection</a>
                    @endif
                    <a href="{{ route('pages.contact') }}?inquiry_type=custom-order" class="link-line">Commission a piece</a>
                </div>
            </div>

            @if ($featuredCount)
                <div class="lg:col-span-5 lg:col-start-8 xl:col-span-4 xl:col-start-9" data-reveal style="transition-delay: 120ms">
                    <div class="mx-auto w-full max-w-[26rem] lg:max-w-none" data-hero-slider>
                        <div class="plate-mat aspect-[4/5]">
                            <div class="relative h-full w-full overflow-hidden">
                                @foreach ($featured as $i => $piece)
                                    <a href="{{ route('product.show', $piece) }}" data-hero-piece
                                       data-name="{{ $piece->display_name }}" data-price="From ${{ number_format($piece->from_price) }}"
                                       class="hero-plate__img {{ $i === 0 ? 'is-active' : '' }}" tabindex="{{ $i === 0 ? '0' : '-1' }}"
                                       aria-label="{{ $piece->display_name }}">
                                        <img src="{{ $piece->plate_src }}" alt="{{ $piece->display_name }}" class="h-full w-full object-cover" draggable="false">
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-5 flex items-end justify-between gap-6">
                            <div class="min-w-0">
                                <p class="label text-silver-500"><span data-hero-count>01</span> / {{ str_pad($featuredCount, 2, '0', STR_PAD_LEFT) }}</p>
                                <p class="mt-2 truncate font-lux text-[1.45rem] leading-tight text-white" data-hero-name>{{ $featured[0]->display_name }}</p>
                            </div>
                            <p class="shrink-0 pb-1 font-label text-sm font-light text-[#b9b5ab]" data-hero-price>From ${{ number_format($featured[0]->from_price) }}</p>
                        </div>
                        <div class="hero-progress mt-5" aria-hidden="true"><span class="hero-progress__bar"></span></div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- THE COLLECTION --}}
    @if ($collection->isNotEmpty())
        <section id="collection" class="bg-ink-900 py-28 sm:py-36" data-index>
            <div class="mx-auto max-w-[88rem] px-5 sm:px-8 lg:px-12">
                <div class="mb-16 flex items-end justify-between gap-8 sm:mb-20" data-reveal>
                    <div>
                        <p class="label text-gold-500">The Collection</p>
                        <h2 class="mt-5 font-lux text-[clamp(2.4rem,4.4vw,4.2rem)] font-normal leading-[1.02] tracking-[-0.01em] text-white">Choose a marque.</h2>
                    </div>
                    @if ($automotive)
                        <a href="{{ route('category.show', $automotive) }}" class="link-line hidden sm:inline-block">View all pieces</a>
                    @endif
                </div>

                <div class="grid gap-14 lg:grid-cols-12 lg:gap-10">
                    <ol class="lg:col-span-6" data-reveal>
                        @foreach ($collection as $i => $piece)
                            <li>
                                <a href="{{ route('product.show', $piece) }}" data-index-row data-index="{{ $i }}"
                                   class="index-row {{ $i === 0 ? 'is-active' : '' }}">
                                    <span class="index-row__num label">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="index-row__thumb lg:hidden"><img src="{{ $piece->plate_src }}" alt="" loading="lazy" class="h-full w-full object-cover"></span>
                                    <span class="index-row__name font-lux">{{ $piece->marque }}</span>
                                    <span class="index-row__price font-label">From ${{ number_format($piece->from_price) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ol>

                    <div class="hidden lg:col-span-5 lg:col-start-8 lg:block">
                        <div class="sticky top-32">
                            <div class="plate-mat aspect-[4/5]">
                                <div class="relative h-full w-full overflow-hidden bg-[#0b0b0d]">
                                    @foreach ($collection as $i => $piece)
                                        <div data-index-image class="index-stage__img {{ $i === 0 ? 'is-active' : '' }}"
                                             data-name="{{ $piece->display_name }}" data-url="{{ route('product.show', $piece) }}">
                                            @if ($piece->plate_aspect > 0.85)
                                                <img src="{{ $piece->plate_src }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full scale-125 object-cover opacity-70 blur-2xl brightness-[.45]">
                                            @endif
                                            <img src="{{ $piece->plate_src }}" alt="{{ $piece->display_name }}" loading="lazy" class="relative h-full w-full {{ $piece->plate_aspect > 0.85 ? 'object-contain' : 'object-cover' }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-5 flex items-end justify-between gap-6">
                                <p class="min-w-0 font-lux text-[1.45rem] leading-tight text-white"><span class="block truncate" data-index-name>{{ $collection[0]->display_name }}</span></p>
                                <a href="{{ route('product.show', $collection[0]) }}" data-index-link class="link-line shrink-0">View piece</a>
                            </div>
                            @if ($sizeRange)
                                <p class="mt-2 font-label text-sm font-light text-silver-500">Hardwood and epoxy. {{ $sizeRange }}.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- SIZES --}}
    @if (count($sizes) >= 2)
        <section class="border-y border-white/10 bg-charcoal-900 py-28 sm:py-36">
            <div class="mx-auto max-w-[88rem] px-5 sm:px-8 lg:px-12">
                <div class="grid gap-14 lg:grid-cols-12 lg:gap-10">
                    <div class="lg:col-span-4" data-reveal>
                        <p class="label text-gold-500">Sizes</p>
                        <h2 class="mt-5 font-lux text-[clamp(2.4rem,4vw,3.8rem)] font-normal leading-[1.04] tracking-[-0.01em] text-white">The same crest, at four scales.</h2>
                        <p class="mt-7 max-w-sm font-label font-light leading-relaxed text-[#b9b5ab]">Every piece is made to order. Other dimensions are available on request, and shipping is calculated at checkout.</p>
                    </div>

                    <div class="lg:col-span-8" data-reveal>
                        @php $largest = max(array_column($sizes, 'inches')); @endphp
                        <div class="flex items-end gap-5 sm:gap-8">
                            @foreach ($sizes as $size)
                                <div class="min-w-0 flex-1">
                                    <div class="size-box" style="width: {{ round($size['inches'] / $largest * 100) }}%"></div>
                                    <p class="mt-5 font-lux text-2xl text-white sm:text-3xl">{{ $size['inches'] }}<span class="font-label text-sm font-light text-silver-500"> in</span></p>
                                    <p class="mt-1 font-label text-sm font-light text-[#b9b5ab]">${{ number_format($size['price']) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- COMMISSION --}}
    <section class="relative isolate overflow-hidden bg-ink-900 py-32 sm:py-44">
        <img src="{{ asset('images/luxury-garage-commission.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-95 brightness-110 contrast-105" loading="lazy" aria-hidden="true">
        {{-- A soft dark pool behind the copy keeps it readable while the car stays visible around it. --}}
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_55%_60%_at_50%_50%,rgba(11,11,13,0.8)_0%,rgba(11,11,13,0.4)_55%,rgba(11,11,13,0.08)_100%)]"></div>
        <div class="absolute inset-x-0 top-0 -z-10 h-28 bg-gradient-to-b from-ink-900 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 -z-10 h-28 bg-gradient-to-t from-ink-900 to-transparent"></div>
        <div class="mx-auto max-w-3xl px-5 text-center sm:px-8" data-reveal>
            <p class="label text-gold-500">Commissions</p>
            <h2 class="mt-6 font-lux text-[clamp(2.6rem,5.2vw,4.8rem)] font-normal leading-[1.02] tracking-[-0.015em] text-white">Your marque,<br><em class="font-normal italic text-gold-300">made to order.</em></h2>
            <p class="mx-auto mt-8 max-w-md font-label font-normal leading-relaxed text-[#e4dfd2]">Tell us the car. We design, carve and finish the piece for your garage.</p>
            <div class="mt-12 flex justify-center">
                <a href="{{ route('pages.contact') }}?inquiry_type=custom-order" class="btn-solid">Commission a piece</a>
            </div>
        </div>
    </section>

    {{-- OUR STORY: a short introduction, the full story lives on its own page. --}}
    <section class="bg-ink-900 py-28 sm:py-36">
        <div class="mx-auto grid max-w-[88rem] items-center gap-14 px-5 sm:px-8 lg:grid-cols-12 lg:gap-10 lg:px-12">
            <div class="lg:col-span-5" data-reveal>
                <div class="plate-mat mx-auto aspect-[4/5] max-w-[26rem] lg:max-w-none">
                    <img src="{{ asset('images/df211347-0d1d-4047-9ded-30cdf48ee89555.webp') }}" alt="The maker carving a piece by hand" loading="lazy" class="h-full w-full object-cover">
                </div>
            </div>
            <div class="lg:col-span-6 lg:col-start-7" data-reveal style="transition-delay: 120ms">
                <p class="label text-gold-500">Our Story</p>
                <h2 class="mt-5 font-lux text-[clamp(2.4rem,4.4vw,4.2rem)] font-normal leading-[1.04] tracking-[-0.01em] text-white">Woodwork with a <em class="font-normal italic text-gold-300">story to tell.</em></h2>
                <p class="mt-8 max-w-xl font-label text-[1.05rem] font-light leading-[1.85] text-[#b9b5ab]">At JDM Custom Creations, we are passionate artisans dedicated to bringing your ideas to life through the timeless beauty of handcrafted woodwork. Our journey began with a simple mission: to create unique, custom made pieces that reflect the individuality and vision of our customers.</p>
                <div class="mt-10">
                    <a href="{{ route('pages.about') }}" class="link-line">Read our story</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ALSO FROM THE WORKSHOP: a single quiet line. --}}
    @if ($workshop->isNotEmpty())
        <section class="border-t border-white/10 bg-ink-900 py-12">
            <div class="mx-auto flex max-w-[88rem] flex-col gap-5 px-5 sm:px-8 lg:flex-row lg:items-center lg:justify-between lg:px-12">
                <p class="label text-silver-500">Also from the workshop</p>
                <ul class="flex flex-wrap gap-x-9 gap-y-3">
                    @foreach ($workshop as $category)
                        <li><a href="{{ route('category.show', $category) }}" class="link-line">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
</x-layouts.storefront>
