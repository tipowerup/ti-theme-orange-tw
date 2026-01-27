<div
    x-data="OrangeCartItem()"
    data-control="cart-item"
    data-min-quantity="{{ $minQuantity }}"
    data-price-amount="{{ $price }}"
>
    <form wire:submit="onSave" class="flex flex-col max-h-[90vh]">
        {{-- Modal Header --}}
        <div class="flex items-start justify-between p-6 border-b border-border dark:border-border">
            <h2 class="text-2xl font-bold text-text dark:text-text">
                {{ $menuItemData->name }}
            </h2>
            <button
                type="button"
                @click="$dispatch('hideModal')"
                class="text-text-muted hover:text-text dark:hover:text-text transition-colors"
                aria-label="Close"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Item Image --}}
        @if ($showThumb)
            <div class="w-full">
                <img
                    src="{{ $menuItemData->getThumb([
                        'width' => $thumbWidth,
                        'height' => $thumbHeight,
                    ]) }}"
                    srcset="{{ $menuItemData->getThumb([
                        'width' => $thumbWidth,
                        'height' => $thumbHeight,
                    ]) }} 1x,
                            {{ $menuItemData->getThumb([
                        'width' => $thumbWidth * 2,
                        'height' => $thumbHeight * 2,
                    ]) }} 2x"
                    alt="{{ $menuItemData->name }}"
                    class="w-full h-64 object-cover"
                    loading="eager"
                    width="{{ $thumbWidth }}"
                    height="{{ $thumbHeight }}"
                />
            </div>
        @endif

        {{-- Modal Body --}}
        <div class="flex-1 overflow-y-auto p-6">
            {{-- Description --}}
            @if (strlen($menuItemData->description))
                <p class="text-text-muted dark:text-text-muted mb-6">{!! $menuItemData->description !!}</p>
            @endif

            <input type="hidden" wire:model="menuId" />
            <input type="hidden" wire:model="rowId" />

            {{-- Menu Options --}}
            <div x-ref="item-options" class="space-y-6 mb-6">
                @foreach ($menuItemData->getOptions() as $index => $menuOption)
                    <div
                        x-data="OrangeCartItemOptions({{ $menuOption->min_selected }}, {{ $menuOption->max_selected }})"
                        data-control="item-option"
                        data-option-type="{{ $menuOption->display_type }}"
                        wire:key="option-{{ $index }}"
                        class="menu-option"
                    >
                        <div class="mb-2">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-lg font-semibold text-text dark:text-text">
                                    {{ $menuOption->option_name }}
                                </h3>
                                @if ($menuOption->isRequired())
                                    <span class="text-sm text-red-600 dark:text-red-400">@lang('tipowerup.orange-tw::default.menu.required')</span>
                                @endif
                            </div>
                            @if ($menuOption->min_selected > 0 || $menuOption->max_selected > 0)
                                <p class="text-sm text-text-muted dark:text-text-muted">
                                    {!! sprintf(lang('igniter.cart::default.text_option_summary'), $menuOption->min_selected, $menuOption->max_selected) !!}
                                </p>
                            @endif
                        </div>

                        @if (count($optionValues = $menuOption->menu_option_values))
                            <input
                                type="hidden"
                                wire:model.fill="menuOptions.{{ $index }}.menu_option_id"
                                value="{{ $menuOption->menu_option_id }}"
                            />

                            <div class="space-y-2">
                                {{-- Radio buttons for single-select --}}
                                @if ($menuOption->display_type === 'radio')
                                    @foreach ($optionValues as $optionValue)
                                        <label class="flex items-center p-3 border border-border dark:border-border rounded-lg cursor-pointer hover:bg-surface dark:hover:bg-surface transition-colors">
                                            <input
                                                type="radio"
                                                name="menuOptions[{{ $index }}][option_values][]"
                                                wire:model="menuOptions.{{ $index }}.option_values"
                                                value="{{ $optionValue->menu_option_value_id }}"
                                                data-option-price="{{ $optionValue->price }}"
                                                class="w-4 h-4 text-primary-600 focus:ring-primary-500"
                                                @change="$root.calculateTotal()"
                                            />
                                            <span class="ml-3 flex-1 text-text dark:text-text">
                                                {{ $optionValue->name }}
                                            </span>
                                            @if (!$hideZeroOptionPrices || $optionValue->price > 0)
                                                <span class="text-text-muted dark:text-text-muted">
                                                    @if ($optionValue->price > 0)
                                                        +{{ currency_format($optionValue->price) }}
                                                    @else
                                                        {{ currency_format($optionValue->price) }}
                                                    @endif
                                                </span>
                                            @endif
                                        </label>
                                    @endforeach
                                @endif

                                {{-- Checkboxes for multi-select --}}
                                @if ($menuOption->display_type === 'checkbox')
                                    @foreach ($optionValues as $optionValue)
                                        <label class="flex items-center p-3 border border-border dark:border-border rounded-lg cursor-pointer hover:bg-surface dark:hover:bg-surface transition-colors">
                                            <input
                                                type="checkbox"
                                                wire:model="menuOptions.{{ $index }}.option_values"
                                                value="{{ $optionValue->menu_option_value_id }}"
                                                data-option-price="{{ $optionValue->price }}"
                                                class="w-4 h-4 text-primary-600 border-border rounded focus:ring-primary-500 dark:bg-surface"
                                                @change="$root.calculateTotal()"
                                            />
                                            <span class="ml-3 flex-1 text-text dark:text-text">
                                                {{ $optionValue->name }}
                                            </span>
                                            @if (!$hideZeroOptionPrices || $optionValue->price > 0)
                                                <span class="text-text-muted dark:text-text-muted">
                                                    @if ($optionValue->price > 0)
                                                        +{{ currency_format($optionValue->price) }}
                                                    @else
                                                        {{ currency_format($optionValue->price) }}
                                                    @endif
                                                </span>
                                            @endif
                                        </label>
                                    @endforeach
                                @endif

                                {{-- Select dropdown --}}
                                @if ($menuOption->display_type === 'select')
                                    <select
                                        wire:model="menuOptions.{{ $index }}.option_values"
                                        class="w-full px-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        @change="$root.calculateTotal()"
                                    >
                                        <option value="">@lang('tipowerup.orange-tw::default.menu.select_option')</option>
                                        @foreach ($optionValues as $optionValue)
                                            <option
                                                value="{{ $optionValue->menu_option_value_id }}"
                                                data-option-price="{{ $optionValue->price }}"
                                            >
                                                {{ $optionValue->name }}
                                                @if (!$hideZeroOptionPrices || $optionValue->price > 0)
                                                    @if ($optionValue->price > 0)
                                                        (+{{ currency_format($optionValue->price) }})
                                                    @else
                                                        ({{ currency_format($optionValue->price) }})
                                                    @endif
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @error('menuOptions')
                <p class="text-red-600 dark:text-red-400 text-sm mb-4">{{ $message }}</p>
            @enderror

            {{-- Special Instructions --}}
            <div>
                <label for="comment" class="block text-sm font-semibold text-text dark:text-text mb-2">
                    @lang('tipowerup.orange-tw::default.cart.special_instructions')
                </label>
                <textarea
                    wire:model="comment"
                    id="comment"
                    rows="3"
                    placeholder="@lang('tipowerup.orange-tw::default.cart.special_instructions_placeholder')"
                    class="w-full px-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                ></textarea>
                @error('comment')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 border-t border-border dark:border-border">
            <div class="flex items-center gap-4">
                {{-- Quantity Selector --}}
                <div class="flex items-center gap-2">
                    <button
                        x-on:click="decrementQuantity()"
                        type="button"
                        class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-border dark:border-border text-text dark:text-text hover:border-primary-500 hover:text-primary-500 transition-colors"
                        aria-label="@lang('tipowerup.orange-tw::default.cart.decrease_quantity')"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <input
                        x-model="quantity"
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        readonly
                        class="w-16 text-center bg-transparent border-0 text-lg font-semibold text-text dark:text-text"
                    />
                    <button
                        x-on:click="incrementQuantity()"
                        type="button"
                        class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-border dark:border-border text-text dark:text-text hover:border-primary-500 hover:text-primary-500 transition-colors"
                        aria-label="@lang('tipowerup.orange-tw::default.cart.increase_quantity')"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>

                {{-- Add/Update Button --}}
                <button
                    type="submit"
                    data-attach-loading
                    class="flex-1 px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-between"
                >
                    <span>
                        {!! $cartItem
                            ? lang('igniter.cart::default.button_update')
                            : lang('igniter.cart::default.button_add_to_order')
                        !!}
                    </span>
                    <span x-text="total" class="font-normal"></span>
                </button>
            </div>
        </div>
    </form>
</div>
