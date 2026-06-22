@extends('frontend.layouts.master')

@section('meta_title', 'Find Certified Used OEM Auto Parts | Auto Parts Marketplace')
@section('meta_description', 'Browse our inventory of high-quality pre-tested engines, transmissions, headlights, wheels, body parts and more. Fast free shipping across the US.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Auto Parts Catalog</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Search/Filter Bar at the top of the catalog page -->
    <section class="py-4 bg-white border-bottom shadow-sm">
        <div class="container">
            <form action="{{ url('/parts') }}" method="GET" id="partSearchForm">
                <div class="row g-2 align-items-center">
                    <div class="col-lg-3 col-md-4">
                        <select class="form-select border-secondary-subtle py-2 font-poppins" name="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <select class="form-select border-secondary-subtle py-2 font-poppins" name="make" onchange="this.form.submit()">
                            <option value="">All Makes / Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('make') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <input type="text" class="form-control border-secondary-subtle py-2 font-poppins" name="part_name" placeholder="Search by Part Name or SKU..." value="{{ request('part_name') }}">
                    </div>
                    <div class="col-lg-2 col-12">
                        <button type="submit" class="btn btn-primary w-100 py-2 text-uppercase font-poppins text-white shadow-sm">
                            <i class="fa fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Catalog Main Area -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                
                <!-- Sidebar Filters — all values come from the database -->
                <div class="col-lg-3 col-12">
                    <form action="{{ url('/parts') }}" method="GET" id="sidebarFilterForm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold m-0" style="font-size: 20px;">Filters</h4>
                            <a href="{{ url('/parts') }}" class="text-danger small fw-bold text-decoration-none"><i class="fa fa-rotate-right me-1"></i>Reset All</a>
                        </div>

                        <!-- Vehicle Brand / Make Filter -->
                        <div class="filter-widget">
                            <div class="filter-widget-title d-flex justify-content-between align-items-center">
                                <span>Vehicle Brand / Make</span>
                                <i class="fa fa-chevron-down d-md-none text-muted small"></i>
                            </div>
                            <ul class="filter-list">
                                @forelse($brands as $brand)
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="make" id="make_{{ Str::slug($brand) }}"
                                                value="{{ $brand }}" {{ request('make') == $brand ? 'checked' : '' }}
                                                onchange="document.getElementById('sidebarFilterForm').submit()">
                                            <label class="form-check-label text-dark small" for="make_{{ Str::slug($brand) }}">{{ $brand }}</label>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-muted small">No brands found.</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Part Category Filter -->
                        <div class="filter-widget">
                            <div class="filter-widget-title d-flex justify-content-between align-items-center">
                                <span>Part Category</span>
                                <i class="fa fa-chevron-down d-md-none text-muted small"></i>
                            </div>
                            <ul class="filter-list">
                                @forelse($allCategories as $cat)
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="category" id="cat_{{ $cat->id }}"
                                                value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }}
                                                onchange="document.getElementById('sidebarFilterForm').submit()">
                                            <label class="form-check-label text-dark small" for="cat_{{ $cat->id }}">{{ $cat->name }} ({{ $cat->products_count }})</label>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-muted small">No categories found.</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="filter-widget">
                            <div class="filter-widget-title d-flex justify-content-between align-items-center">
                                <span>Price Range</span>
                                <i class="fa fa-chevron-down d-md-none text-muted small"></i>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm bg-light" name="min_price" placeholder="Min $" value="{{ request('min_price') }}" style="padding: 8px;">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm bg-light" name="max_price" placeholder="Max $" value="{{ request('max_price') }}" style="padding: 8px;">
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-secondary btn-sm w-100 py-2">Apply Range</button>
                                </div>
                            </div>
                        </div>

                        <!-- Condition Filter -->
                        <div class="filter-widget">
                            <div class="filter-widget-title d-flex justify-content-between align-items-center">
                                <span>Part Condition</span>
                                <i class="fa fa-chevron-down d-md-none text-muted small"></i>
                            </div>
                            <ul class="filter-list">
                                @foreach(['used' => 'Grade A (Used & Tested)', 'refurbished' => 'Refurbished', 'oem-genuine' => 'OEM New Takeoff'] as $val => $label)
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="condition" id="cond_{{ $val }}"
                                                value="{{ $val }}" {{ request('condition') == $val ? 'checked' : '' }}
                                                onchange="document.getElementById('sidebarFilterForm').submit()">
                                            <label class="form-check-label text-dark small" for="cond_{{ $val }}">{{ $label }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Pass through existing search inputs so sidebar filters don't lose them --}}
                        @if(request('part_name'))
                            <input type="hidden" name="part_name" value="{{ request('part_name') }}">
                        @endif
                    </form>
                </div>

                <!-- Product Catalog Grid -->
                <div class="col-lg-9 col-12">

                    <!-- Results count and sort bar -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 bg-white p-3 rounded border shadow-sm">
                        <div>
                            <span class="text-muted small">Showing {{ $products->firstItem() ?? 0 }}&ndash;{{ $products->lastItem() ?? 0 }} of </span>
                            <strong class="text-dark">{{ $totalResults }} results</strong>
                            @if(request('part_name') || request('category') || request('make'))
                                <span class="text-muted small"> for "{{ implode(', ', array_filter([request('part_name'), request('category'), request('make')])) }}"</span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small" style="min-width: 60px;">Sort By:</span>
                            <select class="form-select form-select-sm border-secondary-subtle py-1 font-poppins" style="width: 160px; padding: 6px;"
                                onchange="window.location.href='{{ url('/parts') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value}).toString()">
                                <option value="newest" {{ request('sort','newest')=='newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Name A–Z</option>
                            </select>
                        </div>
                    </div>

                    {{-- Dynamic products grid — loops over paginated results from the DB --}}
                    <div class="row g-4 mb-5">
                        @forelse($products as $product)
                            @php
                                // Safely get the first image \u2014 guard against nested arrays from JSON cast
                                $imgs    = $product->images ?? [];
                                $rawImg  = count($imgs) > 0 ? $imgs[0] : null;
                                $img     = is_array($rawImg)
                                    ? ($rawImg['url'] ?? ($rawImg[0] ?? 'https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=600&auto=format&fit=crop'))
                                    : ($rawImg ?: 'https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=600&auto=format&fit=crop');
                                $img = (string) $img;

                                $badge = match($product->condition ?? '') {
                                    'used'        => 'Grade A Tested',
                                    'refurbished' => 'Refurbished',
                                    'oem-genuine' => 'OEM Takeoff',
                                    default       => 'Certified Part',
                                };

                                // Safely get first compatibility entry as a plain string — item is {year, make, model}
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

                                // Display sale_price if it exists and is lower than regular price
                                $displayPrice = ($product->sale_price && $product->sale_price < $product->price)
                                    ? $product->sale_price
                                    : $product->price;
                            @endphp
                            <div class="col-md-6 col-12">
                                <div class="part-card bg-white">
                                    <div class="part-card-img">
                                        <span class="part-badge">{{ $badge }}</span>
                                        <img src="{{ $img }}" alt="{{ $product->name }}" style="object-fit: cover; width: 100%; height: 100%;">
                                    </div>
                                    <div class="part-card-body">
                                        @if($product->category)
                                            <span class="text-danger small fw-bold">{{ strtoupper($product->category->name) }}</span>
                                        @endif
                                        <h4 class="part-card-title mt-1">{{ Str::limit($product->name, 55) }}</h4>
                                        <ul class="part-meta">
                                            <li><i class="fa fa-car text-danger"></i> Fits: {{ $fitText }}</li>
                                            @if($product->sku)
                                                <li><i class="fa fa-barcode text-danger"></i> SKU: {{ $product->sku }}</li>
                                            @endif
                                            <li><i class="fa fa-truck text-success"></i> Free Shipping Included</li>
                                        </ul>
                                        <div class="part-price-row mt-4">
                                            <div>
                                                <span class="text-muted small d-block">SALE PRICE</span>
                                                <span class="part-price">${{ number_format($displayPrice, 2) }}</span>
                                                @if($product->sale_price && $product->sale_price < $product->price)
                                                    <span class="text-muted small text-decoration-line-through ms-2">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <a href="{{ route('parts.show', $product->slug) }}" class="btn btn-primary px-4 py-2 font-poppins" style="font-size: 14px;">View Full Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- Empty state: shown when no products match the current filters --}}
                            <div class="col-12 text-center py-5">
                                <i class="fa fa-magnifying-glass fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No parts found matching your filters.</h5>
                                <p class="text-muted small">Try removing some filters or <a href="{{ url('/parts') }}" class="text-danger">reset all</a> to browse everything.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Laravel's built-in pagination links (styled via Bootstrap) --}}
                    @if($products->hasPages())
                        <nav aria-label="Catalog Navigation">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </nav>
                    @endif

                </div>

            </div>
        </div>
    </section>

    <!-- Call To Action Component -->
    @include('frontend.components.cta')

@endsection
