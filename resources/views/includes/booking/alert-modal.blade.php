<div
    x-data="{ show: false, message: '', exception: '' }"
    @booking::alert.window="show = $event.detail.show; message = $event.detail.message; exception = $event.detail.exception"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity bg-surface dark:bg-body bg-opacity-75 dark:bg-opacity-75"
            @click="show = false"
        ></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block w-full max-w-lg overflow-hidden text-left align-bottom transition-all transform bg-body dark:bg-surface rounded-lg shadow-xl sm:my-8 sm:align-middle"
        >
            <div class="px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                        <h3 class="text-lg font-medium text-text dark:text-text" x-text="message"></h3>
                        <div class="mt-2" x-show="exception">
                            <p class="text-sm text-text-muted dark:text-text-muted" x-text="exception"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-surface dark:bg-surface sm:px-6 sm:flex sm:flex-row-reverse">
                <button
                    type="button"
                    @click="show = false"
                    class="w-full px-4 py-2 text-base font-medium text-white bg-primary-600 hover:bg-primary-700 border border-transparent rounded-lg shadow-sm sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                >
                    @lang('igniter.orange::default.button_close')
                </button>
            </div>
        </div>
    </div>
</div>
