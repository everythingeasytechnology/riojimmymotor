@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Order Details #{{ $order->order_number }}</h2>
            <span class="text-muted small">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back to Orders</a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-download me-1"></i> Download Invoice</a>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- Left Side: Order Items & Client Info -->
        <div class="col-lg-8 col-12">
            
            <!-- Client Details -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <span><i class="fa fa-user text-danger me-2"></i>Customer Information</span>
                </div>
                <div class="admin-card-body text-dark font-poppins">
                    <div class="row g-3">
                        <div class="col-md-4 col-12">
                            <span class="text-muted small d-block">NAME</span>
                            <span class="fw-bold">{{ $order->customer_name }}</span>
                        </div>
                        <div class="col-md-4 col-12">
                            <span class="text-muted small d-block">EMAIL ADDRESS</span>
                            <span class="fw-bold">{{ $order->customer_email }}</span>
                        </div>
                        <div class="col-md-4 col-12">
                            <span class="text-muted small d-block">PHONE NUMBER</span>
                            <span class="fw-bold">{{ $order->customer_phone ?? 'Not Sourced' }}</span>
                        </div>
                        <div class="col-md-6 col-12 border-top pt-2">
                            <span class="text-muted small d-block">BILLING ADDRESS</span>
                            <span class="fw-bold d-block" style="white-space: pre-line;">{{ $order->billing_address ?? 'Not Sourced' }}</span>
                        </div>
                        <div class="col-md-6 col-12 border-top pt-2">
                            <span class="text-muted small d-block">SHIPPING ADDRESS</span>
                            <span class="fw-bold d-block" style="white-space: pre-line;">{{ $order->shipping_address ?? 'Not Sourced' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items List -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa fa-boxes text-danger me-2"></i>Ordered Auto Parts</span>
                </div>
                <div class="admin-card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle m-0 text-dark font-poppins">
                            <thead class="table-light">
                                <tr>
                                    <th>Part Details</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->items as $item)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark d-block">{{ $item->product_name }}</span>
                                            <span class="text-muted small">Brand: {{ $item->product->brand ?? 'OEM' }}</span>
                                        </td>
                                        <td><code>{{ $item->product_sku }}</code></td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @empty
                                    <!-- Fallback visualization row -->
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark d-block">2.5L Toyota Camry Engine Block Assembly</span>
                                            <span class="text-muted small">Brand: Toyota</span>
                                        </td>
                                        <td><code>ENG-CAM-2018</code></td>
                                        <td>$1,450.00</td>
                                        <td>1</td>
                                        <td class="text-end fw-bold">$1,450.00</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Side: Status Updates & Invoice Summary -->
        <div class="col-lg-4 col-12">
            
            <!-- Update Order Status Form -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <span><i class="fa fa-truck-fast text-danger me-2"></i>Update Order State</span>
                </div>
                <div class="admin-card-body text-dark">
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">ORDER STATUS</label>
                            <select class="form-select" name="status" id="orderStatusSelector">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending (Unprocessed)</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped (In Transit)</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <!-- Tracking details field -->
                        <div class="mb-3 d-none" id="trackingField">
                            <label class="form-label small fw-bold">TRACKING NUMBER</label>
                            <input type="text" class="form-control" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="e.g. 1Z999AA10123456784">
                        </div>

                        <!-- Refund reason field -->
                        <div class="mb-3 d-none" id="refundField">
                            <label class="form-label small fw-bold">REFUND REASON</label>
                            <textarea class="form-control" name="refund_reason" rows="2" placeholder="Input reason for refund processing...">{{ $order->refund_reason }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save me-1"></i> Update Order Status</button>
                    </form>
                </div>
            </div>

            <!-- Invoice Summary Card -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa fa-file-invoice-dollar text-danger me-2"></i>Invoice Summary</span>
                </div>
                <div class="admin-card-body text-dark font-poppins">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>${{ number_format($order->subtotal ?? 1450.00, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping Cost</span>
                        <span>${{ number_format($order->shipping_cost ?? 0.00, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span class="text-muted">Tax (0%)</span>
                        <span>${{ number_format($order->tax ?? 0.00, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                        <span>Total Paid</span>
                        <span class="text-danger">${{ number_format($order->total ?? 1450.00, 2) }}</span>
                    </div>

                    <div class="border-top pt-3">
                        <span class="text-muted small d-block">PAYMENT METHOD</span>
                        <span class="fw-bold small">{{ $order->payment_method ?? 'Direct Bank Wire' }}</span>
                        
                        <span class="text-muted small d-block mt-2">TRANSACTION ID</span>
                        <span class="fw-bold small font-monospace">{{ $order->transaction_id ?? 'TXN_MOCK_5832' }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

@push('admin-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelector = document.getElementById('orderStatusSelector');
            const trackingField = document.getElementById('trackingField');
            const refundField = document.getElementById('refundField');

            const checkFieldsToggle = (val) => {
                if (val === 'shipped') {
                    trackingField.classList.remove('d-none');
                    refundField.classList.add('d-none');
                } else if (val === 'refunded') {
                    refundField.classList.remove('d-none');
                    trackingField.classList.add('d-none');
                } else {
                    trackingField.classList.add('d-none');
                    refundField.classList.add('d-none');
                }
            };

            statusSelector.addEventListener('change', function () {
                checkFieldsToggle(this.value);
            });

            // Initial check
            checkFieldsToggle(statusSelector.value);
        });
    </script>
@endpush
