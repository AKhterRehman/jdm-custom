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
                    Ready-made items that arrive damaged or defective may be returned or exchanged within 30
                    days of delivery. Because most pieces are custom-built or personalized to order, made-to-order
                    and engraved items are final sale unless the piece arrives damaged or does not match the
                    approved design.
                </p>
            </div>

            <div>
                <h2 class="font-heading text-lg font-semibold text-ink-900 mb-3">4. Custom &amp; Personalized Orders</h2>
                <p>
                    Personalization details (names, dates, dimensions, wood or finish selections) are the buyer's
                    responsibility to confirm before an order goes into production. Production begins once an
                    order is placed, so changes after that point may not be possible.
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
                    JDM Custom Creations is not liable for indirect, incidental, or consequential damages arising
                    from the use of products purchased through this site.
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
