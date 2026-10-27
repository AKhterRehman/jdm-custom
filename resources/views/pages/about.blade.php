<x-layouts.storefront :dark="true" :overlay="true" title="Our Story">
    @php $automotive = \App\Models\Category::where('slug', 'automotive-art')->where('is_active', true)->first(); @endphp

    {{-- HERO --}}
    <section class="relative isolate overflow-hidden bg-ink-900 text-[#ece7da]">
        <x-page-bg image="luxury-garage-hero.jpg" />

        <div class="mx-auto grid max-w-[88rem] items-center gap-14 px-5 pb-24 pt-40 sm:px-8 lg:grid-cols-12 lg:gap-10 lg:px-12 lg:pb-28 lg:pt-44">
            <div class="lg:col-span-6" data-reveal>
                <div class="flex items-center gap-4">
                    <span class="rule-gold"></span>
                    <p class="label text-gold-500">Our Story</p>
                </div>
                <h1 class="mt-9 font-lux font-normal leading-[0.98] tracking-[-0.015em] text-[clamp(3rem,6.2vw,6.2rem)]">
                    Woodwork with a<br><em class="font-normal italic text-gold-300">story to tell.</em>
                </h1>
            </div>
            <div class="lg:col-span-4 lg:col-start-9" data-reveal style="transition-delay: 120ms">
                <div class="plate-mat mx-auto aspect-[4/5] max-w-[24rem] lg:max-w-none">
                    <img src="{{ asset('images/df211347-0d1d-4047-9ded-30cdf48ee89555.webp') }}" alt="The maker carving a piece by hand" class="h-full w-full object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- THE STORY --}}
    <section class="bg-ink-900 py-28 sm:py-36">
        <div class="mx-auto grid max-w-[88rem] gap-12 px-5 sm:px-8 lg:grid-cols-12 lg:gap-10 lg:px-12">
            <div class="lg:col-span-4" data-reveal>
                <p class="label text-gold-500">The JDM story</p>
            </div>
            <div class="space-y-8 lg:col-span-7" data-reveal>
                <p class="font-lux text-[clamp(1.6rem,2.4vw,2.2rem)] leading-[1.35] text-white">At JDM Custom Creations, we are passionate artisans dedicated to bringing your ideas to life through the timeless beauty of handcrafted woodwork.</p>
                <p class="max-w-2xl font-label text-[1.05rem] font-light leading-[1.9] text-[#b9b5ab]">Our journey began with a simple mission: to create unique, custom made pieces that reflect the individuality and vision of our customers.</p>
                <p class="max-w-2xl font-label text-[1.05rem] font-light leading-[1.9] text-[#b9b5ab]">Today, we blend traditional craftsmanship with modern innovation to deliver exceptional wooden creations. Every piece is meticulously crafted with attention to detail, whether it is a cherished keepsake, a decorative statement, or a personalized gift.</p>
            </div>
        </div>
    </section>

    {{-- WHAT WE STAND FOR --}}
    <section class="border-y border-white/10 bg-charcoal-900">
        <div class="mx-auto grid max-w-[88rem] px-5 sm:px-8 lg:grid-cols-3 lg:px-12">
            @foreach ([
                ['01', 'Built with purpose', 'Functional, meaningful pieces made to last.'],
                ['02', 'Made your way', 'Your vision guides every cut, curve, and finish.'],
                ['03', 'Made for real moments', 'From our hands to your home.'],
            ] as [$number, $title, $text])
                <div class="border-t border-white/10 py-14 first:border-t-0 lg:border-l lg:border-t-0 lg:px-10 lg:first:border-l-0 lg:first:pl-0" data-reveal style="transition-delay: {{ $loop->index * 90 }}ms">
                    <p class="label text-gold-500">{{ $number }}</p>
                    <h3 class="mt-5 font-lux text-[1.9rem] leading-tight text-white">{{ $title }}</h3>
                    <p class="mt-4 max-w-xs font-label font-light leading-relaxed text-[#b9b5ab]">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- MISSION --}}
    <section class="bg-ink-900 py-28 sm:py-36">
        <div class="mx-auto grid max-w-[88rem] items-center gap-14 px-5 sm:px-8 lg:grid-cols-12 lg:gap-10 lg:px-12">
            <div class="lg:col-span-5 lg:col-start-1" data-reveal>
                <div class="plate-mat mx-auto aspect-[3/4] max-w-[26rem] lg:max-w-none">
                    <img src="{{ asset('images/jdm-custom-creations-2-2.webp') }}" alt="A hand finished JDM Custom Creations sign" loading="lazy" class="h-full w-full object-cover">
                </div>
            </div>
            <div class="lg:col-span-6 lg:col-start-7" data-reveal style="transition-delay: 120ms">
                <p class="label text-gold-500">Our mission</p>
                <h2 class="mt-5 font-lux text-[clamp(2.4rem,4vw,3.8rem)] font-normal leading-[1.04] tracking-[-0.01em] text-white">Your vision, <em class="font-normal italic text-gold-300">beautifully made.</em></h2>
                <p class="mt-8 max-w-xl font-label text-[1.05rem] font-light leading-[1.85] text-[#b9b5ab]">To bring your vision to life through exceptional craftsmanship, innovative design, and unmatched attention to detail.</p>

                <div class="mt-14 border-t border-white/10 pt-10">
                    <p class="label text-gold-500">What we do</p>
                    <h3 class="mt-4 font-lux text-[1.9rem] leading-tight text-white">Craft, technology, and heart.</h3>
                    <p class="mt-4 max-w-xl font-label font-light leading-relaxed text-[#b9b5ab]">From automotive crests and CNC shadow boxes to jewelry boxes, epoxy signs, 3D models, murals, and personalized signs. Every piece is a labor of love.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- COMMITMENT --}}
    <section class="border-t border-white/10 bg-charcoal-900 py-28 sm:py-36">
        <div class="mx-auto grid max-w-[88rem] items-center gap-14 px-5 sm:px-8 lg:grid-cols-12 lg:gap-10 lg:px-12">
            <div class="lg:col-span-6 lg:order-1" data-reveal>
                <p class="label text-gold-500">Our commitment</p>
                <h2 class="mt-5 font-lux text-[clamp(2.4rem,4vw,3.8rem)] font-normal leading-[1.04] tracking-[-0.01em] text-white">More than products. <em class="font-normal italic text-gold-300">Memories.</em></h2>
                <p class="mt-8 max-w-xl font-label text-[1.05rem] font-light leading-[1.85] text-[#b9b5ab]">We proudly serve individuals, families, and businesses with one of a kind creations that stand the test of time.</p>
                <div class="mt-11 flex flex-col items-start gap-6 sm:flex-row sm:items-center sm:gap-9">
                    @if ($automotive)
                        <a href="{{ route('category.show', $automotive) }}" class="btn-solid">Explore our work</a>
                    @endif
                    <a href="{{ route('pages.contact') }}?inquiry_type=custom-order" class="link-line">Commission a piece</a>
                </div>
            </div>
            <div class="lg:col-span-5 lg:col-start-8 lg:order-2" data-reveal style="transition-delay: 120ms">
                <div class="plate-mat mx-auto aspect-[4/5] max-w-[26rem] lg:max-w-none">
                    <img src="{{ asset('images/jdm-custom-creations-3.webp') }}" alt="Customers holding handcrafted JDM Custom Creations pieces" loading="lazy" class="h-full w-full object-cover object-top">
                </div>
            </div>
        </div>
    </section>
</x-layouts.storefront>
