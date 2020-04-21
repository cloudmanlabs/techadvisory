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

                <x-video :src="nova_get_setting('vendor_Home')" />
                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>Projects in Invitation phase</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_Home_Invitation') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div id="invitationPhaseContainer">
                                    @foreach ($invitationProjects as $project)
                                    <div class="card" style="margin-bottom: 30px;"
                                        data-practice="{{$project->practice->name}}" data-year="{{$project->created_at->year}}">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$project->name}}</h4>
                                                <h6>{{$project->practice->name}}</h6>
                                            </div>
                                            <div style="float: right; text-align: right; width: 20%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.previewProject')}}">
                                                    Preview <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                                </a>
                                            </div>
                                            <div style="float: right; text-align: right; width: 17%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.home')}}">
                                                    Accept
                                                </a>
                                            </div>
                                            <div style="float: right; text-align: right; width: 17%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.application.setRejected', ['project' => $project])}}"
                                                    onclick="event.preventDefault(); document.getElementById('reject-project-{{$project->id}}-form').submit();">
                                                    Reject
                                                </a>
                                                <form id="reject-project-{{$project->id}}-form" action="{{ route('vendor.application.setRejected', ['project' => $project]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_Home_Started') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div id="startedPhaseContainer">
                                    @foreach ($startedProjects as $project)
                                    <div class="card" style="margin-bottom: 30px;"
                                        data-practice="{{$project->practice->name}}" data-year="{{$project->created_at->year}}">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$project->name}}</h4>
                                                <h6>{{$project->practice->name}}</h6>
                                            </div>
                                            <div style="float: right; text-align: right; width: 15%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplicationApply')}}">View <i
                                                        class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                            </div>
                                            <x-applicationProgressBar progressFitgap="20" progressVendor="10" progressExperience="0" progressInnovation="0"
                                                progressImplementation="0" progressSubmit="0" />
                                        </div>
                                    </div>
                                    @endforeach
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
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_Home_Submitted') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div id="submittedPhaseContainer">
                                    @foreach ($submittedProjects as $project)
                                    <div class="card" style="margin-bottom: 30px;" data-practice="{{$project->practice->name}}"
                                        data-year="{{$project->created_at->year}}">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$project->name}}</h4>
                                                <h6>{{$project->practice->name}}</h6>
                                            </div>
                                            <div style="float: right; text-align: right; width: 15%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplicationApply')}}">View <i
                                                        class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                            </div>
                                            <x-applicationProgressBar progressFitgap="30" progressVendor="10" progressExperience="10" progressInnovation="10"
                                                progressImplementation="30" progressSubmit="10" />
                                        </div>
                                    </div>
                                    @endforeach
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
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_Home_Rejected') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div id="rejectedPhaseContainer">
                                    @foreach ($rejectedProjects as $project)
                                    <div class="card" style="margin-bottom: 30px;" data-practice="{{$project->practice->name}}"
                                        data-year="{{$project->created_at->year}}">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$project->name}}</h4>
                                                <h6>{{$project->practice->name}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
