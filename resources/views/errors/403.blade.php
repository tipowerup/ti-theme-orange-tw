@extends('tipowerup-orange-tw::errors.layout')

@section('title', 'Access Denied')

@section('content')
    {{-- Error Icon --}}
    <div class="flex justify-center mb-6">
        <div class="w-20 h-20 bg-warning/10 rounded-full flex items-center justify-center">
            <x-tipowerup-orange-tw::icon name="lock-closed" class="w-10 h-10 text-warning" />
        </div>
    </div>

    {{-- Error Code --}}
    <h1 class="text-6xl font-bold text-warning mb-4">403</h1>

    {{-- Error Message --}}
    <h2 class="text-2xl font-semibold text-text mb-4">
        Access Denied
    </h2>

    <p class="text-text-muted mb-8">
        Sorry, you don't have permission to view this page. If you believe this is a mistake, please sign in or contact support.
    </p>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-center mb-6">
        <a
            href="{{ page_url('login') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-600 text-white rounded-lg transition-colors font-medium"
        >
            <x-tipowerup-orange-tw::icon name="user" class="w-4 h-4" />
            Sign In
        </a>
        <a
            href="{{ page_url('home') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-surface hover:bg-body border border-border text-text rounded-lg transition-colors font-medium"
        >
            <x-tipowerup-orange-tw::icon name="home" class="w-4 h-4" />
            Go Home
        </a>
    </div>

    <p class="text-sm text-text-muted">
        Need help?
        <a href="{{ page_url('contact') }}" class="text-primary hover:text-primary-600 underline">Contact us</a>.
    </p>
@endsection
