@extends('accentureViews.layouts.benchmark')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="benchmark"/>

        <div class="page-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Global Analysis & Analytics</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            {{nova_get_setting('accenture_analysisVendorCustom_title') ?? ''}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Other Queries</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_analysisVendorCustom_otherQueries') ?? ''}}
                                </p>
                                <br>

                                <div id="filterContainer">
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

                                    <div class="media-body" style="padding: 20px;">
                                        <p class="welcome_text">
                                            Please choose the SC Capability (Practice) you'd like to see:
                                        </p>
                                        <select id="practiceSelect" class="w-100">
                                            <option selected="true" value="">Choose a option</option>
                                            @foreach ($practices as $practice)
                                                <option>{{$practice}}</option>
                                            @endforeach
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

                                    <!-- All Vendors -->
                                    <div id="projectContainer">
                                        @foreach ($vendors as $vendor)
                                            <div class="card" id="{{$vendor->id}}" style="margin-bottom: 30px;"
                                                 data-id="{{$vendor->id}}"
                                                 data-segment="{{$vendor->getVendorResponse('vendorSegment')}}"
                                                 data-practice="{{json_encode($vendor->vendorSolutionsPractices()->pluck('name')->toArray())}}"
                                                 data-subpractice="{{json_encode($vendor->vendorAppliedSubpractices())}}"
                                                 data-industry="{{$vendor->getVendorResponse('vendorIndustry')}}"
                                                 data-regions="{{$vendor->getVendorResponse('vendorRegions') ?? '[]'}}"
                                            >
                                                <div class="card-body">
                                                    <div style="float: left; max-width: 40%;">
                                                        <h4>{{$vendor->name}}</h4>
                                                        <p>{{$vendor->name}}
                                                            - {{$vendor->vendorSolutionsPracticesNames()}}</p>
                                                        <p>{{$vendor->getVendorResponse('vendorSegment') ?? 'No segment'}}
                                                            - {{$vendor->getVendorResponse('vendorIndustry') ?? 'No industry'}}
                                                            -
                                                            {{implode(', ', json_decode($vendor->getVendorResponse('vendorRegions')) ?? [])}}</p>
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

            <x-footer/>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        /*
        import Label from "../../../nova/resources/js/components/Form/Label";
        export default {
            components: {Label}
        }
        */

    </script>
    <script>

        var allVendorsResponses = [
                @foreach($vendors as $vendor)
            {
                id: '{{$vendor->id}}',
                segment: "{{$vendor->getVendorResponse('vendorSegment')}}",
                practice: "{{json_encode($vendor->vendorSolutionsPractices()->pluck('name')->toArray())}}",
                subpractice: "{{json_encode($vendor->vendorAppliedSubpractices())}}",
                transportFlow: "{{$vendor->getVendorResponsesFromScope(9)}}",
                transportMode: '{{$vendor->getVendorResponsesFromScope(10)}}',
                transportType: '{{$vendor->getVendorResponsesFromScope(11)}}',
                manufacturing: '{{$vendor->getVendorResponsesFromScope(5)}}',
                regions: '{{$vendor->getVendorResponse('vendorRegions') ?? '[]'}}',
                industry: "{{$vendor->getVendorResponse('vendorIndustry')}}"
            },
            @endforeach
        ]

        $('#practiceSelect').change(function () {

            var selectedPractice = $(this).children("option:selected").val();
            $('#TransportScope').hide();
            $('#PlanningScope').hide();
            $('#scopesDiv').hide();
            $('#subpracticesContainer').hide();

            if (selectedPractice) {

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

                    if (data){
                        $('#subpracticesContainer').show();

                        $('#selectSubpractices').empty();

                        var $dropdown = $("#selectSubpractices");
                        $dropdown.append($("<option />").val(null).text('Choose an option'));
                        var subpractices = data.subpractices;
                        $.each(subpractices, function() {
                            $dropdown.append($("<option />").val(this.name).text(this.name));
                        });
                    }

                });
            }
        });

        $(document).ready(function () {

            $('#TransportScope').hide();
            $('#PlanningScope').hide();
            $('#scopesDiv').hide();

            $('#subpracticesContainer').hide();

            function filterVendors() {

                let vendorsByPractice;
                let vendorsBySubpractice;
                let vendorsBySegment;

                let vendorsByTransportFlows;
                let vendorsByTransportModes;
                let vendorsByTransportTypes;
/*
                let vendorsByPlanningResponse;
*/
                let vendorsByRegions;
                let vendorsByIndustries;

                const selectedSegments = $('#segmentSelect').val()
                const selectedPractices = $('#practiceSelect').val()
                const selectedSubpractices = $('#selectSubpractices').val()

                const selectedTransportFlows = $('#selectTransport1').val()
                const selectedTransportModes = $('#selectTransport2').val()
                const selectedTransportTypes = $('#selectTransport3').val()
                //const textPlanning = String($('#PlanningInput1').val()).toLowerCase();

                const selectedRegions = $('#regionSelect').val()
                const selectedIndustries = $('#industrySelect').val()

                if (selectedSegments) {
                    vendorsBySegment = allVendorsResponses.filter(
                        response => response.segment.includes(selectedSegments)
                    );
                    vendorsBySegment = vendorsBySegment.map(vendor => vendor.id);
                } else {
                    vendorsBySegment = allVendorsResponses.map(vendor => vendor.id);
                }

                if (selectedPractices) {
                    vendorsByPractice = allVendorsResponses.filter(
                        response => response.practice.includes(selectedPractices)
                    );
                    vendorsByPractice = vendorsByPractice.map(vendor => vendor.id);
                } else vendorsByPractice = allVendorsResponses.map(vendor => vendor.id);

                if (selectedSubpractices) {
                    vendorsBySubpractice = allVendorsResponses.filter(
                        response => response.subpractice.includes(selectedSubpractices)
                    );
                    vendorsBySubpractice = vendorsBySubpractice.map(vendor => vendor.id);
                } else vendorsBySubpractice = allVendorsResponses.map(vendor => vendor.id);

                if (selectedTransportFlows) {
                    vendorsByTransportFlows = allVendorsResponses.filter(
                        response => response.transportFlow.includes(selectedTransportFlows)
                    );
                    vendorsByTransportFlows = vendorsByTransportFlows.map(vendor => vendor.id);
                } else vendorsByTransportFlows = allVendorsResponses.map(vendor => vendor.id);

                if (selectedTransportModes) {
                    vendorsByTransportModes = allVendorsResponses.filter(
                        response => response.transportMode.includes(selectedTransportModes)
                    );
                    vendorsByTransportModes = vendorsByTransportModes.map(vendor => vendor.id);
                } else vendorsByTransportModes = allVendorsResponses.map(vendor => vendor.id);

                if (selectedTransportTypes) {
                    vendorsByTransportTypes = allVendorsResponses.filter(
                        response => response.transportType.includes(selectedTransportTypes)
                    );
                    vendorsByTransportTypes = vendorsByTransportTypes.map(vendor => vendor.id);
                } else vendorsByTransportTypes = allVendorsResponses.map(vendor => vendor.id);

                if (selectedRegions) {
                    vendorsByRegions = allVendorsResponses.filter(
                        response => response.regions.includes(selectedRegions)
                    );
                    vendorsByRegions = vendorsByRegions.map(vendor => vendor.id);
                } else vendorsByRegions = allVendorsResponses.map(vendor => vendor.id);

                if (selectedIndustries) {
                    vendorsByIndustries = allVendorsResponses.filter(
                        response => response.industry.includes(selectedIndustries)
                    );
                    vendorsByIndustries = vendorsByIndustries.map(vendor => vendor.id);
                } else vendorsByIndustries = allVendorsResponses.map(vendor => vendor.id);

/*                if (textPlanning.length > 0) {
                    vendorsByPlanningResponse = allVendorsResponses.filter(
                        response => response.planning.includes(textPlanning)
                    );
                    vendorsByPlanningResponse = vendorsByPlanningResponse.map(vendor => vendor.id);
                } else vendorsByPlanningResponse = allVendorsResponses.map(vendor => vendor.id);*/

                $('#projectContainer').children().each(function () {

                    let vendorToTest = String($(this).data('id'));

                    if (
                        $.inArray(vendorToTest, vendorsBySegment) !== -1
                        && $.inArray(vendorToTest, vendorsByPractice) !== -1
                        && $.inArray(vendorToTest, vendorsBySubpractice) !== -1
                        && $.inArray(vendorToTest, vendorsByTransportFlows) !== -1
                        && $.inArray(vendorToTest, vendorsByTransportModes) !== -1
                        && $.inArray(vendorToTest, vendorsByTransportTypes) !== -1
                        && $.inArray(vendorToTest, vendorsByRegions) !== -1
                        && $.inArray(vendorToTest, vendorsByIndustries) !== -1)
/*
                        && $.inArray(vendorToTest, vendorsByPlanningResponse) !== -1)
*/
                    {

                        $(this).css('display', 'flex')
                    } else {
                        $(this).css('display', 'none')
                    }
                });
            }

            $('#practiceSelect').on('change', function (e) {
                filterVendors();
            });

            $('#selectSubpractices').on('change', function (e) {
                filterVendors();
            });

            $('#segmentSelect').on('change', function (e) {
                filterVendors();
            });

            $('#selectTransport1').on('change', function (e) {
                filterVendors();
            });

            $('#selectTransport2').on('change', function (e) {
                filterVendors();
            });

            $('#selectTransport3').on('change', function (e) {
                filterVendors();
            });

            $('#regionSelect').on('change', function (e) {
                filterVendors();
            });
            $('#industrySelect').on('change', function (e) {
                filterVendors();
            });

            $('#PlanningInput1').keyup(function () {
                filterVendors();
            })

        });
    </script>
@endsection
