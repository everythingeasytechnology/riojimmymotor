@extends('frontend.layouts.master')

@section('meta_title', 'Contact Our Used Parts Experts | Auto Parts Marketplace')
@section('meta_description', 'Contact Auto Parts Marketplace for help locating a used engine, transmission, or body panel. Speak to a live specialist at +1 (800) 555-0199.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Contact Info & Form -->
    <section class="py-5 bg-white">
        <div class="container">
            
            <div class="row g-5">
                
                <!-- Contact Details Side -->
                <div class="col-lg-5">
                    <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Get In Touch</span>
                    <h1 class="mt-2 mb-4 fw-800 text-dark" style="font-size: 38px;">Contact Our Auto Specialists</h1>
                    <p class="text-muted mb-5">Have a question about vehicle fitment, shipping rates, or warranty terms? Our trained sales specialists are standing by to help you locate the exact OEM salvage part you need.</p>
                    
                    <!-- Phone Contact Info -->
                    <div class="d-flex gap-4 mb-4">
                        <div class="icon-box-icon text-danger" style="background-color: rgba(217, 30, 24, 0.1); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Call Toll-Free</h5>
                            <p class="mb-0 text-danger fw-bold fs-5"><a href="tel:+18005550199" class="text-danger text-decoration-none">+1 (800) 555-0199</a></p>
                            <span class="text-muted small">Customer Service & Quote Hotline</span>
                        </div>
                    </div>

                    <!-- Email Contact Info -->
                    <div class="d-flex gap-4 mb-4">
                        <div class="icon-box-icon text-danger" style="background-color: rgba(217, 30, 24, 0.1); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Email Inquiries</h5>
                            <p class="mb-0 text-dark fw-bold"><a href="mailto:support@autopartsmarket.com" class="text-dark text-decoration-none">support@autopartsmarket.com</a></p>
                            <span class="text-muted small">Standard response within 2 business hours</span>
                        </div>
                    </div>

                    <!-- Address Location Info -->
                    <div class="d-flex gap-4 mb-4">
                        <div class="icon-box-icon text-danger" style="background-color: rgba(217, 30, 24, 0.1); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Corporate Headquarters</h5>
                            <p class="mb-0 text-muted">100 Industrial Pkwy, Suite 400<br>Detroit, MI 48201</p>
                        </div>
                    </div>

                    <!-- Hours of Operation Info -->
                    <div class="d-flex gap-4">
                        <div class="icon-box-icon text-danger" style="background-color: rgba(217, 30, 24, 0.1); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Business Hours</h5>
                            <p class="mb-0 text-muted">Monday - Friday: 8:00 AM - 7:00 PM EST<br>Saturday: 9:00 AM - 4:00 PM EST<br>Sunday: Closed</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Side -->
                <div class="col-lg-7">
                    <div class="bg-light p-4 p-lg-5 rounded border shadow-sm">
                        <h3 class="fw-700 mb-2">Request A Free Quote</h3>
                        <p class="text-muted mb-4">Submit your vehicle details below and our parts specialists will cross-reference inventories and email you price and shipping options.</p>
                        
                        <form onsubmit="event.preventDefault(); alert('Inquiry submitted successfully! A parts specialist will contact you shortly.');">
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-bold small text-dark">FULL NAME *</label>
                                    <input type="text" class="form-control bg-white" placeholder="John Doe" required style="padding: 10px;">
                                </div>
                                <!-- Email -->
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-bold small text-dark">EMAIL ADDRESS *</label>
                                    <input type="email" class="form-control bg-white" placeholder="john@example.com" required style="padding: 10px;">
                                </div>
                                <!-- Phone -->
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-bold small text-dark">PHONE NUMBER *</label>
                                    <input type="tel" class="form-control bg-white" placeholder="(555) 000-0000" required style="padding: 10px;">
                                </div>
                                <!-- VIN -->
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-bold small text-dark">VIN (VEHICLE ID NUMBER)</label>
                                    <input type="text" class="form-control bg-white" placeholder="17-Digit VIN Code" style="padding: 10px;">
                                </div>
                                
                                <!-- Vehicle Selectors -->
                                <div class="col-md-4 col-12">
                                    <label class="form-label fw-bold small text-dark">VEHICLE YEAR *</label>
                                    <input type="text" class="form-control bg-white" placeholder="e.g. 2018" required style="padding: 10px;">
                                </div>
                                <div class="col-md-4 col-12">
                                    <label class="form-label fw-bold small text-dark">VEHICLE MAKE *</label>
                                    <input type="text" class="form-control bg-white" placeholder="e.g. Ford" required style="padding: 10px;">
                                </div>
                                <div class="col-md-4 col-12">
                                    <label class="form-label fw-bold small text-dark">VEHICLE MODEL *</label>
                                    <input type="text" class="form-control bg-white" placeholder="e.g. F-150" required style="padding: 10px;">
                                </div>

                                <!-- Part Name -->
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">PART(S) REQUESTED *</label>
                                    <input type="text" class="form-control bg-white" placeholder="e.g. Engine Assembly, Driver Side Headlight" required style="padding: 10px;">
                                </div>

                                <!-- Message -->
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">ADDITIONAL NOTES (CONDITION OR PREFERENCES)</label>
                                    <textarea class="form-control bg-white" rows="4" placeholder="Any details like trim, engine size (e.g., 2.5L), transmission type, or shipping address..." style="padding: 10px;"></textarea>
                                </div>

                                <!-- Submit -->
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-3 text-uppercase shadow-sm">
                                        <i class="fa fa-paper-plane me-2"></i> Submit Parts Inquiry
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Google Map Placement Mockup -->
    <section class="p-0 border-top border-bottom bg-light">
        <div class="container-fluid p-0">
            <div style="height: 400px; width: 100%; position: relative; background: #e5e5e5; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <!-- Simulated Google Map elements inside a nice dashboard styled representation -->
                <i class="fa fa-map-location-dot text-danger mb-3" style="font-size: 60px;"></i>
                <h4 class="fw-bold text-dark mb-2">Google Map Location Placeholder</h4>
                <p class="text-muted mb-3 px-3 text-center">100 Industrial Pkwy, Suite 400, Detroit, MI 48201</p>
                <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm px-4">
                    <i class="fa fa-external-link me-2"></i> Open in Google Maps
                </a>
                
                <!-- Background decoration representing mapping lines -->
                <div class="position-absolute w-100 h-100 top-0 start-0 opacity-10" style="background-image: radial-gradient(circle, #000 10%, transparent 11%), radial-gradient(circle, #000 10%, transparent 11%); background-size: 20px 20px; z-index: -1;"></div>
            </div>
        </div>
    </section>

    <!-- Testimonials or FAQs -->
    @include('frontend.components.faq')

    <!-- Call to Action Section -->
    @include('frontend.components.cta')

@endsection
