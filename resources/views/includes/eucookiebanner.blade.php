@if($gdprEnabled)
<div
    x-data="cookieBanner()"
    x-show="showBanner"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-0 left-0 right-0 z-50 p-4 md:p-6"
    role="dialog"
    aria-labelledby="cookie-banner-title"
    aria-describedby="cookie-banner-description"
>
    <div class="container mx-auto max-w-5xl">
        <div class="bg-surface/95 backdrop-blur-xs border border-border rounded-lg shadow-lg p-4 md:p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                {{-- Cookie Icon --}}
                <div class="shrink-0">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                        <i class="fa fa-cookie-bite text-xl text-primary" aria-hidden="true"></i>
                    </div>
                </div>

                {{-- Message --}}
                <div class="flex-1">
                    <h3 id="cookie-banner-title" class="text-lg font-semibold text-text mb-2">
                        Cookie Consent
                    </h3>
                    <p id="cookie-banner-description" class="text-sm text-text-muted">
                        {!! $cookieMessage !!}
                        @if($privacyPage)
                            <a
                                href="{{ page_url($privacyPage->permalink_slug) }}"
                                class="text-primary hover:text-primary-600 underline transition-colors"
                                wire:navigate
                            >{{ $moreInfoText }}</a>
                        @endif
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                    <button
                        type="button"
                        @click="declineCookies()"
                        class="px-4 py-2 bg-body hover:bg-surface border border-border text-text rounded-lg transition-colors focus:outline-hidden focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-surface text-sm font-medium"
                        aria-label="Decline cookies"
                    >
                        {{ $declineText }}
                    </button>
                    <button
                        type="button"
                        @click="acceptCookies()"
                        class="px-4 py-2 bg-primary hover:bg-primary-600 text-white rounded-lg transition-colors focus:outline-hidden focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-surface text-sm font-medium"
                        aria-label="Accept all cookies"
                    >
                        {{ $acceptText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
