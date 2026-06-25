@extends('frontend.layouts.master')

@section('meta_title', $product->meta_title ?? ($product->name . ' | Rio Jimmy Motor'))
@section('meta_description', $product->meta_description ?? Str::limit($product->description, 160))

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/parts') }}">Auto Parts</a></li>
                    @if($product->category)
                        <li class="breadcrumb-item"><a href="{{ url('/parts?category=' . $product->category->slug) }}">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5 bg-white">
        <div class="container">
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span><i class="fa fa-circle-check text-success me-2 fs-5"></i>{{ session('success') }}</span>
                        <a href="{{ url('/cart') }}" class="btn btn-sm btn-success text-white fw-bold px-3 py-1.5"><i class="fa fa-shopping-cart me-1"></i> View Cart</a>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: 50%; transform: translateY(-50%); margin-top: 0;"></button>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <span><i class="fa fa-circle-exclamation text-danger me-2 fs-5"></i>{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-5">
                
                <!-- Product Gallery Columns -->
                <div class="col-lg-6">
                    
                    <!-- Main Gallery Image -->
                    <div class="gallery-main">
                        <img id="main-gallery-img" src="{{ !empty($product->images) && is_array($product->images) ? $product->images[0] : 'https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
                    </div>

                    <!-- Thumbnails list (Triggered by main.js click script) -->
                    <div class="gallery-thumbs mt-3 d-flex gap-2">
                        @if(!empty($product->images) && is_array($product->images))
                            @foreach($product->images as $index => $img)
                            <div class="gallery-thumb-item {{ $index === 0 ? 'active' : '' }}" data-large="{{ $img }}" style="cursor: pointer; border: 2px solid {{ $index === 0 ? 'var(--primary)' : '#e0e0e0' }}; border-radius: 4px; overflow: hidden; width: 80px; height: 80px;">
                                <img src="{{ $img }}" alt="Thumbnail {{ $index + 1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            @endforeach
                        @else
                            <div class="gallery-thumb-item active" data-large="https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=800&auto=format&fit=crop" style="cursor: pointer; border: 2px solid var(--primary); border-radius: 4px; overflow: hidden; width: 80px; height: 80px;">
                                <img src="https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=150&auto=format&fit=crop" alt="Thumbnail Engine 1" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endif
                        
                        <!-- Fallback thumbnails if only 1 image is in DB -->
                        @if(empty($product->images) || count($product->images) < 3)
                            <div class="gallery-thumb-item" data-large="https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=800&auto=format&fit=crop" style="cursor: pointer; border: 2px solid #e0e0e0; border-radius: 4px; overflow: hidden; width: 80px; height: 80px;">
                                <img src="https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=150&auto=format&fit=crop" alt="Thumbnail Engine 2" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="gallery-thumb-item" data-large="https://images.unsplash.com/photo-1507136566006-cfc505b114fc?q=80&w=800&auto=format&fit=crop" style="cursor: pointer; border: 2px solid #e0e0e0; border-radius: 4px; overflow: hidden; width: 80px; height: 80px;">
                                <img src="https://images.unsplash.com/photo-1507136566006-cfc505b114fc?q=80&w=150&auto=format&fit=crop" alt="Thumbnail Engine 3" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endif
                    </div>

                    <!-- Certification badges -->
                    <div class="bg-light p-4 rounded border text-center mt-4">
                        <h5 class="fw-bold mb-3 text-dark"><i class="fa fa-circle-check text-success me-2"></i>A-Grade Quality Inspection Checklist</h5>
                        <div class="row text-start g-2">
                            <div class="col-md-6 col-12 small text-muted"><i class="fa fa-check text-success me-2"></i> Compression Tested (185 PSI average)</div>
                            <div class="col-md-6 col-12 small text-muted"><i class="fa fa-check text-success me-2"></i> Cylinders Leak-Down Checked</div>
                            <div class="col-md-6 col-12 small text-muted"><i class="fa fa-check text-success me-2"></i> Zero Oil Deposits or Sludge</div>
                            <div class="col-md-6 col-12 small text-muted"><i class="fa fa-check text-success me-2"></i> Valve Train & Crankshaft Inspected</div>
                        </div>
                    </div>
                </div>

                <!-- Product Content Info & Sidebar Quote Columns -->
                <div class="col-lg-6">
                    
                    <!-- Title & Badges -->
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-danger">{{ strtoupper($product->condition ?? 'USED') }}</span>
                        @if(($product->stock ?? 0) > 0)
                            <span class="badge bg-success"><i class="fa fa-check me-1"></i> IN STOCK</span>
                        @else
                            <span class="badge bg-secondary"><i class="fa fa-times me-1"></i> OUT OF STOCK</span>
                        @endif
                    </div>
                    <h1 class="fw-800 text-dark mb-3" style="font-size: 36px;">{{ $product->name }}</h1>
                    <p class="text-muted">{{ $product->description }}</p>
                    
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
                            <div class="col-md-6 col-12 mb-3 mb-md-0">
                                @if($product->sale_price)
                                    <span class="text-muted small d-block">MARKET VALUE: <del>${{ number_format($product->price, 2) }}</del></span>
                                    <span class="fs-2 fw-bold text-danger font-poppins">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="fs-2 fw-bold text-danger font-poppins">${{ number_format($product->price, 2) }}</span>
                                @endif
                                <span class="text-muted small d-block">Includes Free Standard Freight Shipping</span>
                            </div>
                            <div class="col-md-6 col-12">
                                @if(($product->stock ?? 0) > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="mb-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        
                                        <button type="submit" name="buy_now" value="1" class="btn btn-danger w-100 py-2.5 mb-2 font-poppins text-white fw-bold shadow-sm" style="background-color: var(--primary-red); border-color: var(--primary-red);">
                                            <i class="fa fa-bolt me-1"></i> Buy Now
                                        </button>
                                        <button type="submit" class="btn btn-outline-danger w-100 py-2.5 font-poppins fw-bold shadow-sm" style="color: var(--primary-red); border-color: var(--primary-red);">
                                            <i class="fa fa-shopping-cart me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary w-100 py-3 mb-2 font-poppins text-white fw-bold" disabled>
                                        Out of Stock
                                    </button>
                                @endif
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->get('contact_phone', '+18005550199')) }}" class="btn btn-primary w-100 py-2 font-poppins text-white">
                                    <i class="fa fa-phone me-2"></i> Order by Phone
                                </a>
                                <span class="text-muted small d-block text-center mt-1" style="font-size: 11px;">CALL NOW FOR INSTANT DISCOUNTS</span>
                            </div>
                        </div>
                    </div>

                    <!-- Key Part Attributes list -->
                    <div class="detail-info-block border p-3 rounded">
                        <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark">Part Specifications</h5>
                        <ul class="detail-info-list font-poppins list-unstyled mb-0">
                            @if(!empty($product->specifications) && is_array($product->specifications))
                                @foreach($product->specifications as $key => $value)
                                    <li class="d-flex justify-content-between py-1 border-bottom border-light">
                                        <span class="text-muted">{{ $key }}</span>
                                        <span class="fw-semibold text-dark">{{ $value }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="d-flex justify-content-between py-1 border-bottom border-light"><span class="text-muted">Part Number (OEM)</span> <span class="fw-semibold text-dark">{{ $product->sku }}</span></li>
                                <li class="d-flex justify-content-between py-1 border-bottom border-light"><span class="text-muted">Brand / Make</span> <span class="fw-semibold text-dark">{{ $product->brand }}</span></li>
                                <li class="d-flex justify-content-between py-1 border-bottom border-light"><span class="text-muted">Grade Condition</span> <span class="fw-semibold text-dark">{{ $product->condition }}</span></li>
                                <li class="d-flex justify-content-between py-1 border-bottom border-light"><span class="text-muted">Warranty Sourced</span> <span class="fw-semibold text-dark">{{ $product->warranty ?? '90-Day Standard Replacement' }}</span></li>
                            @endif
                        </ul>
                    </div>

                    <!-- Direct Inquiry Form (Highly Conversion Focused) -->
                    <div class="bg-light p-4 rounded border mt-4">
                        <h5 class="fw-bold mb-2 text-dark">Request A Direct Price Quote</h5>
                        <p class="text-muted small mb-3">Provide your email or phone below. We will send a formal quote details sheet within 15 minutes.</p>
                        
                        <div id="quoteAlert" class="alert d-none mt-2 small py-2.5"></div>

                        <form id="quoteRequestForm" method="POST">
                            @csrf
                            <!-- Hidden validation fields matching HomeController@submitContact schema -->
                            <input type="hidden" name="part_requested" value="{{ $product->name }}">
                            <input type="hidden" name="make" value="{{ $product->brand ?? 'OEM' }}">
                            <input type="hidden" name="model" value="{{ $product->name }}">
                            <input type="hidden" name="year" value="{{ !empty($product->compatibility) && is_array($product->compatibility) ? ($product->compatibility[0]['year'] ?? 'N/A') : 'N/A' }}">
                            <input type="hidden" name="notes" value="Direct quote request for SKU: {{ $product->sku }} Sourced at: {{ url()->current() }}">

                            <div class="row g-2">
                                <div class="col-md-6 col-12">
                                    <input type="text" name="name" class="form-control bg-white form-control-sm py-2" placeholder="Full Name" required style="padding: 10px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="email" name="email" class="form-control bg-white form-control-sm py-2" placeholder="Email Address" required style="padding: 10px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="tel" name="phone" class="form-control bg-white form-control-sm py-2" placeholder="Phone Number" required style="padding: 10px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="text" name="vin" class="form-control bg-white form-control-sm py-2" placeholder="17-Digit Vehicle VIN Code" style="padding: 10px;">
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
                            <h4 class="fw-bold mb-3 text-dark">{{ $product->name }}</h4>
                            <p class="text-muted">{!! nl2br(e($product->description)) !!}</p>
                            @if($product->warranty)
                                <h5 class="fw-bold fs-6 mt-4 mb-2 text-dark">Warranty Information</h5>
                                <p class="text-muted">{{ $product->warranty }}</p>
                            @endif
                        </div>

                        <!-- Compatibility Tab Pane -->
                        <div class="tab-pane fade" id="compat-pane" role="tabpanel" aria-labelledby="compat-tab">
                            <h4 class="fw-bold mb-3 text-dark">Vehicle Fitment Verification</h4>
                            <p class="mb-3 text-muted">Below is the verified compatible vehicles chart. Please verify fitment matching before ordering.</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped font-poppins text-dark">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Year</th>
                                            <th>Make</th>
                                            <th>Model</th>
                                            <th>Trim/Specs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($product->compatibility) && is_array($product->compatibility))
                                            @foreach($product->compatibility as $item)
                                                <tr>
                                                    <td>{{ $item['year'] ?? '' }}</td>
                                                    <td>{{ $item['make'] ?? '' }}</td>
                                                    <td>{{ $item['model'] ?? '' }}</td>
                                                    <td>{{ $item['trim'] ?? $item['specs'] ?? 'Standard Fitment' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">Fits standard {{ $product->brand }} vehicles matching this description. Please consult our support team for exact VIN verification.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Shipping & Returns Tab Pane -->
                        <div class="tab-pane fade" id="shipping-pane" role="tabpanel" aria-labelledby="shipping-tab">
                            <h4 class="fw-bold mb-3 text-dark">Safe Freight Shipping & Simple Return Policies</h4>
                            <h5 class="fw-bold fs-6 mb-2 text-dark"><i class="fa fa-truck text-danger me-2"></i>Shipping Cost & Timelines</h5>
                            <p class="text-muted">Standard freight shipping is **FREE** to both commercial repair shops and residential driveways. Heavy freight units like engines are bolted onto wooden pallets, wrapped, and delivered via dry-van LTL trailers. Deliveries to residential driveways include a complimentary liftgate tailgate unload service to lower the pallet to the ground.</p>
                            
                            <h5 class="fw-bold fs-6 mb-2 mt-4 text-dark"><i class="fa fa-arrows-rotate text-danger me-2"></i>90-Day Returns Policy</h5>
                            <p class="text-muted mb-0">If the engine block arrives damaged or does not run, contact our support team. We will send a replacement unit or issue a 100% full refund and coordinate freight pickup at no cost to you. If you order the wrong engine size or change your mind, returns are subject to flat-rate round-trip freight costs.</p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Related Products Grid -->
    @if(isset($relatedProducts) && count($relatedProducts) > 0)
    <section class="py-5 bg-light border-top">
        <div class="container">
            <h3 class="fw-700 text-dark mb-4 text-center text-md-start">Related Parts</h3>
            
            <div class="row g-4">
                @foreach($relatedProducts as $relProduct)
                <div class="col-lg-3 col-md-6">
                    <div class="part-card bg-white h-100 shadow-sm border rounded overflow-hidden d-flex flex-column">
                        <div class="part-card-img position-relative" style="height: 180px; overflow: hidden;">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 z-1">{{ $relProduct->condition }}</span>
                            <img src="{{ !empty($relProduct->images) && is_array($relProduct->images) ? $relProduct->images[0] : 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $relProduct->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="part-card-body p-3 d-flex flex-column flex-grow-1">
                            <h4 class="part-card-title text-dark fs-6 fw-bold mb-2">{{ $relProduct->name }}</h4>
                            <ul class="part-meta font-poppins list-unstyled small text-muted mb-3 flex-grow-1">
                                <li><i class="fa fa-car text-danger me-1"></i> Brand: {{ $relProduct->brand }}</li>
                                @if(!empty($relProduct->specifications) && is_array($relProduct->specifications) && isset($relProduct->specifications['Mileage']))
                                    <li><i class="fa fa-tachometer-alt text-danger me-1"></i> Mileage: {{ $relProduct->specifications['Mileage'] }}</li>
                                @else
                                    <li><i class="fa fa-barcode text-danger me-1"></i> SKU: {{ $relProduct->sku }}</li>
                                @endif
                            </ul>
                            <div class="part-price-row d-flex justify-content-between align-items-center mt-auto">
                                <span class="part-price fw-bold text-danger">${{ number_format($relProduct->price, 2) }}</span>
                                <a href="{{ route('parts.show', ['slug' => $relProduct->slug]) }}" class="btn btn-outline-primary btn-sm px-3 py-2 font-poppins">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- FAQ Accordion Component -->
    @include('frontend.components.faq')

    <!-- Call to Action Banner Component -->
    @include('frontend.components.cta')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quoteForm = document.getElementById('quoteRequestForm');
    const quoteAlert = document.getElementById('quoteAlert');

    if (quoteForm) {
        quoteForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Reset alert state
            quoteAlert.classList.add('d-none');
            quoteAlert.classList.remove('alert-success', 'alert-danger');
            quoteAlert.innerHTML = '';

            const submitBtn = quoteForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Submitting...';

            const formData = new FormData(quoteForm);

            fetch('{{ route("contact.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (response.status === 422) {
                    return response.json().then(errData => {
                        let errorMsg = errData.message || 'Validation failed.';
                        if (errData.errors) {
                            errorMsg += '<ul class="mb-0 mt-2 text-start">';
                            Object.values(errData.errors).forEach(errArray => {
                                errArray.forEach(err => {
                                    errorMsg += `<li>${err}</li>`;
                                });
                            });
                            errorMsg += '</ul>';
                        }
                        throw new Error(errorMsg);
                    });
                }
                if (!response.ok) {
                    throw new Error('An error occurred. Please try again.');
                }
                return response.json();
            })
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;

                if (data.success) {
                    quoteAlert.classList.remove('d-none');
                    quoteAlert.classList.add('alert-success');
                    quoteAlert.innerHTML = data.message;
                    quoteForm.reset();
                } else {
                    quoteAlert.classList.remove('d-none');
                    quoteAlert.classList.add('alert-danger');
                    quoteAlert.innerHTML = data.message || 'An error occurred. Please try again.';
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                quoteAlert.classList.remove('d-none');
                quoteAlert.classList.add('alert-danger');
                quoteAlert.innerHTML = error.message || 'A connection error occurred. Please try again.';
                console.error('Error:', error);
            });
        });
    }
});
</script>
@endpush
