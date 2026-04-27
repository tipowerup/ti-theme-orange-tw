<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

@include('tipowerup.theme-toolkit::_partials.dark-mode-head')

{!! get_metas() !!}

@if ($favicon = $theme->favicon ?? null)
    <link href="{{ media_url($favicon) }}" rel="shortcut icon" type="image/ico">
@elseif (($site_logo ?? '') !== 'no_photo.png')
    <link href="{{ media_thumb($site_logo, ['width' => 64, 'height' => 64]) }}" rel="shortcut icon" type="image/ico">
@else
    {!! get_favicon() !!}
@endif

<title>{{ lang(get_title()).lang('tipowerup.orange-tw::default.title_separator').setting('site_name') }}</title>

@if ($page->description ?? false)
    <meta name="description" content="{{ $page->description }}">
@endif
@if ($page->keywords ?? false)
    <meta name="keywords" content="{{ $page->keywords }}">
@endif

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="{{ ($themeData['font']['url'] ?? null) ?: 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">

{{--
    Font Awesome, Flatpickr (base + theme overrides), intl-tel-input CSS are
    bundled via Vite — see resources/src/css/app.css and app.js.
    Flatpickr theme overrides live in resources/src/css/flatpickr.css.
--}}

{{-- Theme Styles - Uses TastyIgniter's native asset system via assets.json --}}
@themeStyles

{{-- Custom CSS - Admin-configured values - XSS risk accepted for admin users --}}
@if (!empty($theme->custom_css))
    <style>{!! $theme->custom_css !!}</style>
@endif
