@extends('admin.layouts.app')

@section('title', 'Create testimonial')

@section('content')
    <div class="page-header">
        <div>
            <h1>Create testimonial</h1>
            <p class="subtitle">Homepage quotes</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.testimonials._form')
    </form>
@endsection
