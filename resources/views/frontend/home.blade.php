@extends('frontend.layouts.master')

@section('meta_title', 'Used Auto Parts & Salvage OEM Parts | Auto Parts Marketplace')
@section('meta_description', 'Search and buy high-quality used engines, transmissions, headlights, wheels, and body parts. Standard free nationwide shipping and warranty on certified OEM parts.')

@section('content')

    <!-- Hero Banner (Includes Search Form) -->
    @include('frontend.components.hero')

    <!-- Trust Badges Bar -->
    <div class="trust-badges-bar">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge-item">
                        <i class="fa fa-truck-fast"></i>
                        <div>
                            <h5>Free Shipping</h5>
                            <p>Free delivery on all continental US orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge-item">
                        <i class="fa fa-circle-check"></i>
                        <div>
                            <h5>OEM Compatibility</h5>
                            <p>100% VIN matching guarantee</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge-item">
                        <i class="fa fa-shield-halved"></i>
                        <div>
                            <h5>90-Day Warranty</h5>
                            <p>Full protection on parts and return ship</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge-item">
                        <i class="fa fa-user-shield"></i>
                        <div>
                            <h5>A+ Certified Yards</h5>
                            <p>Tested auto parts from verified networks</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Categories Component -->
    @include('frontend.components.categories')

    <!-- How It Works Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Ordering Process</span>
                    <h2 class="mt-2 fw-700">How Auto Parts Marketplace Works</h2>
                    <p class="text-muted">Buying high-quality salvage and OEM used parts is easy with our 3-step search-and-ship method.</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Step 1 -->
                <div class="col-md-4">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <h4>Select Your Vehicle</h4>
                        <p class="text-muted px-lg-3">Select the year, make, and model of your vehicle using our search tool to filter matching parts.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-md-4">
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <h4>Locate Certified Part</h4>
                        <p class="text-muted px-lg-3">Browse detailed parts details, images, condition ratings, and cross-compatibility guides.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-md-4">
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <h4>Fast & Free Delivery</h4>
                        <p class="text-muted px-lg-3">Place your order safely. We package and ship your verified OEM auto part right to your home or shop.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Featured Auto Parts Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-5 align-items-end">
                <div class="col-md-8 text-center text-md-start">
                    <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Trending Items</span>
                    <h2 class="mt-2 fw-700">Popular Auto Parts In Stock</h2>
                    <p class="text-muted m-0">Browse through some of our high-quality, pre-tested recycled auto parts ready to ship today.</p>
                </div>
                <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                    <a href="{{ url('/parts') }}" class="btn btn-secondary">
                        View Full Inventory <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            {{-- Dynamic product cards loaded from the database --}}
            <div class="row g-4">
                @forelse($featuredProducts as $product)
                    @php
                        // Safely get the first product image — images is a JSON array cast
                        $images = $product->images ?? [];
                        $rawImage = count($images) > 0 ? $images[0] : null;
                        // Guard against nested arrays (e.g. [{"url": "..."}])
                        $firstImage = is_array($rawImage)
                            ? ($rawImage['url'] ?? ($rawImage[0] ?? 'https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=600&auto=format&fit=crop'))
                            : ($rawImage ?: 'https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=600&auto=format&fit=crop');
                        $firstImage = (string) $firstImage;

                        // Determine the badge label based on product condition
                        $badge = match($product->condition ?? '') {
                            'used'         => 'Tested A-Grade',
                            'refurbished'  => 'Refurbished',
                            'oem-genuine'  => 'OEM Genuine',
                            default        => 'Certified Part',
                        };

                        // Get first compatibility entry as a plain string — item is {year, make, model}
                        $compat = $product->compatibility ?? [];
                        $rawFit = count($compat) > 0 ? $compat[0] : null;
                        if (is_array($rawFit)) {
                            // Build a readable "Year Make Model" string from the keyed array
                            $fitText = trim(implode(' ', array_filter([
                                $rawFit['year']  ?? '',
                                $rawFit['make']  ?? '',
                                $rawFit['model'] ?? '',
                            ]))) ?: ($product->brand ?? 'Various Vehicles');
                        } else {
                            $fitText = $rawFit ?: ($product->brand ?? 'Various Vehicles');
                        }
                        $fitText = (string) $fitText;
                    @endphp
                    <div class="col-lg-3 col-md-6">
                        <div class="part-card">
                            <div class="part-card-img">
                                <span class="part-badge">{{ $badge }}</span>
                                <img src="{{ $firstImage }}" alt="{{ $product->name }}" style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <div class="part-card-body">
                                <h4 class="part-card-title">{{ Str::limit($product->name, 45) }}</h4>
                                <ul class="part-meta">
                                    <li><i class="fa fa-car text-danger"></i> Fits: {{ $fitText }}</li>
                                    @if($product->warranty)
                                        <li><i class="fa fa-shield-check text-danger"></i> Warranty: {{ $product->warranty }}</li>
                                    @endif
                                    @if($product->category)
                                        <li><i class="fa fa-folder text-danger"></i> {{ $product->category->name }}</li>
                                    @endif
                                </ul>
                                <div class="part-price-row">
                                    <span class="part-price">${{ number_format($product->price, 2) }}</span>
                                    <a href="{{ route('parts.show', $product->slug) }}" class="btn btn-outline-primary btn-sm px-3 py-2" style="font-size: 14px;">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Shown only when no products exist in the database yet --}}
                    <div class="col-12 text-center py-5">
                        <i class="fa fa-boxes-stacked fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No featured products available yet. Add products from the admin panel.</p>
                        <a href="{{ url('/admin/products/create') }}" class="btn btn-primary">Add First Product</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <!-- Image Side -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=800&auto=format&fit=crop" alt="Auto Parts Warehouse" class="img-fluid rounded shadow-sm">
                </div>
                <!-- Content Side -->
                <div class="col-lg-6 ps-lg-5">
                    <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Why Choose Us</span>
                    <h2 class="mt-2 mb-4 fw-700">Your Direct Pipeline To Recycled Auto Parts</h2>
                    <p class="text-muted mb-4">We are dedicated to providing vehicle owners, automotive hobbyists, and body shops with the highest standard of pre-owned parts at unmatched pricing.</p>
                    
                    <!-- Point 1 -->
                    <div class="icon-box-style">
                        <div class="icon-box-icon"><i class="fa fa-truck-ramp-box"></i></div>
                        <div class="icon-box-content">
                            <h4>Nationwide Delivery Network</h4>
                            <p>Fast LTL shipping for commercial addresses and home deliveries with hydraulic tailgate service if requested.</p>
                        </div>
                    </div>

                    <!-- Point 2 -->
                    <div class="icon-box-style">
                        <div class="icon-box-icon"><i class="fa fa-handshake-angle"></i></div>
                        <div class="icon-box-content">
                            <h4>Industry-Leading Compatibility Guarantee</h4>
                            <p>Our sales team matches every order against factory OEM build catalogues to eliminate return overhead.</p>
                        </div>
                    </div>

                    <!-- Point 3 -->
                    <div class="icon-box-style mb-0">
                        <div class="icon-box-icon"><i class="fa fa-tags"></i></div>
                        <div class="icon-box-content">
                            <h4>Fair Direct Pricing</h4>
                            <p>Salvage sourcing direct from certified yards results in 60-80% savings compared to MSRP dealerships.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Counter Section (Uses main.js dynamic counter script) -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <div class="stat-number" data-target="1500000" data-suffix="+">0</div>
                        <div class="stat-text">Parts In Inventory</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <div class="stat-number" data-target="250" data-suffix="+">0</div>
                        <div class="stat-text">Certified Salvage Yards</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <div class="stat-number" data-target="75000" data-suffix="+">0</div>
                        <div class="stat-text">Happy Customers</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <div class="stat-number" data-target="50" data-suffix="">0</div>
                        <div class="stat-text">States Shipped To</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Component -->
    @include('frontend.components.testimonials')

    <!-- Latest Blog Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-5 align-items-end">
                <div class="col-md-8 text-center text-md-start">
                    <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Educational Articles</span>
                    <h2 class="mt-2 fw-700">Latest From Our Tech Blog</h2>
                    <p class="text-muted m-0">Read mechanical articles, parts replacement tutorials, and buying guidelines written by automotive experts.</p>
                </div>
                <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                    <a href="{{ url('/blog') }}" class="btn btn-outline-primary">
                        View All Posts <i class="fa fa-newspaper ms-2"></i>
                    </a>
                </div>
            </div>

            {{-- Dynamic blog cards loaded from the database --}}
            <div class="row g-4">
                @forelse($latestBlogs as $blog)
                    @php
                        // Use stored image or a relevant placeholder
                        $blogImage = $blog->image ?: 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=600&auto=format&fit=crop';
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card">
                            <div class="blog-card-img">
                                <span class="blog-date-badge">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Draft' }}</span>
                                <img src="{{ $blogImage }}" alt="{{ $blog->title }}" style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <div class="blog-card-body">
                                @if($blog->category)
                                    <span class="blog-category">{{ $blog->category }}</span>
                                @endif
                                <h4 class="blog-title"><a href="{{ route('blog.show', $blog->slug) }}">{{ Str::limit($blog->title, 60) }}</a></h4>
                                <p class="blog-excerpt">{{ Str::limit($blog->summary, 120) }}</p>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="blog-readmore">Read Article <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Shown only when no blogs exist in the database yet --}}
                    <div class="col-12 text-center py-5">
                        <i class="fa fa-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No blog posts published yet. Add posts from the admin panel.</p>
                        <a href="{{ url('/admin/blogs/create') }}" class="btn btn-primary">Write First Article</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Component -->
    @include('frontend.components.faq')

    <!-- Call to Action Banner Component -->
    @include('frontend.components.cta')

@endsection
