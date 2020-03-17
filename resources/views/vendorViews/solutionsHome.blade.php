@extends('vendorViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="solutions" />

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
                                <h3>Solutions</h3>
                                <p class="welcome_text extra-top-15px">This are your existing solutions.</p>
                                <br>
                                <br>
                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>Redistribution of processes at Nestlé</h4>
                                            <h6>Solution type</h6>
                                        </div>
                                        <div style="float: right; text-align: right; width: 17%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplication')}}">Apply <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
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
            </div>

            <x-footer />
        </div>
    </div>
@endsection
