@extends('vendorViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-vendor.video />
                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>Projects in Invitation phase</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>
                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>Redistribution of processes at Nestlé</h4>
                                            <h6>Solution type</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 20%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.previewProject')}}">
                                                Preview <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                            </a>
                                        </div>
                                        {{-- TODO Here we should mark the project as either rejected or accepted --}}
                                        <div style="float: right; text-align: right; width: 17%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.home')}}">
                                                Accept
                                            </a>
                                        </div>
                                        <div style="float: right; text-align: right; width: 17%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.home')}}">
                                                Reject
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" id="preparation_phase">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Started Applications</h3>
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
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplicationApply')}}">View <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                        </div>
                                        <x-applicationProgressBar progressFitgap="20" progressVendor="10" progressExperience="0" progressInnovation="0"
                                            progressImplementation="0" progressSubmit="0" />
                                    </div>
                                </div>


                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>Future of leadership</h4>
                                            <h6>Solution type</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplicationApply')}}">View <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                        </div>
                                        <x-applicationProgressBar progressFitgap="20" progressVendor="10" progressExperience="0" progressInnovation="0"
                                            progressImplementation="0" progressSubmit="0" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" id="preparation_phase">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Submitted Applications</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>Global Management Platform</h4>
                                            <h6>Solution type</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplicationApply')}}">View <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                        </div>
                                        <x-applicationProgressBar progressFitgap="30" progressVendor="10" progressExperience="10" progressInnovation="10"
                                            progressImplementation="30" progressSubmit="10" />
                                    </div>
                                </div>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>Stock of leisiture</h4>
                                            <h6>Solution type</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplicationApply')}}">View <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                        </div>
                                        <x-applicationProgressBar progressFitgap="30" progressVendor="10" progressExperience="10" progressInnovation="10"
                                            progressImplementation="30" progressSubmit="10" />
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
                                <h3>Rejected Projects</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need
                                    to follow some steps to complete your profile and set up your first project. Please check below the
                                    timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>
                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>Redistribution of processes at Nestlé</h4>
                                            <h6>Solution type</h6>
                                        </div>
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
