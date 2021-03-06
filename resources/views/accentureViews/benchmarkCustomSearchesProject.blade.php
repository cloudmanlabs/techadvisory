@extends('layouts.base')

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
                                                Please, choose the Project's Name you'd like to see:
                                            </p>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="searchBox">
                                            </div>
                                        </div>

                                        <div class="media-body" style="padding: 20px;">
                                            <p class="welcome_text">
                                                Please, choose the SC Capability (Practice) you'd like to see:
                                            </p>
                                            <select id="practiceSelect" class="w-100">
                                                <option value="null">-- Select a Practice --</option>
                                                @foreach ($practices as $practice)
                                                    <option>{{$practice}}</option>
                                                @endforeach
                                                <option value="No Practice">No Practice</option>
                                            </select>
                                        </div>

                                        <div class="media-body" style="padding: 20px;">
                                            <p class="welcome_text">
                                                Please, choose the Subpractices you'd like to see:
                                            </p>
                                            <select id="subpracticeSelect" class="w-100" multiple="multiple">
                                                @foreach ($subpractices as $subpractice)
                                                    <option>{{$subpractice}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="media-body" style="padding: 20px;">
                                            <p class="welcome_text">
                                                Please, choose the Clients you'd like to see:
                                            </p>
                                            <select id="clientSelect" class="w-100">
                                                <option value="null">-- Select a Client --</option>
                                                @foreach ($clients as $client)
                                                    <option>{{$client}}</option>
                                                @endforeach
                                                <option value="No Client">No Client</option>
                                            </select>
                                        </div>

                                        <div class="media-body" style="padding: 20px;">
                                            <p class="welcome_text">
                                                Please, choose the Creation Years you'd like to see:
                                            </p>
                                            <select id="yearSelect" class="w-100" multiple="multiple">
                                                @foreach ($years as $year)
                                                    <option>{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="media-body" style="padding: 20px;">
                                            <p class="welcome_text">
                                                Please, choose the Regions you'd like to see:
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
                                                Please, choose the Industries you'd like to see:
                                            </p>
                                            <select id="industrySelect" class="w-100">
                                                <option value="null">-- Select a Industry --</option>
                                                @foreach ($industries as $industry)
                                                    <option>{{$industry}}</option>
                                                @endforeach
                                                <option value="No Industry">No Industry</option>
                                            </select>
                                        </div>

                                        {{--                                        <div class="media-body" style="padding: 20px;">
                                                                                    <p class="welcome_text">
                                                                                        Please choose the Phases you'd like to see:
                                                                                    </p>
                                                                                    <select id="phaseSelect" class="w-100" multiple="multiple">
                                                                                        <option value="preparation">Preparation</option>
                                                                                        <option value="open">Open</option>
                                                                                        <option value="old">Old</option>
                                                                                    </select>
                                                                                </div>--}}

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
                                                    data-client="{{$project->client->name ?? 'No Client'}}"
                                                    data-practice="{{$project->practice->name ?? 'No Practice'}}"
                                                    data-subpractices="{{json_encode($project->subpractices->pluck('name')->toArray()) ?? ['No Subpractice']}}"
                                                    data-year="{{$project->created_at->year}}"
                                                    data-industry="{{$project->industry ?? 'No Industry'}}"
                                                    data-regions="{{json_encode($project->regions ?? ['No Region'])}}"
                                                >
                                                    <div class="card-body">
                                                        <div style="float: left; max-width: 40%;">
                                                            <h4>{{$project->name ?? 'No Name'}}</h4>
                                                            <br>
                                                            <h6> {{$project->client->name ?? 'No Client'}}
                                                                - {{$project->practice->name ?? 'No Practice'}}
                                                            </h6>
                                                            <br>
                                                            <h6>{{$project->created_at->year}}
                                                                - {{$project->industry ?? 'No Industry'}}
                                                                - {{implode(', ', $project->regions ?? ['No Region'])}}
                                                            </h6>
                                                            <br>
                                                            <h6>{{ implode(', ', $project->subpractices->pluck('name')->toArray()) ?? []}}</h6>
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

        $('#practiceSelect').change(function () {
            chargeSubpracticesFromPractice();
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

        $(document).ready(function () {
            function updateProjects() {
                const selectedPractices = $('#practiceSelect').val();
                const selectedSubpractices = $('#subpracticeSelect').val();
                const selectedClients = $('#clientSelect').val();
                const selectedYears = $('#yearSelect').val();
                const selectedIndustries = $('#industrySelect').val();
                const selectedRegions = $('#regionSelect').val();
                const searchBox = $('#searchBox').val().toLocaleLowerCase();


                // Add a display none to the one which don't have this tags
                $('#projectContainer').children().each(function () {
                    const name = $(this).data('name');
                    const practice = $(this).data('practice');
                    const subpractices = $(this).data('subpractices');
                    const client = $(this).data('client');
                    const year = $(this).data('year').toString();
                    const industry = $(this).data('industry');
                    const regions = $(this).data('regions');

                    if (
                        name.toLocaleLowerCase().search(searchBox) > -1
                        && (selectedPractices === 'null' ? true : practice.includes(selectedPractices) === true)
                        && (filterMultipleAND(selectedSubpractices, subpractices))
                        && (selectedClients === 'null' ? true : client.includes(selectedClients) === true)
                        && (selectedYears.length > 0 ? $.inArray(year, selectedYears) !== -1 : true)
                        && (selectedIndustries === 'null' ? true : industry.includes(selectedIndustries) === true)
                        && (filterMultipleAND(selectedRegions, regions))
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

            $('#practiceSelect').on('change', function (e) {
                updateProjects();
            });

            $('#subpracticeSelect').select2();
            $('#subpracticeSelect').on('change', function (e) {
                updateProjects();
            });

            $('#clientSelect').on('change', function (e) {
                updateProjects();
            });

            $('#yearSelect').select2();
            $('#yearSelect').on('change', function (e) {
                updateProjects();
            });

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


