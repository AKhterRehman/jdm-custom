<x-layouts.storefront title="Terms and Conditions">
    <section class="bg-ink-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500 mb-3">Legal</p>
            <h1 class="font-heading text-4xl font-bold">Terms &amp; Conditions</h1>
            <p class="mt-3 text-gray-400 text-sm">Last updated: {{ now()->format('F j, Y') }}</p>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="space-y-10 text-gray-700 leading-relaxed">
            <p class="text-gray-500 italic">
                This is sample terms &amp; conditions content for demonstration purposes. Replace with terms
                reviewed by legal counsel before launch.
            </p>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">1. Orders &amp; Payment</h2>
                <p>
                    By placing an order, you confirm the shipping and billing details provided are accurate.
                    Orders are confirmed once payment is authorized (or, for Cash on Delivery, once the order is
                    placed). We reserve the right to cancel orders due to stock or pricing errors.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">2. Shipping &amp; Delivery</h2>
                <p>
                    Delivery timeframes shown at checkout are estimates, not guarantees. Risk of loss passes to
                    you upon delivery to the shipping carrier. Shipping fees are non-refundable once an order has
                    shipped.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">3. Returns &amp; Warranty</h2>
                <p>
                    Products carry the manufacturer or store warranty period listed on the product page. Parts
                    that arrive damaged or defective may be returned or exchanged within 30 days of delivery.
                    Installed or modified parts are not eligible for return.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">4. Product Fitment</h2>
                <p>
                    Fitment information is provided as a guide. It is the buyer's responsibility to confirm
                    compatibility with their specific vehicle configuration before installation.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">5. Account Use</h2>
                <p>
                    You are responsible for maintaining the confidentiality of your account credentials and for
                    all activity that occurs under your account.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">6. Limitation of Liability</h2>
                <p>
                    JDM Custom is not liable for indirect, incidental, or consequential damages arising from the
                    use or installation of products purchased through this site.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">7. Contact</h2>
                <p>
                    Questions about these terms can be sent via <a href="{{ route('pages.contact') }}" class="text-red-600 hover:underline">our contact page</a>.
                </p>
            </div>
        </div>
    </div>
</x-layouts.storefront>
