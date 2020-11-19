@extends('accentureViews.layouts.benchmark')
@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="benchmark"/>
        <div class="page-wrapper">
            <div class="page-content">

                <div class="row" id="benchmark-title-row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Welcome to Benchmark and Analytics</h3>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-page" id="benchmark-nav-container">
                    <div class="row" id="navs-container">
                        <div class="col-12 grid-margin">
                            @include('accentureViews.benchmarkNavBar')
                            @include('accentureViews.benchmarkCustomSearchesNavBar')
                        </div>
                    </div>

                    <div class="row" id="content-container">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h3>Other Queries</h3>
                                    <p class="welcome_text extra-top-15px">
                                        Select the filter criteria to find all relevant vendors.
                                    </p>
                                    <br>

                                    <div id="filterContainer">
                                        <br>
                                        <div id="vendorSelects">
                                            <h5>Search from Vendor</h5>
                                            <br>
                                            <div class="media-body" style="padding: 20px;">
                                                <p class="welcome_text">
                                                    Please choose the Vendor Segments you'd like to see:
                                                </p>
                                                <select id="segmentSelect" class="w-100">
                                                    <option selected="true" value="">Choose a option</option>
                                                    @foreach ($segments as $segment)
                                                        <option>{{$segment}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="media-body" style="padding: 20px; ">
                                                <p class="welcome_text">
                                                    Please choose the Regions you'd like to see:
                                                </p>
                                                <select id="regionSelect" class="w-100">
                                                    <option selected="true" value="">Choose a option</option>
                                                    @foreach ($regions as $region)
                                                        <option>{{$region}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="media-body" style="padding: 20px;">
                                                <p class="welcome_text">
                                                    Please choose the Industries you'd like to see:
                                                </p>
                                                <select id="industrySelect" class="w-100">
                                                    <option selected="true" value="">Choose a option</option>
                                                    @foreach ($industries as $industry)
                                                        <option>{{$industry}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>
                                        <div id="vendorSolutionSelects">
                                            <h5>Search from Vendor Solution</h5>
                                            <br>
                                            <div class="media-body" style="padding: 20px;">
                                                <p class="welcome_text">
                                                    Please choose the SC Capability (Practice) you'd like to see:
                                                </p>
                                                <select id="practiceSelect" class="w-100">
                                                    <option value="null">-- Select a Practice --</option>
                                                    @foreach ($practices as $practice)
                                                        <option>{{$practice}}</option>
                                                    @endforeach
                                                    <option value="No Practice">No Practice</option>
                                                </select>
                                            </div>

                                            <div id="scopesDiv" class="media-body" style="padding: 20px;">
                                                <p class="welcome_text">Please choose the Scope you'd like to see:</p>
                                                <div id="TransportScope" class="form-group">
                                                    <p id="Transport1" class="welcome_text">Transport Flows</p>
                                                    <select id="selectTransport1" class="w-100">
                                                        <option selected="true" value="">Choose a option</option>
                                                        @foreach ($transportFlows as $transportFlow)
                                                            <option>{{$transportFlow}}</option>
                                                        @endforeach
                                                    </select>
                                                    <p id="Transport2" class="welcome_text">Transport Mode</p>
                                                    <select id="selectTransport2" class="w-100">
                                                        <option selected="true" value="">Choose a option</option>
                                                        @foreach ($transportModes as $transportMode)
                                                            <option>{{$transportMode}}</option>
                                                        @endforeach
                                                    </select>
                                                    <p id="Transport3" class="welcome_text">Transport Type</p>
                                                    <select id="selectTransport3" class="w-100">
                                                        <option selected="true" value="">Choose a option</option>
                                                        @foreach ($transportTypes as $transportType)
                                                            <option>{{$transportType}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="subpracticesContainer" class="media-body" style="padding: 20px;">
                                                <p id="subpracticesText" class="welcome_text">Subpractices</p>
                                                <select id="selectSubpractices" class="w-100">
                                                    <option selected="true" value="">Choose a option</option>
                                                </select>
                                            </div>
                                        </div>

                                        <br>
                                        <h3 style="color: #A12BFE">Search Results</h3>
                                        <br>
                                        <br>

                                        <!-- All Vendors -->
                                        <div id="vendorsContainer">
                                            @foreach ($vendors as $vendor)
                                                <div class="card" id="{{$vendor->id}}" style="margin-bottom: 30px;"
                                                     data-id="{{$vendor->id}}"
                                                     data-segment="{{$vendor->getVendorResponse('vendorSegment') ?? 'No segment'}}"
                                                     data-practice="{{json_encode($vendor->vendorSolutionsPractices()->pluck('name')->toArray() ?? [])}}"
                                                     data-subpractice="{{json_encode($vendor->vendorAppliedSubpractices() ?? [])}}"
                                                     data-transportFlow="{{json_encode($vendor->getVendorResponsesFromScope(9) ?? [])}}"
                                                     data-transportMode="{{json_encode($vendor->getVendorResponsesFromScope(10) ?? [])}}"
                                                     data-transportType="{{json_encode($vendor->getVendorResponsesFromScope(11) ?? [])}}"
                                                     data-manufacturing="{{json_encode($vendor->getVendorResponsesFromScope(5) ?? '')}}"
                                                     data-industry="{{implode(', ', json_decode($vendor->getVendorResponse('vendorIndustry')) ?? ['No Industry'])}}"
                                                     data-regions="{{$vendor->getVendorResponse('vendorRegions') ?? '[No Region]'}}"
                                                >
                                                    <div class="card-body">
                                                        <div style="float: left; max-width: 40%;">
                                                            <h4>{{$vendor->name}}</h4>
                                                            <p>{{$vendor->name}}
                                                                - {{$vendor->vendorSolutionsPracticesNames()}}
                                                            </p>
                                                            <p>
                                                                Segment: {{$vendor->getVendorResponse('vendorSegment') ?? 'No segment'}}
                                                            <p>
                                                            <p>
                                                                Industry: {{implode(', ', json_decode($vendor->getVendorResponse('vendorIndustry')) ?? [])}}</p>
                                                            <p>
                                                                Regions: {{implode(', ', json_decode($vendor->getVendorResponse('vendorRegions')) ?? [])}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="{{url('assets/vendors/select2/select2.min.js')}}"></script>

    <script>

        $('#practiceSelect').change(function () {

            var selectedPractice = $(this).val();
            $('#TransportScope').hide();
            $('#PlanningScope').hide();
            $('#scopesDiv').hide();
            $('#subpracticesContainer').hide();


            if (selectedPractice) {

                // More than one selection. No more subfilters permited.
                $('#TransportScope').hide();
                $('#PlanningScope').hide();
                $('#scopesDiv').hide();
                $('#subpracticesContainer').hide();

                // Scopes from practice (Only for Transport)
                $.get("/accenture/analysis/vendor/custom/getScopes/"
                    + selectedPractice, function (data) {

                    if (selectedPractice.includes('Transport') && Array.isArray(data.scopes)) {

                        var scopes = data.scopes;
                        var firstScope = scopes[0].type;

                        if (firstScope.includes('selectMultiple')) {
                            $('#scopesDiv').show();
                            $('#TransportScope').show();
                        }
                    }
                });

                // subpractices from practice
                $.get("/accenture/analysis/vendor/custom/getSubpractices/"
                    + selectedPractice, function (data) {

                    if (data) {
                        $('#subpracticesContainer').show();

                        $('#selectSubpractices').empty();

                        var $dropdown = $("#selectSubpractices");
                        $dropdown.append($("<option />").val(null).text('Choose an option'));
                        var subpractices = data.subpractices;
                        $.each(subpractices, function () {
                            $dropdown.append($("<option />").val(this.name).text(this.name));
                        });
                    }

                });
            }
        });

        $(document).ready(function () {

            $('#scopesDiv').hide();
            $('#TransportScope').hide();
            $('#PlanningScope').hide();
            $('#subpracticesContainer').hide();


            function updateVendors() {
                const selectedSegment = $('#segmentSelect').val();
                const selectedPractices = $('#practiceSelect').val();
                const selectedSubpractices = $('#subpracticeSelect').val();
                const selectedTransportFlow = $('#selectTransport1').val();
                const selectedTransportMode = $('#selectTransport2').val();
                const selectedTransportType = $('#selectTransport3').val();
                const selectedPlaning = $('#selectTransport3').val().toLocaleLowerCase();
                const selectedRegions = $('#regionSelect').val();
                const selectedIndustries = $('#industrySelect').val();

                // Add a display none to the one which don't have this tags
                $('#vendorsContainer').children().each(function () {
                    const name = $(this).data('name');
                    const practice = $(this).data('practice');
                    const subpractices = $(this).data('subpractices');
                    const industry = $(this).data('industry');
                    const regions = $(this).data('regions');

                    /*                    if (
                                            (selectedPractices === 'null' ? true : practice.includes(selectedPractices) === true)
                                            && (filterMultipleAND(selectedSubpractices, subpractices))
                                            && (selectedIndustries === 'null' ? true : industry.includes(selectedIndustries) === true)
                                            && (filterMultipleAND(selectedRegions, regions))
                                        ) {
                                            $(this).css('display', 'flex')
                                        } else {
                                            $(this).css('display', 'none')
                                        }*/
                });
            }

            function filterMultipleAND(arrayOptions, arrayToSearch) {

                return arrayOptions.length > 0 ? R.all(R.flip(R.includes)(arrayToSearch))(arrayOptions) : true;
            }

            $('#practiceSelect').on('change', function (e) {
                updateVendors()
            });

            $('#selectSubpractices').on('change', function (e) {
                updateVendors()
            });

            $('#segmentSelect').on('change', function (e) {
                updateVendors()
            });

            $('#selectTransport1').on('change', function (e) {
                updateVendors()
            });

            $('#selectTransport2').on('change', function (e) {
                updateVendors()
            });

            $('#selectTransport3').on('change', function (e) {
                updateVendors()
            });

            $('#regionSelect').on('change', function (e) {
                updateVendors()
            });
            $('#industrySelect').on('change', function (e) {
                updateVendors()
            });

            $('#PlanningInput1').keyup(function () {
                updateVendors()
            })

        });
    </script>
@endsection

