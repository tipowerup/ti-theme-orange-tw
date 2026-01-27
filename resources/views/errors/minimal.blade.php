@extends('tipowerup-orange-tw::errors.layout')

@section('title', 'Error')

@section('content')
    {{-- Error Icon --}}
    <div class="flex justify-center mb-6">
        <div class="w-20 h-20 bg-warning/10 rounded-full flex items-center justify-center">
            <x-tipowerup-orange-tw::icon name="alert-circle" class="w-10 h-10 text-warning" />
        </div>
    </div>

    {{-- Error Code --}}
    <h1 class="text-6xl font-bold text-primary mb-4">@yield('code')</h1>

    {{-- Error Message --}}
    <h2 class="text-2xl font-semibold text-text mb-4">
        @yield('message')
    </h2>

    <p class="text-text-muted mb-8">
        We're sorry, but something went wrong while processing your request.
    </p>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <button
            onclick="window.history.back()"
            class="inline-flex items-center gap-2 px-6 py-3 bg-surface hover:bg-body border border-border text-text rounded-lg transition-colors font-medium"
        >
            <x-tipowerup-orange-tw::icon name="arrow-left" class="w-4 h-4" />
            Go Back
        </button>
        <a
            href="{{ page_url('home') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-600 text-white rounded-lg transition-colors font-medium"
        >
            <x-tipowerup-orange-tw::icon name="home" class="w-4 h-4" />
            Go Home
        </a>
    </div>
@endsection
