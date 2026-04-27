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
import type { AlpineComponent } from '../types/alpine';

type AsapFlag = 0 | 1 | boolean;

interface CheckoutFulfillmentArgs {
    isAsap: AsapFlag;
    orderDate: string | null;
    orderTime: string | null;
    timeslot: Record<string, string[]> | string[];
}

interface CheckoutFulfillmentState extends CheckoutFulfillmentArgs {
    showTimePicker: boolean;
    init(): void;
    setAsap(value: AsapFlag): void;
}

interface CheckoutWire {
    $watch(prop: string, callback: (value: AsapFlag | string | null) => void): void;
    set(prop: string, value: unknown): void;
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data(
        'checkoutFulfillment',
        ({ isAsap, orderDate, orderTime, timeslot }: CheckoutFulfillmentArgs): AlpineComponent<CheckoutFulfillmentState, CheckoutWire> => ({
            isAsap,
            orderDate,
            orderTime,
            showTimePicker: !isAsap,
            timeslot,

            init() {
                this.$wire.$watch('orderDate', (value) => {
                    this.orderDate = value as string | null;
                });
                this.$wire.$watch('isAsap', (value) => {
                    this.isAsap = value == 1;
                    this.showTimePicker = value == 0;
                });
            },

            setAsap(value: AsapFlag) {
                this.isAsap = value == 1;
                this.showTimePicker = value == 0;
                this.$wire.set('isAsap', value == 1);
            },
        }),
    );
});
