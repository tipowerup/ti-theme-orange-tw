<div>
    @if(ReviewSettings::allowReviews() && $this->reviewable())
        <div class="bg-body dark:bg-surface rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-text dark:text-text mb-6">
                @if($this->loadReview())
                    @lang('igniter.local::default.review.text_your_review')
                @else
                    @lang('igniter.local::default.review.text_leave_review')
                @endif
            </h2>

            <form wire:submit="onLeaveReview" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.local::default.review.label_quality')
                        </label>
                        <x-tipowerup-orange-tw::star-rating
                            :score="$quality"
                            name="quality"
                            :read-only="false"
                            class="text-yellow-400"
                        />
                        @error('quality')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.local::default.review.label_delivery')
                        </label>
                        <x-tipowerup-orange-tw::star-rating
                            :score="$delivery"
                            name="delivery"
                            :read-only="false"
                            class="text-yellow-400"
                        />
                        @error('delivery')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text dark:text-text mb-2">
                            @lang('igniter.local::default.review.label_service')
                        </label>
                        <x-tipowerup-orange-tw::star-rating
                            :score="$service"
                            name="service"
                            :read-only="false"
                            class="text-yellow-400"
                        />
                        @error('service')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.local::default.review.label_review')
                    </label>
                    <textarea
                        wire:model="comment"
                        id="comment"
                        rows="4"
                        class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors @error('comment') border-red-500 dark:border-red-400 @enderror"
                        placeholder="@lang('igniter.local::default.review.text_leave_review_hint')"
                    ></textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-sm text-text-muted dark:text-text-muted">
                        @lang('igniter.local::default.review.text_review_approval')
                    </p>
                    <button
                        type="submit"
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>@lang('igniter.local::default.review.button_review')</span>
                        <span wire:loading>@lang('igniter.local::default.text_please_wait')</span>
                    </button>
                </div>
            </form>
        </div>
    @elseif(!ReviewSettings::allowReviews())
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <p class="text-yellow-800 dark:text-yellow-200">@lang('igniter.local::default.review.alert_review_disabled')</p>
        </div>
    @else
        <div class="bg-surface dark:bg-surface rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-text-muted dark:text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-text-muted dark:text-text-muted">@lang('igniter.local::default.review.alert_review_not_found')</p>
        </div>
    @endif
</div>
