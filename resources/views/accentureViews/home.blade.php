@extends('accentureViews.layouts.forms')

@section('content')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="home"/>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                    <div class="card">
                        <div class="card-body">
                            <h3 style="cursor: pointer" id="filterH3" title="Click to maximize/minimize">Filters</h3>
                            <br>

                            <div id="filterContainer">
                                <div class="media-body" style="padding: 20px;">
                                    <p class="welcome_text">
                                        Please choose the Practices you'd like to see:
                                    </p>
                                    <select id="homePracticeSelect" class="w-100" multiple="multiple" required>
                                        @foreach ($practices as $practice)
                                        <option selected>{{$practice}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="media-body" style="padding: 20px;">
                                    <p class="welcome_text">
                                        Please choose the Clients you'd like to see:
                                    </p>
                                    <select id="homeClientSelect" class="w-100" multiple="multiple" required>
                                        @foreach ($clients as $client)
                                        <option selected>{{$client}}</option>
                                        @endforeach
                                    </select>
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
                            <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                            <br>
                            <br>

                            <div id="openPhaseContainer">
                                @foreach ($openProjects as $project)
                                <div class="card" style="margin-bottom: 30px;"
                                    data-client="{{$project->client->name}}"
                                    data-practice="{{$project->practice->name}}">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>{{$project->name}}</h4>
                                            <h6>{{$project->client->name}} - {{$project->practice->name}}</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.projectHome', ['project' => $project])}}">
                                                View <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                            </a>
                                        </div>
                                        <x-projectProgressBar progressSetUp="40" progressValue="20" progressResponse="0" progressAnalytics="10"
                                            progressConclusions="0" />
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
                            <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                            <br>

                            <div id="preparationPhaseContainer">
                                @foreach ($preparationProjects as $project)
                                <div class="card" style="margin-bottom: 30px;"
                                    data-client="{{$project->client->name}}"
                                    data-practice="{{$project->practice->name}}">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>{{$project->name}}</h4>
                                            <h6>{{$project->client->name}} - {{$project->practice->name}}</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 17%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.newProjectSetUp')}}">Complete <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                            <br>
                                            @if ($project->hasValueTargeting)
                                                <a href="{{route('accenture.projectValueTargeting', ['project' => $project])}}">Value
                                                    targeting</a>
                                            @endif
                                        </div>
                                        <x-projectProgressBar progressSetUp="20" progressValue="10" progressResponse="0" progressAnalytics="0"
                                                                                progressConclusions="0" />
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
                            <h3>Old Projects</h3>
                            <br>

                            <div id="oldPhaseContainer">
                                @foreach ($oldProjects as $project)
                                <div class="card" style="margin-bottom: 30px;"
                                    data-client="{{$project->client->name}}"
                                    data-practice="{{$project->practice->name}}">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>{{$project->name}}</h4>
                                            <h6>{{$project->client->name}} - {{$project->practice->name}}</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 17%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.projectHome', ['project' => $project])}}">View<i class="btn-icon-prepend"
                                            data-feather="arrow-right"></i></a>
                                        </div>
                                        <x-projectProgressBar progressSetUp="40" progressValue="20" progressResponse="25" progressAnalytics="10"
                                        progressConclusions="5" />
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="startnew">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Start new project</h3>
                            <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                Platform, you'll need to follow some steps to complete your profile and set up your
                                first project. Please check below the timeline and click "Let's start" when you are
                                ready.</p>
                            <br>
                            <br>

                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.newProjectSetUp')}}">Create and do
                                initial set-up <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
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
    <script>
        $('#filterH3').click(function(){
            if($('#filterContainer').css('display') === 'none'){
                $('#filterContainer').css('display', 'initial')
            } else {
                $('#filterContainer').css('display', 'none')
            }
        })
    </script>
@endsection
