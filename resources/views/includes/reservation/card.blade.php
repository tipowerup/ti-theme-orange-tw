{{-- Mobile Reservation Card --}}
<div class="bg-body dark:bg-surface rounded-lg border border-border dark:border-border shadow-sm overflow-hidden hover:shadow-md transition-shadow">
    <div class="p-4">
        <div class="flex items-start justify-between mb-3">
            <a
                href="{{ page_url($reservationPage, ['reservationId' => $reservation->reservation_id, 'hash' => $reservation->hash]) }}"
                wire:navigate
                class="inline-flex items-center px-3 py-1 rounded-lg bg-surface dark:bg-surface hover:bg-surface dark:hover:bg-surface text-sm font-medium text-text dark:text-text transition-colors"
            >
                #{{ $reservation->reservation_id }}
            </a>
            @include('tipowerup-orange-tw::includes.reservation.status-badge', ['reservation' => $reservation])
        </div>

        <div class="space-y-2">
            <div class="flex items-center text-sm">
                <svg class="w-4 h-4 mr-2 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-text dark:text-text">
                    {{ $reservation->location ? $reservation->location->location_name : 'N/A' }}
                </span>
            </div>

            <div class="flex items-center text-sm">
                <svg class="w-4 h-4 mr-2 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-text dark:text-text">
                    {{ $reservation->reserve_date->setTimeFromTimeString($reservation->reserve_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
                </span>
            </div>

            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-text dark:text-text">{{ $reservation->guest_num }} {{ str_plural('guest', $reservation->guest_num) }}</span>
                </div>

                @if($reservation->table_name)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-text dark:text-text">{{ $reservation->table_name }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
