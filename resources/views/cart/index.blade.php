<x-layouts.storefront :dark="true" title="Your Cart">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ selected: [], items: { @foreach ($cart->items as $item) {{ $item->id }}: {{ $item->lineTotal() }}{{ ! $loop->last ? ',' : '' }} @endforeach }, total() { return this.selected.reduce((sum, id) => sum + Number(this.items[id] || 0), 0) } }">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-400">Shopping bag</p>
        <h1 class="mt-2 font-lux font-normal text-[#ece7da] mb-10 text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.05] tracking-[-0.01em]">Your Cart</h1>

        @if (session('status'))
            <div class="mb-6 rounded-none bg-green-500/10 border border-green-500/30 px-4 py-3 text-sm text-green-400">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->has('quantity'))
            <div class="mb-6 rounded-none border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                {{ $errors->first('quantity') }}
            </div>
        @endif

        @if ($cart->items->isEmpty())
            <p class="text-[#8f949c]">Your cart is empty. <a href="{{ route('home') }}" class="text-gold-400 hover:underline">Continue shopping</a>.</p>
        @else
            <form id="selected-items-form" action="{{ route('cart.destroy-selected') }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
            <form id="checkout-selection-form" action="{{ route('checkout.index') }}" method="GET">
                <template x-for="itemId in selected" :key="itemId"><input type="hidden" name="cart_item_ids[]" :value="itemId"></template>
            </form>

            <div class="grid gap-8 lg:grid-cols-12 lg:items-start">
                <section class="lg:col-span-8">
                    <div class="mb-3 flex items-center justify-between rounded-none border border-white/10 bg-[#0f0f11] px-4 py-3 text-xs font-semibold uppercase tracking-wide text-[#8f949c]">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" x-on:change="selected = $event.target.checked ? Object.keys(items).map(Number) : []" class="rounded border-white/15 text-gold-400 focus:ring-gold-500">
                            <span>Select all ({{ $cart->items->count() }} {{ Str::plural('item', $cart->items->count()) }})</span>
                        </label>
                        <button type="submit" form="selected-items-form" class="hover:text-gold-300 transition">Delete</button>
                    </div>
            <div class="divide-y divide-white/10 rounded-none border border-white/10 bg-[#111113]">
                @foreach ($cart->items as $item)
                    <div class="flex items-center gap-4 px-4 py-5">
                        <input form="selected-items-form" type="checkbox" name="cart_item_ids[]" value="{{ $item->id }}" x-model="selected" class="rounded border-white/15 text-gold-400 focus:ring-gold-500">
                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-none bg-[#17171a]">
                            @if ($item->product->images->first())
                                <img src="{{ $item->product->images->first()->url() }}" alt="{{ $item->product->short_name }}" class="h-full w-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1">
                            <a href="{{ route('product.show', $item->product) }}" class="font-lux font-normal text-[#ece7da] hover:text-gold-300 transition">{{ $item->product->short_name }}</a>
                            @if ($item->variation)
                                <p class="text-sm text-[#8f949c]">{{ $item->variation->attribute_name }}: {{ $item->variation->attribute_value }}</p>
                            @endif
                            <p class="text-sm text-[#8f949c]">${{ number_format($item->unitPrice(), 2) }} each</p>
                        </div>

                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center rounded-none border border-white/15">
                            @csrf
                            @method('PATCH')
                            @php($availableStock = $item->variation ? min($item->product->available_stock_quantity, $item->variation->stock_quantity) : $item->product->available_stock_quantity)
                            <button type="submit" formaction="{{ route('cart.decrement', $item) }}" class="h-10 w-9 text-lg text-[#8f949c] hover:text-gold-300">&minus;</button>
                            <input type="hidden" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ max(1, $availableStock) }}">
                            <span class="flex h-10 w-11 items-center justify-center border-x border-white/10 bg-[#111113] text-sm font-bold text-[#ece7da]">{{ $item->quantity }}</span>
                            <button type="submit" formaction="{{ route('cart.increment', $item) }}" @disabled($item->quantity >= $availableStock) class="h-10 w-9 text-lg text-[#8f949c] hover:text-gold-300 disabled:cursor-not-allowed disabled:opacity-40">+</button>
                        </form>

                        <p class="w-24 text-right font-semibold text-[#ece7da]">${{ number_format($item->lineTotal(), 2) }}</p>

                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-[#8f949c] hover:text-gold-300 transition">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
                <a href="{{ route('shop.index') }}" class="mt-6 inline-block text-sm font-semibold text-[#8f949c] hover:text-gold-300 transition">Continue shopping</a>
                </section>

                <aside class="lg:col-span-4 rounded-none border border-white/10 bg-[#111113] p-6 shadow-sm lg:sticky lg:top-24">
                    <h2 class="font-lux text-xl font-normal text-[#ece7da]">Order Summary</h2>
                    <div class="my-5 border-b border-white/10 pb-5 text-sm">
                        <div class="flex justify-between"><span class="text-[#8f949c]">Items subtotal</span><span class="font-medium text-[#ece7da]" x-text="'$' + total().toFixed(2)">$0.00</span></div>
                        <div class="mt-3 flex justify-between"><span class="text-[#8f949c]">Shipping &amp; tax</span><span class="text-[#8f949c]">At checkout</span></div>
                    </div>
                    <form action="{{ route('checkout.coupon.apply') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input name="code" required placeholder="Voucher code" class="min-w-0 flex-1 rounded-none border-white/15 text-sm">
                        <button class="rounded-none bg-gold-500 px-4 text-sm font-bold text-ink-900 hover:bg-[#ece7da] transition">Apply</button>
                    </form>
                    <div class="mt-6 flex justify-between border-t border-white/10 pt-5 text-base font-bold text-[#ece7da]"><span>Subtotal</span><span x-text="'$' + total().toFixed(2)">$0.00</span></div>
                    <button type="submit" form="checkout-selection-form" x-bind:disabled="selected.length === 0" class="mt-6 block w-full rounded-none bg-[#ece7da] px-6 py-3.5 text-center text-sm font-bold uppercase tracking-wide text-ink-900 hover:bg-gold-500 disabled:cursor-not-allowed disabled:opacity-40 transition">Proceed to Checkout</button>
                    <p class="mt-3 text-center text-xs text-[#8f949c]">Shipping, tax, and coupons are calculated at checkout.</p>
                </aside>
            </div>
        @endif
    </div>
</x-layouts.storefront>
