<!-- Top Notification & Contact Bar -->
<div class="top-bar d-none d-md-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="me-3"><i class="fa fa-phone text-danger me-2"></i> Call Free: <a href="tel:+18005550199" class="fw-bold">+1 (800) 555-0199</a></span>
                <span><i class="fa fa-envelope text-danger me-2"></i> <a href="mailto:support@autopartsmarket.com">support@autopartsmarket.com</a></span>
            </div>
            <div class="col-md-6 text-end">
                <span class="me-3"><i class="fa fa-clock me-2 text-danger"></i> Mon - Sat: 8:00 AM - 6:00 PM EST</span>
                <span><i class="fa fa-shipping-fast me-2 text-danger"></i> Fast Shipping Nationwide</span>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Main Navigation Header -->
<header class="sticky-header py-2">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="fs-3 fw-800 text-dark font-poppins d-flex align-items-center">
                    <i class="fa fa-gears text-danger me-2"></i>
                    AUTO<span class="text-danger">PARTS</span>
                </span>
            </a>

            <!-- Mobile Phone and Hamburger Toggle -->
            <div class="d-flex align-items-center d-lg-none gap-2">
                <a href="tel:+18005550199" class="btn btn-primary btn-sm px-3 py-2">
                    <i class="fa fa-phone"></i>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Navigation Links (Offcanvas on Mobile, Standard Navbar on Desktop) -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="mainNavbar" aria-labelledby="mainNavbarLabel">
                <!-- Offcanvas Header (Mobile only) -->
                <div class="offcanvas-header border-bottom d-lg-none">
                    <h5 class="offcanvas-title fw-bold" id="mainNavbarLabel">
                        <i class="fa fa-gears text-danger me-2"></i>
                        AUTO<span class="text-danger">PARTS</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <!-- Offcanvas Body -->
                <div class="offcanvas-body">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">About Us</a>
                        </li>
                        
                        <!-- Mega Menu Dropdown -->
                        <li class="nav-item dropdown megamenu">
                            <a class="nav-link dropdown-toggle" href="#" id="partsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Shop Categories
                            </a>
                            <div class="dropdown-menu megamenu-content" aria-labelledby="partsDropdown">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 megamenu-column mb-3 mb-md-0">
                                            <h6><i class="fa fa-car-side text-danger me-2"></i>Engine & Drivetrain</h6>
                                            <ul>
                                                <li><a href="{{ url('/parts?category=engines') }}">Complete Engines</a></li>
                                                <li><a href="{{ url('/parts?category=transmissions') }}">Transmissions</a></li>
                                                <li><a href="{{ url('/parts?category=alternators') }}">Alternators</a></li>
                                                <li><a href="{{ url('/parts?category=starters') }}">Starters & Ignition</a></li>
                                                <li><a href="{{ url('/parts?category=radiators') }}">Radiators & Cooling</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3 col-sm-6 megamenu-column mb-3 mb-md-0">
                                            <h6><i class="fa fa-hammer text-danger me-2"></i>Body & Exterior</h6>
                                            <ul>
                                                <li><a href="{{ url('/parts?category=bumpers') }}">Front & Rear Bumpers</a></li>
                                                <li><a href="{{ url('/parts?category=hoods') }}">Car Hoods & Grilles</a></li>
                                                <li><a href="{{ url('/parts?category=doors') }}">Doors & Panels</a></li>
                                                <li><a href="{{ url('/parts?category=headlights') }}">Headlights & Tail Lights</a></li>
                                                <li><a href="{{ url('/parts?category=mirrors') }}">Side View Mirrors</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3 col-sm-6 megamenu-column mb-3 mb-md-0">
                                            <h6><i class="fa fa-circle-notch text-danger me-2"></i>Suspension & Wheels</h6>
                                            <ul>
                                                <li><a href="{{ url('/parts?category=wheels') }}">OEM Wheels & Rims</a></li>
                                                <li><a href="{{ url('/parts?category=struts') }}">Struts & Shocks</a></li>
                                                <li><a href="{{ url('/parts?category=axles') }}">Axle Shafts</a></li>
                                                <li><a href="{{ url('/parts?category=brakes') }}">Brakes & Calipers</a></li>
                                                <li><a href="{{ url('/parts?category=steering') }}">Steering Columns</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3 col-sm-6 megamenu-column">
                                            <h6><i class="fa fa-couch text-danger me-2"></i>Interior & Cabin</h6>
                                            <ul>
                                                <li><a href="{{ url('/parts?category=seats') }}">Replacement Seats</a></li>
                                                <li><a href="{{ url('/parts?category=dashboards') }}">Instrument Clusters</a></li>
                                                <li><a href="{{ url('/parts?category=steering-wheels') }}">Steering Wheels</a></li>
                                                <li><a href="{{ url('/parts?category=radios') }}">GPS & Stereo Systems</a></li>
                                                <li><a href="{{ url('/parts?category=airbags') }}">Airbags & Modules</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row mt-3 pt-3 border-top">
                                        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <span class="text-muted small">Can't find your part? Let our experts locate it for you.</span>
                                            <a href="{{ url('/contact') }}" class="btn btn-outline-primary btn-sm px-3 py-1">Contact Part Specialist</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('parts') ? 'active' : '' }}" href="{{ url('/parts') }}">Find Parts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ url('/blog') }}">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a>
                        </li>
                    </ul>

                    <!-- Mobile-Only Navigation CTA Links inside offcanvas body -->
                    <div class="d-flex d-lg-none flex-column gap-3 mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa fa-phone-volume text-danger fs-5"></i>
                            <div>
                                <span class="text-muted d-block small" style="font-size: 11px;">HAVE QUESTIONS?</span>
                                <a href="tel:+18005550199" class="text-dark fw-bold text-decoration-none">+1 (800) 555-0199</a>
                            </div>
                        </div>
                        <a href="{{ url('/contact?quote=1') }}" class="btn btn-primary w-100 py-2 text-uppercase">
                            <i class="fa fa-file-invoice me-1"></i> Get Quote
                        </a>
                    </div>
                </div>
            </div>

            <!-- Desktop-Only Header Call and CTA Action Right -->
            <div class="d-none d-lg-flex align-items-center gap-3">
                <div class="text-end">
                    <span class="text-muted d-block small" style="font-size: 11px;">HAVE QUESTIONS?</span>
                    <a href="tel:+18005550199" class="text-dark fw-bold text-decoration-none" style="font-size: 16px;">
                        <i class="fa fa-phone-volume text-danger me-1"></i> +1 (800) 555-0199
                    </a>
                </div>
                <a href="{{ url('/contact?quote=1') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-file-invoice me-1"></i> Get Quote
                </a>
            </div>
        </nav>
    </div>
</header>
