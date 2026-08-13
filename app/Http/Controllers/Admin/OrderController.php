<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ShippoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private readonly ShippoService $shippo)
    {
    }

    public function index(Request $request): View
    {
        $orders = Order::with('user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('search'), fn ($q) => $q->where('order_number', 'like', '%'.$request->search.'%'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['items', 'user', 'address', 'shippingOption', 'coupon']);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,delivered,cancelled'],
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
        ]);

        $order->update($validated);

        return back()->with('status', 'Order updated.');
    }

    public function generateLabel(Order $order): RedirectResponse
    {
        if ($order->label_url) {
            return back()->with('status', 'A label has already been generated for this order.');
        }

        if (! $order->shippo_rate_id) {
            return back()->with('error', 'No live shipping rate was captured for this order, so a label cannot be generated automatically. Please buy the label directly through your Shippo or Pirate Ship account for this one.');
        }

        try {
            $label = $this->shippo->purchaseLabel($order->shippo_rate_id);
        } catch (\Throwable $e) {
            return back()->with('error', 'Could not generate the label: '.$e->getMessage());
        }

        $order->update([
            'shippo_transaction_id' => $label['transaction_id'],
            'label_url' => $label['label_url'],
            'tracking_number' => $label['tracking_number'],
            'tracking_url' => $label['tracking_url'],
        ]);

        return back()->with('status', 'Shipping label generated.');
    }

    public function receipt(Order $order): View
    {
        $order->load(['items', 'address', 'shippingOption']);

        return view('orders.receipt', [
            'order' => $order,
            'pdfUrl' => route('admin.orders.pdf', $order),
        ]);
    }

    public function pdf(Order $order)
    {
        $order->load(['items', 'address', 'shippingOption']);

        return Pdf::loadView('orders.receipt', ['order' => $order, 'pdfUrl' => '#'])
            ->download("receipt-{$order->order_number}.pdf");
    }
}
