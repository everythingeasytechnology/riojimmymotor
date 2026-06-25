@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Dashboard Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Admin Dashboard</h2>
            <span class="text-muted small">Analytics overview and quick actions.</span>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary" onclick="window.location.reload()"><i class="fa fa-sync me-1"></i> Refresh Metrics</button>
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i> Add Part</a>
        </div>
    </div>

    <!-- Widgets row -->
    <div class="row g-4 mb-4">
        <!-- Revenue Widget -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="widget-card">
                <div>
                    <span class="text-muted small d-block mb-1">TOTAL REVENUE</span>
                    <h3 class="fw-bold mb-0 font-poppins text-success">${{ number_format($stats['total_revenue'], 2) }}</h3>
                </div>
                <div class="widget-icon bg-success-subtle text-success">
                    <i class="fa fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <!-- Orders Widget -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="widget-card">
                <div>
                    <span class="text-muted small d-block mb-1">TOTAL ORDERS</span>
                    <h3 class="fw-bold mb-0 font-poppins">{{ $stats['total_orders'] }}</h3>
                </div>
                <div class="widget-icon bg-primary-subtle text-primary">
                    <i class="fa fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <!-- Products Widget -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="widget-card">
                <div>
                    <span class="text-muted small d-block mb-1">ACTIVE PRODUCTS</span>
                    <h3 class="fw-bold mb-0 font-poppins">{{ $stats['total_products'] }}</h3>
                </div>
                <div class="widget-icon bg-warning-subtle text-warning">
                    <i class="fa fa-cogs"></i>
                </div>
            </div>
        </div>

        <!-- Leads Widget -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="widget-card">
                <div>
                    <span class="text-muted small d-block mb-1">UNREAD LEADS</span>
                    <h3 class="fw-bold mb-0 font-poppins text-danger">{{ $stats['unread_leads'] }} / {{ $stats['total_leads'] }}</h3>
                </div>
                <div class="widget-icon bg-danger-subtle text-danger">
                    <i class="fa fa-envelope-open-text"></i>
                </div>
            </div>
        </div>
    </div>



    <!-- Activity Lists row -->
    <div class="row g-4">
        <!-- Recent Orders table -->
        <div class="col-lg-7 col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa fa-receipt text-danger me-2"></i>Recent Orders</span>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-link text-danger fw-bold btn-sm text-decoration-none">View All</a>
                </div>
                <div class="admin-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0 text-dark font-poppins">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_orders as $order)
                                    <tr>
                                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-decoration-none text-danger">#{{ $order->order_number }}</a></td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            @if($order->status === 'paid' || $order->status === 'delivered')
                                                <span class="badge bg-success-subtle text-success border-success-subtle border px-2 py-1">Paid</span>
                                            @elseif($order->status === 'shipped')
                                                <span class="badge bg-primary-subtle text-primary border-primary-subtle border px-2 py-1">Shipped</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning border-warning-subtle border px-2 py-1">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Fallback items for visualization -->
                                    <tr>
                                        <td><a href="#" class="fw-bold text-decoration-none text-danger">#ORD-5832</a></td>
                                        <td>John Miller</td>
                                        <td>$1,450.00</td>
                                        <td><span class="badge bg-success text-white px-2 py-1">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="fw-bold text-decoration-none text-danger">#ORD-5831</a></td>
                                        <td>Sarah Green</td>
                                        <td>$280.00</td>
                                        <td><span class="badge bg-warning text-dark px-2 py-1">Processing</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="fw-bold text-decoration-none text-danger">#ORD-5830</a></td>
                                        <td>Thomas Cook</td>
                                        <td>$185.00</td>
                                        <td><span class="badge bg-info text-white px-2 py-1">Shipped</span></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Products table -->
        <div class="col-lg-5 col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa fa-box-open text-danger me-2"></i>Recently Added Parts</span>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-link text-danger fw-bold btn-sm text-decoration-none">View All</a>
                </div>
                <div class="admin-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0 text-dark font-poppins">
                            <thead class="table-light">
                                <tr>
                                    <th>Part Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_products as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $product->name }}</a>
                                            <span class="text-muted small">SKU: {{ $product->sku }}</span>
                                        </td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->stock }}</td>
                                    </tr>
                                @empty
                                    <!-- Fallback items for visualization -->
                                    <tr>
                                        <td>
                                            <a href="#" class="fw-bold text-dark text-decoration-none d-block">2.5L Toyota Camry Engine</a>
                                            <span class="text-muted small">SKU: ENG-CAM-2018</span>
                                        </td>
                                        <td>$1,450.00</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#" class="fw-bold text-dark text-decoration-none d-block">Ford F-150 Transmission</a>
                                            <span class="text-muted small">SKU: TRS-F150-10SPD</span>
                                        </td>
                                        <td>$1,890.00</td>
                                        <td>2</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


