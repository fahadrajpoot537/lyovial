@php $favicon = \App\Support\SiteFavicon::resolve(); @endphp
<link rel="icon" href="{{ $favicon['href'] }}" type="{{ $favicon['type'] }}">
<link rel="shortcut icon" href="{{ $favicon['href'] }}" type="{{ $favicon['type'] }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ $favicon['png32'] }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ $favicon['png16'] }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ $favicon['apple'] }}">
