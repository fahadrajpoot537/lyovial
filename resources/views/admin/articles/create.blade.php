@extends('admin.layouts.app')

@section('title', 'Create article')

@section('content')
    <div class="page-header">
        <div>
            <h1>Create article</h1>
            <p class="subtitle">Insights &amp; case notes</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.articles._form')
    </form>
@endsection
