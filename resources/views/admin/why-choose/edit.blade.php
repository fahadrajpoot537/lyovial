@extends('admin.layouts.app')

@section('title', 'Edit why choose item')

@section('content')
    <div class="page-header">
        <div>
            <h1>Edit item</h1>
            <p class="subtitle">{{ $item->title }}</p>
        </div>
        <a href="{{ route('admin.why-choose.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.why-choose.update', $item) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.why-choose._form', ['item' => $item])
    </form>
@endsection
