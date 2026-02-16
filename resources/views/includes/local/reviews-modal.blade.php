{{-- Reviews Slideout Modal --}}
<div
    x-data="{ open: false }"
    x-show="open"
    x-cloak
    @open-modal.window="if ($event.detail === 'reviews-modal') open = true"
    @keydown.escape.window="open = false"
    x-effect="document.body.classList.toggle('overflow-hidden', open)"
    class="fixed inset-0 z-50 overflow-hidden"
    aria-labelledby="reviews-title"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        @click="open = false"
    ></div>

    {{-- Slideout Panel --}}
    <div class="fixed inset-y-0 right-0 flex max-w-full">
        <div
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen max-w-md"
        >
            <div class="flex h-full flex-col bg-body dark:bg-surface shadow-xl">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-border dark:border-border">
                    <h2 id="reviews-title" class="text-lg font-semibold text-text dark:text-text">
                        {{ sprintf(lang('igniter.local::default.review.text_review_heading'), $locationInfo->name) }}
                    </h2>
                    <button
                        type="button"
                        @click="open = false"
                        class="rounded-lg p-2 text-text-muted hover:text-text hover:bg-surface dark:hover:bg-body transition-colors"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Summary --}}
                <div class="px-6 py-4 bg-surface dark:bg-body border-b border-border dark:border-border">
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-text dark:text-text">
                                {{ number_format($locationInfo->reviewsScore(), 1) }}
                            </div>
                            <div class="flex items-center justify-center mt-1">
                                @php
                                    $score = $locationInfo->reviewsScore();
                                    $fullStars = floor($score);
                                    $halfStar = $score - $fullStars >= 0.5;
                                @endphp
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $fullStars)
                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    @elseif($i == $fullStars && $halfStar)
                                        <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                                    @else
                                        <i class="far fa-star text-text-muted text-sm"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="text-sm text-text-muted dark:text-text-muted">
                            @lang('tipowerup.orange-tw::default.local_header.based_on_reviews', ['count' => $locationInfo->reviewsCount()])
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    @forelse($listReviews() as $review)
                        <div class="py-4 {{ !$loop->last ? 'border-b border-border dark:border-border' : '' }}">
                            {{-- Review Header --}}
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <div class="font-medium text-text dark:text-text">
                                        {{ $review->customer_name ?: lang('igniter.local::default.review.text_guest') }}
                                    </div>
                                    <div class="text-xs text-text-muted dark:text-text-muted">
                                        {{ $review->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-yellow-400 text-sm"></i>
                                    @endfor
                                </div>
                            </div>

                            {{-- Review Content --}}
                            @if($review->review_text)
                                <p class="text-sm text-text-muted dark:text-text-muted">
                                    {{ $review->review_text }}
                                </p>
                            @endif
                        </div>

                        @if($loop->last && $locationInfo->reviewsCount() > count($listReviews()))
                            <a
                                href="{{ restaurant_url($reviewsPage ?? 'local/reviews') }}"
                                wire:navigate
                                class="block w-full py-3 text-center text-primary hover:text-primary-700 dark:hover:text-primary-400 font-medium transition-colors"
                            >
                                @lang('tipowerup.orange-tw::default.local_header.view_all_reviews')
                            </a>
                        @endif
                    @empty
                        <div class="py-8 text-center">
                            <i class="far fa-star text-4xl text-text-muted mb-3"></i>
                            <p class="text-text-muted dark:text-text-muted">
                                @lang('igniter.local::default.review.text_no_review')
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
