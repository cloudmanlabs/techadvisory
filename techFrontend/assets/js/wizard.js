$(function () {
    'use strict';

    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: false,
        onFinishing: function (event, currentIndex) {
            window.location.replace("./client_home.html");
        }
    });


    $("#wizard_vendor").steps({
        headerTag: "h2",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: false,
        onFinishing: function (event, currentIndex) {
            window.location.replace("./vendor_new_solution_set_up.html");
        }
    });


    $("#wizard_vendor_go_to_home").steps({
        headerTag: "h2",
        bodyTag: "section",
        onFinishing: function (event, currentIndex) {
            window.location.replace("./vendor_home.html");
        }
    });


    $("#wizard_accenture").steps({
        headerTag: "h2",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: false,
        onFinishing: function (event, currentIndex) {
            window.location.replace("./accenture_home.html");
        }
    });


    $("#subwizard").steps({
        headerTag: "h3",
        bodyTag: "div",
        enableAllSteps: true,
        enablePagination: false,
        stepsOrientation: "vertical",
        onFinishing: function (event, currentIndex) {
            window.location.replace("./accenture_home.html");
        }
    });


});
