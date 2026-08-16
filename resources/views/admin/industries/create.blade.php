@extends('admin.layouts.app')

@section('title', 'Create industry')

@section('content')
    <div class="page-header">
        <div>
            <h1>Create industry</h1>
            <p class="subtitle">Add a new industry</p>
        </div>
        <a href="{{ route('admin.industries.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.industries.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.industries._form')
    </form>
@endsection
