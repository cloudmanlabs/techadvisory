(function ($) {
    'use strict';

    window.showSavedToast = function () {
        $.toast({
            heading: 'Saved successfully!',
            showHideTransition: 'slide',
            icon: 'success',
            hideAfter: 2000,
            position: 'bottom-right'
        })
    }

    window.showErrorToast = function () {
        $.toast({
            heading: 'Oops! Something went wrong!',
            showHideTransition: 'slide',
            icon: 'error',
            hideAfter: 2000,
            position: 'bottom-right'
        });
    }
})(jQuery);
