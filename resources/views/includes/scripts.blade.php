{{-- TastyIgniter JS Variables (creates window.app object) --}}
{!! Assets::getJsVars() !!}

{{-- Theme bundle — loaded directly (stable URL) so Livewire's wire:navigate
     dedupes by src. Cannot go through @themeScripts because that combines it
     with per-page Assets::addJs files into a hashed URL that changes per page,
     causing duplicate-declaration errors on navigation. --}}
<script src="/vendor/tipowerup-orange-tw/js/app.js" data-navigate-once></script>

{{-- Per-page extension JS registered via Assets::addJs (starrating, booking, leaflet, etc.) --}}
@themeScripts

@stack('scripts')

{{-- GA Tracking Code --}}
{!! $theme->ga_tracking_code ?? '' !!}

{{-- Custom JS from theme settings --}}
@if (!empty($theme->custom_js))
    <script type="text/javascript">{!! $theme->custom_js !!}</script>
@endif
