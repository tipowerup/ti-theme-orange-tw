/**
 * Checkout fulfillment toggle (ASAP / scheduled). Bridges Livewire state into
 * an Alpine scope so child elements can react without round-tripping every
 * change through the server.
 *
 * Usage in blade:
 *   <div x-data="checkoutFulfillment({
 *       isAsap: @js($isAsap),
 *       orderDate: @js($orderDate),
 *       orderTime: @js($orderTime),
 *       timeslot: @js($timeslotTimes),
 *   })">
 */
document.addEventListener('alpine:init', () => {
    window.Alpine.data('checkoutFulfillment', ({ isAsap, orderDate, orderTime, timeslot }) => ({
        isAsap,
        orderDate,
        orderTime,
        showTimePicker: !isAsap,
        timeslot,

        init() {
            this.$wire.$watch('orderDate', (value) => {
                this.orderDate = value;
            });
            this.$wire.$watch('isAsap', (value) => {
                this.isAsap = value == 1;
                this.showTimePicker = value == 0;
            });
        },

        setAsap(value) {
            this.isAsap = value == 1;
            this.showTimePicker = value == 0;
            this.$wire.set('isAsap', value == 1);
        },
    }));
});
