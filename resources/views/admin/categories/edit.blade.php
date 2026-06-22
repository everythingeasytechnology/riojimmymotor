@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Edit Category</h2>
            <span class="text-muted small">Update category metadata, parent relationships, and SEO tags.</span>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back to List</a>
    </div>

    <!-- Edit Workspace -->
    <div class="row g-4">
        <div class="col-lg-8 col-12 mx-auto">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span><i class="fa fa-folder-open text-danger me-2"></i>Category Information</span>
                </div>
                <div class="admin-card-body text-dark bg-white rounded-bottom">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6 col-12">
                                <label class="form-label small fw-bold">CATEGORY NAME *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label small fw-bold">PARENT CATEGORY</label>
                                <select class="form-select" name="parent_id">
                                    <option value="">None (Top Level)</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">CATEGORY IMAGE</label>
                                <input type="file" class="form-control mb-2" name="image" accept="image/*">
                                @if($category->image)
                                    <div class="mb-2">
                                        <img src="{{ $category->image }}" class="rounded border" style="max-height: 100px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">DESCRIPTION</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Category description details...">{{ old('description', $category->description) }}</textarea>
                            </div>

                            <div class="col-12">
                                <hr class="my-4">
                                <h5 class="fw-bold mb-3"><i class="fa fa-search text-danger me-2"></i>Category SEO Tags</h5>
                            </div>

                            <div class="col-md-6 col-12">
                                <label class="form-label small fw-bold text-muted">META TITLE</label>
                                <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" placeholder="SEO Title">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label small fw-bold text-muted">CANONICAL URL</label>
                                <input type="text" class="form-control" name="canonical_url" value="{{ old('canonical_url', $category->canonical_url) }}" placeholder="https://...">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">META DESCRIPTION</label>
                                <textarea class="form-control" name="meta_description" rows="3" placeholder="SEO Description...">{{ old('meta_description', $category->meta_description) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
