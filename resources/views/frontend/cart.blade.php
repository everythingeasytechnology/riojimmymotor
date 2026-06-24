@extends('frontend.layouts.master')

@section('meta_title', 'Shopping Cart | Rio Jimmy Motor')
@section('meta_description', 'View the auto parts in your shopping cart, update quantities, and proceed to secure checkout.')

@section('content')
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/parts') }}">Auto Parts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5 font-poppins">
    <h1 class="fw-800 text-dark mb-4 pb-2 border-bottom text-uppercase" style="font-size: 32px;">Shopping Cart</h1>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <span><i class="fa fa-circle-check text-success me-2 fs-5"></i>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <span><i class="fa fa-circle-exclamation text-danger me-2 fs-5"></i>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(!empty($cart) && count($cart) > 0)
        <div class="row g-5">
            <!-- Left Column: Cart Items -->
            <div class="col-lg-8">
                <div class="card border rounded shadow-sm overflow-hidden mb-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="bg-light border-bottom text-muted" style="font-size: 13px;">
                                <tr>
                                    <th class="p-3" style="width: 50%;">PRODUCT</th>
                                    <th class="p-3 text-center" style="width: 15%;">PRICE</th>
                                    <th class="p-3 text-center" style="width: 20%;">QUANTITY</th>
                                    <th class="p-3 text-end" style="width: 15%;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr class="border-bottom">
                                        <!-- Product Image & Name -->
                                        <td class="p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded border bg-light" style="width: 70px; height: 70px; overflow: hidden; min-width: 70px;">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-1"><a href="{{ route('parts.show', ['slug' => $item['slug']]) }}" class="text-dark text-decoration-none hover-danger">{{ $item['name'] }}</a></h6>
                                                    <span class="text-muted small d-block">SKU: {{ $item['sku'] }}</span>
                                                    
                                                    <!-- Remove Form Link -->
                                                    <form action="{{ route('cart.remove') }}" method="POST" class="mt-2">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                                        <button type="submit" class="btn btn-link text-danger p-0 small fw-semibold text-decoration-none" style="font-size: 12px;">
                                                            <i class="fa-regular fa-trash-can me-1"></i> Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Price -->
                                        <td class="p-3 text-center text-dark fw-medium">
                                            ${{ number_format($item['price'], 2) }}
                                        </td>
                                        <!-- Quantity Controls -->
                                        <td class="p-3 text-center">
                                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center justify-content-center gap-1">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                
                                                <!-- Dec Qty Button -->
                                                <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-1 qty-btn-dec" style="border-radius: 4px 0 0 4px;">-</button>
                                                
                                                <input type="number" name="quantity" class="form-control form-control-sm text-center qty-input" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" style="width: 50px; border-radius: 0;" required>
                                                
                                                <!-- Inc Qty Button -->
                                                <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-1 qty-btn-inc" style="border-radius: 0 4px 4px 0;">+</button>
                                                
                                                <button type="submit" class="btn btn-sm btn-dark px-2 py-1 ms-1 d-none qty-submit-btn" title="Update Quantity">
                                                    <i class="fa fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <!-- Subtotal -->
                                        <td class="p-3 text-end text-dark fw-bold">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <a href="{{ url('/parts') }}" class="btn btn-outline-secondary py-2.5 px-4 fw-semibold">
                        <i class="fa fa-arrow-left me-2"></i> Continue Shopping
                    </a>
                    
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted small fw-semibold text-decoration-none">
                            <i class="fa-regular fa-circle-xmark me-1"></i> Clear Shopping Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Cart Summary Card -->
            <div class="col-lg-4">
                <div class="card border rounded shadow-sm p-4" style="background-color: #f8f9fa;">
                    <h4 class="fw-bold text-dark mb-4 border-bottom pb-2">CART TOTALS</h4>
                    
                    <div class="d-flex justify-content-between py-2 border-bottom border-light mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold text-dark">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between py-2 border-bottom border-light mb-4">
                        <span class="text-muted fw-semibold">Shipping</span>
                        <span class="fw-bold text-success">FREE</span>
                    </div>

                    <div class="d-flex justify-content-between py-2 mb-4 align-items-end">
                        <span class="text-dark fw-bold fs-5 mb-0">Total</span>
                        <span class="fw-bold text-danger fs-4">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn btn-danger w-100 py-3 text-uppercase fw-bold text-white shadow-sm" style="background-color: var(--primary-red); border: none; letter-spacing: 0.5px;">
                        Proceed to Checkout <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5 border rounded bg-light shadow-sm">
            <div class="mb-4 text-muted">
                <i class="fa-solid fa-basket-shopping" style="font-size: 80px; color: #ced4da;"></i>
            </div>
            <h3 class="fw-bold text-dark mb-2">Your cart is empty!</h3>
            <p class="text-muted mb-4 max-w-md mx-auto">It looks like you haven't added any certified auto parts to your shopping cart yet.</p>
            <a href="{{ url('/parts') }}" class="btn btn-danger py-3 px-5 fw-bold text-white shadow-sm" style="background-color: var(--primary-red); border: none;">
                <i class="fa fa-search me-2"></i> Browse Our Shop
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInputs = document.querySelectorAll('.qty-input');
        
        qtyInputs.forEach(input => {
            const form = input.closest('form');
            const decBtn = form.querySelector('.qty-btn-dec');
            const incBtn = form.querySelector('.qty-btn-inc');
            const submitBtn = form.querySelector('.qty-submit-btn');

            // Show update button when input manually changes
            input.addEventListener('change', function() {
                submitBtn.classList.remove('d-none');
            });

            // Dec Quantity click
            decBtn.addEventListener('click', function() {
                let val = parseInt(input.value);
                if (val > 1) {
                    input.value = val - 1;
                    form.submit();
                }
            });

            // Inc Quantity click
            incBtn.addEventListener('click', function() {
                let val = parseInt(input.value);
                let max = parseInt(input.getAttribute('max')) || 999;
                if (val < max) {
                    input.value = val + 1;
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection
