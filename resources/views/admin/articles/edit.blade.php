@extends('admin.layouts.app')

@section('title', 'Edit article')

@section('content')
    <div class="page-header">
        <div>
            <h1>Edit article</h1>
            <p class="subtitle">{{ $item->title }}</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.articles.update', $item) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.articles._form')
    </form>
@endsection
