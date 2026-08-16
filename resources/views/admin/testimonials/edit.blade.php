@extends('admin.layouts.app')

@section('title', 'Edit testimonial')

@section('content')
    <div class="page-header">
        <div>
            <h1>Edit testimonial</h1>
            <p class="subtitle">{{ $item->name }}</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.update', $item) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.testimonials._form')
    </form>
@endsection
