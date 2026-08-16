@extends('admin.layouts.app')

@section('title', 'Create page')

@section('content')
    <div class="page-header">
        <div>
            <h1>Create page</h1>
            <p class="subtitle">Add a new CMS page</p>
        </div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.pages._form')
    </form>
@endsection
