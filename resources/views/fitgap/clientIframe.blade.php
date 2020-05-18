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
                url:"{{route('fitgapClientJson', ['project' => $project])}}",
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
                        title: 'Client',
                        width: 140,
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
                        width: 110,

                        @if($disabled)
                        readOnly: true,
                        @endif
                    }
                ],
                onchange: function(instance, cell, x, y, value) {
                    @if(! $disabled)
                        $.post("{{route('fitgapClientJsonUpload', ['project' => $project])}}", {
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