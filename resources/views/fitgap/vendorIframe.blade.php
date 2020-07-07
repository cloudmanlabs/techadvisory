<html>
    <meta name="_token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jexcel.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jsuites.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/extra.css')}}" type="text/css" />

    <script src="{{url('assets/vendors/core/core.js')}}"></script>
    <script src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jexcel.js')}}"></script>
    <script src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jsuites.js')}}"></script>

    <style>
        *{
            font-size: 12px
        }
    </style>

    <body style="background-color: white !important;">
        <div id="spreadsheet"></div>

        <p><button id='download'>Export document</button></p>

        <script>
            $(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            });


            var mySpreadsheet = jexcel(document.getElementById('spreadsheet'), {
                url:"{{route('fitgapVendorJson', ['vendor' => $vendor, 'project' => $project])}}",
                tableOverflow:false,
                contextMenu: false,
                columns: [
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
                        width: 600
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

                        @if($disabled)
                        readOnly: true,
                        @endif
                    },
                ],
                onchange: function(instance, cell, x, y, value) {
                    @if(! $disabled)
                        $.post("{{route('fitgapVendorJsonUpload', ['vendor' => $vendor, 'project' => $project])}}", {
                            data: mySpreadsheet.getJson()
                        })
                    @endif
                }
            });


            document.getElementById('download').onclick = function () {
                mySpreadsheet.download();
            }
        </script>
    </body>
</html>
