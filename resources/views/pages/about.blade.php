<x-layouts.storefront title="About Us">
    <section class="relative overflow-hidden bg-ink-900 text-white" style="background-image: url('{{ asset('images/hero-wood-bg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.18),_transparent_60%)]"></div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Our Story</p>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold">About JDM <span class="text-gradient-animate">Custom</span> Creations</h1>
            <p class="mt-5 text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Handcrafted wooden creations that blend traditional woodworking with modern CNC precision 
                built by artisans who care about the details.
            </p>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid md:grid-cols-2 gap-16 items-start">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Who We Are</p>
                <h2 class="font-heading text-2xl sm:text-3xl font-bold text-ink-900 mb-4">Bringing your ideas to life in wood</h2>
               <p class="text-gray-600 leading-relaxed mb-4">
                    JDM Custom Creations began with a simple goal: build one-of-a-kind wooden pieces that reflect
                    the people who order them. What started as a small workshop has grown into a full custom
                    shop, but the approach hasn't changed. Every piece is still made to order, by hand.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    We work across engraving, CNC-cut art, shadow boxes, jewelry boxes, epoxy signage, layered
                    3D CNC models, murals, and custom board games. Bamboo is our go-to material for its strength
                    and grain, but we work in hardwoods and plywood too, depending on what a piece calls for.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="rounded-xl border border-gray-200 p-6">
                    <p class="font-heading text-3xl font-bold text-red-600">9</p>
                    <p class="text-sm text-gray-500 mt-1">Craft Categories</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-6">
                    <p class="font-heading text-3xl font-bold text-red-600">100%</p>
                    <p class="text-sm text-gray-500 mt-1">Made to Order</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-6">
                    <p class="font-heading text-3xl font-bold text-red-600">CNC</p>
                    <p class="text-sm text-gray-500 mt-1">Precision Cut</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-6">
                    <p class="font-heading text-3xl font-bold text-red-600">Hand</p>
                    <p class="text-sm text-gray-500 mt-1">Finished Every Piece</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 border-y border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3 text-center">What Drives Us</p>
            <h2 class="font-heading text-2xl sm:text-3xl font-bold text-ink-900 mb-12 text-center">Our Values</h2>
            <div class="grid sm:grid-cols-3 gap-8 text-center">
                <div>
                    <h3 class="font-heading font-semibold text-ink-900 mb-2">Made to Order</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Every piece is built for the person who ordered it — not pulled off a shelf.</p>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-ink-900 mb-2">Craft Meets Precision</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Modern CNC tooling paired with hand-finishing for detail that holds up close.</p>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-ink-900 mb-2">Built to Last</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Quality materials and real joinery, so a piece stays in the family for years.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-ink-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <h2 class="font-heading text-3xl sm:text-4xl font-bold">Have an idea in mind?</h2>
            <p class="mt-5 text-gray-300 leading-relaxed">
                Browse the full catalog or reach out and we'll help you bring your piece to life.
            </p>
            <div class="mt-8 flex items-center justify-center gap-4">
                <a href="{{ route('shop.index') }}" class="rounded-md bg-red-600 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-500 transition">Shop Now</a>
                <a href="{{ route('pages.contact') }}" class="rounded-md border border-white/30 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:border-red-500 hover:text-red-400 transition">Contact Us</a>
            </div>
        </div>
    </section>
</x-layouts.storefront>
