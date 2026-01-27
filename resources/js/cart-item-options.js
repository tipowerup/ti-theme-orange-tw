window.OrangeCartItemOptions = (min, max) => {
    return {
        minSelection: min,
        maxSelection: max,
        toggleSelection() {
            if (this.maxSelection <= 0)
                return;

            const selectedCount = this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:checked:not([disabled])').length;

            [...this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:not(:checked)')]
                .forEach(($el) => {
                    selectedCount === this.maxSelection ? $el.setAttribute('disabled', 'disabled') : $el.removeAttribute('disabled')
                })
        },
        init() {
            Livewire.on('cartItemTotalCalculated', () => {
                this.toggleSelection()
            })

            // Handle show more/less options toggle
            const moreBtn = this.$el.querySelector('[data-toggle="more-options"]');
            const lessBtn = this.$el.querySelector('[data-toggle="less-options"]');
            const hiddenOptions = this.$el.querySelector('.hidden-item-options');

            if (moreBtn && lessBtn && hiddenOptions) {
                moreBtn.addEventListener('click', () => {
                    moreBtn.style.display = 'none';
                    lessBtn.style.display = 'block';
                    hiddenOptions.style.display = 'block';
                });

                lessBtn.addEventListener('click', () => {
                    lessBtn.style.display = 'none';
                    moreBtn.style.display = 'block';
                    hiddenOptions.style.display = 'none';
                });
            }
        }
    }
}
