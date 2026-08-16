@php
    $faq = $faq ?? null;
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-admin">
            <div class="card-header">FAQ details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="question">Question</label>
                    <input type="text" name="question" id="question" class="form-control @error('question') is-invalid @enderror"
                           value="{{ old('question', $faq?->question) }}" required>
                    @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-0">
                    <label class="form-label" for="answer">Answer</label>
                    @include('admin.partials.editor', ['name' => 'answer', 'id' => 'answer', 'value' => $faq?->answer])
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-admin">
            <div class="card-header">Publish</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="section">Section</label>
                    <input type="text" name="section" id="section" class="form-control" value="{{ old('section', $faq?->section ?? 'home') }}" placeholder="home">
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" @checked(old('status', $faq?->status ?? true))>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $faq?->sort_order ?? 0) }}">
                </div>
                <button type="submit" class="btn btn-teal w-100">{{ $faq ? 'Update FAQ' : 'Create FAQ' }}</button>
            </div>
        </div>
    </div>

    <div class="col-12">
        @include('admin.partials.seo-fields', ['seo' => $faq?->seo, 'hideSeoSlug' => true, 'seoSourceTitle' => old('question', $faq?->question)])
    </div>
</div>
