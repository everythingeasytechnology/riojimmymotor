<!-- Featured Categories Section -->
<section class="py-5 bg-white">
    <div class="container">
        
        <!-- Section Header -->
        <div class="row mb-5">
            <div class="col-lg-6 mx-auto text-center">
                <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Search By Category</span>
                <h2 class="mt-2 fw-700">Shop Our Featured OEM Categories</h2>
                <p class="text-muted">Explore high-demand certified recycled auto parts, backed by our 100% money-back compatibility guarantee.</p>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="row g-4">
            
            <!-- Engines Card -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card" onclick="window.location.href='{{ url('/parts?category=engines') }}'">
                    <i class="fa fa-car-battery"></i>
                    <h4>Used Engines</h4>
                    <p>Tested complete engines assembly, block and heads. Checked for compression, oil leaks, and runs.</p>
                    <a href="{{ url('/parts?category=engines') }}" class="btn btn-link text-danger fw-bold p-0 mt-3 text-decoration-none small">
                        Explore Engines <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Transmissions Card -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card" onclick="window.location.href='{{ url('/parts?category=transmissions') }}'">
                    <i class="fa fa-sliders"></i>
                    <h4>Used Transmissions</h4>
                    <p>Automatic and manual transmissions, transfer cases, and final drives. Inspected gears and shifting.</p>
                    <a href="{{ url('/parts?category=transmissions') }}" class="btn btn-link text-danger fw-bold p-0 mt-3 text-decoration-none small">
                        Explore Transmissions <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Body Parts Card -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card" onclick="window.location.href='{{ url('/parts?category=body-parts') }}'">
                    <i class="fa fa-car-side"></i>
                    <h4>Body & Collision Parts</h4>
                    <p>OEM bumpers, hood panels, fenders, side mirrors, and front grilles available in various matching colors.</p>
                    <a href="{{ url('/parts?category=body-parts') }}" class="btn btn-link text-danger fw-bold p-0 mt-3 text-decoration-none small">
                        Explore Body Parts <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Wheels Card -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card" onclick="window.location.href='{{ url('/parts?category=wheels') }}'">
                    <i class="fa fa-circle-notch"></i>
                    <h4>OEM Wheels & Rims</h4>
                    <p>Genuine factory alloy wheels, steel wheels, hubcaps, and tire pressure monitoring sensors (TPMS).</p>
                    <a href="{{ url('/parts?category=wheels') }}" class="btn btn-link text-danger fw-bold p-0 mt-3 text-decoration-none small">
                        Explore Wheels <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Electrical Parts Card -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card" onclick="window.location.href='{{ url('/parts?category=electrical') }}'">
                    <i class="fa fa-bolt"></i>
                    <h4>Electrical & Lighting</h4>
                    <p>Alternators, starter motors, high-intensity LED headlights, taillight housings, and computers (ECU/ECM).</p>
                    <a href="{{ url('/parts?category=electrical') }}" class="btn btn-link text-danger fw-bold p-0 mt-3 text-decoration-none small">
                        Explore Electrical <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Interior Parts Card -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card" onclick="window.location.href='{{ url('/parts?category=interior') }}'">
                    <i class="fa fa-couch"></i>
                    <h4>Interior Accessories</h4>
                    <p>Premium replacement leather seats, steering wheels, center consoles, air bags, and radio consoles.</p>
                    <a href="{{ url('/parts?category=interior') }}" class="btn btn-link text-danger fw-bold p-0 mt-3 text-decoration-none small">
                        Explore Interior <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
