@extends('accentureViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home"/>

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening_file')" :text="nova_get_setting('video_opening_text')"/>
                <br><br>

                <!-- Filter Panel-->
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3 style="cursor: pointer" id="filterH3" title="Click to maximize/minimize">Filters
                                    +</h3>

                                <div id="filterContainer" style="display: none">
                                    <br>
                                    <div class="media-body" style="padding: 20px;">
                                        <p class="welcome_text">
                                            Please choose the SC Capability (Practice) you'd like to see:
                                        </p>
                                        <select id="homePracticeSelect" class="w-100" multiple="multiple">
                                            <option>No SC Capability (Practice)</option>
                                            @foreach ($practices as $practice)
                                                <option>{{$practice}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="media-body" style="padding: 20px;">
                                        <p class="welcome_text">
                                            Please choose the Years you'd like to see:
                                        </p>
                                        <select id="homeYearSelect" class="w-100" multiple="multiple">
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2021">2022</option>
                                            <option value="2021">2023</option>
                                        </select>
                                    </div>
                                    <div class="media-body" style="padding: 20px;">
                                        <p class="welcome_text">
                                            Please choose the Project's name:
                                        </p>
                                        <input id="homeNameInput" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>Open Projects</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('client_Home_Open') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div id="openPhaseContainer">
                                    @foreach ($openProjects as $project)
                                        <div class="card" style="margin-bottom: 30px;"
                                             data-practice="{{$project->practice->name ?? ''}}"
                                             data-name="{{$project->name ?? ''}}"
                                             data-year="{{$project->created_at->year}}">
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$project->name}}</h4>
                                                    <h6>SC Capability
                                                        (Practice): {{$project->practice->name ?? 'No SC Capability (Practice)'}}</h6>
                                                    <h6>Last updated: {{$project->updated_at->format('d/m/Y')}}</h6>
                                                </div>
                                                <div style="float: right; text-align: right; width: 17%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                       href="{{route('client.projectHome', ['project' => $project])}}">
                                                        View <i class="btn-icon-prepend" data-feather="arrow-right"></i>
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

                <div class="row" id="preparation_phase">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Preparation phase</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('client_Home_Preparation') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div id="preparationPhaseContainer">
                                    @foreach ($preparationProjects as $project)
                                        <div class="card" style="margin-bottom: 30px;"
                                             data-practice="{{$project->practice->name ?? ''}}"
                                             data-name="{{$project->name ?? ''}}"
                                             data-year="{{$project->created_at->year}}">
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$project->name}}</h4>
                                                    <h6>SC Capability
                                                        (Practice): {{$project->practice->name ?? 'No SC Capability (Practice)'}}</h6>
                                                    <h6>Last updated: {{$project->updated_at->format('d/m/Y')}}</h6>
                                                </div>
                                                <div style="float: right; text-align: right; width: 17%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                       href="{{route('client.newProjectSetUp', ['project' => $project])}}">Complete
                                                        <i
                                                            class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                                    <br>
                                                    @if ($project->hasValueTargeting && $project->hasValueTargetingFiles())
                                                        <a href="{{route('client.projectValueTargeting', ['project' => $project])}}">Value
                                                            targeting</a>
                                                    @endif
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

                <div class="row" id="oldProjects">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3 id="oldProjectsH3" title="Click to maximize/minimize" style="cursor: pointer">Old
                                    Projects +</h3>
                                <br style="display: none" class="plsHideMeToo">
                                <p class="welcome_text extra-top-15px plsHideMeToo" style="display: none">
                                    {{nova_get_setting('client_Home_Old') ?? ''}}
                                </p>
                                <br style="display: none" class="plsHideMeToo">

                                <div id="oldPhaseContainer" style="display: none">
                                    @foreach ($oldProjects as $project)
                                        <div class="card" style="margin-bottom: 30px;"
                                             data-practice="{{$project->practice->name ?? ''}}"
                                             data-name="{{$project->name ?? ''}}"
                                             data-year="{{$project->created_at->year}}">
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$project->name}}</h4>
                                                    <h6>
                                                        Practice: {{$project->practice->name ?? 'No SC Capability (Practice)'}}</h6>
                                                </div>
                                                <div style="float: right; text-align: right; width: 17%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                       href="{{route('client.projectHome', ['project' => $project])}}">
                                                        View <i class="btn-icon-prepend" data-feather="arrow-right"></i>
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

            <x-footer/>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            var searchInputText = null;

            $('#filterH3').click(function () {
                if ($('#filterContainer').css('display') === 'none') {
                    $('#filterContainer').css('display', 'initial')
                    $('#filterH3').text('Filters -')
                } else {
                    $('#filterContainer').css('display', 'none')
                    $('#filterH3').text('Filters +')
                }
            })

            $('#oldProjectsH3').click(function () {
                if ($('#oldPhaseContainer').css('display') === 'none') {
                    $('#oldPhaseContainer').css('display', 'initial')
                    $('.plsHideMeToo').css('display', 'initial')
                    $('#oldProjectsH3').text('Old Projects -')
                } else {
                    $('#oldPhaseContainer').css('display', 'none')
                    $('.plsHideMeToo').css('display', 'none')
                    $('#oldProjectsH3').text('Old Projects +')
                }
            })

            function updateOpenProjects() {
                // Get all selected practices. If there are none, get all of them
                var selectedPractices = $('#homePracticeSelect').select2('data').map((el) => {
                    return el.text
                });
                if (selectedPractices.length == 0) {
                    selectedPractices = $('#homePracticeSelect').children().toArray().map((el) => {
                        return el.innerHTML
                    });
                }

                var selectedYears = $('#homeYearSelect').select2('data').map((el) => {
                    return el.text
                });
                if (selectedYears.length == 0) {
                    selectedYears = $('#homeYearSelect').children().toArray().map((el) => {
                        return el.innerHTML
                    });
                }

                // Add a display none to the one which don't have this tags
                $('#openPhaseContainer').children().each(function () {
                    const practice = $(this).data('practice');
                    const year = $(this).data('year').toString();
                    const name = String($(this).data('name')).toLowerCase();

                    if ($.inArray(practice, selectedPractices) !== -1
                        && $.inArray(year, selectedYears) !== -1
                        && (!searchInputText || name.includes(searchInputText))) {

                        $(this).css('display', 'flex');
                    } else {
                        $(this).css('display', 'none');
                    }
                });
                $('#preparationPhaseContainer').children().each(function () {
                    const practice = $(this).data('practice');
                    const year = $(this).data('year').toString();
                    const name = String($(this).data('name')).toLowerCase();

                    if ($.inArray(practice, selectedPractices) !== -1
                        && $.inArray(year, selectedYears) !== -1
                        && (!searchInputText || name.includes(searchInputText))) {
                        $(this).css('display', 'flex');
                    } else {
                        $(this).css('display', 'none');
                    }
                });

                $('#oldPhaseContainer').children().each(function () {
                    const practice = $(this).data('practice');
                    const year = $(this).data('year').toString();
                    const name = String($(this).data('name')).toLowerCase();

                    if ($.inArray(practice, selectedPractices) !== -1
                        && $.inArray(year, selectedYears) !== -1
                        && (!searchInputText || name.includes(searchInputText))) {
                        $(this).css('display', 'flex');
                    } else {
                        $(this).css('display', 'none');
                    }
                });
            }

            $('#homePracticeSelect').select2();
            $('#homePracticeSelect').on('change', function (e) {
                updateOpenProjects();
            });
            $('#homeClientSelect').select2();
            $('#homeClientSelect').on('change', function (e) {
                updateOpenProjects();
            });
            $('#homeYearSelect').select2();
            $('#homeYearSelect').on('change', function (e) {
                updateOpenProjects();
            });

            $("#homeNameInput").keyup(function (event) {
                searchInputText = event.target.value.toLowerCase();
                updateOpenProjects();
            });
            updateOpenProjects();
        });
    </script>
@endsection
