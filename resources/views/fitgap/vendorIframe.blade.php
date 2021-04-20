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

<body style="background-color: white !important;">
<p>
    <button id='download'>Export document</button>
</p>

<div id="spreadsheet"></div>

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    });

    function showDataUpdatedToast() {
        $.toast({
            heading: 'Data updated from the server',
            showHideTransition: 'slide',
            icon: 'warning',
            hideAfter: 3000,
            position: 'bottom-right'
        })
    }

    var mySpreadsheet = jexcel(document.getElementById('spreadsheet'), {
        url: "{{ route('fitgapVendorJson', ['vendor' => $vendor, 'project' => $project]) }}",
        tableOverflow: false,
        contextMenu: false,
        allowInsertColumn: false,
        allowInsertRow: false,
        allowManualInsertRow: false,
        allowDeleteRow: false,
        allowDeleteColumn: false,
        columns: [
            {
                type: 'hidden',
                title: 'ID',
                readOnly: true
            },
            {
                type: 'text',
                title: 'Type',
                readOnly: true,
                width: 100
            },
            {
                type: 'text',
                title: 'Level 1',
                readOnly: true,
                width: 120
            },
            {
                type: 'text',
                title: 'Level 2',
                readOnly: true,
                width: 140
            },
            {
                type: 'text',
                title: 'Level 3',
                readOnly: true,
                width: 140
            },
            {
                type: 'text',
                title: 'Requirement',
                readOnly: true,
                width: 600,
                wordWrap: true
            },
            {
                type: 'dropdown',
                title: 'Vendor response',
                width: 200,
                source: [
                    'Product does not support the functionality',
                    'Functionality planned for a future release',
                    'Product partially supports the functionality',
                    'Product fully supports the functionality'
                ],
                @if($disabled)
                readOnly: true,
                @endif
            },
            {
                type: 'text',
                title: 'Comments',
                width: 200,
                wordWrap: true,
                @if($disabled)
                readOnly: true,
                @endif
            },
        ],
        @if(!$disabled)
        onchange: function (instance, cell, x, y, value) {
            $.post("{{route('updateFitgapResponse', ['project' => $project, 'vendor' => $vendor])}}", {
                data: mySpreadsheet.getRowData(y),
            }).fail(window.parent.handleAjaxError);
        },
        @endif
    });

    var columnMapping = {
        0: 'ID',
        1: 'Type',
        2: 'Level 1',
        3: 'Level 2',
        4: 'Level 3',
        5: 'Requirement',
        6: 'Vendor response',
        7: 'Comments'
    }

    setInterval(function () {
        $.get("{{ route('fitgapVendorJson', ['vendor' => $vendor, 'project' => $project]) }}")
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
</script>
</body>
</html>
