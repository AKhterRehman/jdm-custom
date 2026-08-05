<x-layouts.storefront :title="'Order '.$order->order_number">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if (session('status'))
            <div class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold">Order {{ $order->order_number }}</h1>
        <p class="mt-1 text-gray-500">
            Placed {{ $order->created_at->format('M j, Y') }} &middot;
            <span class="inline-block rounded-full bg-gray-100 px-3 py-1 text-xs font-medium capitalize">{{ $order->status }}</span>
        </p>

        <div class="mt-8 divide-y divide-gray-100 border-t border-b border-gray-100">
            @foreach ($order->items as $item)
                <div class="flex justify-between py-3 text-sm">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
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

        <div class="mt-10 grid sm:grid-cols-2 gap-8 text-sm">
            <div>
                <h2 class="font-semibold mb-2">Shipping Address</h2>
                <p class="text-gray-600">{{ $order->address->full_name }}</p>
                <p class="text-gray-600">{{ $order->address->fullAddress() }}</p>
                <p class="text-gray-600">{{ $order->address->phone }}</p>
            </div>
            <div>
                <h2 class="font-semibold mb-2">Payment</h2>
                <p class="text-gray-600 uppercase">{{ $order->payment_method }}</p>
                <p class="text-gray-600 capitalize">{{ $order->payment_status }}</p>
                @if ($order->shippingOption)
                    <h2 class="font-semibold mt-4 mb-2">Shipping Method</h2>
                    <p class="text-gray-600">{{ $order->shippingOption->name }}</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.storefront>
