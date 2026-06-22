@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title -->
    <div class="mb-4">
        <h2 class="fw-bold m-0" style="font-size: 28px;">Category Management</h2>
        <span class="text-muted small">Manage parts categories hierarchy and SEO meta tags.</span>
    </div>

    <!-- Category Workspace Grid -->
    <div class="row g-4">
        
        <!-- Left Side: Add Category Form -->
        <div class="col-lg-4 col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa fa-folder-plus text-danger me-2"></i>Add New Category</span>
                </div>
                <div class="admin-card-body text-dark">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">CATEGORY NAME *</label>
                            <input type="text" class="form-control" name="name" placeholder="e.g. Used Engines" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">PARENT CATEGORY</label>
                            <select class="form-select" name="parent_id">
                                <option value="">None (Top Level)</option>
                                @foreach($categories->whereNull('parent_id') as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">CATEGORY IMAGE</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">DESCRIPTION</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Category description details..."></textarea>
                        </div>

                        <!-- Category SEO Accordion -->
                        <div class="accordion border rounded mb-4" id="seoAccordion">
                            <div class="accordion-item border-0">
                                <h3 class="accordion-header" id="headingSeo">
                                    <button class="accordion-button collapsed py-2 px-3 small fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeo" aria-expanded="false" aria-controls="collapseSeo" style="font-size: 13px;">
                                        <i class="fa fa-search text-danger me-2"></i> Category SEO Tags
                                    </button>
                                </h3>
                                <div id="collapseSeo" class="accordion-collapse collapse" aria-labelledby="headingSeo" data-bs-parent="#seoAccordion">
                                    <div class="accordion-body p-3">
                                        <div class="mb-2">
                                            <label class="form-label small text-muted">META TITLE</label>
                                            <input type="text" class="form-control form-control-sm" name="meta_title" placeholder="SEO Title">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small text-muted">CANONICAL URL</label>
                                            <input type="text" class="form-control form-control-sm" name="canonical_url" placeholder="https://...">
                                        </div>
                                        <div>
                                            <label class="form-label small text-muted">META DESCRIPTION</label>
                                            <textarea class="form-control form-control-sm" name="meta_description" rows="2" placeholder="SEO Description..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2"><i class="fa fa-save me-1"></i> Save Category</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side: Category List -->
        <div class="col-lg-8 col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa fa-folder-tree text-danger me-2"></i>Categories Tree</span>
                </div>
                <div class="admin-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0 text-dark font-poppins">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">Image</th>
                                    <th>Category Info</th>
                                    <th>Slug</th>
                                    <th>Parent</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <div style="width: 40px; height: 40px; background-color: #f5f5f5; border-radius: 4px; overflow: hidden;">
                                                <img src="{{ $category->image ?? '/frontend/images/part-default.jpg' }}" alt="Cat" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark d-block">{{ $category->name }}</span>
                                            <span class="text-muted small">{{ Str::limit($category->description, 60) }}</span>
                                        </td>
                                        <td><code>{{ $category->slug }}</code></td>
                                        <td>
                                            @if($category->parent)
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $category->parent->name }}</span>
                                            @else
                                                <span class="text-muted small">None (Top Level)</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline-secondary btn-sm px-2 py-1"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Fallback visualization templates -->
                                    <tr>
                                        <td><div style="width: 40px; height: 40px; background-color: #f5f5f5; border-radius: 4px;"></div></td>
                                        <td><span class="fw-bold text-dark d-block">Used Engines</span><span class="text-muted small">Complete motor assemblies</span></td>
                                        <td><code>engines</code></td>
                                        <td><span class="text-muted small">None</span></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="alert('Mock Edit')"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-outline-danger btn-sm px-2 py-1" onclick="alert('Mock Delete')"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div style="width: 40px; height: 40px; background-color: #f5f5f5; border-radius: 4px;"></div></td>
                                        <td><span class="fw-bold text-dark d-block">Used Transmissions</span><span class="text-muted small">Automatic and manual gearboxes</span></td>
                                        <td><code>transmissions</code></td>
                                        <td><span class="text-muted small">None</span></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="alert('Mock Edit')"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-outline-danger btn-sm px-2 py-1" onclick="alert('Mock Delete')"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
