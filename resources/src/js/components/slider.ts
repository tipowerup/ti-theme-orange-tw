/**
 * Image slider with autoplay. Pauses on hover (the blade wires the
 * mouseenter/mouseleave handlers).
 *
 * Usage in blade: <div x-data="slider({ slideCount: 5, interval: 5000 })">
 */
import type { AlpineComponent } from '../types/alpine';

interface SliderState {
    currentSlide: number;
    slides: number;
    autoplay: boolean;
    interval: number;
    timer: ReturnType<typeof setInterval> | null;
    init(): void;
    startAutoplay(): void;
    stopAutoplay(): void;
    next(): void;
    prev(): void;
    goTo(index: number): void;
}

interface SliderArgs {
    slideCount: number;
    interval: number;
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data('slider', ({ slideCount, interval }: SliderArgs): AlpineComponent<SliderState> => ({
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

        goTo(index: number) {
            this.currentSlide = index;
        },
    }));
});
