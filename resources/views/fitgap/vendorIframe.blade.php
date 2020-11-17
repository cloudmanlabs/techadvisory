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

<div id="spreadsheet"></div>


<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    });

    function showSavedToast() {
        $.toast({
            heading: 'Saved!',
            showHideTransition: 'slide',
            icon: 'success',
            hideAfter: 1000,
            position: 'bottom-right'
        })
    }

    function showErrorToast() {
        $.toast({
            heading: 'Error!',
            showHideTransition: 'slide',
            icon: 'error',
            hideAfter: 1000,
            position: 'bottom-right'
        })
    }

    var mySpreadsheet = jexcel(document.getElementById('spreadsheet'), {
        url: "{{route('fitgapVendorJson', ['vendor' => $vendor, 'project' => $project])}}",
        tableOverflow: false,
        contextMenu: false,
        allowInsertColumn:false,
        allowInsertRow:false,
        allowManualInsertRow:false,
        allowDeleteRow:false,
        allowDeleteColumn:false,
        columns: [
            {
                type: 'text',
                title: 'ID',
                readOnly: true,
                width: 100
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
                title: 'Vendor Response',
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
        onchange: function (instance, cell, x, y, value) {
            @if(! $disabled)
            $.post("{{route('updateFitgapResponse', ['project' => $project])}}", {
                data: mySpreadsheet.getRowData(y),
            }).done(function () {
                showSavedToast();
            }).fail(function (jqXHR, textStatus, error) {
                showErrorToast();
            });
            @endif
        },
    });

    document.getElementById('download').onclick = function () {
        mySpreadsheet.download();
    }
</script>
</body>
</html>
