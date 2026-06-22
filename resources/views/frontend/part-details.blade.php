@extends('frontend.layouts.master')

@section('meta_title', 'Used 2018 Toyota Camry 2.5L Engine Assembly | Auto Parts Marketplace')
@section('meta_description', 'Buy A-Grade Certified Used Engine Assembly for 2018 Toyota Camry (2.5L DOHC 4-Cyl). Includes 90-day warranty and free nationwide shipping.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/parts') }}">Auto Parts</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/parts?category=engines') }}">Used Engines</a></li>
                    <li class="breadcrumb-item active" aria-current="page">2.5L Toyota Camry Engine</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Product Detail Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5">
                
                <!-- Product Gallery Columns -->
                <div class="col-lg-6">
                    
                    <!-- Main Gallery Image -->
                    <div class="gallery-main">
                        <img id="main-gallery-img" src="https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=800&auto=format&fit=crop" alt="Used Toyota Camry Engine Block Assembly" class="img-fluid">
                    </div>

                    <!-- Thumbnails list (Triggered by main.js click script) -->
                    <div class="gallery-thumbs">
                        <div class="gallery-thumb-item active" data-large="https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=800&auto=format&fit=crop">
                            <img src="https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=150&auto=format&fit=crop" alt="Thumbnail Engine 1">
                        </div>
                        <div class="gallery-thumb-item" data-large="https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=800&auto=format&fit=crop">
                            <img src="https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=150&auto=format&fit=crop" alt="Thumbnail Engine 2">
                        </div>
                        <div class="gallery-thumb-item" data-large="https://images.unsplash.com/photo-1507136566006-cfc505b114fc?q=80&w=800&auto=format&fit=crop">
                            <img src="https://images.unsplash.com/photo-1507136566006-cfc505b114fc?q=80&w=150&auto=format&fit=crop" alt="Thumbnail Engine 3">
                        </div>
                    </div>

                    <!-- Certification badges -->
                    <div class="bg-light p-4 rounded border text-center">
                        <h5 class="fw-bold mb-3"><i class="fa fa-circle-check text-success me-2"></i>A-Grade Quality Inspection Checklist</h5>
                        <div class="row text-start g-2">
                            <div class="col-md-6 col-12 small"><i class="fa fa-check text-success me-2"></i> Compression Tested (185 PSI average)</div>
                            <div class="col-md-6 col-12 small"><i class="fa fa-check text-success me-2"></i> Cylinders Leak-Down Checked</div>
                            <div class="col-md-6 col-12 small"><i class="fa fa-check text-success me-2"></i> Zero Oil Deposits or Sludge</div>
                            <div class="col-md-6 col-12 small"><i class="fa fa-check text-success me-2"></i> Valve Train & Crankshaft Inspected</div>
                        </div>
                    </div>
                </div>

                <!-- Product Content Info & Sidebar Quote Columns -->
                <div class="col-lg-6">
                    
                    <!-- Title & Badges -->
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-danger">USED ENGINE</span>
                        <span class="badge bg-success"><i class="fa fa-check me-1"></i> IN STOCK</span>
                    </div>
                    <h1 class="fw-800 text-dark mb-3" style="font-size: 36px;">2.5L DOHC 4-Cylinder Engine Assembly</h1>
                    <p class="text-muted">A-Grade pre-tested factory original OEM engine block assembly. Sourced from a low-mileage 2018 Toyota Camry that was rear-ended. Fully tested, run, and backed by warranty.</p>
                    
                    <!-- Rating and compatibility notice -->
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="text-warning">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <span class="text-muted small fw-bold">5.0 (18 Reviews)</span>
                        <span class="mx-2 text-black-50">|</span>
                        <span class="text-success small fw-bold"><i class="fa fa-check-double me-1"></i> 100% VIN Compatibility Guaranteed</span>
                    </div>

                    <!-- Price Block -->
                    <div class="bg-light p-4 rounded border mb-4">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted small d-block">MARKET VALUE: <del>$1,950.00</del></span>
                                <span class="fs-2 fw-bold text-danger font-poppins">$1,450.00</span>
                                <span class="text-muted small d-block">Includes Free Standard Freight Shipping</span>
                            </div>
                            <div class="col-6 text-end">
                                <a href="tel:+18005550199" class="btn btn-primary w-100 py-3 mb-2 font-poppins text-white">
                                    <i class="fa fa-phone me-2"></i> Order by Phone
                                </a>
                                <span class="text-muted small d-block" style="font-size: 11px;">CALL NOW FOR INSTANT DISCOUNTS</span>
                            </div>
                        </div>
                    </div>

                    <!-- Key Part Attributes list -->
                    <div class="detail-info-block border">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">Part Specifications</h5>
                        <ul class="detail-info-list font-poppins">
                            <li><span>Part Number (OEM)</span> <span>19000-25030</span></li>
                            <li><span>Year Match Range</span> <span>2017 - 2021 Toyota Camry</span></li>
                            <li><span>Engine Displacement</span> <span>2.5 Liter (Inline 4)</span></li>
                            <li><span>Engine Code / Trim</span> <span>A25A-FKS (Gasoline, Non-Hybrid)</span></li>
                            <li><span>Verified Mileage</span> <span>48,150 Odometer Miles</span></li>
                            <li><span>Grade Condition</span> <span>Grade A (Excellent Operation)</span></li>
                            <li><span>Warranty Sourced</span> <span>90-Day Standard Replacement</span></li>
                        </ul>
                    </div>

                    <!-- Direct Inquiry Form (Highly Conversion Focused) -->
                    <div class="bg-light p-4 rounded border mt-4">
                        <h5 class="fw-bold mb-2">Request A Direct Price Quote</h5>
                        <p class="text-muted small mb-3">Provide your email or phone below. We will send a formal quote details sheet within 15 minutes.</p>
                        
                        <form onsubmit="event.preventDefault(); alert('Your part quote inquiry has been submitted! One of our specialists will call/email you in 15 minutes.');">
                            <div class="row g-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" class="form-control bg-white form-control-sm py-2" placeholder="Full Name" required style="padding: 10px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="email" class="form-control bg-white form-control-sm py-2" placeholder="Email Address" required style="padding: 10px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="tel" class="form-control bg-white form-control-sm py-2" placeholder="Phone Number" required style="padding: 10px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="text" class="form-control bg-white form-control-sm py-2" placeholder="17-Digit Vehicle VIN Code" style="padding: 10px;">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-secondary w-100 py-2 mt-2 font-poppins text-white">
                                        <i class="fa fa-envelope me-1"></i> Send Instant Inquiry Quote
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

            <!-- Tabbed Specifications, Compatibility and Shipping Policies -->
            <div class="row mt-5 pt-4 border-top">
                <div class="col-12">
                    <ul class="nav nav-tabs border-bottom-0 gap-2 mb-3" id="detailsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active border shadow-sm rounded-top" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-pane" type="button" role="tab" aria-controls="desc-pane" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border shadow-sm rounded-top" id="compat-tab" data-bs-toggle="tab" data-bs-target="#compat-pane" type="button" role="tab" aria-controls="compat-pane" aria-selected="false">Compatibility Guide</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border shadow-sm rounded-top" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping-pane" type="button" role="tab" aria-controls="shipping-pane" aria-selected="false">Shipping & Returns</button>
                        </li>
                    </ul>

                    <div class="tab-content border p-4 rounded-bottom shadow-sm" id="detailsTabContent" style="background-color: var(--white);">
                        
                        <!-- Description Tab Pane -->
                        <div class="tab-pane fade show active" id="desc-pane" role="tabpanel" aria-labelledby="desc-tab">
                            <h4 class="fw-bold mb-3">OEM 2.5L Toyota Camry Engine Block Assembly</h4>
                            <p>This is a certified recycled original factory Toyota 2.5L engine assembly. We dismantle it from clean, verified cars and test its mechanical compression, cylinder leakage, oil pressure levels, and crankshaft play before logging it in our marketplace inventory database.</p>
                            <p class="mb-0">Please note that the engine assembly includes the core block, cylinder head, oil pan, valve cover, timing cover, and intake manifold. Accessory items like the alternator, starter motor, air conditioning compressor, and power steering pump are sold separately. We highly recommend using new gaskets, crankshaft seals, oil filters, and spark plugs during the install phase to ensure valid warranty claims.</p>
                        </div>

                        <!-- Compatibility Tab Pane -->
                        <div class="tab-pane fade" id="compat-pane" role="tabpanel" aria-labelledby="compat-tab">
                            <h4 class="fw-bold mb-3">Vehicle Fitment Verification</h4>
                            <p class="mb-3 text-muted">Below is the verified compatible vehicles chart. Please verify your exact 5th digit engine VIN code match before ordering.</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped font-poppins text-dark">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Year</th>
                                            <th>Make</th>
                                            <th>Model</th>
                                            <th>Trim/Specs</th>
                                            <th>Transmission Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2018 - 2021</td>
                                            <td>Toyota</td>
                                            <td>Camry</td>
                                            <td>LE, SE, XLE (2.5L Non-Hybrid)</td>
                                            <td>Automatic FWD (8-Speed)</td>
                                        </tr>
                                        <tr>
                                            <td>2019 - 2021</td>
                                            <td>Toyota</td>
                                            <td>RAV4</td>
                                            <td>LE, XLE, Limited (2.5L Gas)</td>
                                            <td>Automatic FWD/AWD (8-Speed)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Shipping & Returns Tab Pane -->
                        <div class="tab-pane fade" id="shipping-pane" role="tabpanel" aria-labelledby="shipping-tab">
                            <h4 class="fw-bold mb-3">Safe Freight Shipping & Simple Return Policies</h4>
                            <h5 class="fw-bold fs-6 mb-2"><i class="fa fa-truck text-danger me-2"></i>Shipping Cost & Timelines</h5>
                            <p class="text-muted">Standard freight shipping is **FREE** to both commercial repair shops and residential driveways. Heavy freight units like engines are bolted onto wooden pallets, wrapped, and delivered via dry-van LTL trailers. Deliveries to residential driveways include a complimentary liftgate tailgate unload service to lower the pallet to the ground.</p>
                            
                            <h5 class="fw-bold fs-6 mb-2 mt-4"><i class="fa fa-arrows-rotate text-danger me-2"></i>90-Day Returns Policy</h5>
                            <p class="text-muted mb-0">If the engine block arrives damaged or does not run, contact our support team. We will send a replacement unit or issue a 100% full refund and coordinate freight pickup at no cost to you. If you order the wrong engine size or change your mind, returns are subject to flat-rate round-trip freight costs.</p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Related Products Grid -->
    <section class="py-5 bg-light border-top">
        <div class="container">
            <h3 class="fw-700 text-dark mb-4 text-center text-md-start">Related Parts for Toyota Camry</h3>
            
            <div class="row g-4">
                
                <!-- Related Part 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="part-card bg-white">
                        <div class="part-card-img">
                            <span class="part-badge">Grade A Tested</span>
                            <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=600&auto=format&fit=crop" alt="Transmission">
                        </div>
                        <div class="part-card-body">
                            <h4 class="part-card-title">8-Speed Automatic Transmission</h4>
                            <ul class="part-meta font-poppins">
                                <li><i class="fa fa-car text-danger"></i> Fits: 2018 Toyota Camry 2.5L</li>
                                <li><i class="fa fa-tachometer-alt text-danger"></i> Mileage: 51,300 Miles</li>
                            </ul>
                            <div class="part-price-row">
                                <span class="part-price">$1,150.00</span>
                                <a href="{{ url('/part-details') }}" class="btn btn-outline-primary btn-sm px-3 py-2 font-poppins">Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Part 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="part-card bg-white">
                        <div class="part-card-img">
                            <span class="part-badge">OEM Genuine</span>
                            <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=600&auto=format&fit=crop" alt="Alloy Wheel">
                        </div>
                        <div class="part-card-body">
                            <h4 class="part-card-title">18" Alloy Wheel SE Rim</h4>
                            <ul class="part-meta font-poppins">
                                <li><i class="fa fa-car text-danger"></i> Fits: 2018-2022 Toyota Camry SE</li>
                                <li><i class="fa fa-star text-danger"></i> Condition: A-Grade</li>
                            </ul>
                            <div class="part-price-row">
                                <span class="part-price">$185.00</span>
                                <a href="{{ url('/part-details') }}" class="btn btn-outline-primary btn-sm px-3 py-2 font-poppins">Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Part 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="part-card bg-white">
                        <div class="part-card-img">
                            <span class="part-badge">OEM Recycled</span>
                            <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=600&auto=format&fit=crop" alt="Side Mirror">
                        </div>
                        <div class="part-card-body">
                            <h4 class="part-card-title">Side Mirror (Driver Side Power)</h4>
                            <ul class="part-meta font-poppins">
                                <li><i class="fa fa-car text-danger"></i> Fits: 2018 Toyota Camry</li>
                                <li><i class="fa fa-palette text-danger"></i> Color: Super White (040)</li>
                            </ul>
                            <div class="part-price-row">
                                <span class="part-price">$120.00</span>
                                <a href="{{ url('/part-details') }}" class="btn btn-outline-primary btn-sm px-3 py-2 font-poppins">Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Part 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="part-card bg-white">
                        <div class="part-card-img">
                            <span class="part-badge">OEM Genuine</span>
                            <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=600&auto=format&fit=crop" alt="LED Headlight">
                        </div>
                        <div class="part-card-body">
                            <h4 class="part-card-title">LED Headlight Assembly (RH)</h4>
                            <ul class="part-meta font-poppins">
                                <li><i class="fa fa-car text-danger"></i> Fits: 2018 Toyota Camry SE</li>
                                <li><i class="fa fa-lightbulb text-danger"></i> Style: LED Black Housing</li>
                            </ul>
                            <div class="part-price-row">
                                <span class="part-price">$260.00</span>
                                <a href="{{ url('/part-details') }}" class="btn btn-outline-primary btn-sm px-3 py-2 font-poppins">Details</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ Accordion Component -->
    @include('frontend.components.faq')

    <!-- Call to Action Banner Component -->
    @include('frontend.components.cta')

@endsection
