{{--
    Auth Section Divider with "Or" text
    Usage: @include('tipowerup-orange-tw::includes.auth.divider')
--}}

<div class="relative my-6">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-border dark:border-border"></div>
    </div>
    <div class="relative flex justify-center text-sm">
        <span class="px-4 bg-body dark:bg-surface text-text-muted dark:text-text-muted">
            @lang('tipowerup.orange-tw::default.text_or_continue_with')
        </span>
    </div>
</div>
