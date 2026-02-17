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

{{-- Font Awesome Icons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Flatpickr Date Picker --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

{{-- Flatpickr Theme Overrides - Must load after flatpickr base CSS --}}
<style>
    .flatpickr-calendar {
        background: rgb(var(--color-body));
        border: 1px solid rgb(var(--color-border));
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .flatpickr-calendar.inline {
        box-shadow: none;
    }
    .flatpickr-months {
        background: rgb(var(--color-surface));
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .flatpickr-months .flatpickr-month {
        color: rgb(var(--color-text));
        fill: rgb(var(--color-text));
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        color: rgb(var(--color-text));
        font-weight: 600;
        background: transparent;
    }
    .flatpickr-current-month input.cur-year {
        color: rgb(var(--color-text));
        font-weight: 600;
    }
    .dark .flatpickr-current-month input.cur-year {
        color: rgb(var(--color-text));
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
        background: rgb(var(--color-surface));
    }
    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
        fill: rgb(var(--color-text));
    }
    .flatpickr-months .flatpickr-prev-month:hover svg,
    .flatpickr-months .flatpickr-next-month:hover svg {
        fill: rgb(var(--color-primary));
    }
    .flatpickr-weekdays {
        background: rgb(var(--color-surface));
    }
    span.flatpickr-weekday {
        color: rgb(var(--color-text-muted));
        font-weight: 500;
    }
    .flatpickr-days {
        border-color: rgb(var(--color-border));
    }
    .dayContainer {
        background: rgb(var(--color-body));
    }
    .flatpickr-day {
        color: rgb(var(--color-text));
        border-radius: 0.5rem;
    }
    .flatpickr-day:hover {
        background: rgb(var(--color-surface));
        border-color: rgb(var(--color-surface));
    }
    .flatpickr-day.today {
        border-color: rgb(var(--color-primary));
    }
    .flatpickr-day.today:hover {
        background: rgb(var(--color-primary) / 0.1);
    }
    .flatpickr-day.selected,
    .flatpickr-day.selected:hover,
    .flatpickr-day.selected:focus,
    span.flatpickr-day.selected,
    span.flatpickr-day.selected:hover,
    span.flatpickr-day.selected:focus {
        background: #ff4900;
        background-color: #ff4900;
        border-color: #ff4900;
        color: #ffffff;
    }
    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.flatpickr-disabled:hover {
        color: rgb(var(--color-text-muted));
        opacity: 0.5;
    }
    .flatpickr-day.prevMonthDay,
    .flatpickr-day.nextMonthDay {
        color: rgb(var(--color-text-muted));
    }
    .flatpickr-day.prevMonthDay:hover,
    .flatpickr-day.nextMonthDay:hover {
        background: rgb(var(--color-surface));
        border-color: rgb(var(--color-surface));
    }
    .flatpickr-time {
        border-top: 1px solid rgb(var(--color-border));
    }
    .flatpickr-time input,
    .flatpickr-time .flatpickr-am-pm {
        color: rgb(var(--color-text));
    }
    .numInputWrapper:hover {
        background: rgb(var(--color-surface));
    }
    .numInputWrapper span {
        border-color: rgb(var(--color-border));
    }
    .numInputWrapper span:hover {
        background: rgb(var(--color-surface));
    }
    .numInputWrapper span svg path {
        fill: rgb(var(--color-text-muted));
    }
</style>

{{-- Theme Styles - Uses TastyIgniter's native asset system via assets.json --}}
@themeStyles

{{-- Custom CSS - Admin-configured values - XSS risk accepted for admin users --}}
@if (!empty($theme->custom_css))
    <style>{!! $theme->custom_css !!}</style>
@endif
