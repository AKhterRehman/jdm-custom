<x-layouts.storefront title="Privacy Policy">
    <section class="bg-ink-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-3">Legal</p>
            <h1 class="font-heading text-4xl font-bold">Privacy Policy</h1>
            <p class="mt-3 text-gray-400 text-sm">Last updated: {{ now()->format('F j, Y') }}</p>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 prose-sm">
        <div class="space-y-10 text-gray-700 leading-relaxed">
            <p class="text-gray-500 italic">
                This is a sample privacy policy for demonstration purposes. Replace this content with policy
                text reviewed by legal counsel before launch.
            </p>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">1. Information We Collect</h2>
                <p>
                    When you create an account, place an order, or contact us, we collect information such as
                    your name, email address, phone number, shipping address, and order history. We also collect
                    limited technical information (browser type, IP address) to keep the site secure and functioning.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">2. How We Use Your Information</h2>
                <p>
                    We use your information to process orders, provide customer support, send order and account
                    notifications, and improve our products and services. We do not sell your personal
                    information to third parties.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">3. Payment Information</h2>
                <p>
                    Payment details are processed by our payment partners and are not stored on our servers in
                    unencrypted form. Cash on Delivery orders are recorded only as an order-level payment method.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">4. Cookies</h2>
                <p>
                    We use cookies to keep you logged in, remember your cart, and understand how the site is
                    used. You can disable cookies in your browser, though some features may not work correctly.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">5. Your Rights</h2>
                <p>
                    You may request access to, correction of, or deletion of your personal data at any time by
                    contacting us. Account deletion is also available from your account settings.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">6. Contact</h2>
                <p>
                    Questions about this policy can be sent to <a href="{{ route('pages.contact') }}" class="text-red-600 hover:underline">our contact page</a>
                    or emailed directly to support@jdmcustom.com.
                </p>
            </div>
        </div>
    </div>
</x-layouts.storefront>
