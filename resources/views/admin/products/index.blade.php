@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Product Management</h2>
            <span class="text-muted small">Manage your automotive marketplace catalog inventory.</span>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fa fa-file-import me-1"></i> Import CSV</button>
            <a href="{{ route('admin.products.export') }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-file-export me-1"></i> Export CSV</a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i> Add Product</a>
        </div>
    </div>

    <!-- Filter & Search Panel -->
    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2">
                <div class="col-md-9 col-12">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-secondary-subtle"><i class="fa fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-secondary-subtle" name="search" placeholder="Search by name, SKU, or brand..." value="{{ $search }}">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <button type="submit" class="btn btn-secondary w-100"><i class="fa fa-filter me-1"></i> Filter Catalog</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="admin-card">
        <div class="admin-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span><i class="fa fa-boxes-stacked text-danger me-2"></i>Product Catalog ({{ $products->total() }} items)</span>
            
            <!-- Bulk Actions -->
            <button class="btn btn-outline-danger btn-sm d-none" id="bulkDeleteBtn" onclick="runBulkDelete()">
                <i class="fa fa-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
            </button>
        </div>
        
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0 text-dark font-poppins">
                    <thead class="table-light">
                        <tr>
                            <th width="40"><input type="checkbox" id="selectAllCheckbox"></th>
                            <th>Part Info</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Condition</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td><input type="checkbox" class="product-checkbox" value="{{ $product->id }}"></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 50px; height: 50px; background-color: #f5f5f5; border-radius: 6px; overflow: hidden;">
                                            <img src="{{ is_array($product->images) && count($product->images) > 0 ? $product->images[0] : '/frontend/images/part-default.jpg' }}" alt="Part" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block" style="font-size: 15px;">{{ $product->name }}</span>
                                            <span class="text-muted small">Brand: {{ $product->brand ?? 'OEM' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code>{{ $product->sku }}</code></td>
                                <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                                <td>
                                    @if($product->sale_price)
                                        <span class="text-danger fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                                        <del class="text-muted small d-block">${{ number_format($product->price, 2) }}</del>
                                    @else
                                        <span class="text-dark fw-bold">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->stock > 0)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">{{ $product->stock }} In Stock</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Out of Stock</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $product->condition }}</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-secondary btn-sm px-2 py-1" title="Edit Part"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this part?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Delete Part"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Fallback Mock items for visualization when DB is empty -->
                            @for($i=1; $i<=4; $i++)
                                <tr>
                                    <td><input type="checkbox" class="product-checkbox" value="{{ $i }}"></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width: 50px; height: 50px; background-color: #f5f5f5; border-radius: 6px; overflow: hidden;">
                                                <img src="https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=100&auto=format&fit=crop" alt="Part" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block" style="font-size: 15px;">2.5L Camry Engine Block Assembly (OEM)</span>
                                                <span class="text-muted small">Brand: Toyota</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><code>ENG-CAM-2018-{{ $i }}</code></td>
                                    <td>Used Engines</td>
                                    <td><span class="text-dark fw-bold">$1,450.00</span></td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">1 In Stock</span></td>
                                    <td><span class="badge bg-light text-dark border">Used</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="alert('Mock Edit Triggered')"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-outline-danger btn-sm px-2 py-1" onclick="alert('Mock Delete Triggered')"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination footer -->
        @if($products->hasPages())
            <div class="admin-card-footer border-top p-3 bg-light">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <span class="text-muted small">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} parts</span>
                    </div>
                    <div>
                        {{ $products->appends(['search' => $search])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Import CSV Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="importModalLabel">Import Products CSV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="small text-muted">Upload a CSV file containing your product information. Your columns should match: <code>Name, SKU, Brand, Price, Stock, Condition</code>.</p>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">SELECT CSV FILE *</label>
                            <input type="file" class="form-control" name="csv_file" accept=".csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Upload & Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('admin-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const bulkBtn = document.getElementById('bulkDeleteBtn');
            const selectedCount = document.getElementById('selectedCount');

            const updateBulkDeleteButton = () => {
                const checked = document.querySelectorAll('.product-checkbox:checked');
                selectedCount.textContent = checked.length;
                if (checked.length > 0) {
                    bulkBtn.classList.remove('d-none');
                } else {
                    bulkBtn.classList.add('d-none');
                }
            };

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(c => c.checked = this.checked);
                updateBulkDeleteButton();
            });

            checkboxes.forEach(c => {
                c.addEventListener('change', updateBulkDeleteButton);
            });
        });

        function runBulkDelete() {
            if (confirm('Are you sure you want to delete all selected parts?')) {
                const checked = document.querySelectorAll('.product-checkbox:checked');
                const ids = Array.from(checked).map(c => c.value);
                
                // Mock AJAX bulk delete action trigger
                alert('Bulk Delete complete (Mockup) for IDs: ' + ids.join(', '));
                window.location.reload();
            }
        }
    </script>
@endpush
