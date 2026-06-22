@extends('frontend.layouts.master')

@section('meta_title', 'Used Car Buying Guides & Repair Articles | Auto Parts Marketplace')
@section('meta_description', 'Read tips on inspecting engines, transmissions, headlights, wheels, and body parts. Sourcing guides and automotive advice written by mechanics.')

@section('content')

    <!-- Breadcrumb Header -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog &amp; Guides</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Blog Listing Section -->
    <section class="py-5 bg-white">
        <div class="container">

            <!-- Section Heading -->
            <div class="row mb-5 text-center text-md-start">
                <div class="col-lg-8">
                    <span class="text-danger fw-bold text-uppercase small" style="letter-spacing: 2px;">Expert Advice</span>
                    <h1 class="mt-2 fw-800 text-dark" style="font-size: 38px;">Auto Parts Guides &amp; Salvage Tips</h1>
                    <p class="text-muted">Stay up to date with mechanical tips, diagnostic tutorials, and OEM parts buying guidelines.</p>
                </div>
            </div>

            {{-- Featured Article block — shows the first (most recent) post as a hero card --}}
            @php
                // Pull the most recently published post to use as the featured hero block
                $featured = $blogs->first();
            @endphp

            @if($featured)
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border overflow-hidden shadow-sm bg-light" style="border-radius: 12px;">
                            <div class="row g-0">
                                {{-- Featured image — use the stored image or a reliable placeholder --}}
                                @php
                                    $featuredImg = $featured->image
                                        ?: 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=1200&auto=format&fit=crop';
                                @endphp
                                <div class="col-lg-7 col-12"
                                     style="min-height: 360px;
                                            background-image: url('{{ $featuredImg }}');
                                            background-size: cover;
                                            background-position: center;">
                                </div>

                                <!-- Featured text panel -->
                                <div class="col-lg-5 col-12 p-4 p-lg-5 d-flex flex-column justify-content-center">
                                    <span class="blog-category">
                                        {{ $featured->category ?: 'Featured Article' }}
                                    </span>
                                    <h2 class="fw-700 text-dark mb-3 mt-2" style="font-size: 26px; line-height: 1.35;">
                                        <a href="{{ route('blog.show', $featured->slug) }}" class="text-dark text-decoration-none">
                                            {{ $featured->title }}
                                        </a>
                                    </h2>
                                    <p class="text-muted">{{ Str::limit($featured->summary, 200) }}</p>

                                    <div class="mt-2 mb-3">
                                        @if($featured->author)
                                            <span class="d-block fw-bold text-dark small">By {{ $featured->author->name }}</span>
                                        @endif
                                        <span class="text-muted small">
                                            {{ $featured->published_at ? $featured->published_at->format('F d, Y') : '' }}
                                        </span>
                                    </div>

                                    <a href="{{ route('blog.show', $featured->slug) }}" class="btn btn-primary align-self-start px-4 py-2">
                                        Read Full Article <i class="fa fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Category Filter Buttons + Keyword Search -->
            <div class="row g-3 mb-4 align-items-center justify-content-between">

                {{-- Dynamic category pill buttons from database --}}
                <div class="col-lg-8 col-12 d-flex flex-wrap gap-2">
                    <a href="{{ url('/blog') }}"
                       class="btn btn-sm px-3 py-2 {{ !request('category') ? 'btn-secondary' : 'btn-outline-secondary' }}">
                        All Articles
                    </a>
                    @foreach($blogCategories as $cat)
                        <a href="{{ url('/blog?category=' . urlencode($cat)) }}"
                           class="btn btn-sm px-3 py-2 {{ request('category') == $cat ? 'btn-secondary' : 'btn-outline-primary' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>

                {{-- Keyword search box — preserves active category filter --}}
                <div class="col-lg-3 col-md-5 col-12">
                    <form action="{{ url('/blog') }}" method="GET" class="input-group">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <input type="text" class="form-control border-secondary-subtle"
                               name="q" placeholder="Search articles..."
                               value="{{ request('q') }}" style="padding: 10px;">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Results count shown only when an active filter is applied --}}
            @if(request('q') || request('category'))
                <div class="mb-4 text-muted small">
                    Showing <strong>{{ $blogs->total() }}</strong> article(s)
                    @if(request('q')) for &ldquo;<strong>{{ request('q') }}</strong>&rdquo;@endif
                    @if(request('category')) in &ldquo;<strong>{{ request('category') }}</strong>&rdquo;@endif
                    &mdash; <a href="{{ url('/blog') }}" class="text-danger text-decoration-none">Clear filters</a>
                </div>
            @endif

            {{-- Blog post grid — renders all paginated posts from the database --}}
            <div class="row g-4 mb-5">
                @forelse($blogs as $blog)
                    @php
                        // Use the stored image or a reliable auto-parts themed placeholder
                        $blogImg = $blog->image
                            ?: 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=600&auto=format&fit=crop';
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card bg-white">
                            <div class="blog-card-img">
                                <span class="blog-date-badge">
                                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Draft' }}
                                </span>
                                <img src="{{ $blogImg }}" alt="{{ $blog->title }}"
                                     style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <div class="blog-card-body">
                                @if($blog->category)
                                    <span class="blog-category">{{ $blog->category }}</span>
                                @endif
                                <h4 class="blog-title">
                                    <a href="{{ route('blog.show', $blog->slug) }}">
                                        {{ Str::limit($blog->title, 65) }}
                                    </a>
                                </h4>
                                <p class="blog-excerpt">{{ Str::limit($blog->summary, 130) }}</p>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="blog-readmore">
                                    Read Article <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty state shown when no posts match the current search or category --}}
                    <div class="col-12 text-center py-5">
                        <i class="fa fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No articles found.</h5>
                        <p class="text-muted small">
                            Try a different keyword or
                            <a href="{{ url('/blog') }}" class="text-danger">browse all articles</a>.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Laravel Bootstrap-5 pagination — only renders when there are multiple pages --}}
            @if($blogs->hasPages())
                <nav aria-label="Blog pagination navigation">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </nav>
            @endif

        </div>
    </section>

    <!-- Call to Action Banner -->
    @include('frontend.components.cta')

@endsection
