<div>
    @if($subscribed)
        <div
            class="p-4 bg-success/10 border border-success/20 rounded-lg text-success dark:bg-success/20"
            role="alert"
        >
            <div class="flex items-start gap-3">
                <x-tipowerup-orange-tw::icon name="check-circle" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <p class="text-sm">{{ $message }}</p>
            </div>
        </div>
    @else
        <form wire:submit="subscribe" class="flex flex-col sm:flex-row gap-2">
            <div class="flex-1">
                <label for="newsletter-email" class="sr-only">Email address</label>
                <input
                    id="newsletter-email"
                    type="email"
                    wire:model="email"
                    placeholder="@lang('tipowerup.orange-tw::default.newsletter.placeholder')"
                    class="w-full px-4 py-2 bg-body border border-border rounded-lg text-text placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-shadow"
                    aria-label="Email address for newsletter"
                    aria-describedby="email-error"
                />
                @error('email')
                    <p id="email-error" class="text-danger text-sm mt-1" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="px-6 py-2 bg-primary hover:bg-primary-600 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                aria-label="Subscribe to newsletter"
            >
                <span wire:loading.remove>@lang('tipowerup.orange-tw::default.newsletter.button')</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Subscribing...
                </span>
                <x-tipowerup-orange-tw::icon name="send" class="w-4 h-4" wire:loading.remove />
            </button>
        </form>
    @endif
</div>
