<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
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
        $order->load('items.product');

        $siteName = Setting::getValue('site_name', 'Rio Jimmy Motor');
        $contactPhone = Setting::getValue('contact_phone', '+1 (800) 555-0199');
        $contactEmail = Setting::getValue('contact_email', 'support@riojimmymotor.com');
        $officeAddress = Setting::getValue('office_address', '100 Industrial Pkwy, Detroit, MI 48201');

        $headers = [
            "Content-type" => "text/html",
            "Content-Disposition" => "attachment; filename=Invoice_{$order->order_number}.html",
        ];

        // Format items table rows
        $itemsHtml = "";
        foreach($order->items as $item) {
            $brandName = $item->product->brand ?? 'OEM';
            $formattedPrice = number_format($item->price, 2);
            $formattedSubtotal = number_format($item->price * $item->quantity, 2);
            $itemsHtml .= "
            <tr>
                <td style='padding: 12px; border-bottom: 1px solid #eeeeee; text-align: left; vertical-align: top;'>
                    <strong style='color: #111111; display: block;'>{$item->product_name}</strong>
                    <span style='font-size: 11px; color: #888888;'>Brand: {$brandName}</span>
                </td>
                <td style='padding: 12px; border-bottom: 1px solid #eeeeee; text-align: left; vertical-align: top;'><code>{$item->product_sku}</code></td>
                <td style='padding: 12px; border-bottom: 1px solid #eeeeee; text-align: right; vertical-align: top;'>\${$formattedPrice}</td>
                <td style='padding: 12px; border-bottom: 1px solid #eeeeee; text-align: center; vertical-align: top;'>{$item->quantity}</td>
                <td style='padding: 12px; border-bottom: 1px solid #eeeeee; text-align: right; vertical-align: top; font-weight: bold;'>\${$formattedSubtotal}</td>
            </tr>";
        }

        $formattedTotal = number_format($order->total, 2);
        $orderDate = $order->created_at->format('M d, Y');
        $statusColor = ($order->status === 'delivered' || $order->status === 'paid') ? '#28a745' : (($order->status === 'cancelled' || $order->status === 'refunded') ? '#dc3545' : '#ffc107');
        $trackingHtml = $order->tracking_number ? "<p style='margin: 0 0 5px 0; font-size: 14px;'><strong>Tracking:</strong> {$order->tracking_number}</p>" : "";

        $htmlContent = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Invoice #{$order->order_number}</title>
            <style>
                body {
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    color: #333333;
                    background-color: #ffffff;
                    margin: 0;
                    padding: 40px;
                    font-size: 14px;
                    line-height: 1.6;
                }
                .invoice-box {
                    max-width: 800px;
                    margin: auto;
                    border: 1px solid #eeeeee;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
                    padding: 30px;
                    border-radius: 8px;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    border-bottom: 2px solid #f5f5f5;
                    padding-bottom: 20px;
                    margin-bottom: 30px;
                }
                .logo {
                    font-size: 22px;
                    font-weight: bold;
                    color: #d91e18;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
                .invoice-title {
                    text-align: right;
                }
                .invoice-title h1 {
                    margin: 0;
                    font-size: 28px;
                    color: #111111;
                    font-weight: 800;
                }
                .invoice-title span {
                    color: #888888;
                    font-size: 14px;
                }
                .details-container {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 30px;
                    gap: 20px;
                }
                .details-col {
                    flex: 1;
                }
                .details-col h5 {
                    margin: 0 0 10px 0;
                    font-size: 12px;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    color: #888888;
                }
                .details-col p {
                    margin: 0 0 5px 0;
                    font-size: 14px;
                    color: #444444;
                }
                .details-col strong {
                    color: #111111;
                }
                .table-items {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 30px;
                }
                .table-items th {
                    background-color: #fcfcfc;
                    border-bottom: 2px solid #eeeeee;
                    text-align: left;
                    padding: 12px;
                    font-size: 12px;
                    text-transform: uppercase;
                    color: #666666;
                    font-weight: bold;
                }
                .total-box {
                    display: flex;
                    justify-content: flex-end;
                }
                .total-table {
                    width: 250px;
                    border-collapse: collapse;
                }
                .total-table td {
                    padding: 8px 12px;
                    color: #666666;
                }
                .total-table tr.grand-total td {
                    border-top: 2px solid #eeeeee;
                    font-size: 18px;
                    font-weight: bold;
                    color: #d91e18;
                }
                .footer {
                    margin-top: 50px;
                    text-align: center;
                    border-top: 1px solid #eeeeee;
                    padding-top: 20px;
                    color: #888888;
                    font-size: 12px;
                }
            </style>
        </head>
        <body>
            <div class='invoice-box'>
                <div class='header' style='display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f5f5f5; padding-bottom: 20px; margin-bottom: 30px;'>
                    <div class='logo' style='font-size: 22px; font-weight: bold; color: #d91e18; text-transform: uppercase; letter-spacing: 1px;'>
                        {$siteName}
                    </div>
                    <div class='invoice-title' style='text-align: right;'>
                        <h1 style='margin: 0; font-size: 28px; color: #111111; font-weight: 800;'>INVOICE</h1>
                        <span style='color: #888888; font-size: 14px;'>No: INV-{$order->order_number}</span>
                    </div>
                </div>
                
                <div class='details-container' style='display: flex; justify-content: space-between; margin-bottom: 30px; gap: 20px;'>
                    <div class='details-col' style='flex: 1;'>
                        <h5 style='margin: 0 0 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888888;'>Seller Info</h5>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444;'><strong style='color: #111111;'>{$siteName}</strong></p>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444;'>{$officeAddress}</p>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444;'>Email: {$contactEmail}</p>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444;'>Phone: {$contactPhone}</p>
                    </div>
                    <div class='details-col' style='flex: 1;'>
                        <h5 style='margin: 0 0 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888888;'>Bill To</h5>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444;'><strong style='color: #111111;'>{$order->customer_name}</strong></p>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444; white-space: pre-line;'>{$order->billing_address}</p>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444;'>Email: {$order->customer_email}</p>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444;'>Phone: {$order->customer_phone}</p>
                    </div>
                    <div class='details-col' style='flex: 1;'>
                        <h5 style='margin: 0 0 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888888;'>Ship To</h5>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444;'><strong style='color: #111111;'>{$order->customer_name}</strong></p>
                        <p style='margin: 0 0 5px 0; font-size: 13px; color: #444444; white-space: pre-line;'>{$order->shipping_address}</p>
                    </div>
                    <div class='details-col' style='flex: 1; text-align: right;'>
                        <h5 style='margin: 0 0 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888888;'>Order Summary</h5>
                        <p style='margin: 0 0 5px 0; font-size: 14px;'><strong>Date:</strong> {$orderDate}</p>
                        <p style='margin: 0 0 5px 0; font-size: 14px;'><strong>Status:</strong> <span style='text-transform: uppercase; font-weight: bold; font-size: 12px; color: {$statusColor};'>{$order->status}</span></p>
                        {$trackingHtml}
                    </div>
                </div>
                
                <table class='table-items' style='width: 100%; border-collapse: collapse; margin-bottom: 30px;'>
                    <thead>
                        <tr>
                            <th style='background-color: #fcfcfc; border-bottom: 2px solid #eeeeee; text-align: left; padding: 12px; font-size: 12px; text-transform: uppercase; color: #666666; font-weight: bold;'>Part Details</th>
                            <th style='background-color: #fcfcfc; border-bottom: 2px solid #eeeeee; text-align: left; padding: 12px; font-size: 12px; text-transform: uppercase; color: #666666; font-weight: bold;'>SKU</th>
                            <th style='background-color: #fcfcfc; border-bottom: 2px solid #eeeeee; text-align: right; padding: 12px; font-size: 12px; text-transform: uppercase; color: #666666; font-weight: bold;'>Price</th>
                            <th style='background-color: #fcfcfc; border-bottom: 2px solid #eeeeee; text-align: center; padding: 12px; font-size: 12px; text-transform: uppercase; color: #666666; font-weight: bold;'>Qty</th>
                            <th style='background-color: #fcfcfc; border-bottom: 2px solid #eeeeee; text-align: right; padding: 12px; font-size: 12px; text-transform: uppercase; color: #666666; font-weight: bold;'>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$itemsHtml}
                    </tbody>
                </table>
                
                <div class='total-box' style='display: flex; justify-content: flex-end;'>
                    <table class='total-table' style='width: 250px; border-collapse: collapse;'>
                        <tr>
                            <td style='padding: 8px 12px; color: #666666;'>Subtotal:</td>
                            <td style='padding: 8px 12px; color: #666666; text-align: right; font-weight: bold;'>\${$formattedTotal}</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 12px; color: #666666;'>Shipping:</td>
                            <td style='padding: 8px 12px; color: #28a745; text-align: right; font-weight: bold;'>FREE</td>
                        </tr>
                        <tr class='grand-total'>
                            <td style='padding: 8px 12px; border-top: 2px solid #eeeeee; font-size: 18px; font-weight: bold; color: #d91e18;'>Total Paid:</td>
                            <td style='padding: 8px 12px; border-top: 2px solid #eeeeee; font-size: 18px; font-weight: bold; color: #d91e18; text-align: right;'>\${$formattedTotal}</td>
                        </tr>
                    </table>
                </div>
                
                <div class='footer' style='margin-top: 50px; text-align: center; border-top: 1px solid #eeeeee; padding-top: 20px; color: #888888; font-size: 12px;'>
                    Thank you for shopping with {$siteName}. If you have any questions about this invoice, please contact support.
                </div>
            </div>
        </body>
        </html>";

        return response($htmlContent, 200, $headers);
    }
}
