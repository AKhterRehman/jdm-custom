<x-layouts.storefront title="Contact Us">
    <section class="relative overflow-hidden bg-ink-900 text-white" style="background-image: url('http://jdm-custom.test/images/hero-wood-bg.jpg'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.18),_transparent_60%)]"></div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Get In Touch</p>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold">Contact <span class="text-gradient-animate">Us</span></h1>
            <p class="mt-5 text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Questions about a custom piece, an order, or a personalized design? We're here to help.
            </p>
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

                <h2 class="font-heading text-xl font-semibold text-ink-900 mb-2">Tell us about your enquiry</h2>
                <p class="mb-6 text-sm text-gray-500">Fields marked with <span class="text-red-600">*</span> are required. The more detail you share, the better we can help.</p>

                <form action="{{ route('pages.contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Full name <span class="text-red-600">*</span></label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="w-full rounded-md border-gray-300 text-sm" placeholder="Your full name">
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email address <span class="text-red-600">*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-md border-gray-300 text-sm" placeholder="you@example.com">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-medium text-gray-700">Phone number</label>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" class="w-full rounded-md border-gray-300 text-sm" placeholder="+1 (555) 000-0000">
                        </div>
                        <div>
                            <label for="company_name" class="mb-1.5 block text-sm font-medium text-gray-700">Company or organization</label>
                            <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" autocomplete="organization" class="w-full rounded-md border-gray-300 text-sm" placeholder="Optional">
                        </div>
                    </div>
                    <div>
                        <label for="inquiry_type" class="mb-1.5 block text-sm font-medium text-gray-700">What can we help with?</label>
                        <select id="inquiry_type" name="inquiry_type" class="w-full rounded-md border-gray-300 text-sm">
                            <option value="">Select an enquiry type</option>
                            @foreach (['general' => 'General enquiry', 'custom-order' => 'Custom order', 'existing-order' => 'Existing order', 'product-question' => 'Product question', 'wholesale' => 'Wholesale or trade', 'other' => 'Other'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('inquiry_type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="subject" class="mb-1.5 block text-sm font-medium text-gray-700">Subject <span class="text-red-600">*</span></label>
                        <input id="subject" type="text" name="subject" value="{{ old('subject') }}" required class="w-full rounded-md border-gray-300 text-sm" placeholder="A short summary of your enquiry">
                    </div>
                    <div>
                        <label for="message" class="mb-1.5 block text-sm font-medium text-gray-700">Message <span class="text-red-600">*</span></label>
                        <textarea id="message" name="message" rows="6" required class="w-full rounded-md border-gray-300 text-sm" placeholder="Tell us about your idea, requirements, or question.">{{ old('message') }}</textarea>
                    </div>
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
