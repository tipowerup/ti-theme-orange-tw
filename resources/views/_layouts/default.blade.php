---
description: Default layout
---
<!DOCTYPE html>
<html
    xmlns="http://www.w3.org/1999/xhtml"
    lang="{{ App::getLocale() }}"
    class="h-full"
    x-data="darkMode()"
    :class="{ 'dark': isDark }"
>
<head>
    <meta name="view-transition" content="same-origin">
    @include('tipowerup-orange-tw::includes.head')
    @include('tipowerup-orange-tw::includes.theme-vars')
    @livewireStyles
</head>
<body class="flex flex-col min-h-full {{ $this->page->bodyClass ?? '' }}">

@include('tipowerup-orange-tw::includes.header')

<main class="flex-grow">
    <div id="page-wrapper">
        @themePage
    </div>
</main>

@unless($this->page->hideFooter ?? false)
<footer class="mt-auto">
    @include('tipowerup-orange-tw::includes.footer')
</footer>
@endunless

@include('tipowerup-orange-tw::includes.bottom-tab-bar')

@livewire('tipowerup-orange-tw::flash-message')

@include('tipowerup-orange-tw::includes.scripts')
@livewireScripts
</body>
</html>
