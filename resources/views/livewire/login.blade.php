<div>
    <h1 class="text-2xl font-semibold text-text dark:text-text mb-6">
        @lang('tipowerup.orange-tw::default.text_login')
    </h1>

    <form wire:submit="onLogin">
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
                    required
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

        {{-- Password Field --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-text dark:text-text mb-2">
                @lang('igniter.user::default.login.label_password')
            </label>
            <div class="relative">
                <input
                    type="password"
                    id="password"
                    wire:model="form.password"
                    autocomplete="current-password"
                    class="w-full px-4 py-3 pr-10 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors @error('form.password') border-red-500 dark:border-red-400 @enderror"
                    placeholder="@lang('igniter.user::default.login.label_password')"
                    required
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

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <input
                    id="remember"
                    type="checkbox"
                    wire:model="form.remember"
                    value="1"
                    class="w-4 h-4 text-primary-600 bg-body dark:bg-surface border-border dark:border-border rounded focus:ring-primary-500 dark:focus:ring-primary-400 focus:ring-2 transition-colors"
                />
                <label for="remember" class="ml-2 text-sm text-text dark:text-text">
                    @lang('igniter.user::default.login.label_remember')
                </label>
            </div>
            <a
                href="{{ page_url('account.reset') }}"
                wire:navigate
                class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
            >
                @lang('tipowerup.orange-tw::default.text_forgot')
            </a>
        </div>
        @error('form.remember')
            <p class="mb-4 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror

        {{-- Login Button --}}
        <div class="mb-6">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full px-6 py-3 text-white bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span wire:loading.remove>@lang('igniter.user::default.login.button_login')</span>
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

    {{-- Register Link --}}
    @if ($registrationAllowed)
        <div class="text-center text-sm text-text-muted dark:text-text-muted">
            @lang('tipowerup.orange-tw::default.text_signup_no_account')
            <a
                href="{{ page_url('account.register') }}"
                wire:navigate
                class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
            >
                @lang('tipowerup.orange-tw::default.button_register')
            </a>
        </div>
    @endif
</div>
