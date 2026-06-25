@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Add New Auto Part</h2>
            <span class="text-muted small">Fill out specifications, compatibility, and SEO details.</span>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back to Catalog</a>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Tab Selectors -->
        <ul class="nav nav-tabs border-bottom-0 gap-2 mb-3" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active border shadow-sm rounded-top" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-pane" type="button" role="tab" aria-controls="general-pane" aria-selected="true"><i class="fa fa-info-circle me-1"></i> General Details</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link border shadow-sm rounded-top" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-pane" type="button" role="tab" aria-controls="specs-pane" aria-selected="false"><i class="fa fa-sliders me-1"></i> Tech Specs & Compatibility</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link border shadow-sm rounded-top" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo-pane" type="button" role="tab" aria-controls="seo-pane" aria-selected="false"><i class="fa fa-search me-1"></i> SEO & Schema</button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content border p-4 rounded-bottom shadow-sm bg-white text-dark mb-4">
            
            <!-- Tab 1: General Details -->
            <div class="tab-pane fade show active" id="general-pane" role="tabpanel" aria-labelledby="general-tab">
                <div class="row g-3">
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">PRODUCT NAME *</label>
                        <input type="text" class="form-control" name="name" placeholder="e.g. 2.5L Toyota Camry Engine Block Assembly" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">SKU (PART CODE) *</label>
                        <input type="text" class="form-control" name="sku" placeholder="e.g. ENG-CAM-2018-01" required>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">CATEGORY *</label>
                        <select class="form-select" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">BRAND (OEM OR MANUFACTURER)</label>
                        <input type="text" class="form-control" name="brand" placeholder="e.g. Toyota">
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">CONDITION</label>
                        <select class="form-select" name="condition">
                            <option value="Used">Used (Recycled)</option>
                            <option value="OEM Takeoff">OEM New Takeoff</option>
                            <option value="Remanufactured">Remanufactured</option>
                            <option value="New">Brand New OEM</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">BASE PRICE ($) *</label>
                        <input type="number" step="0.01" class="form-control" name="price" placeholder="1450.00" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">SALE PRICE ($)</label>
                        <input type="number" step="0.01" class="form-control" name="sale_price" placeholder="1250.00">
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">STOCK AMOUNT *</label>
                        <input type="number" class="form-control" name="stock" value="1" required>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">WARRANTY INFO</label>
                        <input type="text" class="form-control" name="warranty" placeholder="e.g. 90-Day Money-Back Warranty" value="90-Day Money-Back Warranty">
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">GALLERY IMAGES</label>
                        <input type="file" class="form-control" name="gallery_images[]" multiple accept="image/*">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">DESCRIPTION</label>
                        <textarea class="form-control" id="description-editor" name="description" rows="4" placeholder="Enter detailed part condition description..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Specifications & Compatibility -->
            <div class="tab-pane fade" id="specs-pane" role="tabpanel" aria-labelledby="specs-tab">
                
                <!-- Part Specifications Builder -->
                <div class="mb-5">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Technical Specifications</h5>
                    <p class="text-muted small">Add custom specifications like Mileage, Cylinders, Block Type, etc.</p>
                    <div id="specsContainer">
                        <div class="row g-2 mb-2 spec-row">
                            <div class="col-5">
                                <input type="text" class="form-control form-control-sm" name="spec_keys[]" placeholder="e.g. Mileage">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" name="spec_values[]" placeholder="e.g. 48,150 Miles">
                            </div>
                            <div class="col-1 text-end">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 py-2 remove-spec-btn"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addSpecBtn"><i class="fa fa-plus me-1"></i> Add Spec Row</button>
                </div>

                <!-- Vehicle Compatibility Builder -->
                <div>
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Vehicle Compatibility</h5>
                    <p class="text-muted small">Link this part to multiple target vehicle applications.</p>
                    <div id="compatContainer">
                        <div class="row g-2 mb-2 compat-row">
                            <div class="col-3">
                                <input type="text" class="form-control form-control-sm" name="compat_years[]" placeholder="e.g. 2018 - 2021">
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control form-control-sm" name="compat_makes[]" placeholder="e.g. Toyota">
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control form-control-sm" name="compat_models[]" placeholder="e.g. Camry">
                            </div>
                            <div class="col-1 text-end">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 py-2 remove-compat-btn"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addCompatBtn"><i class="fa fa-plus me-1"></i> Add Compatibility Row</button>
                </div>
            </div>

            <!-- Tab 3: SEO Details -->
            <div class="tab-pane fade" id="seo-pane" role="tabpanel" aria-labelledby="seo-tab">
                <div class="row g-3">
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">META TITLE</label>
                        <input type="text" class="form-control" name="meta_title" placeholder="Meta Title placeholder">
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">CANONICAL URL</label>
                        <input type="text" class="form-control" name="canonical_url" placeholder="https://riojimmymotor.com/parts/...">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">META KEYWORDS</label>
                        <input type="text" class="form-control" name="meta_keywords" placeholder="used engine, camry engine, 2018 camry engine">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">META DESCRIPTION</label>
                        <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta Description placeholder..."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">CUSTOM SCHEMA INJECTION (JSON-LD)</label>
                        <textarea class="form-control font-monospace" name="schema_markup" rows="5" placeholder="{&#10;  &quot;@@context&quot;: &quot;https://schema.org&quot;,&#10;  &quot;@@type&quot;: &quot;Product&quot;&#10;}"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Submit actions -->
        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Save Product</button>
        </div>
    </form>

@endsection

@push('admin-scripts')
    <!-- CKEditor 5 Classic CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline {
            min-height: 250px;
            color: #000000;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize CKEditor for Product Description
            ClassicEditor
                .create(document.querySelector('#description-editor'), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
                })
                .catch(error => {
                    console.error(error);
                });

            // Specs Builder
            const specsContainer = document.getElementById('specsContainer');
            const addSpecBtn = document.getElementById('addSpecBtn');

            addSpecBtn.addEventListener('click', function () {
                const newRow = document.createElement('div');
                newRow.className = 'row g-2 mb-2 spec-row';
                newRow.innerHTML = `
                    <div class="col-5">
                        <input type="text" class="form-control form-control-sm" name="spec_keys[]" placeholder="Specification Label">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm" name="spec_values[]" placeholder="Specification Value">
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 py-2 remove-spec-btn"><i class="fa fa-times"></i></button>
                    </div>
                `;
                specsContainer.appendChild(newRow);
                bindRemoveButtons();
            });

            // Compatibility Builder
            const compatContainer = document.getElementById('compatContainer');
            const addCompatBtn = document.getElementById('addCompatBtn');

            addCompatBtn.addEventListener('click', function () {
                const newRow = document.createElement('div');
                newRow.className = 'row g-2 mb-2 compat-row';
                newRow.innerHTML = `
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm" name="compat_years[]" placeholder="Years Range">
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="compat_makes[]" placeholder="Make">
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="compat_models[]" placeholder="Model">
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 py-2 remove-compat-btn"><i class="fa fa-times"></i></button>
                    </div>
                `;
                compatContainer.appendChild(newRow);
                bindRemoveButtons();
            });

            function bindRemoveButtons() {
                document.querySelectorAll('.remove-spec-btn').forEach(btn => {
                    btn.onclick = function() { this.closest('.spec-row').remove(); };
                });
                document.querySelectorAll('.remove-compat-btn').forEach(btn => {
                    btn.onclick = function() { this.closest('.compat-row').remove(); };
                });
            }

            bindRemoveButtons();
        });
    </script>
@endpush
