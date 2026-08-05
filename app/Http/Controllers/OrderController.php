<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->orders()->with('items')->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorizeOwnership($request, $order);

        $order->load(['items', 'address', 'shippingOption', 'coupon']);

        return view('orders.show', compact('order'));
    }

    public function receipt(Request $request, Order $order): View
    {
        $this->authorizeOwnership($request, $order);

        $order->load(['items', 'address', 'shippingOption']);

        return view('orders.receipt', [
            'order' => $order,
            'pdfUrl' => route('orders.pdf', $order),
        ]);
    }

    public function pdf(Request $request, Order $order)
    {
        $this->authorizeOwnership($request, $order);

        $order->load(['items', 'address', 'shippingOption']);

        return Pdf::loadView('orders.receipt', ['order' => $order, 'pdfUrl' => '#'])
            ->download("receipt-{$order->order_number}.pdf");
    }

    private function authorizeOwnership(Request $request, Order $order): void
    {
        abort_unless($order->user_id === $request->user()->id, 403);
    }
}
