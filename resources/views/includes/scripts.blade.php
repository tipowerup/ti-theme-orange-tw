{{-- Theme JavaScript --}}
@vite(['resources/src/js/app.js'], 'vendor/tipowerup-orange-tw/build')

{{-- Custom JS from theme settings --}}
@if (!empty($theme->custom_js))
    <script type="text/javascript">{!! $theme->custom_js !!}</script>
@endif

@stack('scripts')
