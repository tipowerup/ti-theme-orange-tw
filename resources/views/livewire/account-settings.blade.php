<div class="bg-body dark:bg-surface rounded-lg shadow-sm">
    <div class="p-6">
        <h5 class="text-lg font-medium text-text dark:text-text mb-6">
            @lang('igniter.user::default.text_edit_details')
        </h5>

        <form wire:submit="onUpdate">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.user::default.settings.label_first_name')
                    </label>
                    <input
                        wire:model="form.first_name"
                        id="first_name"
                        type="text"
                        autocomplete="given-name"
                        class="w-full px-4 py-2.5 border border-border dark:border-border rounded-md bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    />
                    @error('form.first_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.user::default.settings.label_last_name')
                    </label>
                    <input
                        wire:model="form.last_name"
                        id="last_name"
                        type="text"
                        autocomplete="family-name"
                        class="w-full px-4 py-2.5 border border-border dark:border-border rounded-md bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    />
                    @error('form.last_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="telephone" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.user::default.settings.label_telephone')
                    </label>
                    <input
                        wire:model="form.telephone"
                        id="telephone"
                        type="tel"
                        autocomplete="tel"
                        class="w-full px-4 py-2.5 border border-border dark:border-border rounded-md bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    />
                    @error('form.telephone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.user::default.settings.label_email')
                    </label>
                    <input
                        wire:model="form.email"
                        id="email"
                        type="email"
                        autocomplete="email"
                        class="w-full px-4 py-2.5 border border-border dark:border-border rounded-md bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    />
                    @error('form.email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        wire:model="form.newsletter"
                        id="newsletter"
                        class="w-4 h-4 text-primary-600 border-border dark:border-border rounded focus:ring-primary-500 dark:bg-surface"
                        value="1"
                    />
                    <span class="ml-2 text-sm text-text dark:text-text">
                        @lang('igniter.user::default.settings.label_newsletter')
                    </span>
                </label>
                @error('form.newsletter')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-border dark:border-border pt-6 mb-6">
                <h5 class="text-lg font-medium text-text dark:text-text mb-4">
                    @lang('igniter.user::default.settings.text_password_heading')
                </h5>

                <div class="mb-6">
                    <label for="old_password" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.user::default.settings.label_old_password')
                    </label>
                    <input
                        type="password"
                        wire:model="form.old_password"
                        id="old_password"
                        autocomplete="current-password"
                        class="w-full px-4 py-2.5 border border-border dark:border-border rounded-md bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    />
                    @error('form.old_password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.user::default.settings.label_password')
                        </label>
                        <input
                            type="password"
                            wire:model="form.password"
                            id="password"
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 border border-border dark:border-border rounded-md bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        />
                        @error('form.password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.user::default.settings.label_password_confirm')
                        </label>
                        <input
                            type="password"
                            wire:model="form.password_confirmation"
                            id="password_confirmation"
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 border border-border dark:border-border rounded-md bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        />
                        @error('form.password_confirmation')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors disabled:opacity-50"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>@lang('igniter.user::default.settings.button_save')</span>
                    <span wire:loading>
                        <i class="fa fa-spinner fa-spin mr-2"></i>Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
