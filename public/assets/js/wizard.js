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

    $("#clientNewProjectSetUpWizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        labels: {
            finish: 'Submit general set up'
        },
        onFinishing: function (event, currentIndex) {
            window.location.replace("/client/home");
        },
        onStepChanging: function (e, c, n) {
            // Change the button name on Sizing info
            if (n == 2) {
                $('#clientNewProjectSetUpWizard-next').html('Submit general set up')
            } else {
                $('#clientNewProjectSetUpWizard-next').html('Next')
            }


            // if (c == 2) {
            //     window.location.replace("/client/home");
            // }

            return true
        },
        onStepChanged: function (e, c, p) {
            for (let i = 0; i < 10; i++) {
                $('#clientNewProjectSetUpWizard-p-' + i).css('display', 'none')
            }
            $('#clientNewProjectSetUpWizard-p-' + c).css('display', 'block')
        }
    });

    $("#clientNewProjectSetUpWizard-withSelectionCriteria").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        labels: {
            finish: 'Submit general set up'
        },
        onFinishing: function (event, currentIndex) {
            // TODO Only let the client submit if all the fields are full

            window.location.replace("/client/home");
        },
        onStepChanging: function (e, c, n) {
            // TODO Check if all the fields are filled
            var canGoToSelection = false;

            if (n == 2 && !canGoToSelection) {
                $('#clientNewProjectSetUpWizard-next').html('Submit general set up')
            } else {
                $('#clientNewProjectSetUpWizard-next').html('Next')
            }

            // Check if we can move to selection criteria
            if (c == 2) {
                if (canGoToSelection) {
                    window.location.replace("/client/home");
                    return false
                } else {
                    return true
                }
            }

            return true
        },
        onStepChanged: function (e, c, p) {
            for (let i = 0; i < 10; i++) {
                $('#clientNewProjectSetUpWizard-p-' + i).css('display', 'none')
            }
            $('#clientNewProjectSetUpWizard-p-' + c).css('display', 'block')
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

    $("#viewVendorProposalClient").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onFinishing: function (event, currentIndex) {
            window.location.replace("/client/project/home");
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
