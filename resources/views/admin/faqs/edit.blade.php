@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')
    <div class="page-header">
        <div>
            <h1>Edit FAQ</h1>
            <p class="subtitle">{{ \Illuminate\Support\Str::limit($faq->question, 60) }}</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
        @csrf
        @method('PUT')
        @include('admin.faqs._form', ['faq' => $faq])
    </form>
@endsection
