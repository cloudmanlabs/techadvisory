@extends('accentureViews.layouts.app')

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
                            <h3>Open Projects</h3>
                            <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                            <br>
                            <br>

                            <div class="card" style="margin-bottom: 30px;">
                                <div class="card-body">
                                    <div style="float: left; max-width: 40%;">
                                        <h4>Global Transport Management</h4>
                                        <h6>Solution type</h6>
                                    </div>
                                    <div style="float: right; text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.projectHome')}}">
                                            View <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                        </a>
                                    </div>
                                    <div style="float: right; width: 35%; margin-right: 10%;">
                                        Current status
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                                        </div>
                                    </div>
                                </div>
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
                            <br>
                            <div class="card" style="margin-bottom: 30px;">
                                <div class="card-body">
                                    <div style="float: left; max-width: 40%;">
                                        <h4>Redistribution of processes at Nestlé</h4>
                                        <h6>Solution type</h6>
                                    </div>
                                    <div style="float: right; text-align: right; width: 17%;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.newProjectSetUp')}}">Complete <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                    </div>
                                    <!--<div style="float: right; width: 35%; margin-right: 5%; margin-left: 5%;">
                                        Current status
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="preparation_phase">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Start new project</h3>
                            <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                            <br>
                            <br>

                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.newProjectSetUp')}}">
                                Create and do initial set-up <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <x-footer />
    </div>
</div>
@endsection
