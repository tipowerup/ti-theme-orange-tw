import type { JQueryStatic } from 'jquery';

declare global {
    interface Window {
        jQuery: JQueryStatic;
        $: JQueryStatic;
        flatpickr: any;
        intlTelInput: any;
        intlTelInputUtilsUrl: string;
        currency: any;
        app: any;
        Livewire: any;
        Alpine: any;
        OrangeCartItem: () => any;
        OrangeCartItemCheckbox: (key: string, id: number) => any;
        OrangeCartItemOptions: (min: number, max: number) => any;
        stickyHeader: () => any;
        OrangeFulfillment?: any;
        OrangeCheckout?: any;
        OrangeGoogleMaps?: any;
    }

    const app: any;
    const Livewire: any;
    const Alpine: any;
    const flatpickr: any;
    const intlTelInput: any;
    const google: any;
    const L: any;

    interface JQuery<TElement = HTMLElement> {
        render(callback: () => void): any;
        booking(): JQuery<TElement>;
        checkout: any;
        fulfillment: any;
    }
}

declare module '*?url' {
    const url: string;
    export default url;
}

declare module 'intl-tel-input' {
    const intlTelInput: any;
    export default intlTelInput;
}

declare module '@tipowerup/ti-theme-toolkit/js/dark-mode';

export {};
