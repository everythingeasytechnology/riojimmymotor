@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Order Management</h2>
            <span class="text-muted small">Monitor purchase transactions and change shipping statuses.</span>
        </div>
        <button class="btn btn-sm btn-outline-secondary" onclick="alert('Exporting orders CSV (Mockup)')"><i class="fa fa-file-export me-1"></i> Export Orders</button>
    </div>

    <!-- Filter & Search Panel -->
    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2">
                <div class="col-md-5 col-12">
                    <input type="text" class="form-control border-secondary-subtle" name="search" placeholder="Search by Order # or Customer..." value="{{ $search }}">
                </div>
                <div class="col-md-4 col-12">
                    <select class="form-select border-secondary-subtle" name="status">
                        <option value="">All Orders Status</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="refunded" {{ $status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-3 col-12">
                    <button type="submit" class="btn btn-secondary w-100"><i class="fa fa-filter me-1"></i> Filter Orders</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table Card -->
    <div class="admin-card">
        <div class="admin-card-header">
            <span><i class="fa fa-receipt text-danger me-2"></i>Order Invoice Records</span>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0 text-dark font-poppins">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer Name</th>
                            <th>Date Sourced</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Invoice Total</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td><span class="fw-bold text-dark">#{{ $order->order_number }}</span></td>
                                <td>
                                    <span class="fw-bold text-dark d-block">{{ $order->customer_name }}</span>
                                    <span class="text-muted small">{{ $order->customer_email }}</span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Paid</span>
                                    @elseif($order->payment_status === 'refunded')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Refunded</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->status === 'delivered')
                                        <span class="badge bg-success text-white">Delivered</span>
                                    @elseif($order->status === 'shipped')
                                        <span class="badge bg-info text-white">Shipped</span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge bg-primary text-white">Processing</span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="badge bg-danger text-white">Cancelled</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td><span class="fw-bold">${{ number_format($order->total, 2) }}</span></td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-secondary btn-sm px-3 py-1"><i class="fa fa-eye me-1"></i> View</a>
                                </td>
                            </tr>
                        @empty
                            <!-- Fallback Mock items for visualization when DB is empty -->
                            @for($i=1; $i<=3; $i++)
                                <tr>
                                    <td><span class="fw-bold text-dark">#ORD-583{{ $i }}</span></td>
                                    <td>
                                        <span class="fw-bold text-dark d-block">Customer Name {{ $i }}</span>
                                        <span class="text-muted small">customer{{ $i }}@example.com</span>
                                    </td>
                                    <td>2026-06-22 13:40</td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">Paid</span></td>
                                    <td><span class="badge bg-primary text-white">Processing</span></td>
                                    <td><span class="fw-bold">$1,450.00</span></td>
                                    <td>
                                        <button class="btn btn-outline-secondary btn-sm px-3 py-1" onclick="alert('Mock Order Details Triggered')"><i class="fa fa-eye me-1"></i> View</button>
                                    </td>
                                </tr>
                            @endfor
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination footer -->
        @if($orders->hasPages())
            <div class="admin-card-footer border-top p-3 bg-light">
                {{ $orders->appends(['search' => $search, 'status' => $status])->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

@endsection
