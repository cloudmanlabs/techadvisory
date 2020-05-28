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
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="#" data-toggle="modal"
                                            data-target="#resend_invite_modal">Resend invite <i class="btn-icon-prepend"
                                                data-feather="mail"></i></a>
                                    </div>
                                </x-vendorCard>
                                @endforeach

                                <div class="modal fade" id="resend_invite_modal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="resend_invite_modal">Resend invitation to
                                                    vendor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Message:</label>
                                                        <textarea class="form-control" id="message-text" style="min-height: 400px;">Dear Vendor, &#10;&#10;We would like to invite dolor sit amet, consectetur adipiscing elit. Etiam in eros libero. &#10;&#10;Curabitur quis ipsum in purus imperdiet dictum. Vivamus at varius sapien. Aenean et bibendum diam, in condimentum erat. Duis sed odio quis nulla venenatis cursus et eu sapien. &#10;&#10;Phasellus hendrerit pharetra turpis. Aliquam lobortis scelerisque dui, at accumsan nunc vehicula laoreet. Proin auctor, nisi emollis ipsum at this link:&#10;&#10;[INVITATION LINK]&#10;&#10;Thank you,&#10;Accenture Team
                                                                            </textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Resend invitation</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.viewVendorProposalEvaluation', ['project' => $project, 'vendor' => $vendor])}}">Evaluate
                                            Response
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
                                        <a class="btn btn-primary btn-lg btn-icon-text" target="_blank" href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download response
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
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View Response</a>
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
