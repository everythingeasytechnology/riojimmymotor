@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title -->
    <div class="mb-4">
        <h2 class="fw-bold m-0" style="font-size: 28px;">SEO Management System</h2>
        <span class="text-muted small">Configure global SEO configurations, site verification tags, and custom schemas.</span>
    </div>

    <!-- SEO Configurations Form -->
    <form action="{{ route('admin.seo.update') }}" method="POST">
        @csrf

        <div class="row g-4">
            
            <!-- Left Side: Main configurations -->
            <div class="col-lg-8 col-12">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <span><i class="fa fa-search text-danger me-2"></i>Global Metadata Parameters</span>
                    </div>
                    <div class="admin-card-body text-dark">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">HOMEPAGE META TITLE *</label>
                            <input type="text" class="form-control" name="meta_title" value="{{ $seo_settings['meta_title'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">HOMEPAGE META DESCRIPTION *</label>
                            <textarea class="form-control" name="meta_description" rows="4" required>{{ $seo_settings['meta_description'] }}</textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 col-12">
                                <label class="form-label small fw-bold">CANONICAL BASE URL</label>
                                <input type="text" class="form-control" name="canonical_url" value="{{ $seo_settings['canonical_url'] }}">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label small fw-bold">ROBOTS META INSTRUCTION</label>
                                <select class="form-select" name="robots_meta">
                                    <option value="index, follow" {{ $seo_settings['robots_meta'] === 'index, follow' ? 'selected' : '' }}>Index, Follow (Default)</option>
                                    <option value="noindex, follow" {{ $seo_settings['robots_meta'] === 'noindex, follow' ? 'selected' : '' }}>Noindex, Follow</option>
                                    <option value="noindex, nofollow" {{ $seo_settings['robots_meta'] === 'noindex, nofollow' ? 'selected' : '' }}>Noindex, Nofollow (Private)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Structured Schema Injectors -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <span><i class="fa fa-code text-danger me-2"></i>JSON-LD Schema Markup Generators</span>
                    </div>
                    <div class="admin-card-body text-dark">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">ORGANIZATION SCHEMA (JSON-LD)</label>
                            <textarea class="form-control font-monospace" name="schema_organization" rows="6" placeholder="{&quot;@@type&quot;: &quot;Organization&quot;}">{{ $seo_settings['schema_organization'] }}</textarea>
                        </div>
                        <div>
                            <label class="form-label small fw-bold">LOCAL BUSINESS SCHEMA (JSON-LD)</label>
                            <textarea class="form-control font-monospace" name="schema_local_business" rows="6" placeholder="{&quot;@@type&quot;: &quot;LocalBusiness&quot;}">{{ $seo_settings['schema_local_business'] }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Verification Tags & Save Actions -->
            <div class="col-lg-4 col-12">
                <!-- Search Console & Webmasters Verification Code -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <span><i class="fa fa-circle-check text-danger me-2"></i>Webmaster Tools Verifications</span>
                    </div>
                    <div class="admin-card-body text-dark">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">GOOGLE SEARCH CONSOLE CODE</label>
                            <input type="text" class="form-control form-control-sm" placeholder="google-site-verification=..." onclick="alert('Verification codes are saved via Settings Panel (Mockup)')">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">BING WEBMASTER VERIFICATION</label>
                            <input type="text" class="form-control form-control-sm" placeholder="msvalidate.01=...">
                        </div>
                        <div>
                            <label class="form-label small fw-bold text-muted">PINTEREST VERIFICATION CODE</label>
                            <input type="text" class="form-control form-control-sm" placeholder="pinterest-site-verification=...">
                        </div>
                    </div>
                </div>

                <!-- Submit Action button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save me-1"></i> Save SEO Settings</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="alert('All Sitemap configurations are generated dynamically at /sitemap.xml (Mockup)')"><i class="fa fa-sitemap me-1"></i> Generate Sitemap</button>
                </div>
            </div>

        </div>
    </form>

@endsection
