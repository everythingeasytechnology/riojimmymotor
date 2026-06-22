@extends('frontend.layouts.master')

@section('meta_title', 'What to Check Before Buying a Used Engine Online | Auto Parts Marketplace')
@section('meta_description', 'Avoid online engine buying scams. Learn how to verify compression ratings, mileage codes, cylinder leaks, and OEM numbers before purchase.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/blog') }}">Blog</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/blog?category=buying-guides') }}">Buying Guides</a></li>
                    <li class="breadcrumb-item active" aria-current="page">What to Check Before Buying a Used Engine</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Article Detail Layout -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5">
                
                <!-- Main Article Content Area -->
                <div class="col-lg-8">
                    
                    <!-- Title and Meta -->
                    <span class="blog-category">Buying Guides</span>
                    <h1 class="fw-800 text-dark mb-3 mt-1" style="font-size: 38px;">What to Check Before Buying a Used Engine Assembly Online</h1>
                    
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom flex-wrap">
                        <div class="d-flex align-items-center gap-2">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=100&auto=format&fit=crop" alt="Richard Cooper" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                            <span class="small fw-bold text-dark">Richard Cooper (ASE Master Tech)</span>
                        </div>
                        <span class="text-muted small"><i class="fa fa-calendar me-1 text-danger"></i> June 18, 2026</span>
                        <span class="text-muted small"><i class="fa fa-clock me-1 text-danger"></i> 6 min read</span>
                        <span class="text-muted small"><i class="fa fa-comments me-1 text-danger"></i> 3 Comments</span>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-4 rounded overflow-hidden shadow-sm" style="max-height: 450px;">
                        <img src="https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=1200&auto=format&fit=crop" alt="Engine Mechanic Shop" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>

                    <!-- Table of Contents (Anchors managed by main.js) -->
                    <div class="toc-box font-poppins">
                        <h5>Table of Contents</h5>
                        <ul class="toc-list">
                            <li><a href="#section-mileage">1. Verify Odometer Odometer Mileage Records</a></li>
                            <li><a href="#section-compression">2. Request Valid Cylinder Compression Test Reports</a></li>
                            <li><a href="#section-oem-match">3. Check OEM Parts Number & VIN Matching</a></li>
                            <li><a href="#section-warranty">4. Read the Engine Warranty Policy Fine Print</a></li>
                            <li><a href="#section-conclusion">5. Conclusion: Sourcing Safely</a></li>
                        </ul>
                    </div>

                    <!-- Rich Content -->
                    <article class="article-content text-dark">
                        <p>Buying a pre-owned engine assembly is one of the most cost-effective ways to restore a vehicle with a blown head gasket, rod knock, or cracked cylinder block. স Sourcing an engine from a vehicle salvage marketplace can save you thousands of dollars compared to buying a factory remanufactured crate motor. However, buying mechanical parts online requires a set checklist to ensure you do not receive a defective block or the wrong variant.</p>
                        
                        <blockquote>
                            "Sourcing a replacement engine does not have to be a gamble if you demand verified testing logs and double-check your VIN code against builder databases before shipping."
                        </blockquote>

                        <!-- Section 1 -->
                        <h3 id="section-mileage" class="fw-700 mt-4 mb-3 text-dark">1. Verify Odometer Mileage Records</h3>
                        <p>Mileage is the single most critical factor in determining the remaining operational lifespan of a used engine block. Always ask the seller for the vehicle’s original odometer reading. Vetted salvage networks log mileage using insurance vehicle intake slips or salvage title certificates.</p>
                        <p>Avoid listings that claim "low mileage" without providing an exact number or showing an image of the dashboard odometer cluster. A-grade engines typically have under 75,000 miles, whereas B-grade units may exceed 100,000 miles but are still fully functional and cheaper.</p>

                        <!-- Section 2 -->
                        <h3 id="section-compression" class="fw-700 mt-4 mb-3 text-dark">2. Request Valid Cylinder Compression Test Reports</h3>
                        <p>A salvage engine should never be installed without confirming its internal health. A compression test measures the pressure built up by the cylinders during rotation, verifying that the piston rings and valves seal properly. Ask for exact PSI readings for each cylinder:</p>
                        <ul>
                            <li><strong>Four-Cylinder Engines:</strong> Readings should average 160-185 PSI across all cylinders.</li>
                            <li><strong>V6 and V8 Engines:</strong> Readings should hover between 150-180 PSI.</li>
                            <li><strong>Critical Metric:</strong> The variance between the highest and lowest cylinder reading should not exceed 10-15%. An engine with 180 PSI on cylinders 1-3 and 120 PSI on cylinder 4 has a failed valve seal or head gasket issue.</li>
                        </ul>

                        <!-- Section 3 -->
                        <h3 id="section-oem-match" class="fw-700 mt-4 mb-3 text-dark">3. Check OEM Parts Number & VIN Matching</h3>
                        <p>Car manufacturers frequently change engine displacements, layouts, oil pan designs, and electrical wiring plugs mid-generation. For example, a 2018 Toyota Camry engine may differ between FWD gas models, Hybrid models, or AWD models.</p>
                        <p>To prevent receiving an engine block with incompatible motor mount tabs or fuel rail hookups, supply your vehicle's 17-digit Vehicle Identification Number (VIN) to the seller. We cross-reference this code with original parts catalogs (like Toyota EPS or Ford Microcat) to confirm the part matches.</p>

                        <!-- Section 4 -->
                        <h3 id="section-warranty" class="fw-700 mt-4 mb-3 text-dark">4. Read the Engine Warranty Policy Fine Print</h3>
                        <p>Even a well-tested engine can experience issues on startup. Never buy a used engine that is sold "As-Is." Look for suppliers offering a minimum 90-day parts replacement warranty. Read the warranty guidelines carefully:</p>
                        <ul>
                            <li><strong>Installation rules:</strong> Most warranties require replacing the oil filter, spark plugs, thermostat, and front/rear main seals during installation.</li>
                            <li><strong>Cooling lines:</strong> Radiators and oil coolers must be flushed to clear debris from the previous engine failure.</li>
                            <li><strong>Labor coverage:</strong> Standard salvage yard warranties cover parts replacement or refunds only. They do not reimburse mechanics' labor fees.</li>
                        </ul>

                        <!-- Section 5 -->
                        <h3 id="section-conclusion" class="fw-700 mt-4 mb-3 text-dark">5. Conclusion: Sourcing Safely</h3>
                        <p>Investing in a used engine is a smart, eco-friendly way to keep your car running without breaking the bank. By following these validation steps, you minimize the risk and ensure a smooth, worry-free installation process. When in doubt, speak to a certified parts specialist who can guide you through the process.</p>
                    </article>

                    <!-- Author Details Box -->
                    <div class="author-box border shadow-sm">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&auto=format&fit=crop" alt="Richard Cooper" class="author-img border-danger border-2">
                        <div>
                            <h4 class="fw-bold mb-2">Richard Cooper (ASE Master Tech)</h4>
                            <p class="text-muted mb-0">Richard has over 18 years of mechanical repair experience. He specializes in engine building, drivetrain diagnostics, and OEM salvage cross-referencing. He regularly reviews parts intake standards at Auto Parts Marketplace.</p>
                        </div>
                    </div>

                    <!-- Comments Section UI -->
                    <div class="mb-5">
                        <h3 class="fw-700 mb-4 text-dark border-bottom pb-2">Comments (3)</h3>
                        
                        <div class="d-flex gap-3 mb-4">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=80&auto=format&fit=crop" alt="User" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h5 class="fw-bold mb-1" style="font-size: 15px;">Frank H. <span class="text-muted fw-normal ms-2" style="font-size: 12px;">June 19, 2026</span></h5>
                                <p class="text-muted small">"Great article. I didn't know about checking the cylinder variance metric (the 10-15% variance rule). That makes perfect sense to avoid blown head gaskets on arrival."</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4 ps-4 border-left" style="border-left: 2px solid var(--border-color);">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=80&auto=format&fit=crop" alt="User" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h5 class="fw-bold mb-1" style="font-size: 15px;">Sarah M. <span class="text-muted fw-normal ms-2" style="font-size: 12px;">June 19, 2026</span></h5>
                                <p class="text-muted small">"I purchased a used Camry engine from you guys last month, and the compression sheet was inside the envelope. My mechanic said it was extremely clean. Thanks for the tips!"</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <img src="https://images.unsplash.com/photo-1507136566006-cfc505b114fc?q=80&w=80&auto=format&fit=crop" alt="User" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h5 class="fw-bold mb-1" style="font-size: 15px;">Gary T. <span class="text-muted fw-normal ms-2" style="font-size: 12px;">June 15, 2026</span></h5>
                                <p class="text-muted small">"Is a compression test also performed on diesel engines, and what are the normal pressures?"</p>
                            </div>
                        </div>
                    </div>

                    <!-- Comment Submission Form UI -->
                    <div class="bg-light p-4 rounded border shadow-sm mb-5">
                        <h4 class="fw-bold mb-2">Leave A Comment</h4>
                        <p class="text-muted small mb-4">Your email address will not be published. Required fields are marked *</p>
                        
                        <form onsubmit="event.preventDefault(); alert('Comment submitted for moderation.');">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <input type="text" class="form-control bg-white" placeholder="Name *" required style="padding: 10px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="email" class="form-control bg-white" placeholder="Email Address *" required style="padding: 10px;">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control bg-white" rows="5" placeholder="Comment *" required style="padding: 10px;"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4 py-2 font-poppins text-white">Post Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- Right Sidebar Widgets Column -->
                <div class="col-lg-4">
                    
                    <!-- Search Widget -->
                    <div class="filter-widget">
                        <h5 class="filter-widget-title">Search Articles</h5>
                        <form action="{{ url('/blog') }}" method="GET" class="input-group">
                            <input type="text" class="form-control border-secondary-subtle" name="search" placeholder="Type here..." style="padding: 8px;">
                            <button class="btn btn-secondary px-3" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>

                    <!-- Popular Category List Widget -->
                    <div class="filter-widget">
                        <h5 class="filter-widget-title">Categories</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between align-items-center mb-2">
                                <a href="{{ url('/blog?category=buying-guides') }}" class="text-decoration-none text-muted small hover-danger"><i class="fa fa-folder-open me-2 text-danger"></i> Buying Guides</a>
                                <span class="badge bg-light text-dark border">14</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center mb-2">
                                <a href="{{ url('/blog?category=maintenance') }}" class="text-decoration-none text-muted small hover-danger"><i class="fa fa-folder-open me-2 text-danger"></i> Repair & Care</a>
                                <span class="badge bg-light text-dark border">22</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center mb-2">
                                <a href="{{ url('/blog?category=troubleshooting') }}" class="text-decoration-none text-muted small hover-danger"><i class="fa fa-folder-open me-2 text-danger"></i> Diagnostics</a>
                                <span class="badge bg-light text-dark border">9</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <a href="{{ url('/blog?category=industry') }}" class="text-decoration-none text-muted small hover-danger"><i class="fa fa-folder-open me-2 text-danger"></i> Industry News</a>
                                <span class="badge bg-light text-dark border">5</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Banner Call to Action Widget (Conversion focused) -->
                    <div class="bg-danger text-white rounded p-4 text-center border shadow-sm mb-4">
                        <i class="fa fa-gears mb-3" style="font-size: 50px;"></i>
                        <h4 class="fw-bold text-white mb-2">Find Your Auto Part Today</h4>
                        <p class="text-white-50 small mb-4">Search over 1,500,000+ certified parts with free standard shipping and returns warranty.</p>
                        <a href="{{ url('/parts') }}" class="btn btn-secondary w-100 py-3 text-uppercase font-poppins text-white shadow-sm">
                            <i class="fa fa-search me-1"></i> Browse Parts Catalog
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Articles Grid -->
    <section class="py-5 bg-light border-top">
        <div class="container">
            <h3 class="fw-700 text-dark mb-4 text-center text-md-start">Related Articles</h3>
            
            <div class="row g-4">
                
                <!-- Related Article 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card bg-white">
                        <div class="blog-card-img">
                            <span class="blog-date-badge">June 10, 2026</span>
                            <img src="https://images.unsplash.com/photo-1507136566006-cfc505b114fc?q=80&w=600&auto=format&fit=crop" alt="OEM vs Aftermarket parts">
                        </div>
                        <div class="blog-card-body">
                            <span class="blog-category">OEM Comparisons</span>
                            <h4 class="blog-title"><a href="{{ url('/blog-details') }}">OEM vs. Aftermarket Panels: Which Is Better for Resale Value?</a></h4>
                            <a href="{{ url('/blog-details') }}" class="blog-readmore mt-2">Read Tutorial <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Related Article 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card bg-white">
                        <div class="blog-card-img">
                            <span class="blog-date-badge">May 28, 2026</span>
                            <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=600&auto=format&fit=crop" alt="Transmission install">
                        </div>
                        <div class="blog-card-body">
                            <span class="blog-category">Maintenance</span>
                            <h4 class="blog-title"><a href="{{ url('/blog-details') }}">5 Crucial Steps When Installing a Recycled Transmission</a></h4>
                            <a href="{{ url('/blog-details') }}" class="blog-readmore mt-2">Read Tutorial <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Related Article 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card bg-white">
                        <div class="blog-card-img">
                            <span class="blog-date-badge">May 15, 2026</span>
                            <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=600&auto=format&fit=crop" alt="Offset wheels">
                        </div>
                        <div class="blog-card-body">
                            <span class="blog-category">Buying Guides</span>
                            <h4 class="blog-title"><a href="{{ url('/blog-details') }}">How to Find the Correct Offset and Backspacing for OEM Rims</a></h4>
                            <a href="{{ url('/blog-details') }}" class="blog-readmore mt-2">Read Tutorial <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Schema details metadata block -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BlogPosting",
      "headline": "What to Check Before Buying a Used Engine Assembly Online",
      "image": "https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=1200&auto=format&fit=crop",
      "author": {
        "@@type": "Person",
        "name": "Richard Cooper"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "Auto Parts Marketplace",
        "logo": {
          "@@type": "ImageObject",
          "url": "{{ asset('frontend/images/logo.png') }}"
        }
      },
      "datePublished": "2026-06-18",
      "description": "Learn how to buy pre-owned engines online safely. Verify odometer mileage, compression test scores, compatibility and VIN code records."
    }
    </script>

@endsection
