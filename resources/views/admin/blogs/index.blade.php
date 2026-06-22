@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Blog Post Management</h2>
            <span class="text-muted small">Publish buying guidelines, troubleshooting advice, and auto repair tutorials.</span>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i> Add Article</a>
    </div>

    <!-- Blogs List Table Card -->
    <div class="admin-card">
        <div class="admin-card-header">
            <span><i class="fa fa-newspaper text-danger me-2"></i>Published Articles</span>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0 text-dark font-poppins">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Image</th>
                            <th>Article Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Published Date</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td>
                                    <div style="width: 60px; height: 40px; background-color: #f5f5f5; border-radius: 4px; overflow: hidden;">
                                        <img src="{{ $blog->image ?? '/frontend/images/part-default.jpg' }}" alt="Post" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark d-block" style="font-size: 15px;">{{ $blog->title }}</span>
                                    <span class="text-muted small">Slug: <code>{{ $blog->slug }}</code></span>
                                </td>
                                <td>{{ $blog->author->name ?? 'Admin Specialist' }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $blog->category ?? 'General' }}</span></td>
                                <td>
                                    @if($blog->status === 'published')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Published</span>
                                    @elseif($blog->status === 'scheduled')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Scheduled</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $blog->published_at ? $blog->published_at->format('Y-m-d H:i') : 'Not Set' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="alert('Mock Edit article ID: {{ $blog->id }}')"><i class="fa fa-edit"></i></button>
                                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Delete this article?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Fallback Mock items for visualization when DB is empty -->
                            <tr>
                                <td><div style="width: 60px; height: 40px; background-color: #f5f5f5; border-radius: 4px;"></div></td>
                                <td>
                                    <span class="fw-bold text-dark d-block" style="font-size: 15px;">What to Check Before Buying a Used Engine Online</span>
                                    <span class="text-muted small">Slug: <code>buying-used-engine-online</code></span>
                                </td>
                                <td>Richard Cooper</td>
                                <td><span class="badge bg-light text-dark border">Buying Guides</span></td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle">Published</span></td>
                                <td>2026-06-18 10:00</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="alert('Mock Edit')"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-outline-danger btn-sm px-2 py-1" onclick="alert('Mock Delete')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div style="width: 60px; height: 40px; background-color: #f5f5f5; border-radius: 4px;"></div></td>
                                <td>
                                    <span class="fw-bold text-dark d-block" style="font-size: 15px;">OEM vs. Aftermarket Parts: Which Is Better for Resale Value?</span>
                                    <span class="text-muted small">Slug: <code>oem-vs-aftermarket-parts</code></span>
                                </td>
                                <td>Richard Cooper</td>
                                <td><span class="badge bg-light text-dark border">OEM Comparisons</span></td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle">Published</span></td>
                                <td>2026-06-10 11:30</td>
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

@endsection
