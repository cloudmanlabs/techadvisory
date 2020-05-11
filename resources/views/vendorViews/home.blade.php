@extends('vendorViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">
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
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.previewProject', ['project' => $project])}}">
                                                    Preview <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                                </a>
                                            </div>
                                            <div style="float: right; text-align: right; width: 17%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text"
                                                    href="{{route('vendor.application.setAccepted', ['project' => $project])}}"
                                                    onclick="event.preventDefault(); document.getElementById('accepted-project-{{$project->id}}-form').submit();">
                                                    Accept
                                                </a>
                                                <form id="accepted-project-{{$project->id}}-form"
                                                    action="{{ route('vendor.application.setAccepted', ['project' => $project]) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
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
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplication.apply', ['project' => $project])}}">View <i
                                                        class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                            </div>
                                            @php
                                            $vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id',
                                            auth()->id())->first();
                                            @endphp
                                            <x-applicationProgressBar :application="$vendorApplication" />
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
                                                {{--  TODO CHange this route to submittedApplication --}}
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.submittedApplication', ['project' => $project])}}">View <i
                                                        class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                            </div>
                                            @php
                                            $vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id',
                                            auth()->id())->first();
                                            @endphp
                                            <x-applicationProgressBar :application="$vendorApplication" />
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
