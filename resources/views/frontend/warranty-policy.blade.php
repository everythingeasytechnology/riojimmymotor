@extends('frontend.layouts.master')

@section('meta_title', 'Warranty Policy | ' . $siteSettings->get('site_name', 'Rio Jimmy Motor'))
@section('meta_description', 'Read the Warranty Policy for ' . $siteSettings->get('site_name', 'Rio Jimmy Motor') . '. Learn about our 30,000-mile or 36-month engines and transmissions warranty coverage.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Warranty Policy</li>
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
                        <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Quality Guarantee</span>
                        <h1 class="mt-2 mb-3 fw-800 text-dark" style="font-size: 38px;">Warranty Policy</h1>
                        <p class="text-muted mb-5"><strong>Effective Date:</strong> February 05, 2025</p>
                        
                        <div class="alert alert-danger border-0 shadow-sm p-4 mb-5 rounded" style="background-color: rgba(217, 30, 24, 0.05); border-left: 4px solid var(--primary-red) !important;">
                            <h4 class="fw-bold text-dark mb-2"><i class="fa fa-award me-2 text-danger"></i> 30,000-Mile / 36-Month Warranty</h4>
                            <p class="m-0 text-muted">We proudly offer a <strong>30,000-mile or 36-month warranty</strong> (whichever comes first) on all engines and transmissions sold through <strong>{{ $siteSettings->get('site_name', 'Rio Jimmy Motors') }}</strong>.</p>
                        </div>
                        
                        <div class="policy-content">
                            
                            <!-- Covered vs Not Covered Row -->
                            <div class="row g-4 mb-5">
                                <!-- Section 1: What's Covered -->
                                <div class="col-md-6">
                                    <div class="p-4 bg-light rounded border h-100">
                                        <h3 class="fw-700 text-dark mb-3" style="font-size: 22px;"><i class="fa fa-check-circle text-success me-2"></i> 1. What’s Covered</h3>
                                        <p class="text-muted small">The warranty covers the following components and defects under standard operating guidelines:</p>
                                        <ul class="list-unstyled text-muted small ps-0">
                                            <li class="mb-2"><i class="fa fa-check text-success me-2"></i> Internal components of engines and transmissions.</li>
                                            <li class="mb-2"><i class="fa fa-check text-success me-2"></i> Manufacturing defects in materials or assembly.</li>
                                            <li><i class="fa fa-check text-success me-2"></i> Failure due to normal, non-commercial vehicle usage.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- Section 2: What's Not Covered -->
                                <div class="col-md-6">
                                    <div class="p-4 bg-light rounded border h-100">
                                        <h3 class="fw-700 text-dark mb-3" style="font-size: 22px;"><i class="fa fa-times-circle text-danger me-2"></i> 2. What’s Not Covered</h3>
                                        <p class="text-muted small">Our warranty does not apply to damage or failure resulting from:</p>
                                        <ul class="list-unstyled text-muted small ps-0">
                                            <li class="mb-2"><i class="fa fa-times text-danger me-2"></i> Damage from improper or non-professional installation.</li>
                                            <li class="mb-2"><i class="fa fa-times text-danger me-2"></i> Overheating, insufficient fluid levels, or lack of proper oil.</li>
                                            <li><i class="fa fa-times text-danger me-2"></i> Racing, off-road abuse, negligence, or aftermarket modification.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 3 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-shield-alt text-danger me-2"></i> 3. Warranty Activation</h3>
                                <p class="text-muted">To activate and preserve the validity of your warranty, the following requirements must be met:</p>
                                <ul class="text-muted ps-4">
                                    <li class="mb-2">The engine or transmission must be installed by a <strong>certified technician or ASE-licensed repair facility</strong>.</li>
                                    <li class="mb-2">Proper documentation, log receipts of fluids/filters change, and installation service receipts must be kept and presented upon request.</li>
                                </ul>
                            </div>
                            
                            <!-- Section 4 -->
                            <div class="policy-section">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-file-invoice text-danger me-2"></i> 4. Claim Process</h3>
                                <p class="text-muted">In the event of a warranty claim, please contact us at <a href="mailto:support@riojimmymotor.com" class="text-danger fw-bold text-decoration-none">support@riojimmymotor.com</a> and provide the following documentation:</p>
                                
                                <div class="row g-3 mt-1 mb-4">
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded text-center border">
                                            <span class="fs-4">🔢</span>
                                            <h6 class="fw-bold text-dark mt-2 mb-1">Order Details</h6>
                                            <p class="text-muted small m-0">Your unique purchase order number.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded text-center border">
                                            <span class="fs-4">📝</span>
                                            <h6 class="fw-bold text-dark mt-2 mb-1">Problem Description</h6>
                                            <p class="text-muted small m-0">Detailed description of the issue or codes.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded text-center border">
                                            <span class="fs-4">📊</span>
                                            <h6 class="fw-bold text-dark mt-2 mb-1">Diagnosis Report</h6>
                                            <p class="text-muted small m-0">A professional shop diagnosis report.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="text-muted">Once our technical claims department verifies the claim details, we may offer one of the following resolutions:</p>
                                <div class="p-3 bg-light rounded border-start border-success border-4">
                                    <ul class="text-muted mb-0 ps-3">
                                        <li class="mb-1"><strong>Free replacement</strong> of the defective component with a tested alternative.</li>
                                        <li class="mb-1">A <strong>partial refund</strong> based on the condition and term of usage.</li>
                                        <li>Store <strong>credit</strong> applicable towards your next automotive parts purchase.</li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
