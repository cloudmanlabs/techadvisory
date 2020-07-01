@extends('accentureViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-accenture.projectNavbar section="projectHome" :project="$project" />

                <br>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendors invited</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectHome_invited') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($invitedVendors as $vendor)
                                <x-vendorCard :showProgressBar="false" :vendor="$vendor" :project="$project">
                                    <div style="float: right; text-align: right; width: 25%;">
                                        <x-accenture.resendInvitationModal :vendor="$vendor" :project="$project" />
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
                                <h3>Vendors applicating</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectHome_applicating') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($applicatingVendors as $vendor)
                                <x-vendorCard :vendor="$vendor" :project="$project">
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor])}}"
                                            onclick="event.preventDefault(); document.getElementById('disqualify-vendor-{{$vendor->id}}-form').submit();">
                                            Disqualify
                                        </a>
                                        <form id="disqualify-vendor-{{$vendor->id}}-form"
                                            action="{{ route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor]) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                    <div style="text-align: right; width: 10%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">
                                            View
                                        </a>
                                    </div>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.editVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">
                                            Support on responses
                                        </a>
                                    </div>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" target="_blank" href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">
                                            Download responses
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
                                <h3>Vendors pending evaluation</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectHome_pendingEvalutation') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($pendingEvaluationVendors as $vendor)
                                <x-vendorCard :vendor="$vendor" :project="$project">
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor])}}"
                                            onclick="event.preventDefault(); document.getElementById('disqualify-vendor-{{$vendor->id}}-form').submit();">
                                            Disqualify
                                        </a>
                                        <form id="disqualify-vendor-{{$vendor->id}}-form"
                                            action="{{ route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor]) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.viewVendorProposalEvaluation', ['project' => $project, 'vendor' => $vendor])}}">
                                            Evaluate Response
                                        </a>
                                    </div>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" target="_blank" href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download responses
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
                                <h3>Release vendor responses</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectHome_release') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($evaluatedVendors as $vendor)
                                <x-vendorCard :showProgressBar="false" :vendor="$vendor" :project="$project">
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor])}}"
                                            onclick="event.preventDefault(); document.getElementById('disqualify-vendor-{{$vendor->id}}-form').submit();">
                                            Disqualify
                                        </a>
                                        <form id="disqualify-vendor-{{$vendor->id}}-form"
                                            action="{{ route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor]) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.project.releaseResponse', ['project' => $project, 'vendor' => $vendor])}}"
                                            onclick="event.preventDefault(); document.getElementById('releaseResponse-vendor-{{$vendor->id}}-form').submit();">
                                            Release response
                                        </a>
                                        <form id="releaseResponse-vendor-{{$vendor->id}}-form"
                                            action="{{ route('accenture.project.releaseResponse', ['project' => $project, 'vendor' => $vendor]) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View response
                                        </a>
                                    </div>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" target="_blank" href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download responses
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
                                <h3>Released responses</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectHome_released') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($submittedVendors as $vendor)
                                <x-vendorCard :showProgressBar="false" :vendor="$vendor" :project="$project">
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View response
                                        </a>
                                    </div>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" target="_blank" href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download responses
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
                                <h3>Disqualified Vendors</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectHome_disqualified') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($disqualifiedVendors as $vendor)
                                <x-vendorCard :vendor="$vendor" :project="$project">
                                    <a class="btn btn-primary btn-lg btn-icon-text" style="margin-right: 1rem" href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View Response</a>
                                    <div style="text-align: right; width: 15%; margin-right: 1rem">
                                        <a class="btn btn-primary btn-lg btn-icon-text" target="_blank" href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download responses
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
                                <h3>Rejected Vendors</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectHome_rejected') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($rejectedVendors as $vendor)
                                <x-vendorCard :showProgressBar="false" :vendor="$vendor" :project="$project">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                    href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View Response</a>
                                </x-vendorCard>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <x-deadline :project="$project" />
            </div>

            <x-footer />
        </div>
    </div>
@endsection

@section('head')
@parent

<style>
    select.form-control {
        color: #495057;
    }
</style>
@endsection
