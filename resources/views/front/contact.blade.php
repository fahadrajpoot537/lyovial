@extends('front.layouts.lyovial-home')

@php
    $seo = $contact->seo;
    $banner = \App\Support\SiteImages::resolve($contact->banner_image, \App\Support\SiteImages::get('banner_contact'));
    $phone = $contact->phone ?: ($sitePhone ?? '');
    $email = $contact->email ?: ($siteEmail ?? '');
    $address = $contact->address ?: ($siteAddress ?? '');
    $includeItems = collect(preg_split('/\r\n|\r|\n/', strip_tags(str_replace(['</li>', '<br>', '<br/>', '<br />'], "\n", $contact->what_to_include_content ?? ''))))
        ->map(fn ($line) => trim(html_entity_decode($line)))
        ->filter()
        ->values();
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])

@include('front.partials.page-banner', [
    'bannerTitle' => $contact->heading ?: 'Contact',
    'bannerImage' => $banner,
])

<section class="contact-main">
  <div class="container">
    <div class="contact-grid">
      <div class="contact-form-panel">
        <h2>{{ $contact->form_heading ?: 'Start a Project' }}</h2>
        <p>{{ strip_tags($contact->description ?: 'Tell us about your formulation, target batch size, and timeline, and we\'ll follow up to talk through next steps.') }}</p>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}" class="contact-form">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label for="name">Name</label>
              <input type="text" name="name" id="name" value="{{ old('name') }}" required class="@error('name') is-invalid @enderror">
              @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" required class="@error('email') is-invalid @enderror">
              @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label for="phone">Phone</label>
              <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
            </div>
            <div class="col-md-6">
              <label for="company">Company <span style="font-weight:500;color:#8a97a0">(optional)</span></label>
              <input type="text" name="company" id="company" value="{{ old('company') }}" class="@error('company') is-invalid @enderror">
              @error('company')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label for="message">Message</label>
              <textarea name="message" id="message" rows="5" required class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
              @error('message')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary contact-submit">Submit</button>
            </div>
          </div>
        </form>
      </div>

      <div class="contact-side">
        <h3>Contact Details</h3>
        <ul class="contact-details list-unstyled">
          @if($phone)
            <li><i class="bi bi-telephone"></i><a href="tel:{{ preg_replace('/\D+/', '', $phone) }}">{{ $phone }}</a></li>
          @endif
          @if($email)
            <li><i class="bi bi-envelope"></i><a href="mailto:{{ $email }}">{{ $email }}</a></li>
          @endif
          @if($address)
            <li><i class="bi bi-geo-alt"></i><span>{!! nl2br(e($address)) !!}</span></li>
          @endif
        </ul>

        @if($contact->what_to_include_heading || $includeItems->isNotEmpty() || $contact->what_to_include_content)
          <h3 class="mt-4">{{ $contact->what_to_include_heading ?: 'What to Include When You Reach Out' }}</h3>
          @if($includeItems->isNotEmpty())
            <ul class="contact-checklist">
              @foreach($includeItems as $item)
                <li><i class="bi bi-check-circle-fill"></i><span>{{ $item }}</span></li>
              @endforeach
            </ul>
          @else
            <div class="contact-rich">{!! $contact->what_to_include_content !!}</div>
          @endif
        @endif

        @if($contact->how_can_we_help_heading || $contact->how_can_we_help_content)
          <h3 class="mt-4">{{ $contact->how_can_we_help_heading ?: 'How Can We Help You?' }}</h3>
          <div class="contact-rich">{{ strip_tags($contact->how_can_we_help_content) }}</div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
.contact-main{padding:70px 0 90px;background:#fff}
.contact-grid{display:grid;grid-template-columns:1.15fr .85fr;gap:48px;align-items:start}
.contact-form-panel{background:#f3f5f7;padding:36px 32px;border-radius:4px}
.contact-form-panel h2,.contact-side h3{color:#0e7c86;font-weight:800;margin-bottom:12px}
.contact-form-panel p,.contact-rich,.contact-details,.contact-checklist{color:#4A5A67;line-height:1.7}
.contact-form label{display:block;font-size:13px;font-weight:600;color:#0e7c86;margin-bottom:6px}
.contact-form input,.contact-form textarea{
  width:100%;border:1px solid #d7dde3;background:#fff;padding:12px 14px;border-radius:4px;color:#0e7c86;
}
.contact-form input:focus,.contact-form textarea:focus{outline:none;border-color:#0e7c86}
.contact-submit{width:100%;margin-top:8px}
.contact-details li{display:flex;gap:12px;align-items:flex-start;margin-bottom:14px}
.contact-details i{color:#0e7c86;margin-top:3px}
.contact-details a{color:#0e7c86;text-decoration:none;font-weight:500}
.contact-checklist{list-style:none;padding:0;margin:0}
.contact-checklist li{display:flex;gap:10px;align-items:flex-start;margin-bottom:12px}
.contact-checklist i{color:#0e7c86;flex-shrink:0;margin-top:2px}
@media (max-width:992px){
  .contact-grid{grid-template-columns:1fr;gap:36px}
}
</style>
@endpush
