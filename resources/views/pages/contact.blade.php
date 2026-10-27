<x-layouts.storefront :dark="true" title="Contact Us">
    <section class="page-head relative isolate overflow-hidden bg-ink-900 text-[#ece7da]">
        <x-page-bg image="luxury-garage-commission.jpg" />
        <div class="mx-auto max-w-[88rem] px-5 py-16 sm:px-8 sm:py-20 lg:px-12">
            <h1 class="font-lux text-[clamp(2.8rem,6vw,5.2rem)] font-normal leading-[1] tracking-[-0.015em]">Contact <em class="font-normal italic text-gold-300">us.</em></h1>
            <p class="mt-7 max-w-lg font-label text-[1.02rem] font-light leading-relaxed text-[#cfcabd]">Questions about a custom piece, an order, or a personalized design? We're here to help.</p>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-2 gap-16">
            <div>
                @if (session('status'))
                    <div class="mb-6 rounded-none bg-green-500/10 border border-green-500/30 px-4 py-3 text-sm text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-none bg-red-500/10 border border-red-500/30 px-4 py-3 text-sm text-red-300">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h2 class="font-lux text-xl font-normal text-[#ece7da] mb-2">Tell us about your enquiry</h2>
                <p class="mb-6 text-sm text-[#8f949c]">Fields marked with <span class="text-gold-400">*</span> are required. Share your preferred dimensions, design, logo, colors, and quantity for a faster custom quote.</p>

                <form action="{{ route('pages.contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-[#d3cec1]">Full name <span class="text-gold-400">*</span></label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="w-full rounded-none border-white/15 text-sm" placeholder="Your full name">
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-[#d3cec1]">Email address <span class="text-gold-400">*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-none border-white/15 text-sm" placeholder="you@example.com">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-medium text-[#d3cec1]">Phone number</label>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" class="w-full rounded-none border-white/15 text-sm" placeholder="+1 (555) 000-0000">
                        </div>
                        <div>
                            <label for="company_name" class="mb-1.5 block text-sm font-medium text-[#d3cec1]">Company or organization</label>
                            <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" autocomplete="organization" class="w-full rounded-none border-white/15 text-sm" placeholder="Optional">
                        </div>
                    </div>
                    <div>
                        <label for="inquiry_type" class="mb-1.5 block text-sm font-medium text-[#d3cec1]">What can we help with?</label>
                        <select id="inquiry_type" name="inquiry_type" class="w-full rounded-none border-white/15 text-sm">
                            <option value="">Select an enquiry type</option>
                            @foreach (['general' => 'General enquiry', 'custom-order' => 'Custom order', 'existing-order' => 'Existing order', 'product-question' => 'Product question', 'wholesale' => 'Wholesale or trade', 'other' => 'Other'] as $value => $label)
                                <option value="{{ $value }}" @selected((old('inquiry_type', request('inquiry_type')) === $value))>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="subject" class="mb-1.5 block text-sm font-medium text-[#d3cec1]">Subject <span class="text-gold-400">*</span></label>
                        <input id="subject" type="text" name="subject" value="{{ old('subject') }}" required class="w-full rounded-none border-white/15 text-sm" placeholder="A short summary of your enquiry">
                    </div>
                    <div>
                        <label for="message" class="mb-1.5 block text-sm font-medium text-[#d3cec1]">Message <span class="text-gold-400">*</span></label>
                        <textarea id="message" name="message" rows="6" required class="w-full rounded-none border-white/15 text-sm" placeholder="Tell us about your idea, requirements, or question.">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="rounded-none bg-[#ece7da] px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-ink-900 hover:bg-gold-500 transition">
                        Send Message
                    </button>
                </form>
            </div>

            <div>
                <h2 class="font-lux text-xl font-normal text-[#ece7da] mb-6">Visit or reach us</h2>
                <dl class="space-y-4 text-sm mb-8">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-[#8f949c]">Address</dt>
                        <dd class="text-[#d3cec1] mt-1">1245 Torrance Blvd, Los Angeles, CA 90501</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-[#8f949c]">Email</dt>
                        <dd class="text-[#d3cec1] mt-1">support@jdmcustom.com</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-[#8f949c]">Phone</dt>
                        <dd class="text-[#d3cec1] mt-1">+1 (555) 019-4420</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-widest text-[#8f949c]">Hours</dt>
                        <dd class="text-[#d3cec1] mt-1">Mon&ndash;Fri, 9am&ndash;6pm PST</dd>
                    </div>
                </dl>

                <div class="rounded-none overflow-hidden border border-white/10 aspect-video">
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
