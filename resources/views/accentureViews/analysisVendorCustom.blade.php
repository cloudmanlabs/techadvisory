@extends('accentureViews.layouts.benchmark')

@section('content')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="benchmark" />

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
                                        The first phase of the process is ipsum dolor sit amet, consectetur
                                        adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a.
                                        Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc
                                        pellentesque luctus. ipsum dolor
                                        sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut
                                        dictum nunc pharetra a.
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
                            <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                Platform, you'll need to follow some steps to complete your profile and set up your
                                first project. Please check below the timeline and click "Let's start" when you are
                                ready.</p>
                            <br>

                            <div id="filterContainer">
                                <br>
                                <div class="media-body" style="padding: 20px;">
                                    <p class="welcome_text">
                                        Please choose the Segments you'd like to see:
                                    </p>
                                    <select id="segmentSelect" class="w-100" multiple="multiple">
                                        @foreach ($segments as $segment)
                                        <option>{{$segment}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="media-body" style="padding: 20px;">
                                    <p class="welcome_text">
                                        Please choose the Practices you'd like to see:
                                    </p>
                                    <select id="practiceSelect" class="w-100" multiple="multiple">
                                        @foreach ($practices as $practice)
                                        <option>{{$practice}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="media-body" style="padding: 20px;">
                                    <p class="welcome_text">
                                        Please choose the Regions you'd like to see:
                                    </p>
                                    <select id="regionSelect" class="w-100" multiple="multiple">
                                        @foreach ($regions as $region)
                                        <option>{{$region}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="media-body" style="padding: 20px;">
                                    <p class="welcome_text">
                                        Please choose the Industries you'd like to see:
                                    </p>
                                    <select id="industrySelect" class="w-100" multiple="multiple">
                                        @foreach ($industries as $industry)
                                        <option>{{$industry}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="projectContainer">
                                    @foreach ($vendors as $vendor)
                                    <div class="card" style="margin-bottom: 30px;"
                                        data-segment="{{$vendor->getVendorResponse('vendorSegment')}}"
                                        data-practice="{{$vendor->getVendorResponse('vendorPractice')}}"
                                        data-industry="{{$vendor->getVendorResponse('vendorIndustry')}}"
                                        data-regions="{{$vendor->getVendorResponse('vendorRegions') ?? '[]'}}"
                                    >
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$vendor->name}}</h4>
                                                <p>{{$vendor->name}} - {{$vendor->getVendorResponse('vendorPractice') ?? 'No practice'}}</p>
                                                <p>{{$vendor->getVendorResponse('vendorSegment') ?? 'No segment'}} - {{$vendor->getVendorResponse('vendorIndustry') ?? 'No industry'}} -
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

        <x-footer />
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="{{url('assets/vendors/select2/select2.min.js')}}"></script>
<script>
    $(document).ready(function(){
            function updateProjects() {
                // Get all selected practices. If there are none, get all of them
                const selectedSegments = getSelectedFrom('segmentSelect')
                const selectedPractices = getSelectedFrom('practiceSelect')
                const selectedRegions = getSelectedFrom('regionSelect')
                const selectedIndustries = getSelectedFrom('industrySelect')

                console.log(selectedSegments, selectedPractices, selectedRegions, selectedIndustries);


                // Add a display none to the one which don't have this tags
                $('#projectContainer').children().each(function () {
                    const segment = $(this).data('segment');
                    const practice = $(this).data('practice');
                    const regions = $(this).data('regions');
                    const industry = $(this).data('industry');

                    if (
                        $.inArray(segment, selectedSegments) !== -1
                        && $.inArray(practice, selectedPractices) !== -1
                        && $.inArray(industry, selectedIndustries) !== -1
                        && (intersect(regions, selectedRegions).length !== 0)
                    ) {
                        $(this).css('display', 'flex')
                    } else {
                        $(this).css('display', 'none')
                    }
                });
            }

            function getSelectedFrom(id){
                let selectedPractices = $(`#${id}`).select2('data').map((el) => {
                    return el.text
                });
                if(selectedPractices.length == 0){
                    selectedPractices = $(`#${id}`).children().toArray().map((el) => {
                        return el.innerHTML.replace('&amp;', '&')
                    });
                }

                return selectedPractices;
            }

            function intersect(a, b) {
                var t;
                if (b.length > a.length) t = b, b = a, a = t; // indexOf to loop over shorter
                return a.filter(function (e) {
                    return b.indexOf(e) > -1;
                });
            }



            $('#practiceSelect').select2();
            $('#practiceSelect').on('change', function (e) {
                updateProjects();
            });
            $('#segmentSelect').select2();
            $('#segmentSelect').on('change', function (e) {
                updateProjects();
            });
            $('#industrySelect').select2();
            $('#industrySelect').on('change', function (e) {
                updateProjects();
            });
            $('#regionSelect').select2();
            $('#regionSelect').on('change', function (e) {
                updateProjects();
            });
            updateProjects();
        });
</script>
@endsection
