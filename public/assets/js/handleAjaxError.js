/**
 * Depends on toast.js
 */
(function ($) {
    'use strict';

    window.handleAjaxError = function () {
        showErrorToast()
        setTimeout(function () {
            location.reload();
        }, 200000)
    }
})(jQuery);
