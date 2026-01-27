---
description: Static layout for simple pages
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
<body class="flex flex-col min-h-full bg-body text-text">

<main class="flex-grow">
    <div class="container py-12">
        @themePage
    </div>
</main>

@livewire('flash-message')

@include('tipowerup-orange-tw::includes.scripts')
@livewireScripts
</body>
</html>
