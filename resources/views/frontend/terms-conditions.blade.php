@extends('frontend.layouts.master')

@section('meta_title', 'Terms & Conditions | ' . $siteSettings->get('site_name', 'Rio Jimmy Motor'))
@section('meta_description', 'Read the Terms & Conditions for ' . $siteSettings->get('site_name', 'Rio Jimmy Motor') . '. Understand our site usage guidelines, purchase terms, and customer rights.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
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
                        <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Legal Agreement</span>
                        <h1 class="mt-2 mb-3 fw-800 text-dark" style="font-size: 38px;">Terms & Conditions</h1>
                        <p class="text-muted mb-5"><strong>Effective Date:</strong> February 05, 2025</p>
                        
                        <div class="policy-intro mb-5">
                            <p class="lead text-dark">By accessing, browsing, purchasing products, or using services provided by <strong>{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}</strong>, you agree to be bound by the following Terms and Conditions. Please read them carefully.</p>
                        </div>
                        
                        <div class="policy-content">
                            
                            <!-- Section 1 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-globe text-danger me-2"></i> Use of Website</h3>
                                <p class="text-muted">All content on this website, including product listings, engine and transmission information, images, specifications, descriptions, service information, logos, and text, is provided for informational purposes only.</p>
                                <p class="text-muted">Rio Jimmy Motors reserves the right to modify, update, suspend, or discontinue any product, service, pricing, content, or feature without prior notice.</p>
                            </div>
                            
                            <!-- Section 2 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-shopping-cart text-danger me-2"></i> Orders & Payments</h3>
                                <ul class="text-muted ps-4">
                                    <li class="mb-2">All orders and service requests may require advance payment before processing.</li>
                                    <li class="mb-2">Orders and service engagements are considered confirmed only after successful payment verification through our approved payment processing systems.</li>
                                    <li class="mb-2">Rio Jimmy Motors reserves the right to cancel or refuse any order or service request in cases of suspected fraud, inaccurate information, payment disputes, or operational limitations.</li>
                                </ul>
                            </div>
                            
                            <!-- Section 3 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-hands text-danger me-2"></i> Vendor Location, Sourcing & Coordination Services</h3>
                                <p class="text-muted">Rio Jimmy Motors may provide vendor locating, supplier identification, sourcing assistance, procurement support, vendor coordination, and related business support services for automotive components and related products.</p>
                                <div class="p-3 bg-light rounded border-start border-danger border-4 mb-3">
                                    <p class="text-muted small m-0">These services are advisory and coordination-based in nature. Customers remain solely responsible for evaluating suppliers, reviewing product specifications, negotiating pricing, and making final purchasing decisions.</p>
                                </div>
                                <p class="text-muted">Rio Jimmy Motors does not guarantee any specific supplier, product availability, inventory levels, pricing, or purchasing outcome.</p>
                            </div>
                            
                            <!-- Section 4 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-shipping-fast text-danger me-2"></i> Shipping Policy</h3>
                                <p class="text-muted">For products sold directly by Rio Jimmy Motors, shipping may be available within designated service regions, including the United States.</p>
                                <ul class="text-muted ps-4">
                                    <li class="mb-2">Estimated delivery times may vary depending on supplier availability, destination, shipping carrier, weather conditions, and other logistical factors.</li>
                                    <li class="mb-2">Rio Jimmy Motors shall not be responsible for delays caused by third-party shipping carriers, customs procedures, weather events, force majeure events, or supplier-related delays.</li>
                                </ul>
                            </div>
                            
                            <!-- Section 5 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-car-battery text-danger me-2"></i> Product Compatibility</h3>
                                <p class="text-muted">Customers are responsible for providing accurate vehicle information, including Year, Make, Model, Engine Specifications, and VIN (where applicable). We strongly recommend confirming compatibility before completing any purchase.</p>
                                <p class="text-muted">Rio Jimmy Motors shall not be responsible for compatibility issues resulting from inaccurate or incomplete information provided by the customer.</p>
                            </div>
                            
                            <!-- Section 6 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-network-wired text-danger me-2"></i> Third-Party Suppliers & Vendor Network</h3>
                                <p class="text-muted">Certain products and services available through Rio Jimmy Motors may involve independent third-party suppliers, vendors, distributors, or service providers.</p>
                                <p class="text-muted">Rio Jimmy Motors may assist customers in locating suppliers and coordinating communications; however, final transactions, supplier selection, pricing agreements, logistics arrangements, and purchasing decisions remain the responsibility of the customer.</p>
                                <p class="text-muted">Rio Jimmy Motors shall not be liable for the actions, omissions, delays, pricing changes, inventory shortages, or performance of third-party suppliers.</p>
                            </div>
                            
                            <!-- Section 7 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-sms text-danger me-2"></i> SMS Messaging Terms (A2P Compliance)</h3>
                                
                                <div class="bg-light p-4 rounded border">
                                    <div class="mb-3">
                                        <h5 class="fw-bold text-dark mb-1">Messaging Program Name</h5>
                                        <p class="text-muted small mb-0">The Rio Jimmy Motors Customer Messaging Program allows customers to receive order updates, service notifications, customer support messages, and business-related communications.</p>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <h5 class="fw-bold text-dark mb-1">Program Description</h5>
                                        <p class="text-muted small mb-1">Customers who provide their phone number through our website forms or communication channels may receive SMS messages related to:</p>
                                        <ul class="text-muted small mb-0 ps-3">
                                            <li>Order confirmations</li>
                                            <li>Order status updates</li>
                                            <li>Shipping notifications</li>
                                            <li>Customer support communications</li>
                                            <li>Service updates</li>
                                            <li>Account-related notifications</li>
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <h5 class="fw-bold text-dark mb-1">Message Frequency</h5>
                                            <p class="text-muted small mb-0">Message frequency may vary depending on your interaction with our products and services.</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="fw-bold text-dark mb-1">Message & Data Rates</h5>
                                            <p class="text-muted small mb-0">Message and data rates may apply depending on your mobile carrier and mobile plan.</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <h5 class="fw-bold text-dark mb-1">Opt-Out Instructions</h5>
                                            <p class="text-muted small mb-0">You may opt out of SMS communications at any time by replying <strong>STOP</strong>.</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="fw-bold text-dark mb-1">Help Instructions</h5>
                                            <p class="text-muted small mb-0">For assistance, reply <strong>HELP</strong>.</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <h5 class="fw-bold text-dark mb-1">Customer Support</h5>
                                        <p class="text-muted small mb-0">For assistance regarding products, services, orders, or messaging communications, please email: <a href="mailto:support@riojimmymotor.com" class="text-danger fw-bold text-decoration-none">support@riojimmymotor.com</a></p>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <h5 class="fw-bold text-dark mb-1">Carrier Disclaimer</h5>
                                        <p class="text-muted small mb-0">Mobile carriers are not responsible for delayed or undelivered messages.</p>
                                    </div>
                                    <hr>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">Privacy Policy Reference</h5>
                                        <p class="text-muted small mb-0">Your privacy is important to us. Information collected through our website and communication channels is handled in accordance with our <a href="{{ url('/privacy-policy') }}" class="text-danger fw-bold text-decoration-none">Privacy Policy</a>.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 8 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-undo text-danger me-2"></i> Refunds & Cancellations</h3>
                                <p class="text-muted">For physical products purchased directly from Rio Jimmy Motors, refund and return requests shall be governed by the <a href="{{ url('/return-refund') }}" class="text-danger fw-bold text-decoration-none">Refund & Return Policy</a> published on our website.</p>
                                <p class="text-muted">For vendor locating, sourcing assistance, supplier identification, consulting, and coordination services, refund requests may be considered only if substantial work has not yet commenced.</p>
                                <p class="text-muted">Once supplier research, sourcing activities, vendor identification, or coordination services have begun, related service fees may become non-refundable.</p>
                            </div>
                            
                            <!-- Section 9 -->
                            <div class="policy-section mb-5">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-exclamation-triangle text-danger me-2"></i> Limitation of Liability</h3>
                                <p class="text-muted">Rio Jimmy Motors shall not be liable for any indirect, incidental, consequential, special, or punitive damages arising from the use of our website, products, services, or third-party supplier relationships.</p>
                                <p class="text-muted">Rio Jimmy Motors is not responsible for installation errors, improper handling, misuse, unauthorized modifications, or damage occurring after delivery of products.</p>
                                <p class="text-muted">For vendor locating, sourcing assistance, and coordination services, Rio Jimmy Motors does not guarantee any specific supplier, pricing, inventory availability, purchasing outcome, or business result.</p>
                            </div>
                            
                            <!-- Section 10 -->
                            <div class="policy-section">
                                <h3 class="fw-700 text-dark mb-3"><i class="fa fa-gavel text-danger me-2"></i> Governing Law</h3>
                                <p class="text-muted">These Terms and Conditions shall be governed by and interpreted in accordance with the laws of <strong>India</strong>.</p>
                                <div class="p-3 bg-light rounded border-start border-danger border-4">
                                    <p class="text-muted small m-0">Any disputes arising from the use of our website, products, or services shall be subject to the exclusive jurisdiction of the courts of <strong>Dehradun, Uttarakhand, India</strong>.</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
