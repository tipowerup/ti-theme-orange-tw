<div>
    <h1 class="text-2xl font-bold text-text dark:text-text mb-6">
        @lang('igniter.orange::default.text_customer_reviews')
    </h1>

    @forelse($this->loadReviewList() as $review)
        <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg shadow-sm mb-4 overflow-hidden">
            <div class="p-6">
                <blockquote class="mb-4">
                    <p class="text-text dark:text-text leading-relaxed">{{ $review->review_text }}</p>
                </blockquote>

                <div class="border-t border-border dark:border-border pt-4">
                    <div class="text-sm text-text-muted dark:text-text-muted">
                        <div class="mb-3">
                            <span class="font-semibold text-text dark:text-text">{{ $review->author }}</span>
                            @if($review->customer?->address)
                                <span>@lang('igniter.local::default.text_from')</span>
                                <cite class="not-italic">{{ $review->customer?->address ? $review->customer->address->city : '' }}</cite>
                            @endif
                            <span>@lang('igniter.local::default.text_on')</span>
                            <span>{{ $review->created_at->isoFormat(lang('system::lang.moment.date_format_short')) }}</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-text dark:text-text">Quality:</span>
                                <x-tipowerup-orange-tw::star-rating :score="$review->quality" name="quality" class="text-yellow-400" />
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-text dark:text-text">Delivery:</span>
                                <x-tipowerup-orange-tw::star-rating :score="$review->delivery" name="delivery" class="text-yellow-400" />
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-text dark:text-text">Service:</span>
                                <x-tipowerup-orange-tw::star-rating :score="$review->service" name="service" class="text-yellow-400" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($loop->last)
            <div class="flex justify-end mt-6">
                {{ $this->loadReviewList()->links('tipowerup-orange-tw::pagination.tailwind') }}
            </div>
        @endif
    @empty
        <div class="bg-surface dark:bg-surface rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-text-muted dark:text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            <p class="text-text-muted dark:text-text-muted">@lang('igniter.local::default.review.text_no_review')</p>
        </div>
    @endforelse
</div>
