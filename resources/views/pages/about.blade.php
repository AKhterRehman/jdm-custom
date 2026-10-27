<x-layouts.storefront :dark="true" title="About Us">
    @php $automotive = \App\Models\Category::where('slug', 'automotive-art')->where('is_active', true)->first(); @endphp

    <section class="relative isolate overflow-hidden border-b border-white/10 bg-ink-900 text-white">
        <img src="{{ asset('images/luxury-garage-hero.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-50" aria-hidden="true">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-ink-900/80 via-ink-900/60 to-ink-900"></div>
        <div class="relative mx-auto max-w-4xl px-4 py-28 text-center sm:px-6 lg:px-8">
            <p class="lux-eyebrow">The Artist</p>
            <h1 class="mt-5 font-display text-5xl font-medium tracking-tight sm:text-7xl">Made by hand.<br><span class="italic text-gold-300">Made for collectors.</span></h1>
            <div class="lux-rule mx-auto mt-8"></div>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 py-20 text-center sm:px-6 sm:py-28">
        <p class="font-display text-2xl leading-relaxed text-silver-300 sm:text-3xl">
            JDM Custom Creations builds hand-finished automotive art in hardwood and epoxy. Every crest is designed,
            carved, and finished one at a time, made to order for the garage it will hang in.
        </p>
        <p class="mx-auto mt-8 max-w-xl leading-relaxed text-silver-400">
            The workshop also builds custom furniture, signs, and CNC pieces, but automotive art is the work it is known for.
        </p>
    </section>

    <section class="border-y border-white/10 bg-charcoal-900">
        <div class="mx-auto grid max-w-5xl gap-12 px-4 py-20 text-center sm:grid-cols-3 sm:px-6">
            @foreach ([
                ['Made to order', 'Nothing comes off a shelf. Each piece is built for the person who ordered it.'],
                ['Hand finished', 'Hardwood, epoxy, and a gloss finish, brought up by hand.'],
                ['Commissions welcome', 'Any marque, any crest, any size. Tell us the car.'],
            ] as [$title, $text])
                <div data-reveal>
                    <div class="lux-rule mx-auto mb-6"></div>
                    <h3 class="font-display text-2xl text-white">{{ $title }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-silver-400">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-ink-900 py-24 text-center">
        <div class="mx-auto max-w-xl px-4" data-reveal>
            <h2 class="font-display text-4xl font-medium text-white sm:text-5xl">Commission a piece</h2>
            <div class="mt-10 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ route('pages.contact') }}?inquiry_type=custom-order" class="btn-gold">Start a Commission</a>
                @if ($automotive)
                    <a href="{{ route('category.show', $automotive) }}" class="btn-ghost">View the Collection</a>
                @endif
            </div>
        </div>
    </section>
</x-layouts.storefront>
