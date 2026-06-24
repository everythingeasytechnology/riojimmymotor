@extends('frontend.layouts.master')

@section('meta_title', 'Order Confirmed | Rio Jimmy Motor')
@section('meta_description', 'Thank you for your purchase! Your auto parts order has been placed successfully.')

@section('content')
<div class="container py-5 font-poppins">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-12">
            <!-- Success Banner -->
            <div class="text-center mb-5">
                <div class="success-icon-wrapper mb-4 d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow-sm" style="width: 80px; height: 80px;">
                    <i class="fa fa-check fs-1"></i>
                </div>
                <h1 class="fw-800 text-dark mb-2" style="font-size: 32px;">Order Confirmed!</h1>
                <p class="text-muted fs-6">Thank you for your order, <strong>{{ $order->customer_name }}</strong>. Your purchase is complete and currently processing.</p>
                <div class="badge bg-light text-dark border px-3 py-2 mt-2">
                    <span class="text-muted">Order Number:</span> <strong class="text-danger">{{ $order->order_number }}</strong>
                </div>
            </div>

            <!-- Receipt & Summary details -->
            <div class="card border rounded shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">Order Details</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="border-bottom text-muted" style="font-size: 13px;">
                                    <th class="ps-0 pb-2">ITEM</th>
                                    <th class="pb-2 text-center" style="width: 15%;">QTY</th>
                                    <th class="pe-0 text-end pb-2" style="width: 25%;">PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr class="border-bottom">
                                    <td class="ps-0 py-3">
                                        <h6 class="fw-bold mb-1 text-dark">{{ $item->product_name }}</h6>
                                        <span class="text-muted small">SKU: {{ $item->product_sku }}</span>
                                    </td>
                                    <td class="text-center py-3 text-dark fw-medium">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="pe-0 text-end py-3 text-dark fw-bold">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="2" class="ps-0 pt-4 text-muted small fw-medium">Subtotal</td>
                                    <td class="pe-0 text-end pt-4 text-dark fw-bold">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->shipping_cost > 0)
                                <tr>
                                    <td colspan="2" class="ps-0 py-1 text-muted small fw-medium">Shipping</td>
                                    <td class="pe-0 text-end py-1 text-dark fw-bold">${{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="2" class="ps-0 py-1 text-muted small fw-medium">Shipping</td>
                                    <td class="pe-0 text-end py-1 text-success fw-bold">FREE</td>
                                </tr>
                                @endif
                                @if($order->tax > 0)
                                <tr>
                                    <td colspan="2" class="ps-0 py-1 text-muted small fw-medium">Tax</td>
                                    <td class="pe-0 text-end py-1 text-dark fw-bold">${{ number_format($order->tax, 2) }}</td>
                                </tr>
                                @endif
                                <tr class="border-top">
                                    <td colspan="2" class="ps-0 pt-3 pb-0 fw-bold text-dark fs-5">Total Paid</td>
                                    <td class="pe-0 text-end pt-3 pb-0 fw-bold text-danger fs-4">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Customer & Delivery Meta Information -->
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-12">
                    <div class="card h-100 border rounded shadow-sm">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="fw-bold mb-0 text-dark"><i class="fa fa-user me-2 text-danger"></i>Customer Information</h6>
                        </div>
                        <div class="card-body small text-muted lh-lg">
                            <div class="mb-1"><strong class="text-dark">Email:</strong> {{ $order->customer_email }}</div>
                            <div class="mb-1"><strong class="text-dark">Phone:</strong> {{ $order->customer_phone }}</div>
                            <div class="mb-1"><strong class="text-dark">Payment Method:</strong> {{ $order->payment_method }}</div>
                            <div><strong class="text-dark">Payment Status:</strong> <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ strtoupper($order->payment_status) }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="card h-100 border rounded shadow-sm">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="fw-bold mb-0 text-dark"><i class="fa fa-truck me-2 text-danger"></i>Shipping Address</h6>
                        </div>
                        <div class="card-body small text-muted lh-base">
                            <p class="mb-0">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What happens next step section -->
            <div class="bg-light p-4 rounded border mb-5">
                <h5 class="fw-bold text-dark mb-3"><i class="fa fa-clipboard-list me-2 text-danger"></i>What Happens Next?</h5>
                <div class="d-flex flex-column gap-3 text-muted small">
                    <div class="d-flex gap-3 align-items-start">
                        <span class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; min-width: 24px;">1</span>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Pre-Shipment Verification Check</h6>
                            <p class="mb-0">Our engine/transmission specialists will perform a final quality check (compressions and seals inspection) before pallet packing to ensure A-grade quality.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start border-top pt-3">
                        <span class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; min-width: 24px;">2</span>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Freight LTL Shipping Arrangements</h6>
                            <p class="mb-0">Orders are shipped via major freight carriers. The local dispatch terminal will contact you directly on your phone number (<strong>{{ $order->customer_phone }}</strong>) to arrange a convenient delivery window.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start border-top pt-3">
                        <span class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; min-width: 24px;">3</span>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Tracking Notification</h6>
                            <p class="mb-0">We will dispatch the tracking code to <strong>{{ $order->customer_email }}</strong> inside the next 24-48 business hours. Deliveries normally take 5-7 business days across the USA.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions block -->
            <div class="text-center gap-2 d-sm-flex justify-content-center">
                <a href="{{ url('/parts') }}" class="btn btn-danger py-3 px-4 fw-bold text-white shadow-sm mb-2 mb-sm-0" style="background-color: var(--primary-red); border: none;">
                    <i class="fa fa-shopping-bag me-2"></i> Continue Shopping
                </a>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary py-3 px-4 fw-bold">
                    Go back Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
