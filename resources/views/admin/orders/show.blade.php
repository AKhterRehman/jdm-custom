<x-layouts.admin :title="'Order '.$order->order_number">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-silver-400 hover:text-gold-400">&larr; Back to orders</a>

    <div class="flex items-start justify-between mt-2 mb-8">
        <div>
            <h1 class="font-display text-3xl font-medium text-white">{{ $order->order_number }}</h1>
            <p class="text-silver-400">{{ $order->user->name }} ({{ $order->user->email }}) &middot; {{ $order->created_at->format('M j, Y g:ia') }}</p>
            <div class="flex gap-3 text-sm mt-2">
                <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="rounded-md border border-white/15 bg-charcoal-800 px-3 py-1.5 hover:border-gold-500">Print Receipt</a>
                <a href="{{ route('admin.orders.pdf', $order) }}" class="rounded-md border border-white/15 bg-charcoal-800 px-3 py-1.5 hover:border-gold-500">Download PDF</a>
            </div>
        </div>

        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-end gap-2">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-xs text-silver-400 mb-1">Status</label>
                <select name="status" class="rounded-md border-white/15 text-sm">
                    @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-silver-400 mb-1">Payment</label>
                <select name="payment_status" class="rounded-md border-white/15 text-sm">
                    @foreach (['pending', 'paid', 'failed', 'refunded'] as $status)
                        <option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-md bg-gold-500 px-4 py-2 text-sm font-semibold text-ink-900 hover:bg-gold-400 transition">Update</button>
        </form>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="rounded-lg border border-white/10 bg-charcoal-800 divide-y divide-white/10">
                @foreach ($order->items as $item)
                    <div class="flex justify-between px-4 py-3 text-sm">
                        <div>
                            <p class="font-medium">{{ $item->product_name }}</p>
                            @if ($item->variation_label)
                                <p class="text-silver-400">{{ $item->variation_label }}</p>
                            @endif
                            <p class="text-silver-400">Qty {{ $item->quantity }} &times; ${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                        <p class="font-semibold">${{ number_format($item->line_total, 2) }}</p>
                    </div>
                @endforeach
            </div>

            <dl class="mt-6 space-y-2 text-sm max-w-xs ml-auto">
                <div class="flex justify-between"><dt class="text-silver-400">Subtotal</dt><dd>${{ number_format($order->subtotal, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-silver-400">Discount</dt><dd class="text-green-400">-${{ number_format($order->discount_amount, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-silver-400">Shipping</dt><dd>${{ number_format($order->shipping_amount, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-silver-400">Tax</dt><dd>${{ number_format($order->tax_amount, 2) }}</dd></div>
                <div class="flex justify-between text-base font-bold border-t border-white/5 pt-2"><dt>Total</dt><dd>${{ number_format($order->total, 2) }}</dd></div>
            </dl>
        </div>

        <div class="space-y-6 text-sm">
            <div class="rounded-lg border border-white/10 bg-charcoal-800 p-4">
                <h2 class="font-semibold mb-2">Shipping Address</h2>
                <p class="text-silver-300">{{ $order->address->full_name }}</p>
                <p class="text-silver-300">{{ $order->address->fullAddress() }}</p>
                <p class="text-silver-300">{{ $order->address->phone }}</p>
            </div>

            <div class="rounded-lg border border-white/10 bg-charcoal-800 p-4">
                <h2 class="font-semibold mb-2">Payment & Shipping</h2>
                <p class="text-silver-300 uppercase">{{ $order->payment_method }}</p>
                @if ($order->carrier)
                    <p class="text-silver-300">{{ $order->carrier }} &middot; {{ $order->service_level }}</p>
                @elseif ($order->service_level)
                    <p class="text-silver-300">{{ $order->service_level }}</p>
                @endif
                @if ($order->coupon)
                    <p class="text-silver-300">Coupon: {{ $order->coupon->code }}</p>
                @endif
            </div>

            <div class="rounded-lg border border-white/10 bg-charcoal-800 p-4">
                <h2 class="font-semibold mb-2">Shipping Label</h2>

                @if ($order->label_url)
                    <p class="text-silver-300 mb-1">Tracking: {{ $order->tracking_number }}</p>
                    <div class="flex gap-3 mt-2">
                        <a href="{{ $order->label_url }}" target="_blank" class="rounded-md border border-white/15 bg-charcoal-800 px-3 py-1.5 hover:border-gold-500">Download Label</a>
                        @if ($order->tracking_url)
                            <a href="{{ $order->tracking_url }}" target="_blank" class="rounded-md border border-white/15 bg-charcoal-800 px-3 py-1.5 hover:border-gold-500">Track Package</a>
                        @endif
                    </div>
                @elseif ($order->shippo_rate_id)
                    <p class="text-silver-400 mb-3">No label generated yet.</p>
                    <form action="{{ route('admin.orders.generate-label', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-md bg-gold-500 px-4 py-2 text-sm font-semibold text-ink-900 hover:bg-gold-400 transition">Generate Label</button>
                    </form>
                @else
                    <p class="text-silver-400">No live shipping rate was captured for this order. Buy the label directly through Shippo or Pirate Ship for this one.</p>
                @endif
            </div>

            @if ($order->notes)
                <div class="rounded-lg border border-white/10 bg-charcoal-800 p-4">
                    <h2 class="font-semibold mb-2">Order Notes</h2>
                    <p class="text-silver-300">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
