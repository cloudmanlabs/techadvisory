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

    $("#viewVendorProposalEvaluationWizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        labels: {
            finish: 'Submit validation'
        },
        onFinishing: function (event, currentIndex) {
            // TODO Here check if all thingies have a value
            window.location.replace("/accenture/project/home");
        },
        // HACK Cause otherwise subwizards don't work
        onStepChanged: function (e, c, p) {
            for (let i = 0; i < 10; i++) {
                $('#viewVendorProposalEvaluationWizard-p-' + i).css('display', 'none')
            }

            $('#viewVendorProposalEvaluationWizard-p-' + c).css('display', 'block')
        }
    });

    $("#projectViewWizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        showFinishButtonAlways: false,
        enableFinishButton: false,
        // HACK Cause otherwise subwizards don't work
        onStepChanged: function (e, c, p) {
            for (let i = 0; i < 10; i++) {
                $('#projectViewWizard-p-' + i).css('display', 'none')
            }

            $('#projectViewWizard-p-' + c).css('display', 'block')
        }
    });

    $("#projectEditWizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        labels: {
            finish: 'Save'
        },
        onFinishing: function (event, currentIndex) {
            // TODO Here check if all thingies have a value
            window.location.replace("/accenture/project/view");
        },
        // HACK Cause otherwise subwizards don't work
        onStepChanged: function (e, c, p) {
            for (let i = 0; i < 10; i++) {
                $('#projectEditWizard-p-' + i).css('display', 'none')
            }

            $('#projectEditWizard-p-' + c).css('display', 'block')
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
