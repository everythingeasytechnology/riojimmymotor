<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $orders = Order::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->when($search, function ($query, $search) {
            return $query->where('order_number', 'like', "%{$search}%")
                         ->orWhere('customer_name', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('admin.orders.index', compact('orders', 'status', 'search'));
    }

    /**
     * Display details of a specific order.
     */
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order shipment and processing status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,delivered,cancelled,refunded',
            'tracking_number' => 'nullable|string',
            'refund_reason' => 'nullable|string'
        ]);

        $order->status = $request->status;

        if ($request->status === 'shipped' && $request->tracking_number) {
            $order->tracking_number = $request->tracking_number;
        }

        if ($request->status === 'refunded') {
            $order->payment_status = 'refunded';
            $order->refund_reason = $request->refund_reason;
        }

        $order->save();

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Order status updated successfully.');
    }

    /**
     * Download the order PDF invoice.
     */
    public function downloadInvoice(Order $order)
    {
        // Mock invoice output details for frontend
        $headers = [
            "Content-type" => "text/html",
            "Content-Disposition" => "attachment; filename=Invoice_{$order->order_number}.html",
        ];

        $htmlContent = "
        <html>
        <head><title>Invoice #{$order->order_number}</title></head>
        <body style='font-family: sans-serif; padding: 40px;'>
            <h2>Auto Parts Marketplace</h2>
            <hr>
            <p><strong>Invoice Number:</strong> INV-{$order->order_number}</p>
            <p><strong>Customer Name:</strong> {$order->customer_name}</p>
            <p><strong>Date:</strong> " . $order->created_at->format('Y-m-d') . "</p>
            <p><strong>Total Paid:</strong> \${$order->total}</p>
            <p><strong>Status:</strong> " . strtoupper($order->status) . "</p>
        </body>
        </html>";

        return response($htmlContent, 200, $headers);
    }
}
