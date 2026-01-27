<div>
    @if(count($reservations))
        {{-- Desktop Table View --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-border dark:border-border">
                    <tr class="text-left">
                        <th class="pb-3 text-sm font-semibold text-text dark:text-text">@lang('igniter.reservation::default.column_id')</th>
                        <th class="pb-3 text-sm font-semibold text-text dark:text-text">@lang('igniter.reservation::default.column_location')</th>
                        <th class="pb-3 text-sm font-semibold text-text dark:text-text">@lang('igniter.reservation::default.column_status')</th>
                        <th class="pb-3 text-sm font-semibold text-text dark:text-text">@lang('igniter.reservation::default.column_date')</th>
                        <th class="pb-3 text-sm font-semibold text-text dark:text-text">@lang('igniter.reservation::default.column_table')</th>
                        <th class="pb-3 text-sm font-semibold text-text dark:text-text">@lang('igniter.reservation::default.column_guest')</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border dark:divide-border">
                    @foreach ($reservations as $reservation)
                        <tr class="hover:bg-surface dark:hover:bg-surface/50 transition-colors">
                            <td class="py-4">
                                <a
                                    href="{{ page_url($reservationPage, ['reservationId' => $reservation->reservation_id, 'hash' => $reservation->hash]) }}"
                                    wire:navigate
                                    class="inline-flex items-center px-3 py-1 rounded-lg bg-surface dark:bg-surface hover:bg-surface dark:hover:bg-surface text-sm font-medium text-text dark:text-text transition-colors"
                                >
                                    #{{ $reservation->reservation_id }}
                                </a>
                            </td>
                            <td class="py-4 text-sm text-text dark:text-text">
                                {{ $reservation->location ? $reservation->location->location_name : null }}
                            </td>
                            <td class="py-4">
                                @include('tipowerup-orange-tw::includes.reservation.status-badge', ['reservation' => $reservation])
                            </td>
                            <td class="py-4 text-sm text-text dark:text-text">
                                {{ $reservation->reserve_date->setTimeFromTimeString($reservation->reserve_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
                            </td>
                            <td class="py-4 text-sm text-text dark:text-text">
                                {{ $reservation->table_name }}
                            </td>
                            <td class="py-4 text-sm text-text dark:text-text">
                                {{ $reservation->guest_num }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View --}}
        <div class="md:hidden space-y-4">
            @foreach ($reservations as $reservation)
                @include('tipowerup-orange-tw::includes.reservation.card', ['reservation' => $reservation, 'reservationPage' => $reservationPage])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $reservations->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-text dark:text-text">
                @lang('igniter.reservation::default.text_empty')
            </h3>
            <p class="mt-1 text-sm text-text-muted dark:text-text-muted">
                @lang('tipowerup.orange-tw::default.reservations.empty_text')
            </p>
            <div class="mt-6">
                <a
                    href="{{ page_url('reservation.reservation') }}"
                    wire:navigate
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-surface focus:ring-primary-500"
                >
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    @lang('tipowerup.orange-tw::default.reservations.make_reservation')
                </a>
            </div>
        </div>
    @endif
</div>
