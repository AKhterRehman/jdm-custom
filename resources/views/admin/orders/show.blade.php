<x-layouts.admin :title="'Order '.$order->order_number">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-red-600">&larr; Back to orders</a>

    <div class="flex items-start justify-between mt-2 mb-8">
        <div>
            <h1 class="font-heading text-2xl font-bold text-ink-900">{{ $order->order_number }}</h1>
            <p class="text-gray-500">{{ $order->user->name }} ({{ $order->user->email }}) &middot; {{ $order->created_at->format('M j, Y g:ia') }}</p>
            <div class="flex gap-3 text-sm mt-2">
                <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 hover:border-red-600">Print Receipt</a>
                <a href="{{ route('admin.orders.pdf', $order) }}" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 hover:border-red-600">Download PDF</a>
            </div>
        </div>

        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-end gap-2">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select name="status" class="rounded-md border-gray-300 text-sm">
                    @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Payment</label>
                <select name="payment_status" class="rounded-md border-gray-300 text-sm">
                    @foreach (['pending', 'paid', 'failed', 'refunded'] as $status)
                        <option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-md bg-ink-900 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600 transition">Update</button>
        </form>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="rounded-lg border border-gray-200 bg-white divide-y divide-gray-100">
                @foreach ($order->items as $item)
                    <div class="flex justify-between px-4 py-3 text-sm">
                        <div>
                            <p class="font-medium">{{ $item->product_name }}</p>
                            @if ($item->variation_label)
                                <p class="text-gray-500">{{ $item->variation_label }}</p>
                            @endif
                            <p class="text-gray-500">Qty {{ $item->quantity }} &times; ${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                        <p class="font-semibold">${{ number_format($item->line_total, 2) }}</p>
                    </div>
                @endforeach
            </div>

            <dl class="mt-6 space-y-2 text-sm max-w-xs ml-auto">
                <div class="flex justify-between"><dt class="text-gray-500">Subtotal</dt><dd>${{ number_format($order->subtotal, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Discount</dt><dd class="text-green-600">-${{ number_format($order->discount_amount, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Shipping</dt><dd>${{ number_format($order->shipping_amount, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Tax</dt><dd>${{ number_format($order->tax_amount, 2) }}</dd></div>
                <div class="flex justify-between text-base font-bold border-t border-gray-100 pt-2"><dt>Total</dt><dd>${{ number_format($order->total, 2) }}</dd></div>
            </dl>
        </div>

        <div class="space-y-6 text-sm">
            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h2 class="font-semibold mb-2">Shipping Address</h2>
                <p class="text-gray-600">{{ $order->address->full_name }}</p>
                <p class="text-gray-600">{{ $order->address->fullAddress() }}</p>
                <p class="text-gray-600">{{ $order->address->phone }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4">
                <h2 class="font-semibold mb-2">Payment & Shipping</h2>
                <p class="text-gray-600 uppercase">{{ $order->payment_method }}</p>
                @if ($order->shippingOption)
                    <p class="text-gray-600">{{ $order->shippingOption->name }}</p>
                @endif
                @if ($order->coupon)
                    <p class="text-gray-600">Coupon: {{ $order->coupon->code }}</p>
                @endif
            </div>

            @if ($order->notes)
                <div class="rounded-lg border border-gray-200 bg-white p-4">
                    <h2 class="font-semibold mb-2">Order Notes</h2>
                    <p class="text-gray-600">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
