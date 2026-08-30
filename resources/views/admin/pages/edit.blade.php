@extends('admin.layouts.app')

@section('title', 'Edit page')

@section('content')
    <div class="page-header">
        <div>
            <h1>Edit page</h1>
            <p class="subtitle">{{ $page->title }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ $page->publicUrl() }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">View on site</a>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.pages._form', ['page' => $page])
    </form>
@endsection
