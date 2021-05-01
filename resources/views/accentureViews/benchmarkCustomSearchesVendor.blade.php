@extends('layouts.base')

@section('content')
    <style type="text/css">
      .select2.select2-container.select2-container--default {
          width: 100% !important;
      }
    </style>
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
                                                    <option selected="true" value="null">Choose a option</option>
                                                    @foreach ($segments as $segment)
                                                        <option>{{$segment}}</option>
                                                    @endforeach
                                                    <option value="No Segment">No Segment</option>
                                                </select>
                                            </div>
                                            <div class="media-body" style="padding: 20px; ">
                                                <p class="welcome_text">
                                                    Please choose the Regions you'd like to see:
                                                </p>
                                                <select id="regionSelect" class="w-100" multiple="multiple">
                                                    @foreach ($regions as $region)
                                                        <option>{{$region}}</option>
                                                    @endforeach
                                                    <option value="No Region">No Region</option>
                                                </select>
                                            </div>

                                            <div class="media-body" style="padding: 20px;">
                                                <p class="welcome_text">
                                                    Please choose the Industries you'd like to see:
                                                </p>
                                                <select id="industriesSelect" class="w-100" multiple="multiple">
                                                    @foreach ($industries as $industry)
                                                        <option>{{$industry}}</option>
                                                    @endforeach
                                                    <option value="No Industry">No Industry</option>
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
                                                        <option data-id="{{$allPractices->where('name', $practice)->first()->id}}" value="{{$practice}}">{{$practice}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="media-body" style="padding: 20px;">
                                                <p class="welcome_text">
                                                    Please choose the TMS Capabilities (Subpractices) you'd like to see:
                                                </p>
                                                <select id="subpracticeSelect" class="w-100" multiple="multiple">
                                                    @foreach ($subpractices as $subpractice)
                                                        <option>{{$subpractice}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="scopesDiv" class="media-body" style="padding: 20px;">
                                                <p class="welcome_text">Please choose the Scope you'd like to see:</p>
                                                <br>
                                                @foreach ($questions as $question)
                                                    <div class="form-group questionDiv" data-practice="{{$question->practice->id ?? ''}}" style="display: none;">
                                                      <label>{{$question->label}}</label>
                                                      <select
                                                        class="js-example-basic-multiple w-100"
                                                        data-changing="{{$question->id}}"
                                                        multiple="multiple"
                                                        id="{{str_replace(' ', '', $question->label)}}"
                                                        >
                                                          @foreach ($question->optionList() as $option)
                                                          <option value="{{$option}}">{{$option}}</option>
                                                          @endforeach
                                                      </select>
                                                    </div>
                                                @endforeach
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
                                                     data-segment="{{$vendor->getVendorResponse('vendorSegment') ?? 'No Segment'}}"
                                                     data-practice="{{json_encode($vendor->vendorSolutionsPractices()->pluck('name')->toArray() ?? [])}}"
                                                     data-subpractices="{{json_encode($vendor->vendorSolutionsSubpracticesNames() ?? [])}}"
                                                     data-responses="{{json_encode($vendor->getVendorResponsesNames() ?? [])}}"
                                                     {{-- data-manufacturing="{{json_encode($vendor->getVendorResponsesFromScope(5) ?? '')}}"--}}
                                                     data-industry="{{implode(', ', json_decode($vendor->getIndustryFromVendor()) ?? ['No Industry'])}}"
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
                                                                Industry: {{ implode(', ', json_decode($vendor->getIndustryFromVendor()) ?? ['No Industry']) }}</p>
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
        $(document).ready(function () {
            const $segmentSelector = $('#segmentSelect');
            const $regionSelector = $('#regionSelect');
            const $industrySelector = $('#industriesSelect');
            const $practiceSelector = $('#practiceSelect');
            const $subPracticeSelector = $('#subpracticeSelect');
            @foreach ($questions as $question)
            const $questionSelector{{str_replace(' ', '', $question->label)}} = $('#{{str_replace(' ', '', $question->label)}}');
            @endforeach

            const $vendorsContainer = $('#vendorsContainer');

            function updateShownQuestionsAccordingToPractice(currentPracticeId) {
                $('.questionDiv').each(function () {
                    let practiceId = $(this).data('practice');

                    if (practiceId == currentPracticeId || practiceId == "") {
                        $(this).css('display', 'block')
                    } else {
                        $(this).css('display', 'none')
                    }
                });
            }

            function checkResponses(selectedQuestions, responses) {
              if (filterMultipleAND(selectedQuestions, responses)) {
                return true;
              } else {
                return false;
              }
            }

            function updateVendors() {
                const selectedSegment = $segmentSelector.val();
                const selectedRegions = $regionSelector.val();
                const selectedIndustries = $industrySelector.val();
                const selectedPractices = $practiceSelector.val();
                const selectedSubpractices = $subPracticeSelector.val();
                @foreach ($questions as $question)
                const selectedQuestions{{str_replace(' ', '', $question->label)}} = $questionSelector{{str_replace(' ', '', $question->label)}}.val();
                @endforeach

                // Add a display none to the one which don't have this tags
                $vendorsContainer.children().each(function () {
                    const segment = $(this).data('segment');
                    const regions = $(this).data('regions');
                    const industries = $(this).data('industry');
                    const practice = $(this).data('practice');
                    const subpractices = $(this).data('subpractices');
                    const responses = $(this).data('responses');

                    if (
                        (selectedSegment === 'null' ? true : segment.includes(selectedSegment) === true)
                        && (filterMultipleAND(selectedRegions, regions))
                        && (filterMultipleAND(selectedIndustries, industries))
                        && (selectedPractices === 'null' ? true : practice.includes(selectedPractices) === true)
                        && (filterMultipleAND(selectedSubpractices, subpractices))
                        @foreach ($questions as $question)
                        &&  checkResponses(selectedQuestions{{str_replace(' ', '', $question->label)}}, responses)
                        @endforeach
                        // && (filterMultipleAND(selectedTransportFlow, transportFlow))
                        // && (filterMultipleAND(selectedTransportMode, transportMode))
                        // && (filterMultipleAND(selectedTransportType, transportType))
                    ) {
                        $(this).css('display', 'flex')
                    } else {
                        $(this).css('display', 'none')
                    }
                });
            }

            function filterMultipleAND(arrayOptions, arrayToSearch) {
                return arrayOptions.length > 0 ? R.all(R.flip(R.includes)(arrayToSearch))(arrayOptions) : true;
            }

            $('#practiceSelect').change(function () {
                chargeSubpracticesFromPractice();
                updateShownQuestionsAccordingToPractice($('#practiceSelect').find(':selected').data('id'));
            });

            function chargeSubpracticesFromPractice() {
                $('#subpracticeSelect').empty();

                var selectedPractices = $('#practiceSelect').val();
                $.get("/accenture/benchmark/customSearches/getSubpractices/"
                    + selectedPractices, function (data) {

                    var $dropdown = $("#subpracticeSelect");
                    var subpractices = data.subpractices;
                    $.each(subpractices, function () {
                        var option = $("<option />").val(this).text(this);
                        $dropdown.append(option);
                    });
                    //$dropdown.append($("<option />").val('No Subpractice').text('No Subpractice'));
                });
            }

            $segmentSelector.on('change', updateVendors);
            $regionSelector.select2().on('change', updateVendors);
            $industrySelector.select2().on('change', updateVendors);
            $practiceSelector.on('change', updateVendors);
            $('#subpracticeSelect').select2();
            $('#subpracticeSelect').on('change', function (e) {
                updateVendors();
            });
            @foreach ($questions as $question)
            $questionSelector{{str_replace(' ', '', $question->label)}}.select2().on('change', updateVendors);
            @endforeach
            // $transport1Selector.select2().on('change', updateVendors);
            // $transport2Selector.select2().on('change', updateVendors);
            // $transport3Selector.select2().on('change', updateVendors);
        });
    </script>
@endsection

