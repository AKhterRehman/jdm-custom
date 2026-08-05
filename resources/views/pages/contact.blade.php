<x-layouts.storefront title="Contact Us">
    <section class="bg-ink-900 text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-3">Get In Touch</p>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold">Contact Us</h1>
            <p class="mt-4 text-gray-300 max-w-xl mx-auto">Questions about fitment, an order, or a custom build? We're here to help.</p>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-2 gap-16">
            <div>
                @if (session('status'))
                    <div class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h2 class="font-heading text-xl font-semibold text-ink-900 mb-6">Send us a message</h2>

                <form action="{{ route('pages.contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Your name" required class="w-full rounded-md border-gray-300 text-sm">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required class="w-full rounded-md border-gray-300 text-sm">
                    </div>
                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject" required class="w-full rounded-md border-gray-300 text-sm">
                    <textarea name="message" rows="6" placeholder="How can we help?" required class="w-full rounded-md border-gray-300 text-sm">{{ old('message') }}</textarea>
                    <button type="submit" class="rounded-md bg-ink-900 px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-600 transition">
                        Send Message
                    </button>
                </form>
            </div>

            <div>
                <h2 class="font-heading text-xl font-semibold text-ink-900 mb-6">Visit or reach us</h2>
                <dl class="space-y-4 text-sm mb-8">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-gray-400">Address</dt>
                        <dd class="text-gray-700 mt-1">1245 Torrance Blvd, Los Angeles, CA 90501</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-gray-400">Email</dt>
                        <dd class="text-gray-700 mt-1">support@jdmcustom.com</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-gray-400">Phone</dt>
                        <dd class="text-gray-700 mt-1">+1 (555) 019-4420</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-gray-400">Hours</dt>
                        <dd class="text-gray-700 mt-1">Mon&ndash;Fri, 9am&ndash;6pm PST</dd>
                    </div>
                </dl>

                <div class="rounded-xl overflow-hidden border border-gray-200 aspect-video">
                    <iframe
                        class="w-full h-full"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=-118.2937%2C34.0022%2C-118.1937%2C34.1022&layer=mapnik&marker=34.0522%2C-118.2437"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</x-layouts.storefront>
