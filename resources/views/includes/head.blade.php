{!! get_metas() !!}
<meta name="csrf-token" content="{{ csrf_token() }}">
@if ($favicon = $theme->favicon)
    <link href="{{ media_url($favicon) }}" rel="shortcut icon" type="image/ico">
@elseif ($site_logo !== 'no_photo.png')
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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="{{ $theme->font['url'] ?? 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
@themeStyles
@if (!empty($theme->custom_css))
    <style>{{ $theme->custom_css }}</style>
@endif
