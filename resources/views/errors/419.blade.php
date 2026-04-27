@extends('tipowerup-orange-tw::errors.layout')

@section('title', 'Page Expired')

@section('content')
    {{-- Error Icon --}}
    <div class="flex justify-center mb-6">
        <div class="w-20 h-20 bg-info/10 rounded-full flex items-center justify-center">
            <x-tipowerup-orange-tw::icon name="clock" class="w-10 h-10 text-info" />
        </div>
    </div>

    {{-- Error Code --}}
    <h1 class="text-6xl font-bold text-primary mb-4">419</h1>

    {{-- Error Message --}}
    <h2 class="text-2xl font-semibold text-text mb-4">
        Your session has expired
    </h2>

    <p class="text-text-muted mb-8">
        For your security, this page timed out before you finished. Please refresh and try again — your work isn't lost.
    </p>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <button
            type="button"
            onclick="window.location.reload()"
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-600 text-white rounded-lg transition-colors font-medium"
        >
            <x-tipowerup-orange-tw::icon name="refresh-cw" class="w-4 h-4" />
            Refresh Page
        </button>
        <a
            href="{{ page_url('home') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-surface hover:bg-body border border-border text-text rounded-lg transition-colors font-medium"
        >
            <x-tipowerup-orange-tw::icon name="home" class="w-4 h-4" />
            Go Home
        </a>
    </div>
@endsection
