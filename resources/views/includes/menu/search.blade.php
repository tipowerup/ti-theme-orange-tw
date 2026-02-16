<div class="relative">
    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-muted text-sm"></i>
    <input
        wire:model.live.debounce.500ms="menuSearchTerm"
        type="search"
        class="w-full pl-9 pr-4 py-2 text-sm bg-surface dark:bg-surface border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-text dark:text-text placeholder-text-muted"
        placeholder="@lang('tipowerup.orange-tw::default.common.search_menu_items')"
    />
</div>
