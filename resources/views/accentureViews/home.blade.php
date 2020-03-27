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
                            <h3>Open Projects</h3>
                            <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                            <br>
                            <br>

                            <div class="media-body" style="padding: 20px;">
                                <p class="welcome_text">
                                    Please choose the Practices you'd like to see:
                                </p>
                                <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                    <option selected>Transport</option>
                                    <option selected>Planning</option>
                                    <option>Manufacturing</option>
                                    <option>Wharehousing</option>
                                    <option>Sourcing</option>
                                </select>
                            </div>

                            <div class="media-body" style="padding: 20px;">
                                <p class="welcome_text">
                                    Please choose the Clients you'd like to see:
                                </p>
                                <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                    <option selected>Client 1</option>
                                    <option selected>Client 2</option>
                                    <option>Client 3</option>
                                    <option>Client 4</option>
                                    <option>Client 5</option>
                                </select>
                            </div>

                            <div class="card" style="margin-bottom: 30px;">
                                <div class="card-body">
                                    <div style="float: left; max-width: 40%;">
                                        <h4>Global Transport Management</h4>
                                        <h6>Client Name - Practice</h6>
                                    </div>
                                    <div style="float: right; text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.projectHome')}}">
                                            View <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                        </a>
                                    </div>
                                    <x-projectProgressBar progressSetUp="40" progressValue="20" progressResponse="0" progressAnalytics="10" progressConclusions="0" />
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
                            <div class="media-body" style="padding: 20px;">
                                <p class="welcome_text">
                                    Please choose the Practices you'd like to see:
                                </p>
                                <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                    <option selected>Transport</option>
                                    <option selected>Planning</option>
                                    <option>Manufacturing</option>
                                    <option>Wharehousing</option>
                                    <option>Sourcing</option>
                                </select>
                            </div>

                            <div class="media-body" style="padding: 20px;">
                                <p class="welcome_text">
                                    Please choose the Clients you'd like to see:
                                </p>
                                <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                    <option selected>Client 1</option>
                                    <option selected>Client 2</option>
                                    <option>Client 3</option>
                                    <option>Client 4</option>
                                    <option>Client 5</option>
                                </select>
                            </div>

                            <div class="card" style="margin-bottom: 30px;">
                                <div class="card-body">
                                    <div style="float: left; max-width: 40%;">
                                        <h4>Redistribution of processes at Nestlé</h4>
                                        <h6>Client Name - Practice</h6>
                                    </div>
                                    <div style="float: right; text-align: right; width: 17%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.newProjectSetUp')}}">Complete <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                        <br>
                                        <a href="{{route('accenture.projectValueTargeting')}}">Value
                                            targeting</a>
                                    </div>
                                    <x-projectProgressBar progressSetUp="20" progressValue="10" progressResponse="0" progressAnalytics="0"
                                                                            progressConclusions="0" />
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
                            <h3>Old Projects</h3>
                            <br>

                            <div class="media-body" style="padding: 20px;">
                                <p class="welcome_text">
                                    Please choose the Practices you'd like to see:
                                </p>
                                <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                    <option selected>Transport</option>
                                    <option selected>Planning</option>
                                    <option>Manufacturing</option>
                                    <option>Wharehousing</option>
                                    <option>Sourcing</option>
                                </select>
                            </div>

                            <div class="media-body" style="padding: 20px;">
                                <p class="welcome_text">
                                    Please choose the Clients you'd like to see:
                                </p>
                                <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                    <option selected>Client 1</option>
                                    <option selected>Client 2</option>
                                    <option>Client 3</option>
                                    <option>Client 4</option>
                                    <option>Client 5</option>
                                </select>
                            </div>

                            <div class="card" style="margin-bottom: 30px;">
                                <div class="card-body">
                                    <div style="float: left; max-width: 40%;">
                                        <h4>Finished project 1</h4>
                                        <h6>Client Name - Practice</h6>
                                    </div>
                                    <div style="float: right; text-align: right; width: 17%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.projectHome')}}">View<i class="btn-icon-prepend"
                                                data-feather="arrow-right"></i></a>
                                    </div>
                                    <x-projectProgressBar progressSetUp="40" progressValue="20" progressResponse="25" progressAnalytics="10"
                                        progressConclusions="5" />
                                </div>
                            </div>

                            <div class="card" style="margin-bottom: 30px;">
                                <div class="card-body">
                                    <div style="float: left; max-width: 40%;">
                                        <h4>Finished project 2</h4>
                                        <h6>Client Name - Practice</h6>
                                    </div>
                                    <div style="float: right; text-align: right; width: 17%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.newProjectSetUp')}}">View<i class="btn-icon-prepend"
                                                data-feather="arrow-right"></i></a>
                                    </div>
                                    <x-projectProgressBar progressSetUp="40" progressValue="20" progressResponse="25" progressAnalytics="10"
                                        progressConclusions="5" />
                                </div>
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
