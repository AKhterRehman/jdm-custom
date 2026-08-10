<x-layouts.storefront title="Terms and Conditions">
    <section class="relative overflow-hidden bg-ink-900 text-white"
        style="background-image: url('{{ asset('images/hero-wood-bg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(220,38,38,0.18),_transparent_60%)]">
        </div>
        <div
            class="relative mx-auto flex min-h-[280px] max-w-5xl items-center justify-center px-4 sm:px-6 lg:px-8 py-24 text-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-4">Legal</p>
                <h1 class="font-heading text-4xl sm:text-5xl font-bold">Terms &amp; <span class="text-gradient-animate">
                        Conditions</span></h1>
                <p class="mt-5 text-gray-300 max-w-2xl mx-auto leading-relaxed">Last updated:
                    {{ now()->format('F j, Y') }}
                </p>
            </div>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="space-y-10 text-gray-700 leading-relaxed">
            <p class="text-gray-500 italic">
                Welcome to JDM Custom Creations! These Terms and Conditions outline the rules and regulations for using
                our website and services. By accessing or using our site, you agree to these terms. Please read them
                carefully before placing an order or interacting with our platform.
            </p>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">1. Acceptance of Terms</h2>
                <p>
                    By accessing our website or making a purchase, you agree to comply with these Terms and Conditions.
                    If you do not agree, please refrain from using our site or services.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">2. Product Information and Custom
                    Orders</h2>
                <p>
                    We strive to provide accurate descriptions and images of our products. However, due to the
                    handcrafted nature of our work, slight variations may occur. For custom orders, it is your
                    responsibility to provide clear instructions, and we will confirm all details before starting
                    production.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">3. Pricing and Payments</h2>
                <p>
                    All prices listed on our website are in [Currency] and are subject to change without prior notice.
                    Payments must be made in full at the time of purchase or as per any agreed payment terms for custom
                    orders. We accept [list payment methods].
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">4. Shipping and Delivery</h2>
                <p>
                    We aim to deliver your order within the estimated time frame provided at checkout. Delays may occur
                    due to factors beyond our control, such as weather or carrier issues. Customers are responsible for
                    providing accurate shipping information; we are not liable for orders delivered to incorrect
                    addresses.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">5. Returns and Refunds</h2>
                <p>
                    Due to the custom nature of many of our products, returns and refunds may not be applicable unless
                    the item arrives damaged or defective. In such cases, please contact us within [X] days of receiving
                    your order, and we will work to resolve the issue promptly.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">6. Intellectual Property</h2>
                <p>
                    All content on this website, including text, images, and designs, is the intellectual property of
                    JDM Custom Creations. Reproduction, distribution, or use of our content without prior written
                    consent is strictly prohibited.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">7. User Responsibilities</h2>
                <p>
                    You agree to use our website and services responsibly and refrain from any activities that could
                    harm, disrupt, or interfere with the functionality of the site.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">8. Limitation of Liability</h2>
                <p>
                    JDM Custom Creations is not liable for any indirect, incidental, or consequential damages arising
                    from the use of our website or services. Our liability is limited to the value of the product
                    purchased.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">9. Governing Law</h2>
                <p>
                    These Terms and Conditions are governed by and construed in accordance with the laws of [Your
                    Country/State]. Any disputes arising from these terms shall be resolved in the courts of [Your
                    Jurisdiction].
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">10. Changes to Terms and Conditions
                </h2>
                <p>
                    We reserve the right to update these Terms and Conditions at any time. Changes will be effective
                    immediately upon posting on this page. Continued use of our website indicates your acceptance of any
                    modified terms.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">8. Contact</h2>
                <p>
                    If you have any questions about this Privacy Policy or how we handle your personal information,
                    please contact us at:
                    <br>
                    Email: <a href="mailto:jdmadvancedbuilders@gmail.com"
                        class="text-red-600 hover:underline">jdmadvancedbuilders@gmail.com</a>
                    <br>
                    Phone: <a href="tel:+1234567890" class="text-red-600 hover:underline">+1 (234) 567-890</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.storefront>