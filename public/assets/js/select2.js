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
        var selectedPractices = $('#homePracticeSelect').select2('data').map((el) => {
            return el.text
        });
        var selectedClients = $('#homeClientSelect').select2('data').map((el) => {
            return el.text
        });

        console.log(selectedClients)
        console.log(selectedPractices)

        // Add a display none to the one which don't have this tags
        $('#openPhaseContainer').children().each(function () {
            let practice = $(this).data('practice');
            let client = $(this).data('client');

            if ($.inArray(practice, selectedPractices) !== -1 && $.inArray(client, selectedClients) !== -1) {
                $(this).css('display', 'flex')
            } else {
                $(this).css('display', 'none')
            }
        });
        $('#preparationPhaseContainer').children().each(function () {
            let practice = $(this).data('practice');
            let client = $(this).data('client');

            if ($.inArray(practice, selectedPractices) !== -1 && $.inArray(client, selectedClients) !== -1) {
                $(this).css('display', 'flex')
            } else {
                $(this).css('display', 'none')
            }
        });
        $('#oldPhaseContainer').children().each(function () {
            let practice = $(this).data('practice');
            let client = $(this).data('client');

            if ($.inArray(practice, selectedPractices) !== -1 && $.inArray(client, selectedClients) !== -1) {
                $(this).css('display', 'flex')
            } else {
                $(this).css('display', 'none')
            }
        });
    }

    $('#homePracticeSelect').select2();
    $('#homePracticeSelect').on('change', function (e) {
        updateOpenProjects();
    });
    $('#homeClientSelect').select2();
    $('#homeClientSelect').on('change', function (e) {
        updateOpenProjects();
    });
});
