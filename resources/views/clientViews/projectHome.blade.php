@extends('clientViews.layouts.app')

@section('content')
<div class="main-wrapper">
    <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

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
                                <x-vendorCard :vendor="$vendor" :project="$project">
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
                                <x-vendorCard :showProgressBar="false" :vendor="$vendor" :project="$project">
                                    <div style="text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" target="_blank" href="{{route('client.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download response
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
                                <h5>{{$project->deadline->format('F j Y, \a\t H:i')}}</h5>
                                <br>

                                @if ($project->deadline != null && !$project->deadline->isPast())
                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="text-align: center;">
                                            <div id="clockdiv" data-enddate="{{$project->deadline->format('F j Y H:i')}}">
                                                <div>
                                                    <span class="days">{{$project->deadline->days()}}</span>
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
                                @else
                                <h3 style="text-align: center;">Date has already passed!</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
