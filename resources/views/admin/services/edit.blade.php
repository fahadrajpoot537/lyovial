@extends('admin.layouts.app')

@section('title', 'Edit service')

@section('content')
    <div class="page-header">
        <div>
            <h1>Edit service</h1>
            <p class="subtitle">{{ $service->title }}</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.services._form', ['service' => $service])
    </form>
@endsection
