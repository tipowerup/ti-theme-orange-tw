<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ setting('site_name') }}</title>
    <meta name="robots" content="noindex, nofollow">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('vendor/tipowerup-orange-tw/images/favicon.ico') }}" type="image/x-icon">

    {{-- Vite Assets --}}
    @vite(['resources/src/css/app.css', 'resources/src/js/app.js'], 'vendor/tipowerup-orange-tw')
</head>
<body class="h-full bg-body text-text antialiased">
    <div class="min-h-full flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full space-y-8 text-center">
            {{-- Logo --}}
            <div class="flex justify-center">
                <a href="{{ page_url('home') }}" class="inline-block">
                    @if($theme->logo_image ?? false)
                        <img
                            class="h-16 w-auto"
                            alt="{{ setting('site_name') }}"
                            src="{{ media_url($theme->logo_image) }}"
                        />
                    @elseif($theme->logo_text ?? false)
                        <span class="text-3xl font-bold text-primary">{{ $theme->logo_text }}</span>
                    @else
                        <img
                            class="h-16 w-auto"
                            alt="{{ setting('site_name') }}"
                            src="{{ asset('vendor/tipowerup-orange-tw/images/favicon.ico') }}"
                        />
                    @endif
                </a>
            </div>

            {{-- Error Content --}}
            <div class="bg-surface border border-border rounded-lg p-8 shadow-sm">
                @yield('content')
            </div>

            {{-- Back to Home --}}
            <div class="mt-6">
                <a
                    href="{{ page_url('home') }}"
                    class="inline-flex items-center gap-2 text-primary hover:text-primary-600 transition-colors font-medium"
                >
                    <x-tipowerup-orange-tw::icon name="arrow-left" class="w-4 h-4" />
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
