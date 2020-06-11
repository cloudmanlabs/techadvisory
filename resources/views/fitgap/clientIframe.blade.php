<html>
    <meta name="_token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jexcel.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jsuites.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/extra.css')}}" type="text/css" />

    <script src="{{url('assets/vendors/core/core.js')}}"></script>
    <script src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jexcel.js')}}"></script>
    <script src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/dist/jsuites.js')}}"></script>

    <body style="background-color: white !important; overflow-x: scroll">
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
                        @if($disabled || !$isAccenture)
                        readOnly: true,
                        @endif
                        width: 210
                    },
                    {
                        type: 'text',
                        title: 'Level 1',
                        @if($disabled || !$isAccenture)
                        readOnly: true,
                        @endif
                        width: 180
                    },
                    {
                        type: 'text',
                        title: 'Level 2',
                        @if($disabled || !$isAccenture)
                        readOnly: true,
                        @endif
                        width: 230
                    },
                    {
                        type: 'text',
                        title: 'Level 3',
                        @if($disabled || !$isAccenture)
                        readOnly: true,
                        @endif
                        width: 230
                    },
                    {
                        type: 'text',
                        title: 'Requirement',
                        @if($disabled || !$isAccenture)
                        readOnly: true,
                        @endif
                        width: 250
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

                        @if($disabled || !$isAccenture)
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
