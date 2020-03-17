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

                <x-client.projectNavbar section="projectHome" />

                <br>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendors applicating</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%; padding-top: 8px; padding-bottom: 8px; padding-left: 10px;">
                                            <h4>Vendix Solutions S.L.</h4>
                                        </div>
                                        <div style="float: right; width: 50%; margin-right: 2%;">
                                            Application status
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%; padding-top: 8px; padding-bottom: 8px; padding-left: 10px;">
                                            <h4>Another Solutions Gmbh.</h4>
                                        </div>
                                        <div style="float: right; width: 50%; margin-right: 2%;">
                                            Application status
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 18%;" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">18%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%; padding-top: 8px; padding-bottom: 8px; padding-left: 10px;">
                                            <h4>Supracompany Ltd.</h4>
                                        </div>
                                        <div style="float: right; width: 50%; margin-right: 2%;">
                                            Application status
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">90%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%; padding-top: 8px; padding-bottom: 8px; padding-left: 10px;">
                                            <h4>Altervendor Soft Corp.</h4>
                                        </div>
                                        <div style="float: right; width: 50%; margin-right: 2%;">
                                            Application status
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Project deadline</h3>
                                <br>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="text-align: center;">

                                            <div id="clockdiv">
                                                <div>
                                                    <span class="days"></span>
                                                    <div class="smalltext">Days</div>
                                                </div>
                                                <div>
                                                    <span class="hours"></span>
                                                    <div class="smalltext">Hours</div>
                                                </div>
                                                <div>
                                                    <span class="minutes"></span>
                                                    <div class="smalltext">Minutes</div>
                                                </div>
                                                <div>
                                                    <span class="seconds"></span>
                                                    <div class="smalltext">Seconds</div>
                                                </div>
                                            </div>

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
