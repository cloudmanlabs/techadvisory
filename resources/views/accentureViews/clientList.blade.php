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
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>List of Clients</h3>
                                <p class="welcome_text extra-top-15px">In this list you can see the list of clients
                                    already registered in the platform. See the detail of the client profile by clicking
                                    on the button.</p>
                                <br>
                                <br>
                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>Client Name </h4>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                                href="{{route('accenture.clientHomeProfileCreate')}}">View <i
                                                    class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                        </div>
                                        <div style="float: right; width: 20%; margin-right: 10%;">
                                            <h5>Industry name</h5>
                                        </div>
                                        <div style="float: right; width: 10%; margin-right: 10%;">
                                            <img alt="profile" src="@profilePic" style="height: 20px">
                                        </div>
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
                                <h3>Create new Client</h3>
                                <br>
                                <br>

                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.createNewClient')}}">Create and
                                    do
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
