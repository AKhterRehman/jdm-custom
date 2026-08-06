<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt {{ $order->order_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Helvetica, Arial, sans-serif; color: #1a1a1a; font-size: 13px; margin: 0; padding: 32px; }
        .header { width: 100%; border-bottom: 3px solid #dc2626; padding-bottom: 16px; margin-bottom: 24px; }
        .header td { vertical-align: top; }
        .brand-logo { display: block; height: 70px; width: auto; object-fit: contain; filter: brightness(1.5) contrast(1.15); }
        .muted { color: #6b7280; }
        .right { text-align: right; }
        .mt-24 { margin-top: 24px; }
        .mt-8 { margin-top: 8px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 16px; }
        table.items th { text-align: left; background: #f3f4f6; padding: 8px; font-size: 11px; text-transform: uppercase; letter-spacing: .04em; color: #6b7280; }
        table.items td { padding: 8px; border-bottom: 1px solid #f0f0f0; }
        table.totals { width: 260px; margin-left: auto; margin-top: 16px; }
        table.totals td { padding: 4px 0; }
        table.totals tr.grand td { border-top: 2px solid #1a1a1a; font-weight: bold; font-size: 15px; padding-top: 8px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; background: #f3f4f6; font-size: 11px; text-transform: capitalize; }
        .footer { margin-top: 40px; padding-top: 16px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 11px; text-align: center; }
        .no-print { margin-bottom: 20px; }
        .no-print button, .no-print a {
            display: inline-block; padding: 10px 18px; font-size: 13px; text-decoration: none;
            border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #1a1a1a; cursor: pointer; margin-right: 8px;
        }
        .no-print .primary { background: #111827; color: #fff; border-color: #111827; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Print</button>
        <a class="primary" href="{{ $pdfUrl }}">Download PDF</a>
    </div>

    <table class="header">
        <tr>
            <td>
                <img src="{{ asset('images/update logo.png') }}" alt="JDM Custom" class="brand-logo">
                <div class="muted mt-8">Handcrafted custom wood creations</div>
            </td>
            <td class="right">
                <div style="font-size:16px; font-weight:bold;">Receipt</div>
                <div class="muted mt-8">{{ $order->order_number }}</div>
                <div class="muted">{{ $order->created_at->format('M j, Y') }}</div>
            </td>
        </tr>
    </table>

    <table style="width:100%;">
        <tr>
            <td style="width:50%; vertical-align:top;">
                <strong>Billed To</strong><br>
                {{ $order->address->full_name }}<br>
                {{ $order->address->fullAddress() }}<br>
                {{ $order->address->phone }}
            </td>
            <td style="width:50%; vertical-align:top;">
                <strong>Order Details</strong><br>
                Status: <span class="badge">{{ $order->status }}</span><br>
                Payment: {{ strtoupper($order->payment_method) }} &middot; <span class="badge">{{ $order->payment_status }}</span><br>
                @if ($order->shippingOption)
                    Shipping: {{ $order->shippingOption->name }}
                @endif
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th class="right">Unit Price</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product_name }}
                        @if ($item->variation_label)
                            <br><span class="muted">{{ $item->variation_label }}</span>
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td class="right">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="right">${{ number_format($item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr><td>Subtotal</td><td class="right">${{ number_format($order->subtotal, 2) }}</td></tr>
        <tr><td>Discount</td><td class="right">-${{ number_format($order->discount_amount, 2) }}</td></tr>
        <tr><td>Shipping</td><td class="right">${{ number_format($order->shipping_amount, 2) }}</td></tr>
        <tr><td>Tax</td><td class="right">${{ number_format($order->tax_amount, 2) }}</td></tr>
        <tr class="grand"><td>Total</td><td class="right">${{ number_format($order->total, 2) }}</td></tr>
    </table>

    <div class="footer">
        Thank you for shopping with JDM Custom Creations. For questions about this order, contact support with reference {{ $order->order_number }}.
    </div>
</body>
</html>
