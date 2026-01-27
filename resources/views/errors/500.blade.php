@extends('tipowerup-orange-tw::errors.layout')

@section('title', 'Server Error')

@section('content')
    {{-- Error Icon --}}
    <div class="flex justify-center mb-6">
        <div class="w-20 h-20 bg-danger/10 rounded-full flex items-center justify-center">
            <x-tipowerup-orange-tw::icon name="alert-triangle" class="w-10 h-10 text-danger" />
        </div>
    </div>

    {{-- Error Code --}}
    <h1 class="text-6xl font-bold text-danger mb-4">500</h1>

    {{-- Error Message --}}
    <h2 class="text-2xl font-semibold text-text mb-4">
        Oops! Something went wrong
    </h2>

    <p class="text-text-muted mb-8">
        We're sorry, but something unexpected happened on our end. Our team has been notified and we're working to fix it.
    </p>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-center mb-6">
        <button
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

    {{-- Support Information --}}
    <div class="bg-body rounded-lg p-6">
        <h3 class="text-sm font-semibold text-text mb-3">Need immediate assistance?</h3>
        <p class="text-sm text-text-muted mb-4">
            If this problem persists, please contact our support team with the error code above.
        </p>
        <a
            href="{{ page_url('contact') }}"
            class="inline-flex items-center gap-2 text-primary hover:text-primary-600 transition-colors font-medium text-sm"
        >
            <x-tipowerup-orange-tw::icon name="mail" class="w-4 h-4" />
            Contact Support
        </a>
    </div>

    {{-- Error Details (only in debug mode) --}}
    @if(config('app.debug') && isset($exception))
        <details class="mt-6 text-left bg-surface border border-border rounded-lg p-4">
            <summary class="cursor-pointer font-semibold text-text mb-2">
                Error Details (Debug Mode)
            </summary>
            <pre class="text-xs text-text-muted overflow-auto">{{ $exception->getMessage() }}</pre>
        </details>
    @endif
@endsection
