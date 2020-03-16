@extends('accentureViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />


        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Global Transport Management</h3>
                                </div>

                                <div style="float: right; width: 35%;">
                                    Current status
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 65%;"
                                            aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-accenture.projectNavbar section="projectConclusions" />

                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Project conclusions</h3>
                                </div>
                                <br><br>

                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-md-12 col-xl-12">
                                        <div class="card">
                                            <img src="{{url("/assets/images/ConclusionsDemo/conclusions.jpg")}}"
                                                class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <div style="text-align: center; margin-top: 5px;"><a href="#"
                                                        class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            </div>

            <x-accenture.footer />
        </div>
    </div>
@endsection
