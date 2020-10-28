@extends('accentureViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home"/>

        <div class="page-wrapper">
            <div class="page-content">
                <x-video :src="nova_get_setting('video_opening_file')"
                         :text="nova_get_setting('video_openingVendor_text')"/>
                <br><br>

                <div class="row" id="filters">
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
                <br><br>

                <!-- Invitation -->
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>Projects in Invitation phase</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_Home_Invitation') ?? ''}}
                                </p>
                                <br>
                                <br>


                                <div id="invitationPhaseContainer">
                                    @foreach ($invitationProjects as $project)
                                        <div class="card" style="margin-bottom: 30px;"
                                             data-practice="{{$project->practice->name}}"
                                             data-name="{{$project->name}}"
                                             data-year="{{$project->created_at->year}}">
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$project->name}}</h4>
                                                    <h6>{{$project->practice->name}}</h6>
                                                </div>
                                                <div style="float: right; text-align: right; width: 20%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                       href="{{route('vendor.previewProject', ['project' => $project])}}">
                                                        Preview <i class="btn-icon-prepend"
                                                                   data-feather="arrow-right"></i>
                                                    </a>
                                                </div>
                                                <div style="float: right; text-align: right; width: 17%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                       href="{{route('vendor.application.setAccepted', ['project' => $project])}}"
                                                       onclick="event.preventDefault(); document.getElementById('accepted-project-{{$project->id}}-form').submit();">
                                                        Accept
                                                    </a>
                                                    <form id="accepted-project-{{$project->id}}-form"
                                                          action="{{ route('vendor.application.setAccepted', ['project' => $project]) }}"
                                                          method="POST"
                                                          style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                                <div style="float: right; text-align: right; width: 17%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                       href="{{route('vendor.application.setRejected', ['project' => $project])}}"
                                                       onclick="event.preventDefault(); document.getElementById('reject-project-{{$project->id}}-form').submit();">
                                                        Reject
                                                    </a>
                                                    <form id="reject-project-{{$project->id}}-form"
                                                          action="{{ route('vendor.application.setRejected', ['project' => $project]) }}"
                                                          method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <!-- Started -->
                <div class="row" id="preparation_phase">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Started Applications</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_Home_Started') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div id="startedPhaseContainer">
                                    @foreach ($startedProjects as $project)
                                        <div class="card" style="margin-bottom: 30px;"
                                             data-practice="{{$project->practice->name}}"
                                             data-name="{{$project->name}}"
                                             data-year="{{$project->created_at->year}}">
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$project->name}}</h4>
                                                    <h6>{{$project->practice->name}}</h6>
                                                </div>
                                                <div style="float: right; text-align: right; width: 15%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                       href="{{route('vendor.newApplication.apply', ['project' => $project])}}">View
                                                        <i
                                                            class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                                </div>
                                                @php
                                                    $vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id',
                                                    auth()->id())->first();
                                                @endphp
                                                <x-applicationProgressBar :application="$vendorApplication"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <!-- Submitted -->
                <div class="row" id="preparation_phase">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Submitted Applications</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_Home_Submitted') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div id="submittedPhaseContainer">
                                    @foreach ($submittedProjects as $project)
                                        <div class="card" style="margin-bottom: 30px;"
                                             data-practice="{{$project->practice->name}}"
                                             data-name="{{$project->name}}"
                                             data-year="{{$project->created_at->year}}">
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$project->name}}</h4>
                                                    <h6>{{$project->practice->name}}</h6>
                                                </div>
                                                <div style="float: right; text-align: right; width: 15%;">
                                                    {{--  TODO CHange this route to submittedApplication --}}
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                       href="{{route('vendor.submittedApplication', ['project' => $project])}}">View
                                                        <i
                                                            class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                                </div>
                                                @php
                                                    $vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id',
                                                    auth()->id())->first();
                                                @endphp
                                                <x-applicationProgressBar :application="$vendorApplication"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>Rejected Projects</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_Home_Rejected') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div id="rejectedPhaseContainer">
                                    @foreach ($rejectedProjects as $project)
                                        <div class="card" style="margin-bottom: 30px;"
                                             data-practice="{{$project->practice->name}}"
                                             data-name="{{$project->name}}"
                                             data-year="{{$project->created_at->year}}">
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$project->name}}</h4>
                                                    <h6>{{$project->practice->name}}</h6>
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

            <x-footer/>
        </div>
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {

            var searchInputText = null;

            // Show filter panel
            $('#filterH3').click(function () {
                if ($('#filterContainer').css('display') === 'none') {
                    $('#filterContainer').css('display', 'initial')
                    $('#filterH3').text('Filters -')
                } else {
                    $('#filterContainer').css('display', 'none')
                    $('#filterH3').text('Filters +')
                }
            })

            function updateProjects() {

                // Get all selected practices. If there are none, get all of them
                var selectedPractices = $('#homePracticeSelect').select2('data').map(function(el) {
                    return el.text
                });
                if (selectedPractices.length == 0) {
                    selectedPractices = $('#homePracticeSelect').children().toArray().map(function(el) {
                        return el.innerHTML
                    });
                }

                var selectedYears = $('#homeYearSelect').select2('data').map(function (el) {
                    return el.text
                });
                if (selectedYears.length == 0) {
                    selectedYears = $('#homeYearSelect').children().toArray().map(function(el) {
                        return el.innerHTML
                    });
                }

                // Filter projects into the cards.
                $('#invitationPhaseContainer').children().each(function () {
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

                $('#startedPhaseContainer').children().each(function () {
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

                $('#submittedPhaseContainer').children().each(function () {
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

                $('#rejectedPhaseContainer').children().each(function () {
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
                updateProjects();
            });

            $('#homeYearSelect').select2();
            $('#homeYearSelect').on('change', function (e) {
                updateProjects();
            });

            $("#homeNameInput").keyup(function (event) {
                searchInputText = event.target.value.toLowerCase();
                updateProjects();
            });
            updateProjects();
        });

    </script>
@endsection
