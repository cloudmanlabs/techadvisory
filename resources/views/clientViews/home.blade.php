@extends('clientViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('client_Home')"/>

                <br><br>

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
                                    <div class="card" style="margin-bottom: 30px;" data-practice="{{$project->practice->name ?? ''}}">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$project->name}}</h4>
                                                <h6>Practice: {{$project->practice->name ?? 'No practice'}}</h6>
                                                <h6>Last updated: {{$project->updated_at->format('d/m/Y')}}</h6>
                                            </div>
                                            <div style="float: right; text-align: right; width: 17%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.projectHome', ['project' => $project])}}">
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
                                        data-practice="{{$project->practice->name ?? ''}}">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$project->name}}</h4>
                                                <h6>Practice: {{$project->practice->name ?? 'No practice'}}</h6>
                                                <h6>Last updated: {{$project->updated_at->format('d/m/Y')}}</h6>
                                            </div>
                                            <div style="float: right; text-align: right; width: 17%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text"
                                                    href="{{route('client.newProjectSetUp', ['project' => $project])}}">Complete <i
                                                        class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                                <br>
                                                @if ($project->hasValueTargeting && $project->hasValueTargetingFiles())
                                                <a href="{{route('client.projectValueTargeting', ['project' => $project])}}">Value
                                                    targeting</a>
                                                @endif
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

                <div class="row" id="oldProjects">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3 id="oldProjectsH3" title="Click to maximize/minimize" style="cursor: pointer">Old Projects +</h3>
                                <br style="display: none" class="plsHideMeToo">
                                <p class="welcome_text extra-top-15px plsHideMeToo" style="display: none">
                                    {{nova_get_setting('client_Home_Old') ?? ''}}
                                </p>
                                <br style="display: none" class="plsHideMeToo">

                                <div id="oldPhaseContainer" style="display: none">
                                    @foreach ($oldProjects as $project)
                                    <div class="card" style="margin-bottom: 30px;" data-practice="{{$project->practice->name ?? ''}}">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$project->name}}</h4>
                                                <h6>Practice: {{$project->practice->name ?? 'No practice'}}</h6>
                                            </div>
                                            <div style="float: right; text-align: right; width: 17%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.projectHome', ['project' => $project])}}">
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

            <x-footer />
        </div>
    </div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function(){
            $('#oldProjectsH3').click(function(){
                if($('#oldPhaseContainer').css('display') === 'none'){
                    $('#oldPhaseContainer').css('display', 'initial')
                    $('.plsHideMeToo').css('display', 'initial')
                    $('#oldProjectsH3').text('Old Projects -')
                } else {
                    $('#oldPhaseContainer').css('display', 'none')
                    $('.plsHideMeToo').css('display', 'none')
                    $('#oldProjectsH3').text('Old Projects +')
                }
            })
        });
</script>
@endsection
