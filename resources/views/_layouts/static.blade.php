---
description: Static layout for static pages (About, Privacy Policy, etc.)
---
<!DOCTYPE html>
<html
    xmlns="http://www.w3.org/1999/xhtml"
    lang="{{ App::getLocale() }}"
    class="h-full"
    x-data="darkMode()"
    style="{!! $themeBrandStyle ?? '' !!}"
>
<head>
    @include('tipowerup-orange-tw::includes.head')
    @include('tipowerup-orange-tw::includes.theme-vars')
    @livewireStyles
</head>
<body class="flex flex-col min-h-full {{ $this->page->bodyClass ?? '' }}">

@include('tipowerup-orange-tw::includes.header')

<main class="flex-grow">
    <div class="container mx-auto px-4 py-8 md:py-12">
        {{-- Page Heading --}}
        <header class="mb-8 pb-6 border-b border-border">
            <h1 class="text-3xl md:text-4xl font-bold text-text">
                {{ $this->page->title ?? '' }}
            </h1>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Sidebar: all static pages --}}
            <aside class="lg:col-span-1">
                <x-tipowerup-orange-tw::nav code="pages-menu" />
            </aside>

            {{-- Page content --}}
            <div class="lg:col-span-3">
                <article class="prose dark:prose-invert max-w-none bg-surface border border-border rounded-lg p-6 md:p-8">
                    @themePage
                </article>
            </div>
        </div>
    </div>
</main>

<footer class="mt-auto">
    @include('tipowerup-orange-tw::includes.footer')
</footer>

@include('tipowerup-orange-tw::includes.bottom-tab-bar')

@livewire('tipowerup-orange-tw::flash-message')
@livewire('tipowerup-orange-tw::modal-manager')

@include('tipowerup-orange-tw::includes.eucookiebanner')

@include('tipowerup-orange-tw::includes.scripts')
@livewireScripts
</body>
</html>
