<div class="bg-body dark:bg-surface rounded-lg border border-border dark:border-border">
    <div class="p-6 lg:p-8">
        <h1 class="text-2xl font-semibold text-text dark:text-text mb-6">
            @lang('tipowerup.orange-tw::default.text_register')
        </h1>

        @if ($registrationAllowed)
            <form wire:submit="onRegister">
                {{-- Name Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    {{-- First Name --}}
                    <div>
                        <label for="first-name" class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.user::default.settings.label_first_name')
                        </label>
                        <input
                            type="text"
                            id="first-name"
                            wire:model="form.first_name"
                            autocomplete="given-name"
                            class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors @error('form.first_name') border-red-500 dark:border-red-400 @enderror"
                            placeholder="@lang('igniter.user::default.settings.label_first_name')"
                        />
                        @error('form.first_name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label for="last-name" class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.user::default.settings.label_last_name')
                        </label>
                        <input
                            type="text"
                            id="last-name"
                            wire:model="form.last_name"
                            autocomplete="family-name"
                            class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors @error('form.last_name') border-red-500 dark:border-red-400 @enderror"
                            placeholder="@lang('igniter.user::default.settings.label_last_name')"
                        />
                        @error('form.last_name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Email Field --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.user::default.settings.label_email')
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            id="email"
                            wire:model="form.email"
                            autocomplete="email"
                            class="w-full px-4 py-3 pr-10 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors @error('form.email') border-red-500 dark:border-red-400 @enderror"
                            placeholder="@lang('igniter.user::default.settings.label_email')"
                        />
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-text-muted dark:text-text-muted">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </span>
                    </div>
                    @error('form.email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.user::default.login.label_password')
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                wire:model="form.password"
                                autocomplete="new-password"
                                class="w-full px-4 py-3 pr-10 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors @error('form.password') border-red-500 dark:border-red-400 @enderror"
                                placeholder="@lang('igniter.user::default.login.label_password')"
                            />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-text-muted dark:text-text-muted">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                        </div>
                        @error('form.password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password-confirm" class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.user::default.login.label_password_confirm')
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password-confirm"
                                wire:model="form.password_confirmation"
                                autocomplete="new-password"
                                class="w-full px-4 py-3 pr-10 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors @error('form.password_confirmation') border-red-500 dark:border-red-400 @enderror"
                                placeholder="@lang('igniter.user::default.login.label_password_confirm')"
                            />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-text-muted dark:text-text-muted">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                        </div>
                        @error('form.password_confirmation')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Phone Field --}}
                <div class="mb-4">
                    <label for="telephone" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.user::default.settings.label_telephone')
                    </label>
                    <div class="relative">
                        <input
                            type="tel"
                            id="telephone"
                            wire:model="form.telephone"
                            autocomplete="tel"
                            class="w-full px-4 py-3 pr-10 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors @error('form.telephone') border-red-500 dark:border-red-400 @enderror"
                            placeholder="@lang('igniter.user::default.settings.label_telephone')"
                        />
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-text-muted dark:text-text-muted">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </span>
                    </div>
                    @error('form.telephone')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Newsletter Checkbox --}}
                <div class="mb-4">
                    <div class="flex items-center">
                        <input
                            id="newsletter"
                            type="checkbox"
                            wire:model="form.newsletter"
                            value="1"
                            class="w-4 h-4 text-primary-600 bg-body dark:bg-surface border-border dark:border-border rounded focus:ring-primary-500 dark:focus:ring-primary-400 focus:ring-2 transition-colors"
                        />
                        <label for="newsletter" class="ml-2 text-sm text-text dark:text-text">
                            @lang('igniter.user::default.login.label_newsletter')
                        </label>
                    </div>
                    @error('form.newsletter')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Terms Checkbox --}}
                @if ($requireRegistrationTerms && $agreeTermsSlug)
                    <div class="mb-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input
                                    id="agree-terms"
                                    type="checkbox"
                                    wire:model="form.terms"
                                    value="1"
                                    class="w-4 h-4 text-primary-600 bg-body dark:bg-surface border-border dark:border-border rounded focus:ring-primary-500 dark:focus:ring-primary-400 focus:ring-2 transition-colors @error('form.terms') border-red-500 dark:border-red-400 @enderror"
                                />
                            </div>
                            <label for="agree-terms" class="ml-2 text-sm text-text dark:text-text">
                                {!! sprintf(lang('igniter.user::default.login.label_terms'), '<a href="'.url($agreeTermsSlug).'" class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors" target="_blank">'.lang('igniter.user::default.login.text_terms').'</a>') !!}
                            </label>
                        </div>
                        @error('form.terms')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- Register Button --}}
                <div class="mb-6">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="w-full px-6 py-3 text-white bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove>@lang('tipowerup.orange-tw::default.button_register')</span>
                        <span wire:loading class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>

            {{-- Login Link --}}
            <div class="text-center text-sm text-text-muted dark:text-text-muted">
                @lang('tipowerup.orange-tw::default.text_login_has_account')
                <a
                    href="{{ page_url('account.login') }}"
                    wire:navigate
                    class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
                >
                    @lang('tipowerup.orange-tw::default.text_login')
                </a>
            </div>
        @else
            <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                    @lang('igniter.user::default.login.alert_registration_disabled')
                </p>
            </div>
        @endif
    </div>
</div>
