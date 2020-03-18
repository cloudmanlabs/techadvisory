$(async function () {
    'use strict';

    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onFinishing: function (event, currentIndex) {
            window.location.replace("/client/home");
        }
    });


    $("#wizard_vendor").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onFinishing: function (event, currentIndex) {
            window.location.replace("/vendor/newSolutionSetUp");
        }
    });

    $("#wizardVendorAccenture").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onFinishing: function (event, currentIndex) {
            window.location.replace("/accenture/vendorList");
        }
    });

    $("#wizard_vendor_go_to_home").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onFinishing: function (event, currentIndex) {
            window.location.replace("/vendor/home");
        }
    });

    $("#wizard_accenture").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onFinishing: function (event, currentIndex) {
            window.location.replace("/accenture/home");
        },
        // HACK Cause otherwise subwizards don't work
        onStepChanged: function (e, c, p) {
            for (let i = 0; i < 10; i++) {
                $('#wizard_accenture-p-' + i).css('display', 'none')
            }

            $('#wizard_accenture-p-' + c).css('display', 'block')
        }
    });


    $("#subwizard").steps({
        headerTag: "h3",
        bodyTag: "div",
        transitionEffect: "slideLeft",
        showFinishButtonAlways: false,
        enableFinishButton: false,
    });
});
