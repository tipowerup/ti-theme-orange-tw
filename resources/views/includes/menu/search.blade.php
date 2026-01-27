<div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg p-4">
    <div class="flex items-center space-x-2">
        <i class="fa fa-search text-text-muted"></i>
        <input
            wire:model.live.debounce.500ms="menuSearchTerm"
            type="search"
            class="flex-1 bg-transparent border-none focus:ring-0 text-text dark:text-text placeholder-text-muted"
            placeholder="@lang('tipowerup.orange-tw::default.common.search_menu_items')"
        />
    </div>
</div>
