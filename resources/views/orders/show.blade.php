<?php
    $steps = ['pending' => 'Order Placed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
    $stepKeys = array_keys($steps);
    $currentIndex = array_search($order->status, $stepKeys, true);
?>
<x-layouts.account :title="'Order '.$order->order_number">
    <div class="flex items-center justify-between">
        <a href="{{ route('orders.index') }}" class="text-sm text-[#8f949c] hover:text-gold-300">&larr; Back to orders</a>
        <div class="flex gap-3 text-sm">
            <a href="{{ route('orders.receipt', $order) }}" target="_blank" class="rounded-none border border-white/15 px-3 py-1.5 hover:border-gold-500">Print Receipt</a>
            <a href="{{ route('orders.pdf', $order) }}" class="rounded-none border border-white/15 px-3 py-1.5 hover:border-gold-500">Download PDF</a>
        </div>
    </div>

    <h1 class="font-lux text-2xl font-normal text-[#ece7da] mt-2 text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.05] tracking-[-0.01em]">Order {{ $order->order_number }}</h1>
    <p class="mt-1 text-[#8f949c]">Placed {{ $order->created_at->format('M j, Y') }}</p>

    @if ($order->status === 'cancelled')
        <div class="mt-6 rounded-none bg-red-500/10 border border-red-500/30 px-4 py-3 text-sm text-red-300">
            This order has been cancelled.
        </div>
    @else
        <ol class="mt-8 flex items-center w-full max-w-2xl">
            @foreach ($steps as $key => $label)
                <li class="flex-1 flex items-center {{ ! $loop->last ? 'after:content-[\'\'] after:flex-1 after:h-0.5 after:mx-2 '.($loop->index < $currentIndex ? 'after:bg-gold-500' : 'after:bg-gray-200') : '' }}">
                    <div class="flex flex-col items-center gap-1 shrink-0">
                        <span class="h-3 w-3 rounded-full {{ $loop->index <= $currentIndex ? 'bg-gold-500' : 'bg-gray-200' }}"></span>
                        <span class="text-xs {{ $loop->index <= $currentIndex ? 'text-[#ece7da] font-medium' : 'text-[#8f949c]' }}">{{ $label }}</span>
                    </div>
                </li>
            @endforeach
        </ol>
    @endif

    <div class="mt-10 divide-y divide-white/10 border-t border-b border-white/10">
        @foreach ($order->items as $item)
            <div class="flex justify-between py-3 text-sm">
                <div>
                    <p class="font-medium text-[#ece7da]">{{ \App\Models\Product::shortenName($item->product_name) }}</p>
                    @if ($item->variation_label)
                        <p class="text-[#8f949c]">{{ $item->variation_label }}</p>
                    @endif
                    <p class="text-[#8f949c]">Qty {{ $item->quantity }} &times; ${{ number_format($item->unit_price, 2) }}</p>
                </div>
                <p class="font-semibold">${{ number_format($item->line_total, 2) }}</p>
            </div>
        @endforeach
    </div>

    <dl class="mt-6 space-y-2 text-sm max-w-xs ml-auto">
        <div class="flex justify-between"><dt class="text-[#8f949c]">Subtotal</dt><dd>${{ number_format($order->subtotal, 2) }}</dd></div>
        <div class="flex justify-between"><dt class="text-[#8f949c]">Discount</dt><dd class="text-green-400">-${{ number_format($order->discount_amount, 2) }}</dd></div>
        <div class="flex justify-between"><dt class="text-[#8f949c]">Shipping</dt><dd>${{ number_format($order->shipping_amount, 2) }}</dd></div>
        <div class="flex justify-between"><dt class="text-[#8f949c]">Tax</dt><dd>${{ number_format($order->tax_amount, 2) }}</dd></div>
        <div class="flex justify-between text-base font-bold border-t border-white/10 pt-2"><dt>Total</dt><dd>${{ number_format($order->total, 2) }}</dd></div>
    </dl>

    <div class="mt-10 grid sm:grid-cols-2 gap-8 text-sm">
        <div>
            <h2 class="font-semibold mb-2">Shipping Address</h2>
            <p class="text-[#b9b5ab]">{{ $order->address->full_name }}</p>
            <p class="text-[#b9b5ab]">{{ $order->address->fullAddress() }}</p>
            <p class="text-[#b9b5ab]">{{ $order->address->phone }}</p>
        </div>
        <div>
            <h2 class="font-semibold mb-2">Payment</h2>
            <p class="text-[#b9b5ab] uppercase">{{ $order->payment_method }}</p>
            <p class="text-[#b9b5ab] capitalize">{{ $order->payment_status }}</p>

            @if ($order->payment_method === 'stripe' && $order->payment_status !== 'paid')
                <form action="{{ route('checkout.stripe.retry', $order) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="rounded-none bg-[#ece7da] px-4 py-2 text-xs font-bold uppercase tracking-wide text-ink-900 hover:bg-gold-500 transition">
                        Pay with Card
                    </button>
                </form>
            @endif

            @if ($order->shippingOption)
                <h2 class="font-semibold mt-4 mb-2">Shipping Method</h2>
                <p class="text-[#b9b5ab]">{{ $order->shippingOption->name }}</p>
            @endif
        </div>
    </div>
</x-layouts.account>
