@extends('frontend.layouts.master')

@section('meta_title', 'Privacy Policy | ' . $siteSettings->get('site_name', 'Rio Jimmy Motor'))
@section('meta_description', 'Read the Privacy Policy for ' . $siteSettings->get('site_name', 'Rio Jimmy Motor') . '. Learn how we collect, protect, and use your personal information.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
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
                        <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Legal Information</span>
                        <h1 class="mt-2 mb-3 fw-800 text-dark" style="font-size: 38px;">Privacy Policy</h1>
                        <p class="text-muted mb-5"><strong>Effective Date:</strong> February 05, 2025</p>
                        
                        <div class="policy-intro mb-5">
                            <p class="lead text-dark"><strong>{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}</strong> values your privacy and is committed to protecting your personal information. This Privacy Policy explains how we collect, use, and protect the information you provide when using our website or services.</p>
                        </div>
                        
                        <div class="policy-content">
                            
                            <!-- Section 1 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-database text-danger me-2"></i> 1. Information We Collect</h3>
                                <p class="text-muted">When you use our website or contact us, we may collect the following information:</p>
                                
                                <div class="row g-4 mt-2">
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded border h-100">
                                            <h5 class="fw-bold text-dark mb-2"><i class="fa fa-user text-danger me-2"></i> Personal Info</h5>
                                            <ul class="list-unstyled text-muted small mb-0">
                                                <li class="mb-1"><i class="fa fa-check text-success me-1"></i> Name</li>
                                                <li class="mb-1"><i class="fa fa-check text-success me-1"></i> Email address</li>
                                                <li class="mb-1"><i class="fa fa-check text-success me-1"></i> Phone number</li>
                                                <li><i class="fa fa-check text-success me-1"></i> Billing & shipping address</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded border h-100">
                                            <h5 class="fw-bold text-dark mb-2"><i class="fa fa-car text-danger me-2"></i> Vehicle & Orders</h5>
                                            <ul class="list-unstyled text-muted small mb-0">
                                                <li class="mb-1"><i class="fa fa-check text-success me-1"></i> Vehicle year, make, model</li>
                                                <li class="mb-1"><i class="fa fa-check text-success me-1"></i> VIN (for compatibility verification)</li>
                                                <li><i class="fa fa-check text-success me-1"></i> Order & transaction details</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded border h-100">
                                            <h5 class="fw-bold text-dark mb-2"><i class="fa fa-laptop text-danger me-2"></i> Technical Info</h5>
                                            <ul class="list-unstyled text-muted small mb-0">
                                                <li class="mb-1"><i class="fa fa-check text-success me-1"></i> IP address</li>
                                                <li class="mb-1"><i class="fa fa-check text-success me-1"></i> Browser type</li>
                                                <li><i class="fa fa-check text-success me-1"></i> Cookies & usage data</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 2 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-cogs text-danger me-2"></i> 2. How We Use Your Information</h3>
                                <p class="text-muted">We use the collected information to:</p>
                                <ul class="text-muted ps-4">
                                    <li class="mb-2">Process orders and payments efficiently.</li>
                                    <li class="mb-2">Provide reliable customer support.</li>
                                    <li class="mb-2">Respond to inquiries and parts compatibility service requests.</li>
                                    <li class="mb-2">Send order confirmations, invoice records, and shipping/tracking updates.</li>
                                    <li class="mb-2">Improve website functionality, layout, and overall user experience.</li>
                                </ul>
                            </div>
                            
                            <!-- Section 3 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-sms text-danger me-2"></i> 3. SMS Communications</h3>
                                <p class="text-muted">If you provide your phone number through our website forms or communication channels, you may receive SMS messages related to:</p>
                                <ul class="text-muted ps-4 mb-3">
                                    <li class="mb-2">Order confirmations</li>
                                    <li class="mb-2">Shipping updates</li>
                                    <li class="mb-2">Customer support communication</li>
                                    <li class="mb-2">Service notifications</li>
                                </ul>
                                <p class="text-muted small mb-2"><i class="fa fa-info-circle text-danger me-1"></i> Message frequency may vary depending on your interaction with our services.</p>
                                <p class="text-muted small mb-2"><i class="fa fa-info-circle text-danger me-1"></i> Message and data rates may apply.</p>
                                <p class="text-muted small mb-2"><i class="fa fa-info-circle text-danger me-1"></i> You can opt out of SMS communications at any time by replying <strong>STOP</strong>.</p>
                                <p class="text-muted small"><i class="fa fa-info-circle text-danger me-1"></i> For assistance, reply <strong>HELP</strong> or contact our support team.</p>
                            </div>
                            
                            <!-- Section 4 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-shield-alt text-danger me-2"></i> 4. SMS Privacy Commitment</h3>
                                <div class="p-4 bg-light rounded border-start border-danger border-4">
                                    <p class="text-dark fw-bold mb-2">Your trust is our priority.</p>
                                    <p class="text-muted mb-2"><strong>{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}</strong> does not sell, rent, share, or distribute phone numbers or SMS consent data to third parties or affiliates for marketing or promotional purposes.</p>
                                    <p class="text-muted mb-0">SMS consent is used only for direct communication related to our services and will not be transferred to any external organization.</p>
                                </div>
                            </div>
                            
                            <!-- Section 5 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-share-alt text-danger me-2"></i> 5. Sharing Your Information</h3>
                                <p class="text-muted">We do not sell your personal information. Your information may be shared only with trusted service providers necessary to operate our business, including:</p>
                                <ul class="text-muted ps-4">
                                    <li class="mb-2"><strong>Payment processors</strong> (to process secure financial transactions)</li>
                                    <li class="mb-2"><strong>Shipping and logistics providers</strong> (to deliver purchased auto parts to your address)</li>
                                    <li class="mb-2"><strong>Website hosting or technical service providers</strong> (to maintain stable site operations)</li>
                                </ul>
                                <p class="text-muted">These partners are required to maintain confidentiality and use the information only for service-related purposes.</p>
                            </div>
                            
                            <!-- Section 6 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-cookie-bite text-danger me-2"></i> 6. Cookies</h3>
                                <p class="text-muted">Our website uses cookies to improve functionality, analyze traffic, and enhance your user experience. You may disable cookies through your browser settings, but some website features may not function properly as a result.</p>
                            </div>
                            
                            <!-- Section 7 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-lock text-danger me-2"></i> 7. Data Security</h3>
                                <p class="text-muted">We implement robust and reasonable security measures to protect your personal information. Financial payment information is processed through secure, industry-leading encrypted payment gateways.</p>
                            </div>
                            
                            <!-- Section 8 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-user-shield text-danger me-2"></i> 8. Your Rights</h3>
                                <p class="text-muted">You have the right to request access, correction, or deletion of your personal information. To make such a request, please contact us at:</p>
                                <div class="d-flex align-items-center gap-2 mt-3">
                                    <span class="fs-5">📧</span>
                                    <a href="mailto:support@riojimmymotor.com" class="text-danger fw-bold text-decoration-none fs-5">support@riojimmymotor.com</a>
                                </div>
                            </div>
                            
                            <!-- Section 9 -->
                            <div class="policy-section">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-history text-danger me-2"></i> 9. Policy Updates</h3>
                                <p class="text-muted m-0"><strong>{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}</strong> may update this Privacy Policy periodically. Changes will be posted on this page with the updated effective date.</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
