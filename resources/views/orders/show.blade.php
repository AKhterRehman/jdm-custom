<?php
    $steps = ['pending' => 'Order Placed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
    $stepKeys = array_keys($steps);
    $currentIndex = array_search($order->status, $stepKeys, true);
?>
<x-layouts.account :title="'Order '.$order->order_number">
    <a href="{{ route('orders.index') }}" class="text-sm text-gray-500 hover:text-red-600">&larr; Back to orders</a>

    <h1 class="text-2xl font-bold mt-2">Order {{ $order->order_number }}</h1>
    <p class="mt-1 text-gray-500">Placed {{ $order->created_at->format('M j, Y') }}</p>

    @if ($order->status === 'cancelled')
        <div class="mt-6 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            This order has been cancelled.
        </div>
    @else
        <ol class="mt-8 flex items-center w-full max-w-2xl">
            @foreach ($steps as $key => $label)
                <li class="flex-1 flex items-center {{ ! $loop->last ? 'after:content-[\'\'] after:flex-1 after:h-0.5 after:mx-2 '.($loop->index < $currentIndex ? 'after:bg-red-600' : 'after:bg-gray-200') : '' }}">
                    <div class="flex flex-col items-center gap-1 shrink-0">
                        <span class="h-3 w-3 rounded-full {{ $loop->index <= $currentIndex ? 'bg-red-600' : 'bg-gray-200' }}"></span>
                        <span class="text-xs {{ $loop->index <= $currentIndex ? 'text-gray-900 font-medium' : 'text-gray-400' }}">{{ $label }}</span>
                    </div>
                </li>
            @endforeach
        </ol>
    @endif

    <div class="mt-10 divide-y divide-gray-100 border-t border-b border-gray-100">
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
</x-layouts.account>
