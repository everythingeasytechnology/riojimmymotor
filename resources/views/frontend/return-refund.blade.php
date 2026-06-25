@extends('frontend.layouts.master')

@section('meta_title', 'Return & Refund Policy | ' . $siteSettings->get('site_name', 'Rio Jimmy Motor'))
@section('meta_description', 'Read the Return & Refund Policy for ' . $siteSettings->get('site_name', 'Rio Jimmy Motor') . '. Find out about our return procedures, warranty returns, and refund processing.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Return & Refund</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Content Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto">
                    <div class="policy-wrapper">
                        <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Support & Returns</span>
                        <h1 class="mt-2 mb-3 fw-800 text-dark" style="font-size: 38px;">Return & Refund Policy</h1>
                        <p class="text-muted mb-5"><strong>Effective Date:</strong> February 05, 2025</p>
                        
                        <div class="policy-intro mb-5">
                            <p class="lead text-dark">We want you to be completely satisfied with your purchase. This policy details the eligibility requirements, procedures, and timelines for returns, refunds, and cancellations at <strong>{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}</strong>.</p>
                        </div>
                        
                        <div class="policy-content">
                            
                            <!-- Section 1 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-clipboard-check text-danger me-2"></i> 1. Returns & Refund Eligibility</h3>
                                <div class="row g-4 mt-2">
                                    <div class="col-md-6">
                                        <div class="p-4 bg-light rounded border h-100">
                                            <h5 class="fw-bold text-dark mb-3"><i class="fa fa-box text-danger me-2"></i> Physical Products</h5>
                                            <p class="text-muted small mb-0">For physical products purchased directly from Rio Jimmy Motors, return requests may be accepted within <strong>30 days of delivery</strong>, subject to product condition and compatibility requirements.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 bg-light rounded border h-100">
                                            <h5 class="fw-bold text-dark mb-3"><i class="fa fa-handshake text-danger me-2"></i> Sourcing & Svc Support</h5>
                                            <p class="text-muted small mb-0">For vendor locating, sourcing assistance, supplier identification, consulting and coordination services, refund requests may be considered <strong>only if no substantial work has been initiated</strong>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 2 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-money-bill-wave text-danger me-2"></i> 2. Refund Processing</h3>
                                <ul class="text-muted ps-4">
                                    <li class="mb-3"><strong>Physical Products:</strong> Eligible refunds for physical products will be processed to the original payment method after parts are returned, inspected, and approved.</li>
                                    <li class="mb-3"><strong>Service-Related Work:</strong> Eligible service-related refunds, where applicable, will be reviewed on a case-by-case basis and processed to the original payment method.</li>
                                </ul>
                            </div>
                            
                            <!-- Section 3 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-ban text-danger me-2"></i> 3. Non-Returnable / Non-Refundable Items</h3>
                                <p class="text-muted">The following products and services are not eligible for returns or refunds under any circumstances:</p>
                                <div class="p-4 bg-danger-subtle rounded border-start border-danger border-4" style="background-color: rgba(220, 53, 69, 0.05) !important;">
                                    <ul class="text-muted mb-0 ps-3">
                                        <li class="mb-2">Special order or custom sourced automotive parts.</li>
                                        <li class="mb-2">Products damaged due to installation errors, misuse, or improper handling/testing.</li>
                                        <li class="mb-2">Services for which vendor research, supplier identification, sourcing assistance, or coordination work has already commenced.</li>
                                        <li>Fees charged for completed consulting or coordination services.</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Section 4 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-truck text-danger me-2"></i> 4. Vendor Sourcing & Coordination Services</h3>
                                <p class="text-muted">Rio Jimmy Motors may provide vendor locating, sourcing assistance, supplier identification, and coordination services for automotive components and related products.</p>
                                <ul class="text-muted ps-4">
                                    <li class="mb-2">Customers remain responsible for evaluating suppliers and making final purchasing decisions.</li>
                                    <li class="mb-2">Product purchases, shipping arrangements, transportation, and logistics may involve third-party suppliers and service providers.</li>
                                </ul>
                            </div>
                            
                            <!-- Section 5 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-times-circle text-danger me-2"></i> 5. Cancellation Policy</h3>
                                <p class="text-muted">Cancellation requests for services must be submitted before substantial work has commenced.</p>
                                <div class="p-3 bg-light rounded border-start border-danger border-4">
                                    <p class="text-muted small m-0"><strong>Please Note:</strong> Once research, sourcing, or coordination activities have begun, service fees may become non-refundable.</p>
                                </div>
                            </div>
                            
                            <!-- Section 6 -->
                            <div class="policy-section">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-envelope text-danger me-2"></i> 6. Contact Information</h3>
                                <p class="text-muted">For return, refund, or cancellation requests, please contact our support desk:</p>
                                <div class="d-flex align-items-center gap-2 mt-3">
                                    <span class="fs-5">📧</span>
                                    <a href="mailto:support@riojimmymotor.com" class="text-danger fw-bold text-decoration-none fs-5">support@riojimmymotor.com</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
