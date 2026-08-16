@extends('admin.layouts.app')

@section('title', 'Edit industry')

@section('content')
    <div class="page-header">
        <div>
            <h1>Edit industry</h1>
            <p class="subtitle">{{ $industry->title }}</p>
        </div>
        <a href="{{ route('admin.industries.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.industries.update', $industry) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.industries._form', ['industry' => $industry])
    </form>
@endsection
