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
            @forelse($categories as $category)
                @php
                    $icon = match($category->slug) {
                        'engines'       => 'fa fa-car-battery',
                        'transmissions' => 'fa fa-sliders',
                        'body-parts'    => 'fa fa-car-side',
                        'wheels'        => 'fa fa-circle-notch',
                        'lights', 'electrical' => 'fa fa-bolt',
                        'interior'      => 'fa fa-couch',
                        default         => 'fa fa-gears',
                    };
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="category-card" onclick="window.location.href='{{ url('/parts?category=' . $category->slug) }}'">
                        <i class="{{ $icon }}"></i>
                        <h4>{{ $category->name }}</h4>
                        <p>{{ Str::limit($category->description, 120) }}</p>
                        <a href="{{ url('/parts?category=' . $category->slug) }}" class="btn btn-link text-danger fw-bold p-0 mt-3 text-decoration-none small">
                            Explore {{ $category->name }} <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No categories available in the database. Add categories from the admin panel.</p>
                    <a href="{{ url('/admin/categories/create') }}" class="btn btn-primary">Add First Category</a>
                </div>
            @endforelse
        </div>
    </div>
</section>
