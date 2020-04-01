@extends('clientViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-client.video />

                <br><br>

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
                                            <h6>Practice: Transport</h6>
                                            <h6>Last updated: 11/11/1111</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.projectHome')}}">
                                                View <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                            </a>
                                        </div>
                                        {{-- <x-projectProgressBar progressSetUp="20" progressValue="10" progressResponse="0" progressAnalytics="0" progressConclusions="0" /> --}}
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
                                            <h4>Global Transport Management</h4>
                                            <h6>Practice: Transport</h6>
                                            <h6>Last updated: 11/11/1111</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.newProjectSetUp')}}">
                                                Complete <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                            </a>
                                            <br>
                                            <a href="{{route('client.projectDiscovery')}}">Value
                                                targeting</a>
                                        </div>
                                        {{-- <x-projectProgressBar progressSetUp="20" progressValue="10" progressResponse="0" progressAnalytics="0"
                                            progressConclusions="0" /> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="oldProjects">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Finished projects</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need
                                    to follow some steps to complete your profile and set up your first project. Please check below the
                                    timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>Global Transport Management</h4>
                                            <h6>Practice: Transport</h6>
                                            <h6>Last updated: 11/11/1111</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.projectHome')}}">
                                                View <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                            </a>
                                        </div>
                                        {{-- <x-projectProgressBar progressSetUp="40" progressValue="20" progressResponse="25"
                                            progressAnalytics="10" progressConclusions="5" /> --}}
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
