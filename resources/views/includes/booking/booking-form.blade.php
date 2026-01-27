<form wire:submit="onComplete" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="firstName" class="block text-sm font-medium text-text dark:text-text mb-2">
                @lang('igniter.reservation::default.label_first_name')
            </label>
            <input
                wire:model="form.firstName"
                type="text"
                id="firstName"
                autocomplete="given-name"
                class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors @error('form.firstName') border-red-500 dark:border-red-400 @enderror"
                placeholder="@lang('igniter.reservation::default.label_first_name')"
                required
            />
            @error('form.firstName')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="lastName" class="block text-sm font-medium text-text dark:text-text mb-2">
                @lang('igniter.reservation::default.label_last_name')
            </label>
            <input
                wire:model="form.lastName"
                type="text"
                id="lastName"
                autocomplete="family-name"
                class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors @error('form.lastName') border-red-500 dark:border-red-400 @enderror"
                placeholder="@lang('igniter.reservation::default.label_last_name')"
                required
            />
            @error('form.lastName')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-text dark:text-text mb-2">
                @lang('igniter.reservation::default.label_email')
            </label>
            <input
                wire:model="form.email"
                type="email"
                id="email"
                autocomplete="email"
                class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors @error('form.email') border-red-500 dark:border-red-400 @enderror"
                @if($customer) readonly @endif
                placeholder="@lang('igniter.reservation::default.label_email')"
                required
            />
            @error('form.email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="telephone" class="block text-sm font-medium text-text dark:text-text mb-2">
                @lang('igniter.reservation::default.label_telephone')
            </label>
            <input
                wire:model="form.telephone"
                type="tel"
                id="telephone"
                autocomplete="tel"
                class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors @error('form.telephone') border-red-500 dark:border-red-400 @enderror"
                placeholder="@lang('igniter.reservation::default.label_telephone')"
            />
            @error('form.telephone')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="comment" class="block text-sm font-medium text-text dark:text-text mb-2">
            @lang('igniter.reservation::default.label_comment')
        </label>
        <textarea
            wire:model="form.comment"
            id="comment"
            rows="4"
            class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors @error('form.comment') border-red-500 dark:border-red-400 @enderror"
            placeholder="@lang('igniter.reservation::default.label_comment')"
        ></textarea>
        @error('form.comment')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <button
        type="submit"
        wire:loading.attr="disabled"
        class="w-full px-6 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors text-lg disabled:opacity-50 disabled:cursor-not-allowed"
    >
        <span wire:loading.remove>@lang('igniter.reservation::default.button_reservation')</span>
        <span wire:loading>@lang('igniter.local::default.text_please_wait')</span>
    </button>
</form>
