<html>
    <meta name="_token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jexcel.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jsuites.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/extra.css')}}" type="text/css" />

    <script src="{{url('assets/vendors/core/core.js')}}"></script>
    <script src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jexcel.js')}}"></script>
    <script src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jsuites.js')}}"></script>

    <body style="background-color: white !important;">
        <div id="spreadsheet"></div>

        <p><button id='download'>Export document as CSV</button></p>

        <script>
            $(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            });


            var mySpreadsheet = jexcel(document.getElementById('spreadsheet'), {
                url:"{{route('fitgapVendorJson', ['vendor' => $vendor, 'project' => $project, 'review' => $review])}}",
                tableOverflow:false,
                contextMenu: false,
                columns: [
                    {
                        type: 'text',
                        title: 'Type',
                        readOnly: true,
                        width: 110
                    },
                    {
                        type: 'text',
                        title: 'Level 1',
                        readOnly: true,
                        width: 140
                    },
                    {
                        type: 'text',
                        title: 'Level 2',
                        readOnly: true,
                        width: 200
                    },
                    {
                        type: 'text',
                        title: 'Level 3',
                        readOnly: true,
                        width: 190
                    },
                    {
                        type: 'text',
                        title: 'Requirement',
                        readOnly: true,
                        width: 150
                    },
                    {
                        type: 'dropdown',
                        title: 'Vendor Score',
                        width: 140,
                        source: [
                            'Must have',
                            'Required',
                            'Nice to have'
                        ]
                    },
                    {
                        type: 'text',
                        title: 'Comments',
                        width: 110
                    },
                    @if($review)
                    {
                        type: 'text',
                        title: 'Score',
                        width: 110
                    },
                    @endif
                ],
                onchange: function(instance, cell, x, y, value) {
                    @if($disabled)
                        mySpreadsheet.undo()
                    @else
                        $.post("{{route('fitgapVendorJsonUpload', ['vendor' => $vendor, 'project' => $project])}}", {
                            data: mySpreadsheet.getJson()
                        })
                    @endif
                },
                @if($disabled)
                onselection: function(){
                    mySpreadsheet.undo()
                }
                @endif
            });


            document.getElementById('download').onclick = function () {
                mySpreadsheet.download();
            }
        </script>
    </body>
</html>
