<x-layouts.storefront title="About Us">
    <section class="relative overflow-hidden bg-ink-900 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.18),_transparent_60%)]"></div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Our Story</p>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold">About JDM Custom</h1>
            <p class="mt-5 text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Built by enthusiasts, for enthusiasts. We source and engineer the parts that turn a daily driver
                into something worth building a garage around.
            </p>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid md:grid-cols-2 gap-16 items-start">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Who We Are</p>
                <h2 class="font-heading text-2xl sm:text-3xl font-bold text-ink-900 mb-4">Started in a garage, built for the track</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    JDM Custom started with a simple frustration: sourcing reliable, fitment-verified performance
                    parts for JDM platforms shouldn't mean gambling on marketplace listings. We built the catalog
                    we wished existed — vetted turbochargers, body kits, wheels, and suspension components backed
                    by people who actually wrench on these cars.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Every product on this site is chosen for fitment accuracy, material quality, and real-world
                    durability — not just spec-sheet numbers. Whether you're building a weekend track car or
                    upgrading your daily, we carry parts that hold up.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="rounded-xl border border-gray-200 p-6">
                    <p class="font-heading text-3xl font-bold text-red-600">15+</p>
                    <p class="text-sm text-gray-500 mt-1">Product Categories</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-6">
                    <p class="font-heading text-3xl font-bold text-red-600">100%</p>
                    <p class="text-sm text-gray-500 mt-1">Fitment Verified</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-6">
                    <p class="font-heading text-3xl font-bold text-red-600">24-48h</p>
                    <p class="text-sm text-gray-500 mt-1">Order Processing</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-6">
                    <p class="font-heading text-3xl font-bold text-red-600">2 Yr</p>
                    <p class="text-sm text-gray-500 mt-1">Warranty Standard</p>
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
                    <h3 class="font-heading font-semibold text-ink-900 mb-2">Fitment First</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Every part is checked against real chassis and drivetrain specs before it goes on the shelf.</p>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-ink-900 mb-2">Track-Proven</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">We test what we sell — components are chosen because they hold up under real load, not just on paper.</p>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-ink-900 mb-2">Community Built</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Feedback from builders shapes our catalog. This is a store run by people who build cars too.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <h2 class="font-heading text-2xl sm:text-3xl font-bold text-ink-900 mb-4">Ready to build?</h2>
        <p class="text-gray-600 mb-8">Browse the full catalog or get in touch if you need help picking the right parts for your build.</p>
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('shop.index') }}" class="rounded-md bg-ink-900 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-600 transition">Shop Now</a>
            <a href="{{ route('pages.contact') }}" class="rounded-md border border-gray-300 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-ink-900 hover:border-red-600 transition">Contact Us</a>
        </div>
    </section>
</x-layouts.storefront>
