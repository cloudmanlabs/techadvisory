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
                                        Select the filter criteria to find all relevant projects.
                                    </p>
                                    <br>

                                    <div id="filterContainer">
                                        <div class="media-body" style="padding: 20px;">
                                            <p class="welcome_text">
                                                Search:
                                            </p>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="searchBox">
                                            </div>
                                        </div>

                                        <div class="media-body" style="padding: 20px;">
                                            <p class="welcome_text">
                                                Please choose the SC Capability (Practice) you'd like to see:
                                            </p>
                                            <select id="practiceSelect" class="w-100" multiple="multiple">
                                                @foreach ($practices as $practice)
                                                    <option>{{$practice}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="media-body" style="padding: 20px;">
                                            <p class="welcome_text">
                                                Please choose the Subpractices you'd like to see:
                                            </p>
                                            <select id="subpracticeSelect" class="w-100" multiple="multiple">
                                                @foreach ($subpractices as $subpractice)
                                                    <option>{{$subpractice}}</option>
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

                                        <br>
                                        <h3 style="color: #A12BFE">Search Results</h3>
                                        <br>
                                        <br>

                                        <div id="projectContainer">
                                            @foreach ($projects as $project)
                                                <div
                                                    class="card"
                                                    style="margin-bottom: 30px;"

                                                    data-name="{{$project->name ?? ''}}"
                                                    data-client="{{$project->client->name ?? ''}}"
                                                    data-practice="{{$project->practice->name ?? ''}}"
                                                    data-subpractices="{{json_encode($project->subpractices->pluck('name')->toArray()) ?? ''}}"
                                                    data-year="{{$project->created_at->year}}"
                                                    data-industry="{{$project->industry}}"
                                                    data-regions="{{json_encode($project->regions ?? [])}}"
                                                    data-phase="{{ucfirst($project->currentPhase)}}"
                                                >
                                                    <div class="card-body">
                                                        <div style="float: left; max-width: 40%;">
                                                            <h4>{{$project->name ?? ''}}</h4>
                                                            <h6>{{$project->client->name ?? ''}}
                                                                - {{$project->practice->name ?? ''}}</h6>
                                                            <h6>{{$project->created_at->year}} - {{$project->industry}}
                                                                - {{implode(', ', $project->regions ?? [])}}</h6>
                                                            <h6>{{implode(', ', $project->subpractices->pluck('name')->toArray() ?? [])}}</h6>
                                                        </div>
                                                        <div style="float: right; text-align: right; width: 15%;">
                                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                                               href="{{route($project->currentPhase == 'preparation' ? 'accenture.newProjectSetUp' : 'accenture.projectHome', ['project' => $project])}}">
                                                                View <i class="btn-icon-prepend"
                                                                        data-feather="arrow-right"></i>
                                                            </a>
                                                        </div>
                                                        <x-projectProgressBar :project="$project"/>
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
        <x-footer/>
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
                const selectedSubpractices = getSelectedFrom('subpracticeSelect')
                const selectedClients = getSelectedFrom('clientSelect')
                const selectedYears = getSelectedFrom('yearSelect')
                const selectedIndustries = getSelectedFrom('industrySelect')
                const selectedRegions = getSelectedFrom('regionSelect')
                const selectedPhases = getSelectedFrom('phaseSelect')
                const searchBox = $('#searchBox').val().toLocaleLowerCase();

                // Add a display none to the one which don't have this tags
                $('#projectContainer').children().each(function () {
                    const practice = $(this).data('practice');
                    const subpractices = $(this).data('subpractices');
                    const client = $(this).data('client');
                    const year = $(this).data('year').toString();
                    const industry = $(this).data('industry');
                    const regions = $(this).data('regions');
                    const phase = $(this).data('phase');
                    const name = $(this).data('name');

                    if (
                        $.inArray(practice, selectedPractices) !== -1
                        && $.inArray(client, selectedClients) !== -1
                        && $.inArray(year, selectedYears) !== -1
                        && $.inArray(industry, selectedIndustries) !== -1
                        && $.inArray(phase, selectedPhases) !== -1
                        && intersect(regions, selectedRegions).length !== 0
                        && intersect(subpractices, selectedSubpractices).length !== 0

                        && name.toLocaleLowerCase().search(searchBox) > -1
                    ) {
                        $(this).css('display', 'flex')
                    } else {
                        $(this).css('display', 'none')
                    }
                });
            }

            function getSelectedFrom(id){
                let selectedPractices = $(`#${id}`).select2('data').map(function(el) {
                    return el.text
                });
                if(selectedPractices.length == 0){
                    selectedPractices = $(`#${id}`).children().toArray().map(function(el) {
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

            $('#subpracticeSelect').select2();
            $('#subpracticeSelect').on('change', function (e) {
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

            $('#searchBox').on('input', function (e) {
                updateProjects();
            });

            updateProjects();

        });
    </script>
@endsection


