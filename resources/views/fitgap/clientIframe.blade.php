<html>
<meta name="_token" content="{{ csrf_token() }}"/>
<link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jexcel.css')}}" type="text/css"/>
<link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jsuites.css')}}" type="text/css"/>
<link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/extra.css')}}" type="text/css"/>
<link rel="stylesheet" href="{{url('assets/css/jquery.toast.min.css')}}">

<script src="{{url('assets/vendors/core/core.js')}}"></script>
<script src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jexcel.js')}}"></script>
<script src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jsuites.js')}}"></script>
<script src="{{url('assets/js/jquery.toast.min.js')}}"></script>

<style>
    * {
        font-size: 12px
    }

    td {
        text-align: left !important;
    }
</style>

<body style="background-color: white !important; overflow-x: scroll">
<p>
    <button id='download'>Export document</button>
</p>

<div id="spreadsheet"></div>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        function showWarningToast(msg) {
            $.toast({
                heading: msg,
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'bottom-right'
            })
        }

        function showDataUpdatedToast() {
            $.toast({
                heading: 'Data updated from the server',
                showHideTransition: 'slide',
                icon: 'warning',
                hideAfter: 3000,
                position: 'bottom-right'
            })
        }

        const mySpreadsheet = jexcel(document.getElementById('spreadsheet'), {
            url: "{{ route('fitgapClientJson', ['project' => $project]) }}",
            tableOverflow: false,
            contextMenu: false,
            allowInsertColumn: false,
            allowInsertRow: true,
            allowManualInsertRow: true,
            allowDeleteRow: true,
            moveRow: true,
            columns: [
                {
                    type: 'hidden',
                    title: 'ID',
                    readOnly: true,
                    width: 100,
                },
                {
                    type: 'text',
                    title: 'Type',
                    @if($disabled || !$isAccenture)
                    readOnly: true,
                    @endif
                    width: 100
                },
                {
                    type: 'text',
                    title: 'Level 1',
                    @if($disabled || !$isAccenture)
                    readOnly: true,
                    @endif
                    width: 120
                },
                {
                    type: 'text',
                    title: 'Level 2',
                    @if($disabled || !$isAccenture)
                    readOnly: true,
                    @endif
                    width: 140
                },
                {
                    type: 'text',
                    title: 'Level 3',
                    @if($disabled || !$isAccenture)
                    readOnly: true,
                    @endif
                    width: 140
                },
                {
                    type: 'text',
                    title: 'Requirement',
                    @if($disabled || !$isAccenture)
                    readOnly: true,
                    @endif
                    width: 600,
                    wordWrap: true
                },
                {
                    type: 'dropdown',
                    title: 'Client',
                    width: 240,
                    source: [
                        'Must',
                        'Required',
                        'Nice to have',
                    ],
                    @if($disabled)
                    readOnly: true,
                    @endif
                },
                {
                    type: 'text',
                    title: 'Business Opportunity',
                    width: 210,
                    wordWrap: true,
                    @if($disabled || !$isAccenture)
                    readOnly: true,
                    @endif
                },
            ],
            @if(!$disabled)
            onchange: function (instance, cell, x, y, value) {
                $.post("{{ route('updateFitgapQuestion') }}", {
                    data: mySpreadsheet.getRowData(y),
                    position: y
                }).fail(window.parent.handleAjaxError)
            },
            onbeforedeleterow: function (el, rowNumber, numRows, rowRecords) {
                if (numRows > 1) {
                    showWarningToast("You can't delete several rows at the same time");
                } else {
                    $.post("{{ route('deleteFitgapQuestion',  ['project' => $project]) }}", {
                        data: mySpreadsheet.getRowData(rowNumber),
                    }).fail(window.parent.handleAjaxError);
                }
            },
            oninsertrow: function (element, rowNumber, numRows, rowRecords) {
                $.post("{{ route('createFitgapQuestion', ['project' => $project]) }}")
                    .done(function (response) {
                        mySpreadsheet.setValueFromCoords(0, rowNumber + 1, response.data.id, true);
                    }).fail(window.parent.handleAjaxError);
            },
            onmoverow: function (element, origin, destiny) {
                $.post("{{ route('moveFitgapQuestion', ['project' => $project]) }}", {
                    fitgap_question_id: mySpreadsheet.getRowData(destiny)[0],
                    to: destiny
                }).fail(window.parent.handleAjaxError);
            }
            @endif
        });

        var columnMapping = {
            0: 'ID',
            1: 'Type',
            2: 'Level 1',
            3: 'Level 2',
            4: 'Level 3',
            5: 'Requirement',
            6: 'Client',
            7: 'Business Opportunity'
        }

        setInterval(function () {
            $.get("{{ route('fitgapClientJson', ['project' => $project]) }}")
                .done(function (response) {
                    var currentData = mySpreadsheet.getData();
                    var serverData = response;
                    var hasBeenUpdated = false;
                    if (currentData.length !== serverData.length) {
                        mySpreadsheet.setData(response);
                        hasBeenUpdated = true;
                    } else {
                        for (var row = 0; row < currentData.length; row++) {
                            for (var column = 0; column <= 7; column++) {
                                if (currentData[row][column] !== serverData[row][columnMapping[column]]) {
                                    mySpreadsheet.setValueFromCoords(column, row, serverData[row][columnMapping[column]], true);
                                    hasBeenUpdated = true;
                                }
                            }
                        }
                    }

                    if (hasBeenUpdated) showDataUpdatedToast();
                })
        }, 3000)

        document.getElementById('download').onclick = function () {
            mySpreadsheet.download();
        }
    })
</script>
</body>
</html>
