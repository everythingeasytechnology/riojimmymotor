<!-- Hero Banner Section -->
<section class="hero-section text-white d-flex align-items-center" style="background-image: url('https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=1920&auto=format&fit=crop');">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Hero Text Headlines -->
            <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                <span class="hero-badge"><i class="fa fa-certificate me-2"></i>Certified Used Auto Parts</span>
                <h1 class="text-white mb-3 fw-800">Find Certified OEM Used Auto Parts</h1>
                <p class="lead text-white-50 mb-4" style="font-size: 19px;">Get tested and certified engines, transmissions, headlights, wheels, and more delivered straight to your door with a free nationwide warranty.</p>
                
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 mt-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa fa-check-circle text-danger fs-5"></i>
                        <span>Tested & Certified OEM</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa fa-check-circle text-danger fs-5"></i>
                        <span>Free Shipping Nationwide</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa fa-check-circle text-danger fs-5"></i>
                        <span>Up to 1-Year Warranty</span>
                    </div>
                </div>
            </div>

            <!-- Hero Search Form Container -->
            <div class="col-lg-6">
                <div class="search-container text-dark">
                    <div class="d-flex gap-3 mb-4 border-bottom pb-2">
                        <button class="search-tab-btn active"><i class="fa fa-car me-2"></i>Search by Vehicle</button>
                        <button class="search-tab-btn" onclick="alert('Part Number search is available in the input box below. Simply type your Part Name or OEM Code!')"><i class="fa fa-barcode me-2"></i>Search by Part Number</button>
                    </div>
                    
                    <!-- Include the actual search form component -->
                    @include('frontend.components.search-form')
                </div>
            </div>

        </div>
    </div>
</section>
