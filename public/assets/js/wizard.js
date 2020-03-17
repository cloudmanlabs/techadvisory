$(function () {
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
        }
    });


});
