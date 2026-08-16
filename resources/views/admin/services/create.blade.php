@extends('admin.layouts.app')

@section('title', 'Create service')

@section('content')
    <div class="page-header">
        <div>
            <h1>Create service</h1>
            <p class="subtitle">Add a new service</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.services._form')
    </form>
@endsection
