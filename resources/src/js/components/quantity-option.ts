/**
 * State container for a single quantity-style menu option row in the cart
 * item modal. Holds the option's quantity and its per-unit price so child
 * inputs can bind to and increment/decrement them.
 *
 * Usage in blade:
 *   <div x-data="quantityOption({ quantity: 0, price: 1.5 })">
 */
import type { AlpineComponent } from '../types/alpine';

interface QuantityOptionState {
    optionQuantity: number;
    optionPrice: number;
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data(
        'quantityOption',
        ({ quantity = 0, price = 0 }: { quantity?: number; price?: number } = {}): AlpineComponent<QuantityOptionState> => ({
            optionQuantity: quantity,
            optionPrice: price,
        }),
    );
});
