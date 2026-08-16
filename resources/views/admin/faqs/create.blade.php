@extends('admin.layouts.app')

@section('title', 'Create FAQ')

@section('content')
    <div class="page-header">
        <div>
            <h1>Create FAQ</h1>
            <p class="subtitle">Add a new question</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.faqs.store') }}">
        @csrf
        @include('admin.faqs._form')
    </form>
@endsection
