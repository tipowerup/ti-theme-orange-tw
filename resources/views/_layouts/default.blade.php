---
description: Default layout
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ App::getLocale() }}" class="h-full">
<head>
    @include('tipowerup-orange-tw::includes.head')
</head>
<body class="flex flex-col min-h-full {{ $this->page->bodyClass ?? '' }}">

<header class="bg-white shadow">
    @include('tipowerup-orange-tw::includes.header')
</header>

<main class="flex-grow">
    <div id="page-wrapper">
        @themePage
    </div>
</main>

@unless($this->page->hideFooter ?? false)
<footer class="bg-gray-100 mt-auto">
    @include('tipowerup-orange-tw::includes.footer')
</footer>
@endunless

@include('tipowerup-orange-tw::includes.scripts')
</body>
</html>
