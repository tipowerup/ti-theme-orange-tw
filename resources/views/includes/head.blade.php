<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
<link href="{{ $theme->font['url'] ?? 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">

{{-- Theme Styles --}}
@vite(['resources/src/css/app.css'], 'vendor/tipowerup/ti-theme-orange-tw')

{{-- Custom CSS - Admin-configured values - XSS risk accepted for admin users --}}
@if (!empty($theme->custom_css))
    <style>{!! $theme->custom_css !!}</style>
@endif

{{-- GA Tracking Code - Admin-configured values - XSS risk accepted for admin users --}}
@if (!empty($theme->ga_tracking_code))
    {!! $theme->ga_tracking_code !!}
@endif
