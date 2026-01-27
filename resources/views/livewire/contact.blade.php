<div>
    @if($sent)
        <!-- Success Message -->
        <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-6 mb-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-2">
                        @lang('tipowerup.orange-tw::default.contact.alert_contact_sent')
                    </h3>
                    <button
                        wire:click="resetForm"
                        type="button"
                        class="text-sm text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-green-100 underline"
                    >
                        @lang('tipowerup.orange-tw::default.contact.send_another')
                    </button>
                </div>
            </div>
        </div>
    @else
        <form wire:submit="send" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="fullName" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('tipowerup.orange-tw::default.contact.label_full_name')
                        <span class="text-red-500 dark:text-red-400">*</span>
                    </label>
                    <input
                        wire:model="fullName"
                        type="text"
                        id="fullName"
                        autocomplete="name"
                        class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors duration-200"
                        placeholder="John Doe"
                    />
                    @error('fullName')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('tipowerup.orange-tw::default.contact.label_email')
                        <span class="text-red-500 dark:text-red-400">*</span>
                    </label>
                    <input
                        wire:model="email"
                        type="email"
                        id="email"
                        autocomplete="email"
                        class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors duration-200"
                        placeholder="john@example.com"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telephone -->
                <div>
                    <label for="telephone" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('tipowerup.orange-tw::default.contact.label_telephone')
                        <span class="text-red-500 dark:text-red-400">*</span>
                    </label>
                    <input
                        wire:model="telephone"
                        type="tel"
                        id="telephone"
                        autocomplete="tel"
                        class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors duration-200"
                        placeholder="+1 (555) 123-4567"
                    />
                    @error('telephone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('tipowerup.orange-tw::default.contact.label_subject')
                        <span class="text-red-500 dark:text-red-400">*</span>
                    </label>
                    <select
                        wire:model="subject"
                        id="subject"
                        class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors duration-200"
                    >
                        <option value="">@lang('tipowerup.orange-tw::default.contact.text_select_subject')</option>
                        <option value="general">@lang('tipowerup.orange-tw::default.contact.text_general_enquiry')</option>
                        <option value="comment">@lang('tipowerup.orange-tw::default.contact.text_comment')</option>
                        <option value="technical">@lang('tipowerup.orange-tw::default.contact.text_technical_issues')</option>
                    </select>
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-sm font-medium text-text dark:text-text mb-2">
                    @lang('tipowerup.orange-tw::default.contact.label_comment')
                    <span class="text-red-500 dark:text-red-400">*</span>
                </label>
                <textarea
                    wire:model="message"
                    id="message"
                    rows="6"
                    class="w-full px-4 py-3 rounded-lg border border-border dark:border-border bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors duration-200 resize-none"
                    placeholder="Tell us how we can help you..."
                ></textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Captcha (if enabled) -->
            @if(config('system.recaptchaSettings.enable_captcha', false))
                <div>
                    <livewire:tipowerup-orange-tw::captcha />
                </div>
            @endif

            <!-- Submit Button -->
            <div class="flex items-center justify-between pt-4">
                <p class="text-sm text-text-muted dark:text-text-muted">
                    <span class="text-red-500 dark:text-red-400">*</span> Required fields
                </p>
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-8 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl"
                >
                    <span wire:loading.remove>
                        @lang('tipowerup.orange-tw::default.contact.button_send')
                    </span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
