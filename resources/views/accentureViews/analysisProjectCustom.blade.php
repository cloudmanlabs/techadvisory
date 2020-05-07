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
                                            Please choose the Clients you'd like to see:
                                        </p>
                                        <select id="clientSelect" class="w-100" multiple="multiple">
                                            @foreach ($clients as $client)
                                            <option>{{$client}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="media-body" style="padding: 20px;">
                                        <p class="welcome_text">
                                            Please choose the Years you'd like to see:
                                        </p>
                                        <select id="yearSelect" class="w-100" multiple="multiple">
                                            @foreach ($years as $year)
                                            <option>{{$year}}</option>
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

                                    <div class="media-body" style="padding: 20px;">
                                        <p class="welcome_text">
                                            Please choose the Phases you'd like to see:
                                        </p>
                                        <select id="phaseSelect" class="w-100" multiple="multiple">
                                            <option value="preparation">Preparation</option>
                                            <option value="open">Open</option>
                                            <option value="old">Old</option>
                                        </select>
                                    </div>

                                    <div id="projectContainer">
                                        @foreach ($projects as $project)
                                        <div
                                            class="card"
                                            style="margin-bottom: 30px;"

                                            data-client="{{$project->client->name}}"
                                            data-practice="{{$project->practice->name}}"
                                            data-year="{{$project->created_at->year}}"
                                            data-industry="{{$project->industry}}"
                                            data-regions="{{json_encode($project->regions)}}"
                                            data-phase="{{ucfirst($project->currentPhase)}}"
                                        >
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$project->name}}</h4>
                                                    <h6>{{$project->client->name}} - {{$project->practice->name}}</h6>
                                                    <h6>{{$project->created_at->year}} - {{$project->industry}} - {{implode(', ', $project->regions)}}</h6>
                                                </div>
                                                <div style="float: right; text-align: right; width: 15%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                        href="{{route($project->currentPhase == 'preparation' ? 'accenture.newProjectSetUp' : 'accenture.projectHome', ['project' => $project])}}">
                                                        View <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                                    </a>
                                                </div>
                                                <x-projectProgressBar :project="$project" />
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
                const selectedPractices = getSelectedFrom('practiceSelect')
                const selectedClients = getSelectedFrom('clientSelect')
                const selectedYears = getSelectedFrom('yearSelect')
                const selectedIndustries = getSelectedFrom('industrySelect')
                const selectedRegions = getSelectedFrom('regionSelect')
                const selectedPhases = getSelectedFrom('phaseSelect')

                console.log(selectedPhases);

                // Add a display none to the one which don't have this tags
                $('#projectContainer').children().each(function () {
                    const practice = $(this).data('practice');
                    const client = $(this).data('client');
                    const year = $(this).data('year').toString();
                    const industry = $(this).data('industry');
                    const regions = $(this).data('regions');
                    const phase = $(this).data('phase');

                    console.log(phase);


                    if (
                        $.inArray(practice, selectedPractices) !== -1
                        && $.inArray(client, selectedClients) !== -1
                        && $.inArray(year, selectedYears) !== -1
                        && $.inArray(industry, selectedIndustries) !== -1
                        && $.inArray(phase, selectedPhases) !== -1
                        && intersect(regions, selectedRegions).length !== 0
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
                        return el.innerHTML
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
            $('#clientSelect').select2();
            $('#clientSelect').on('change', function (e) {
                updateProjects();
            });
            $('#yearSelect').select2();
            $('#yearSelect').on('change', function (e) {
                updateProjects();
            });
            $('#industrySelect').select2();
            $('#industrySelect').on('change', function (e) {
                updateProjects();
            });
            $('#phaseSelect').select2();
            $('#phaseSelect').on('change', function (e) {
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
