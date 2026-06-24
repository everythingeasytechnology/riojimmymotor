<!-- Top Notification & Contact Bar -->
<div class="top-bar d-none d-md-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="me-3"><i class="fa fa-phone text-danger me-2"></i> Call Free: <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->get('contact_phone', '+18005550199')) }}" class="fw-bold">{{ $siteSettings->get('contact_phone', '+1 (800) 555-0199') }}</a></span>
                <span><i class="fa fa-envelope text-danger me-2"></i> <a href="mailto:{{ $siteSettings->get('contact_email', 'support@autopartsmarket.com') }}">{{ $siteSettings->get('contact_email', 'support@autopartsmarket.com') }}</a></span>
            </div>
            <div class="col-md-6 text-end">
                <span class="me-3"><i class="fa fa-clock me-2 text-danger"></i> {{ $siteSettings->get('business_hours', 'Mon - Sat: 8:00 AM - 6:00 PM EST') }}</span>
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
                <img src="{{ $siteSettings->get('site_logo') ? asset($siteSettings->get('site_logo')) : asset('frontend/images/riojimmymotorLogo.webp') }}" alt="{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }} Logo" style="height: 75px; max-height: 75px !important; object-fit: contain;">
            </a>

            <!-- Mobile Phone and Hamburger Toggle -->
            <div class="d-flex align-items-center d-lg-none gap-3">
                <a href="{{ url('/cart') }}" class="text-dark position-relative d-flex align-items-center justify-content-center text-decoration-none" style="font-size: 20px; width: 36px; height: 36px;">
                    <i class="fa fa-shopping-cart"></i>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger" style="font-size: 9px; padding: 3px 5px;">
                            {{ array_sum(array_column(session('cart'), 'quantity')) }}
                        </span>
                    @endif
                </a>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->get('contact_phone', '+18005550199')) }}" class="btn btn-primary btn-sm px-3 py-2">
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
                        <img src="{{ $siteSettings->get('site_logo') ? asset($siteSettings->get('site_logo')) : asset('frontend/images/riojimmymotorLogo.webp') }}" alt="{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }} Logo" style="height: 55px; max-height: 55px !important; object-fit: contain;">
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
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('parts') ? 'active' : '' }}" href="{{ url('/parts') }}">Shop</a>
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
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->get('contact_phone', '+18005550199')) }}" class="text-dark fw-bold text-decoration-none">{{ $siteSettings->get('contact_phone', '+1 (800) 555-0199') }}</a>
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
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->get('contact_phone', '+18005550199')) }}" class="text-dark fw-bold text-decoration-none" style="font-size: 16px;">
                        <i class="fa fa-phone-volume text-danger me-1"></i> {{ $siteSettings->get('contact_phone', '+1 (800) 555-0199') }}
                    </a>
                </div>
                <a href="{{ url('/cart') }}" class="text-dark position-relative d-flex align-items-center justify-content-center text-decoration-none" style="font-size: 22px; width: 40px; height: 40px;">
                    <i class="fa fa-shopping-cart"></i>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger" style="font-size: 10px; padding: 4px 6px;">
                            {{ array_sum(array_column(session('cart'), 'quantity')) }}
                        </span>
                    @endif
                </a>
                <a href="{{ url('/contact?quote=1') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-file-invoice me-1"></i> Get Quote
                </a>
            </div>
        </nav>
    </div>
</header>
