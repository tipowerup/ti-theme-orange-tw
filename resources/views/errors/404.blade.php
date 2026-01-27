@extends('tipowerup-orange-tw::errors.layout')

@section('title', 'Page Not Found')

@section('content')
    {{-- Error Icon --}}
    <div class="flex justify-center mb-6">
        <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center">
            <x-tipowerup-orange-tw::icon name="search-x" class="w-10 h-10 text-primary" />
        </div>
    </div>

    {{-- Error Code --}}
    <h1 class="text-6xl font-bold text-primary mb-4">404</h1>

    {{-- Error Message --}}
    <h2 class="text-2xl font-semibold text-text mb-4">
        Page Not Found
    </h2>

    <p class="text-text-muted mb-8">
        Sorry, we couldn't find the page you're looking for. The page might have been moved, deleted, or never existed.
    </p>

    {{-- Suggestions --}}
    <div class="bg-body rounded-lg p-6 mb-6">
        <h3 class="text-sm font-semibold text-text mb-3">Here are some helpful links instead:</h3>
        <div class="flex flex-wrap justify-center gap-3">
            <a
                href="{{ page_url('home') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-600 text-white rounded-lg transition-colors font-medium"
            >
                <x-tipowerup-orange-tw::icon name="home" class="w-4 h-4" />
                Home
            </a>
            <a
                href="{{ page_url('locations') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-surface hover:bg-body border border-border text-text rounded-lg transition-colors font-medium"
            >
                <x-tipowerup-orange-tw::icon name="map-pin" class="w-4 h-4" />
                Locations
            </a>
            <a
                href="{{ restaurant_url('local/menus') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-surface hover:bg-body border border-border text-text rounded-lg transition-colors font-medium"
            >
                <x-tipowerup-orange-tw::icon name="utensils" class="w-4 h-4" />
                Menu
            </a>
        </div>
    </div>

    {{-- Search Suggestion --}}
    <p class="text-sm text-text-muted">
        If you think this is a mistake, please
        <a href="{{ page_url('contact') }}" class="text-primary hover:text-primary-600 underline">contact us</a>.
    </p>
@endsection
