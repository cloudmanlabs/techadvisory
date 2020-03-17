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
            window.location.replace("./vendor_new_solution_set_up.html");
        }
    });


    $("#wizard_vendor_go_to_home").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onFinishing: function (event, currentIndex) {
            window.location.replace("./vendor_home.html");
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
