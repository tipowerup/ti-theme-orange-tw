<div>
    @if($apiKey)
        <!-- Google reCAPTCHA v2 -->
        <div
            class="g-recaptcha"
            data-sitekey="{{ $apiKey }}"
            data-theme="{{ setting('theme_mode') === 'dark' ? 'dark' : 'light' }}"
        ></div>

        @error('g-recaptcha-response')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror

        @push('scripts')
            <script
                src="https://www.google.com/recaptcha/api.js?hl={{ $lang }}"
                async
                defer
            ></script>
        @endpush
    @else
        <!-- Simple Custom Captcha Fallback -->
        <div class="space-y-3">
            <div class="flex items-center gap-4">
                <div class="flex-1 bg-surface dark:bg-surface rounded-lg p-4 border-2 border-border dark:border-border">
                    <div class="flex items-center justify-center gap-2 text-2xl font-mono font-bold text-text dark:text-text tracking-wider select-none">
                        <!-- Simple math captcha as fallback -->
                        <span class="text-primary-600 dark:text-primary-400">5</span>
                        <span>+</span>
                        <span class="text-primary-600 dark:text-primary-400">3</span>
                        <span>=</span>
                        <span class="text-text-muted">?</span>
                    </div>
                </div>
                <button
                    wire:click="refresh"
                    type="button"
                    class="p-3 rounded-lg bg-surface dark:bg-surface hover:bg-surface dark:hover:bg-surface text-text dark:text-text transition-colors duration-200"
                    title="@lang('tipowerup.orange-tw::default.captcha.refresh')"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>

            <div>
                <label for="captcha-{{ $captchaKey }}" class="block text-sm font-medium text-text dark:text-text mb-2">
                    @lang('tipowerup.orange-tw::default.captcha.label')
                    <span class="text-red-500 dark:text-red-400">*</span>
                </label>
                <input
                    wire:model="captcha"
                    type="text"
                    id="captcha-{{ $captchaKey }}"
                    class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors duration-200"
                    placeholder="@lang('tipowerup.orange-tw::default.captcha.placeholder')"
                    maxlength="3"
                />
                @error('captcha')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    @endif
</div>
