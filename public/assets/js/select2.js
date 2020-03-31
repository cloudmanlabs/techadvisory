$(function () {
    'use strict'

    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }
    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }


    // TODO Implement this
    function updateOpenProjects() {
        var selectedClients = $('#openProjectsClientSelect').select2('data').map((el) => {
            return el.text
        });
        var selectedPractices = $('#openProjectsPracticeSelect').select2('data').map((el) => {
            return el.text
        });

        // TODO If one is empty display all of them

        // TODO Add a display none to the one which don't have this tags
    }
    $('#openProjectsClientSelect').select2();
    $('#openProjectsClientSelect').on('change', function (e) {
        updateOpenProjects();
    });
    $('#openProjectsPracticeSelect').select2();
    $('#openProjectsPracticeSelect').on('change', function (e) {
        updateOpenProjects();
    });
});
