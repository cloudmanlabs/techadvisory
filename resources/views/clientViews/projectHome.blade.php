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

                <x-client.projectNavbar section="projectHome" :project="$project" />

                <br>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendors applicating</h3>
                                <p class="welcome_text extra-top-15px">
                                    Here you can see the Vendors that are currently applying to this project.
                                    <br>
                                    You'll only be able to view their answers when Accenture releases the responses.
                                </p>
                                <br>
                                <br>

                                @foreach ($startedVendors as $vendor)
                                <x-vendorCard :vendor="$vendor">
                                </x-vendorCard>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Released responses</h3>
                                <p class="welcome_text extra-top-15px">The following responses have already been released.
                                </p>
                                <br>
                                <br>

                                @foreach ($submittedVendors as $vendor)
                                <x-vendorCard :showProgressBar="false" :vendor="$vendor">
                                    <div style="text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="#">Download response
                                        </a>
                                    </div>
                                    <div style=" text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View response
                                        </a>
                                    </div>
                                </x-vendorCard>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

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
                                                    <span class="days">83</span>
                                                    <div class="smalltext">Days</div>
                                                </div>
                                                <div>
                                                    <span class="hours">05</span>
                                                    <div class="smalltext">Hours</div>
                                                </div>
                                                <div>
                                                    <span class="minutes">47</span>
                                                    <div class="smalltext">Minutes</div>
                                                </div>
                                                <div>
                                                    <span class="seconds">19</span>
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
