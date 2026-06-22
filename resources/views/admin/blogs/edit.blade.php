@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Edit Article</h2>
            <span class="text-muted small">Edit tutorials, update SEO parameters, and schedule publishes.</span>
        </div>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back to List</a>
    </div>

    <!-- Main Edit Form -->
    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            
            <!-- Left Side: Main Content Editor & Settings -->
            <div class="col-lg-8 col-12">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <span><i class="fa fa-edit text-danger me-2"></i>Article Editor</span>
                    </div>
                    <div class="admin-card-body text-dark">
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">ARTICLE TITLE *</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $blog->title) }}" required>
                        </div>
                        
                        <!-- Summary -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">SUMMARY / EXCERPT</label>
                            <textarea class="form-control" name="summary" rows="2" placeholder="Brief summary of the article...">{{ old('summary', $blog->summary) }}</textarea>
                        </div>

                        <!-- Rich Content Area placeholder -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">ARTICLE CONTENT *</label>
                            <div class="p-2 bg-light border border-bottom-0 rounded-top d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-light border py-1 px-2" onclick="alert('Bold tag inserted (Mockup)')"><i class="fa fa-bold"></i></button>
                                <button type="button" class="btn btn-sm btn-light border py-1 px-2" onclick="alert('Italic tag inserted (Mockup)')"><i class="fa fa-italic"></i></button>
                                <button type="button" class="btn btn-sm btn-light border py-1 px-2" onclick="alert('Link tag inserted (Mockup)')"><i class="fa fa-link"></i></button>
                                <button type="button" class="btn btn-sm btn-light border py-1 px-2" onclick="alert('Blockquote tag inserted (Mockup)')"><i class="fa fa-quote-left"></i></button>
                            </div>
                            <textarea class="form-control rounded-bottom font-poppins" name="content" rows="12" placeholder="Start writing article HTML / Text here..." required style="border-top: none;">{{ old('content', $blog->content) }}</textarea>
                            <span class="text-muted small d-block mt-1"><i class="fa fa-info-circle me-1"></i> Editor supports raw HTML structures and custom layout parameters.</span>
                        </div>
                    </div>
                </div>

                <!-- FAQ Schema Builder Card -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <span><i class="fa fa-question-circle text-danger me-2"></i>FAQ Schema Builder (JSON-LD ready)</span>
                    </div>
                    <div class="admin-card-body text-dark">
                        <p class="small text-muted">Add FAQ questions and answers to generate structural Google search snippets.</p>
                        <div id="faqBuilderContainer">
                            @if($blog->faq_schema && is_array($blog->faq_schema))
                                @foreach($blog->faq_schema as $index => $faq)
                                    <div class="row g-2 mb-2 faq-item-row {{ $index > 0 ? 'border-top pt-2 mt-2' : '' }}">
                                        <div class="col-12">
                                            <input type="text" class="form-control form-control-sm mb-1 fw-bold" name="faq_questions[]" value="{{ $faq['question'] ?? '' }}" placeholder="Question e.g. What warranty is offered?">
                                            <textarea class="form-control form-control-sm" name="faq_answers[]" rows="2" placeholder="Answer text details...">{{ $faq['answer'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm py-1 px-2 remove-faq-btn"><i class="fa fa-trash-can me-1"></i> Remove FAQ</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row g-2 mb-2 faq-item-row">
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm mb-1 fw-bold" name="faq_questions[]" placeholder="Question e.g. What warranty is offered?">
                                        <textarea class="form-control form-control-sm" name="faq_answers[]" rows="2" placeholder="Answer text details..."></textarea>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm py-1 px-2 remove-faq-btn"><i class="fa fa-trash-can me-1"></i> Remove FAQ</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-3" id="addFaqRowBtn"><i class="fa fa-plus me-1"></i> Add FAQ Question</button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Publishing Options & SEO Manager -->
            <div class="col-lg-4 col-12">
                
                <!-- Status Box -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <span><i class="fa fa-paper-plane text-danger me-2"></i>Publish Settings</span>
                    </div>
                    <div class="admin-card-body text-dark">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">STATUS</label>
                            <select class="form-select" name="status" id="statusSelect">
                                <option value="draft" {{ $blog->status == 'draft' ? 'selected' : '' }}>Draft (Save offline)</option>
                                <option value="published" {{ $blog->status == 'published' ? 'selected' : '' }}>Publish Immediately</option>
                                <option value="scheduled" {{ $blog->status == 'scheduled' ? 'selected' : '' }}>Schedule Publication</option>
                            </select>
                        </div>
                        
                        <!-- Scheduled publish field -->
                        <div class="mb-3 {{ $blog->status == 'scheduled' ? '' : 'd-none' }}" id="scheduledField">
                            <label class="form-label small fw-bold">SCHEDULE PUBLISH DATE *</label>
                            <input type="datetime-local" class="form-control" name="published_at" value="{{ $blog->published_at ? date('Y-m-d\TH:i', strtotime($blog->published_at)) : '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">FEATURED IMAGE</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            @if($blog->image)
                                <div class="mt-2">
                                    <img src="{{ $blog->image }}" class="img-fluid rounded border" style="max-height: 150px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">CATEGORY</label>
                            <input type="text" class="form-control" name="category" value="{{ old('category', $blog->category) }}" placeholder="e.g. Buying Guides">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">TAGS (COMMA SEPARATED)</label>
                            <input type="text" class="form-control" name="tags_input" value="{{ $blog->tags ? implode(', ', $blog->tags) : '' }}" placeholder="e.g. engine, toyota, buying tip">
                        </div>
                    </div>
                </div>

                <!-- SEO parameters Box -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <span><i class="fa fa-search text-danger me-2"></i>SEO Parameters</span>
                    </div>
                    <div class="admin-card-body text-dark">
                        <div class="mb-2">
                            <label class="form-label small text-muted fw-bold">META TITLE</label>
                            <input type="text" class="form-control form-control-sm" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}" placeholder="SEO Title">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small text-muted fw-bold">CANONICAL URL</label>
                            <input type="text" class="form-control form-control-sm" name="canonical_url" value="{{ old('canonical_url', $blog->canonical_url) }}" placeholder="https://...">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small text-muted fw-bold">META KEYWORDS</label>
                            <input type="text" class="form-control form-control-sm" name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords) }}" placeholder="engine tips, used panels">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">META DESCRIPTION</label>
                            <textarea class="form-control form-control-sm" name="meta_description" rows="3" placeholder="SEO Description...">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        </div>
                        <div>
                            <label class="form-label small text-muted fw-bold">CUSTOM ARTICLE SCHEMA (JSON-LD)</label>
                            <textarea class="form-control form-control-sm font-monospace" name="article_schema" rows="4" placeholder="{&quot;@@type&quot;: &quot;NewsArticle&quot;}">{{ old('article_schema', $blog->article_schema) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save me-1"></i> Update Article</button>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                </div>

            </div>

        </div>
    </form>

@endsection

@push('admin-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Scheduled date toggle
            const statusSelect = document.getElementById('statusSelect');
            const scheduledField = document.getElementById('scheduledField');

            statusSelect.addEventListener('change', function () {
                if (this.value === 'scheduled') {
                    scheduledField.classList.remove('d-none');
                } else {
                    scheduledField.classList.add('d-none');
                }
            });

            // FAQ Builder
            const faqContainer = document.getElementById('faqBuilderContainer');
            const addFaqBtn = document.getElementById('addFaqRowBtn');

            addFaqBtn.addEventListener('click', function () {
                const newRow = document.createElement('div');
                newRow.className = 'row g-2 mb-2 faq-item-row border-top pt-2 mt-2';
                newRow.innerHTML = `
                    <div class="col-12">
                        <input type="text" class="form-control form-control-sm mb-1 fw-bold" name="faq_questions[]" placeholder="Question">
                        <textarea class="form-control form-control-sm" name="faq_answers[]" rows="2" placeholder="Answer details..."></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm py-1 px-2 remove-faq-btn"><i class="fa fa-trash-can me-1"></i> Remove FAQ</button>
                    </div>
                `;
                faqContainer.appendChild(newRow);
                bindRemoveButtons();
            });

            function bindRemoveButtons() {
                document.querySelectorAll('.remove-faq-btn').forEach(btn => {
                    btn.onclick = function() { this.closest('.faq-item-row').remove(); };
                });
            }

            bindRemoveButtons();
        });
    </script>
@endpush
