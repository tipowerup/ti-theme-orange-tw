<div>
    @if($message)
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <p class="text-sm text-green-800 dark:text-green-200">{{ $message }}</p>
        </div>
    @elseif($resetCode)
        {{-- Reset Password Form --}}
        <form wire:submit="onResetPassword">
            <input wire:model="resetCode" name="resetCode" type="hidden" />

            {{-- Password Field --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-text dark:text-text mb-2">
                    @lang('igniter.user::default.reset.label_password')
                </label>
                <input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 dark:border-red-400 @enderror"
                    placeholder="@lang('tipowerup.orange-tw::default.reset.new_password')"
                />
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Confirmation Field --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-text dark:text-text mb-2">
                    @lang('igniter.user::default.reset.label_password_confirm')
                </label>
                <input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password_confirmation') border-red-500 dark:border-red-400 @enderror"
                    placeholder="@lang('tipowerup.orange-tw::default.reset.confirm_password')"
                />
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span wire:loading.remove>@lang('igniter.user::default.reset.button_reset')</span>
                <span wire:loading>
                    <svg class="animate-spin inline-block w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>
            </button>
        </form>
    @else
        {{-- Request Reset Form --}}
        <p class="text-sm text-text-muted dark:text-text-muted mb-6">
            @lang('igniter.user::default.reset.text_summary')
        </p>

        <form wire:submit="onForgotPassword">
            {{-- Email Field --}}
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-text dark:text-text mb-2">
                    @lang('igniter.user::default.reset.label_email')
                </label>
                <input
                    wire:model="email"
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 dark:border-red-400 @enderror"
                    placeholder="@lang('tipowerup.orange-tw::default.reset.email_placeholder')"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span wire:loading.remove>@lang('igniter.user::default.reset.button_reset')</span>
                <span wire:loading>
                    <svg class="animate-spin inline-block w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sending...
                </span>
            </button>
        </form>
    @endif
</div>
