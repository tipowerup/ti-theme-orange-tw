/**
 * State container for a single quantity-style menu option row in the cart
 * item modal. Holds the option's quantity and its per-unit price so child
 * inputs can bind to and increment/decrement them.
 *
 * Usage in blade:
 *   <div x-data="quantityOption({ quantity: 0, price: 1.5 })">
 */
document.addEventListener('alpine:init', () => {
    window.Alpine.data('quantityOption', ({ quantity = 0, price = 0 } = {}) => ({
        optionQuantity: quantity,
        optionPrice: price,
    }));
});
