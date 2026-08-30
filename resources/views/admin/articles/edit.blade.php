@extends('admin.layouts.app')

@section('title', 'Edit article')

@section('content')
    <div class="page-header">
        <div>
            <h1>Edit article</h1>
            <p class="subtitle">{{ $item->title }}</p>
        </div>
        <div class="d-flex gap-2">
            @if($item->status)
                <a href="{{ route('blog.show', $item) }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">View on site</a>
            @endif
            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.articles.update', $item) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.articles._form')
    </form>
@endsection
