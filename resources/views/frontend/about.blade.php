@extends('frontend.layouts.master')

@section('meta_title', 'About Our Salvage Sourcing Yard Networks | Rio Jimmy Motor')
@section('meta_description', 'Learn how Rio Jimmy Motor works with over 250 certified salvage yards to source tested OEM engines, transmissions, and body parts.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Intro / Company Story -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center g-5">
                
                <!-- Story Text -->
                <div class="col-lg-6">
                    <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Our Journey</span>
                    <h1 class="mt-2 mb-4 fw-800 text-dark" style="font-size: 38px;">Rebuilding Vehicles, Reducing Waste Since 2015</h1>
                    <p class="lead">Rio Jimmy Motor was founded with a singular, clear goal: to make purchasing high-quality, original manufacturer (OEM) used auto parts simple, transparent, and affordable.</p>
                    <p class="text-muted">Traditionally, sourcing a replacement engine, transmission, or collision panel from a salvage yard involved calling around, negotiating prices, and hoping the part worked. We changed that by connecting nationwide inventories into a single searchable marketplace, backed by certified quality inspections and a standard 90-day warranty.</p>
                    <p class="text-muted">Today, we represent a network of over 250+ vetted dismantle yards across North America, servicing thousands of vehicle owners, independent mechanics, and large-scale collision centers every single month.</p>
                </div>

                <!-- Story Graphics -->
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1517524008697-84babd908191?q=80&w=800&auto=format&fit=crop" alt="Car Maintenance Mechanic" class="img-fluid rounded shadow-sm">
                        <div class="bg-danger text-white rounded p-4 position-absolute d-none d-md-block" style="bottom: -30px; left: -30px; max-width: 280px; box-shadow: 0 10px 30px rgba(217,30,24,0.3);">
                            <h4 class="fw-bold mb-2">10+ Years</h4>
                            <p class="m-0 small text-white-50">Providing tested and certified pre-owned automotive components to drivers nationwide.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                
                <!-- Mission Box -->
                <div class="col-md-6">
                    <div class="bg-white p-4 p-lg-5 rounded border h-100 shadow-sm">
                        <div class="icon-box-icon mb-4"><i class="fa fa-bullseye"></i></div>
                        <h3 class="fw-700 mb-3 text-dark">Our Mission</h3>
                        <p class="text-muted m-0">To deliver reliable, warranty-backed OEM used auto parts that save customers up to 80% compared to dealer MSRP, while delivering an outstanding online buying experience with zero-risk compatibility matching.</p>
                    </div>
                </div>

                <!-- Vision Box -->
                <div class="col-md-6">
                    <div class="bg-white p-4 p-lg-5 rounded border h-100 shadow-sm">
                        <div class="icon-box-icon mb-4"><i class="fa fa-leaf"></i></div>
                        <h3 class="fw-700 mb-3 text-dark">Eco-Friendly Vision</h3>
                        <p class="text-muted m-0">To promote circular automotive manufacturing and environmental sustainability. By recycling and certified re-testing of OEM parts, we keep steel, aluminum, and assemblies out of landfills and reduce the energy needed for new part fabrication.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Detailed Sourcing Process -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-lg-6 mx-auto">
                    <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Rigorous Standards</span>
                    <h2 class="mt-2 fw-700">Our Sourcing & Testing Process</h2>
                    <p class="text-muted">Every auto part we ship must go through a comprehensive checklist before it leaves our yard networks.</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Sourcing Phase 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 h-100 text-center">
                        <div class="card-body">
                            <span class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle fw-bold mb-3" style="width: 50px; height: 50px; font-size: 20px;">1</span>
                            <h4 class="fw-bold mb-3">Vehicle Intake</h4>
                            <p class="text-muted small">Vehicles are sourced from insurance auctions and checked for original parts integrity. We document year, make, model, trim, and absolute odometer mileage.</p>
                        </div>
                    </div>
                </div>

                <!-- Sourcing Phase 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 h-100 text-center">
                        <div class="card-body">
                            <span class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle fw-bold mb-3" style="width: 50px; height: 50px; font-size: 20px;">2</span>
                            <h4 class="fw-bold mb-3">Performance Testing</h4>
                            <p class="text-muted small">Engines are compression tested. Transmissions are shifted and oil pans dropped to ensure zero metal shavings. Electrical elements are voltage tested.</p>
                        </div>
                    </div>
                </div>

                <!-- Sourcing Phase 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 h-100 text-center">
                        <div class="card-body">
                            <span class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle fw-bold mb-3" style="width: 50px; height: 50px; font-size: 20px;">3</span>
                            <h4 class="fw-bold mb-3">VIN Checking</h4>
                            <p class="text-muted small">Our technical sales engineers check the customer's vehicle VIN code against manufacturer parts database to ensure 100% bolt-on compatibility matching.</p>
                        </div>
                    </div>
                </div>

                <!-- Sourcing Phase 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 h-100 text-center">
                        <div class="card-body">
                            <span class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle fw-bold mb-3" style="width: 50px; height: 50px; font-size: 20px;">4</span>
                            <h4 class="fw-bold mb-3">Safe Freight Shipping</h4>
                            <p class="text-muted small">Heavy components are securely strapped to wooden pallets and wrapped to prevent freight transit damage. Tracking is provided within 24 hours of pickup.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us / Value Proposition Panel -->
    <section class="py-5 bg-light">
        <div class="container bg-white p-5 rounded border shadow-sm">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <h3 class="fw-700 text-dark">Ready to Repair Your Vehicle?</h3>
                    <p class="text-muted m-0">Join the thousands of auto repair shops, fleet operators, and car enthusiasts who rely on our platform for tested salvage and OEM components. We offer free phone consultations to locate hard-to-find components.</p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="{{ url('/parts') }}" class="btn btn-primary btn-lg me-3 mb-2 mb-sm-0">Search Inventory</a>
                    <a href="{{ url('/contact') }}" class="btn btn-secondary btn-lg mb-2 mb-sm-0">Contact Our Team</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Dynamic Testimonials Section -->
    @include('frontend.components.testimonials')

    <!-- FAQ Accordion section -->
    @include('frontend.components.faq')

    <!-- Call to Action Section -->
    @include('frontend.components.cta')

@endsection
