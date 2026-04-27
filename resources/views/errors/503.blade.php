@extends('tipowerup-orange-tw::errors.layout')

@section('title', 'We\'ll be right back')

@section('content')
    {{-- Error Icon --}}
    <div class="flex justify-center mb-6">
        <div class="w-20 h-20 bg-info/10 rounded-full flex items-center justify-center">
            <x-tipowerup-orange-tw::icon name="wrench" class="w-10 h-10 text-info" />
        </div>
    </div>

    {{-- Error Code --}}
    <h1 class="text-6xl font-bold text-primary mb-4">503</h1>

    {{-- Error Message --}}
    <h2 class="text-2xl font-semibold text-text mb-4">
        We'll be right back
    </h2>

    <p class="text-text-muted mb-8">
        @if(isset($exception) && $exception->getMessage())
            {{ $exception->getMessage() }}
        @else
            We're performing scheduled maintenance to make things even better. Please check back in a few minutes — thanks for your patience!
        @endif
    </p>

    {{-- Status Card --}}
    <div class="bg-body rounded-lg p-6 mb-6">
        <h3 class="text-sm font-semibold text-text mb-3">Stay updated</h3>
        <p class="text-sm text-text-muted mb-4">
            We typically come back online within a few minutes. If you have urgent enquiries, our team is reachable below.
        </p>
        <a
            href="{{ page_url('contact') }}"
            class="inline-flex items-center gap-2 text-primary hover:text-primary-600 transition-colors font-medium text-sm"
        >
            <x-tipowerup-orange-tw::icon name="mail" class="w-4 h-4" />
            Contact Us
        </a>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <button
            type="button"
            onclick="window.location.reload()"
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-600 text-white rounded-lg transition-colors font-medium"
        >
            <x-tipowerup-orange-tw::icon name="refresh-cw" class="w-4 h-4" />
            Try Again
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
