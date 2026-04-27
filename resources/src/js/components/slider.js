/**
 * Image slider with autoplay. Pauses on hover (the blade wires the
 * mouseenter/mouseleave handlers).
 *
 * Usage in blade: <div x-data="slider({ slideCount: 5, interval: 5000 })">
 */
document.addEventListener('alpine:init', () => {
    window.Alpine.data('slider', ({ slideCount, interval }) => ({
        currentSlide: 0,
        slides: slideCount,
        autoplay: true,
        interval,
        timer: null,

        init() {
            if (this.autoplay && this.slides > 1) {
                this.startAutoplay();
            }
        },

        startAutoplay() {
            this.timer = setInterval(() => this.next(), this.interval);
        },

        stopAutoplay() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },

        next() {
            this.currentSlide = (this.currentSlide + 1) % this.slides;
        },

        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.slides) % this.slides;
        },

        goTo(index) {
            this.currentSlide = index;
        },
    }));
});
