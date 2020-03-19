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

                <x-vendor.projectNavbar section="info" />

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
