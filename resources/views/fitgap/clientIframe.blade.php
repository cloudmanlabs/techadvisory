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

            td {
        text-align:left !important;
            }
		</style>

    <body style="background-color: white !important; overflow-x: scroll">
        <p><button id='download'>Export document</button></p>

        <div id="spreadsheet"></div>


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
