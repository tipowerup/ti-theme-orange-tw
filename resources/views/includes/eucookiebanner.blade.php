@php
    $gdprEnabled = $theme->enable_gdpr ?? false;
    $privacyPage = isset($theme->gdpr_more_info_link)
        ? \Igniter\Pages\Models\Page::find($theme->gdpr_more_info_link)
        : null;
    $cookieMessage = $theme->gdpr_cookie_message ?? 'We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.';
    $moreInfoText = $theme->gdpr_more_info_text ?? 'Learn more';
    $acceptText = $theme->gdpr_accept_text ?? 'Accept All';
    $declineText = $theme->gdpr_decline_text ?? 'Decline';
@endphp

@if($gdprEnabled)
<div
    x-data="{
        showBanner: false,
        init() {
            // Check if user has already made a choice
            if (!localStorage.getItem('cookie-consent')) {
                this.showBanner = true;
            }
        },
        acceptCookies() {
            localStorage.setItem('cookie-consent', 'accepted');
            this.showBanner = false;
        },
        declineCookies() {
            localStorage.setItem('cookie-consent', 'declined');
            this.showBanner = false;
        }
    }"
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
        <div class="bg-surface/95 backdrop-blur-sm border border-border rounded-lg shadow-lg p-4 md:p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                {{-- Cookie Icon --}}
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                        <x-tipowerup-orange-tw::icon name="cookie" class="w-6 h-6 text-primary" />
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
                        class="px-4 py-2 bg-body hover:bg-surface border border-border text-text rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-surface text-sm font-medium"
                        aria-label="Decline cookies"
                    >
                        {{ $declineText }}
                    </button>
                    <button
                        type="button"
                        @click="acceptCookies()"
                        class="px-4 py-2 bg-primary hover:bg-primary-600 text-white rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-surface text-sm font-medium"
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
