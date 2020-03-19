@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />

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
                                    <h3>Redistribution of processes at Nestlé</h3>
                                </div>

                                <div style="float: right; width: 35%;">
                                    Application status
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-page">
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="profile-header">
                                <div class="header-links">
                                    <ul class="links d-flex align-items-center mt-3 mt-md-0">
                                        <li class="header-link-item d-flex align-items-center active">
                                            <i data-feather="bookmark" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i> <a class="pt-1px d-none d-md-block" href="{{route('vendor.newApplication')}}">Project information</a>
                                        </li>
                                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                            <i data-feather="check-circle" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i> <a class="pt-1px d-none d-md-block" href="{{route('vendor.newApplicationApply')}}">Apply to project</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Project information</h3>
                                <p class="welcome_text extra-top-15px">Please review the project documentation before applying to it. It won't take you more than just a few minutes and you can do it today. Note that, if you do not currently have the info for some specific fields, you can leave them blank and fill up them later.</p>
                                <br><br>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/BO1.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">ABInBev - Global Transport Transformation</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/BO2.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">Implementation Journey</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
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
