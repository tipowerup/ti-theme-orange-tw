<div>
    @if($confirm)
        {{-- Email Confirmation Form --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-text dark:text-text mb-2">
                @lang('igniter.socialite::default.text_confirm_email')
            </h1>
            <p class="text-sm text-text-muted dark:text-text-muted">
                @lang('igniter.socialite::default.help_confirm_email')
            </p>
        </div>

        <form wire:submit="onConfirmEmail">
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
                <span wire:loading.remove>@lang('igniter.socialite::default.button_confirm')</span>
                <span wire:loading>
                    <svg class="animate-spin inline-block w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Confirming...
                </span>
            </button>
        </form>
    @else
        {{-- Social Login Buttons --}}
        @if(count($links) > 0)
            <div class="space-y-3">
                @foreach($links as $name => $link)
                    <a
                        href="{{ $link.'?success='.$successPage.'&error='.$errorPage }}"
                        class="flex items-center justify-center w-full px-4 py-3 border border-border dark:border-border rounded-lg text-sm font-medium text-text dark:text-text bg-body dark:bg-surface hover:bg-surface dark:hover:bg-surface transition-colors duration-200"
                    >
                        <span class="flex items-center gap-3">
                            @if($name === 'google')
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                            @elseif($name === 'facebook')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            @elseif($name === 'twitter')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                            <span>@lang('tipowerup.orange-tw::default.socialite.continue_with', ['provider' => ucfirst($name)])</span>
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-sm text-text-muted dark:text-text-muted">
                    @lang('igniter.socialite::default.text_no_login_providers')
                </p>
            </div>
        @endif
    @endif
</div>
