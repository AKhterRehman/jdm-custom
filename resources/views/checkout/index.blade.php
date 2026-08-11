<x-layouts.storefront title="Checkout">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900 mb-10">Checkout</h1>

        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST" class="grid lg:grid-cols-3 gap-12">
            @csrf

            <div class="lg:col-span-2 space-y-10">
                @php
                    $selectedAddressId = old('address_id', $addresses->first()?->id);
                    $hasNewAddressInput = old('new_address.full_name') !== null;
                    $useNewAddress = $addresses->isEmpty() || old('address_id') === '' || ($hasNewAddressInput && old('address_id') === null);
                @endphp

                <section x-data="{ useNewAddress: @js($useNewAddress) }">
                    <h2 class="font-heading text-lg font-semibold text-ink-900 mb-4">Shipping Address</h2>

                    @if ($addresses->isNotEmpty())
                        <div class="space-y-3 mb-4">
                            @foreach ($addresses as $address)
                                <label class="flex items-start gap-3 rounded-md border border-gray-200 p-4 cursor-pointer has-[:checked]:border-red-600">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" @change="useNewAddress = false" @checked((string) $selectedAddressId === (string) $address->id) class="mt-1">
                                    <span class="text-sm">
                                        <span class="block font-medium text-gray-900">{{ $address->full_name }} &middot; {{ $address->phone }}</span>
                                        <span class="block text-gray-500">{{ $address->fullAddress() }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <details class="rounded-md border border-gray-200 p-4" x-bind:open="useNewAddress">
                        <summary class="cursor-pointer text-sm font-medium text-gray-700">Add a new address</summary>
                        <label class="mt-4 flex items-center gap-3 rounded-md border border-gray-200 bg-gray-50 px-4 py-3 cursor-pointer has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                            <input type="radio" name="address_id" value="" @change="useNewAddress = true" @checked($useNewAddress)>
                            <span class="text-sm font-medium text-gray-900">Use this new address for this order</span>
                        </label>
                        <div class="mt-4 grid sm:grid-cols-2 gap-4">
                            <input type="text" name="new_address[full_name]" value="{{ old('new_address.full_name') }}" placeholder="Full name" :disabled="!useNewAddress" class="rounded-md border-gray-300 text-sm disabled:bg-gray-100 disabled:text-gray-400">
                            <input type="text" name="new_address[phone]" value="{{ old('new_address.phone') }}" placeholder="Phone" :disabled="!useNewAddress" class="rounded-md border-gray-300 text-sm disabled:bg-gray-100 disabled:text-gray-400">
                            <input type="text" name="new_address[address_line1]" value="{{ old('new_address.address_line1') }}" placeholder="Address line 1" :disabled="!useNewAddress" class="rounded-md border-gray-300 text-sm sm:col-span-2 disabled:bg-gray-100 disabled:text-gray-400">
                            <input type="text" name="new_address[address_line2]" value="{{ old('new_address.address_line2') }}" placeholder="Address line 2 (optional)" :disabled="!useNewAddress" class="rounded-md border-gray-300 text-sm sm:col-span-2 disabled:bg-gray-100 disabled:text-gray-400">
                            <input type="text" name="new_address[city]" value="{{ old('new_address.city') }}" placeholder="City" :disabled="!useNewAddress" class="rounded-md border-gray-300 text-sm disabled:bg-gray-100 disabled:text-gray-400">
                            <input type="text" name="new_address[state]" value="{{ old('new_address.state') }}" placeholder="State / Province" :disabled="!useNewAddress" class="rounded-md border-gray-300 text-sm disabled:bg-gray-100 disabled:text-gray-400">
                            <input type="text" name="new_address[postal_code]" value="{{ old('new_address.postal_code') }}" placeholder="Postal code" :disabled="!useNewAddress" class="rounded-md border-gray-300 text-sm disabled:bg-gray-100 disabled:text-gray-400">
                            <input type="text" name="new_address[country]" value="{{ old('new_address.country') }}" placeholder="Country" :disabled="!useNewAddress" class="rounded-md border-gray-300 text-sm disabled:bg-gray-100 disabled:text-gray-400">
                        </div>
                        <p class="mt-3 text-xs text-gray-500">Your new address is saved to your account when you place this order.</p>
                    </details>
                </section>

                <section>
                    <h2 class="font-heading text-lg font-semibold text-ink-900 mb-4">Shipping Method</h2>
                    <div class="space-y-3">
                        @foreach ($shippingOptions as $option)
                            <label class="flex items-center justify-between gap-3 rounded-md border border-gray-200 p-4 cursor-pointer has-[:checked]:border-red-600">
                                <span class="flex items-center gap-3 text-sm">
                                    <input type="radio" name="shipping_option_id" value="{{ $option->id }}" {{ $loop->first ? 'checked' : '' }}>
                                    <span>
                                        <span class="block font-medium text-gray-900">{{ $option->name }}</span>
                                        <span class="block text-gray-500">{{ $option->description }}</span>
                                    </span>
                                </span>
                                <span class="font-semibold">${{ number_format($option->cost, 2) }}</span>
                            </label>
                        @endforeach
                    </div>
                </section>

                <section>
                    <h2 class="font-heading text-lg font-semibold text-ink-900 mb-4">Payment Method</h2>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 rounded-md border border-gray-200 p-4 cursor-pointer has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span class="text-sm font-medium text-gray-900">Cash on Delivery</span>
                        </label>

                        <label class="flex items-center gap-3 rounded-md border border-gray-200 p-4 cursor-pointer has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                            <input type="radio" name="payment_method" value="stripe">
                            <span class="text-sm font-medium text-gray-900">Credit / Debit Card (Stripe)</span>
                        </label>

                        <label class="flex items-center gap-3 rounded-md border border-gray-100 bg-gray-50 p-4 cursor-not-allowed opacity-60">
                            <input type="radio" disabled>
                            <span class="text-sm font-medium text-gray-500">PayPal <span class="text-xs">(coming soon)</span></span>
                        </label>

                    </div>
                    <p class="mt-2 text-xs text-gray-400">Stripe is in test mode — use card number 4242 4242 4242 4242, any future expiry, and any CVC.</p>
                </section>

                <section>
                    <h2 class="font-heading text-lg font-semibold text-ink-900 mb-4">Order Notes (optional)</h2>
                    <textarea name="notes" rows="3" class="w-full rounded-md border-gray-300 text-sm" placeholder="Delivery instructions, etc."></textarea>
                </section>
            </div>

            <div class="lg:col-span-1">
                <div class="rounded-xl border border-gray-200 shadow-sm p-6 sticky top-24">
                    <h2 class="font-heading text-lg font-semibold text-ink-900 mb-4">Order Summary</h2>

                    <div class="space-y-2 text-sm mb-4 max-h-64 overflow-y-auto">
                        @foreach ($cart->items as $item)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ $item->product->name }} &times; {{ $item->quantity }}</span>
                                <span class="text-gray-900">${{ number_format($item->lineTotal(), 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-4">
                        @if ($coupon)
                            <div class="flex items-center justify-between text-sm bg-green-50 border border-green-200 rounded-md px-3 py-2">
                                <span>Coupon <strong>{{ $coupon->code }}</strong> applied</span>
                                <button type="submit" form="remove-coupon-form" class="text-red-600 hover:underline">Remove</button>
                            </div>
                        @else
                            <div class="flex gap-2">
                                <input type="text" name="code" form="coupon-form" placeholder="Coupon code" class="flex-1 rounded-md border-gray-300 text-sm">
                                <button type="submit" form="coupon-form" class="rounded-md border border-gray-300 px-3 text-sm hover:border-red-600">Apply</button>
                            </div>
                        @endif

                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Subtotal</dt>
                                <dd>${{ number_format($totals['subtotal'], 2) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Discount</dt>
                                <dd class="text-green-600">-${{ number_format($totals['discount'], 2) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Shipping</dt>
                                <dd>${{ number_format($totals['shipping'], 2) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Tax</dt>
                                <dd>${{ number_format($totals['tax'], 2) }}</dd>
                            </div>
                            <div class="flex justify-between text-base font-bold border-t border-gray-100 pt-2">
                                <dt>Total</dt>
                                <dd>${{ number_format($totals['total'], 2) }}</dd>
                            </div>
                        </dl>
                    </div>

                    <button type="submit" class="mt-6 w-full rounded-md bg-ink-900 px-6 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-600 transition">
                        Place Order
                    </button>
                </div>
            </div>
        </form>

        <form id="coupon-form" action="{{ route('checkout.coupon.apply') }}" method="POST">
            @csrf
        </form>
        <form id="remove-coupon-form" action="{{ route('checkout.coupon.remove') }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-layouts.storefront>
