/**
 * Global pre-flight: make third-party libs available on window BEFORE any
 * side-effect import (like resources/js/checkout.js) can run.
 *
 * ES module imports execute top-down before any top-level statements, so
 * the window.* assignments at the top of app.js were happening too late.
 * Anything that reads window.jQuery / window.flatpickr at module load must
 * either live downstream of this import or be imported after it.
 */
import $ from 'jquery';
import flatpickr from 'flatpickr';
import intlTelInput from 'intl-tel-input';
import intlTelInputUtilsUrl from 'intl-tel-input/build/js/utils.js?url';

window.jQuery = window.$ = $;
window.flatpickr = flatpickr;
window.intlTelInput = intlTelInput;
window.intlTelInputUtilsUrl = intlTelInputUtilsUrl;

// jQuery render plugin — `$.fn.render(cb)` registers a callback fired when
// the document-level 'render' event triggers (dispatched by the Livewire
// hook in app.js after requests/navigates). Defined here because downstream
// IIFE imports (e.g. resources/js/checkout.js) call `$(document).render(...)`
// at module load time and need $.fn.render to already exist.
$.fn.render = function (callback) { $(document).on('render', callback); };

export { $ as jQuery };
export default $;
