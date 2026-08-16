@extends('admin.layouts.app')

@section('title', 'Create why choose item')

@section('content')
    <div class="page-header">
        <div>
            <h1>Create item</h1>
            <p class="subtitle">Why Choose Us</p>
        </div>
        <a href="{{ route('admin.why-choose.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.why-choose.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.why-choose._form')
    </form>
@endsection
