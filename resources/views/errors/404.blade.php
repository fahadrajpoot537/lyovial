@extends('errors.layout')

@section('title', 'Page Not Found')

@section('content')
    <p class="error-code">404</p>
    <h1 class="error-message">Page not found</h1>
    <p class="error-copy">The page you requested is not available. It may have moved, or the link may be outdated.</p>
    <div class="error-actions">
        <a href="{{ url('/') }}" class="error-btn error-btn-primary">Back to homepage</a>
        <a href="{{ url('/contact') }}" class="error-btn error-btn-secondary">Contact LyoVial</a>
    </div>
@endsection
