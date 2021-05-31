@extends('layouts.base')

@section('head')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
    <style>
        select.form-control {
            color: #495057;
        }

        #summary i {
            font-size: 25px;
            padding: 15px;
        }

        #summary .fa-check-circle {
            font-size: 25px;
            color: forestgreen;
        }

        #summary .fa-times-circle {
            font-size: 25px;
            color: red;
        }

        #vendorApplyCard a {
            font-size: 15px;
        }

    </style>
@endsection

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">
                <x-accenture.projectNavbar section="projectHome" :project="$project"/>
                <br>
                <h3 class="p-3">RFP</h3>
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
                                            <x-accenture.resendInvitationModal :vendor="$vendor" :project="$project"/>
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
                                <h3>Vendors applying</h3>
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
                                                  action="{{ route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor]) }}"
                                                  method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                        <div style="text-align: right; width: 10%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                               href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">
                                                View
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                               href="{{route('accenture.editVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">
                                                Support on responses
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text" target="_blank"
                                               href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">
                                                Download responses
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a id="vendorRollback"
                                               class="btn btn-primary btn-lg btn-icon-text text-white cursor-pointer"
                                               href="{{route('accenture.project.vendorApplyRollback', ['project' => $project, 'vendor' => $vendor])}}">
                                                Rollback
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
                                                  action="{{ route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor]) }}"
                                                  method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                               href="{{route('accenture.viewVendorProposalEvaluation', ['project' => $project, 'vendor' => $vendor])}}">
                                                Evaluate Response
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text" target="_blank"
                                               href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download
                                                responses
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a id="vendorRollback"
                                               class="btn btn-primary btn-lg btn-icon-text text-white cursor-pointer"
                                               href="{{route('accenture.project.vendorApplyRollback', ['project' => $project, 'vendor' => $vendor])}}">
                                                Rollback
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
                                                  action="{{ route('accenture.project.disqualifyVendor', ['project' => $project, 'vendor' => $vendor]) }}"
                                                  method="POST"
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
                                               href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View
                                                response
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text" target="_blank"
                                               href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download
                                                responses
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a id="vendorRollback"
                                               class="btn btn-primary btn-lg btn-icon-text text-white cursor-pointer"
                                               href="{{route('accenture.project.vendorApplyRollback', ['project' => $project, 'vendor' => $vendor])}}">
                                                Rollback
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
                                    {{ nova_get_setting('accenture_projectHome_released') ?? '' }}
                                </p>
                                <br>
                                <br>

                                @foreach ($submittedVendors as $vendor)
                                    <x-vendorCard :showProgressBar="false" :vendor="$vendor" :project="$project">
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                               href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">
                                                View response
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text" target="_blank"
                                               href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">
                                                Download responses
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a id="vendorRollback"
                                               class="btn btn-primary btn-lg btn-icon-text text-white cursor-pointer"
                                               href="{{route('accenture.project.vendorApplyRollback', ['project' => $project, 'vendor' => $vendor])}}">
                                                Rollback
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
                                        <a class="btn btn-primary btn-lg btn-icon-text" style="margin-right: 1rem"
                                           href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View
                                            Response</a>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text" target="_blank"
                                               href="{{route('accenture.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download
                                                responses
                                            </a>
                                        </div>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a id="vendorRollback"
                                               class="btn btn-primary btn-lg btn-icon-text text-white cursor-pointer"
                                               href="{{route('accenture.project.vendorApplyRollback', ['project' => $project, 'vendor' => $vendor])}}">
                                                Rollback
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
                                           href="{{route('accenture.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View
                                            Response</a>
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a id="vendorRollback"
                                               class="btn btn-primary btn-lg btn-icon-text text-white cursor-pointer"
                                               href="{{route('accenture.project.vendorApplyRollback', ['project' => $project, 'vendor' => $vendor])}}">
                                                Rollback
                                            </a>
                                        </div>
                                    </x-vendorCard>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="p-3">USE CASES</h3>
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
                                @if (sizeof($useCaseInvitedVendors) > 0)
                                @foreach ($useCaseInvitedVendors as $vendor)
                                    <h4>{{$vendor->name}}</h4>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>User's validation</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectHome_invited') ?? ''}}
                                </p>
                                <br>
                                <br>
                                @foreach ($useCases as $useCase)
                                    <div class="d-flex mb-3" id="use_case_{{$useCase->id}}" style="cursor: pointer;">
                                        <h4 id="{{$useCase->id}}_toggle">+</h4><h4 class="ml-3">{{$useCase->name}}</h4><h4 class="ml-5"><small>{{\App\UseCase::usersSubmittedPercentage($useCase->id)}}% completado</small></h4>
                                    </div>
                                    <div class="m-4" id="use_case_detail_{{$useCase->id}}" style="display: none;">
                                        @foreach ($useCase->users($useCase->id) as $user)
                                            <div class="d-flex m-5">
                                                <h4>{{\App\User::find($user)->name}}</h4>
                                                @if(\App\VendorUseCasesEvaluation::evaluationsSubmitted($user,$useCase->id, $project->vendorsApplied()->whereIn('id', explode(',', urldecode($project->use_case_invited_vendors)))->get(), 'accenture') === 'no')
                                                    <h4 class="text-muted ml-5"><small>Pending Submit</small></h4>
                                                @else
                                                    <button id="rollbackSubmitButton_user_{{$useCase->id}}" class="btn btn-primary btn-right ml-5">
                                                        Rollback Submit
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                        @foreach ($useCase->clients($useCase->id) as $client)
                                            <div class="d-flex m-5">
                                                <h4>{{\App\UserCredential::find($client)->name}}</h4>
                                                @if(\App\VendorUseCasesEvaluation::evaluationsSubmitted($client,$useCase->id, $project->vendorsApplied()->whereIn('id', explode(',', urldecode($project->use_case_invited_vendors)))->get(), 'client') === 'no')
                                                    <h4 class="text-muted ml-5"><small>Pending Submit</small></h4>
                                                @else
                                                    <button id="rollbackSubmitButton_client_{{$useCase->id}}" class="btn btn-primary btn-right ml-5">
                                                        Rollback Submit
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <x-deadline :project="$project"/>
            </div>

            <x-footer/>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        // Make Rollback from Accenture step 3 to initial state
        $('#rollback1').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep1Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                location.reload();
            }).fail(function () {
                $(this).attr('disabled', false);
                handleAjaxError()
            })
        });

        $('#rollback2').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep2Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                location.reload();
            }).fail(function () {
                $(this).attr('disabled', false);
                handleAjaxError()
            })
        });

        // Make Rollback from Accenture step 4 step 3 to Client step 3
        $('#rollback3').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep3Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                location.reload();
            }).fail(function () {
                $(this).attr('disabled', false);
                handleAjaxError()
            })
        });

        // Make Rollback from Client step 4 step 3 to Accenture step 4
        $('#rollback4').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep4Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                location.reload();
            }).fail(function () {
                $(this).attr('disabled', false);
                handleAjaxError()
            })
        });
        @foreach ($useCases as $useCase)
            document.getElementById('use_case_{{$useCase->id}}').addEventListener('click', (e) => {
                if (document.getElementById('use_case_detail_{{$useCase->id}}').style.display == 'block') {
                    document.getElementById('use_case_detail_{{$useCase->id}}').style.display = 'none';
                    document.getElementById('{{$useCase->id}}_toggle').innerHTML = '+';
                } else {
                    document.getElementById('use_case_detail_{{$useCase->id}}').style.display = 'block';
                    document.getElementById('{{$useCase->id}}_toggle').innerHTML = '-';
                }
            });
            @foreach ($useCase->users($useCase->id) as $user)
                @if(\App\VendorUseCasesEvaluation::evaluationsSubmitted($user,$useCase->id, $project->vendorsApplied()->whereIn('id', explode(',', urldecode($project->use_case_invited_vendors)))->get(), 'accenture') === 'yes')
                    document.getElementById('rollbackSubmitButton_user_{{$useCase->id}}').addEventListener('click', (e) => {
                        $.post('/accenture/newProjectSetUp/rollbackSubmitUseCaseVendorEvaluation', {
                            useCaseId: {{$useCase->id}},
                            userCredential: {{$user}}
                        }).done(function () {
                            location.replace("{{route('accenture.projectHome', ['project' => $project])}}")
                        }).fail(handleAjaxError)
                    });
                @endif
            @endforeach
            @foreach ($useCase->clients($useCase->id) as $client)
                @if(\App\VendorUseCasesEvaluation::evaluationsSubmitted($client,$useCase->id, $project->vendorsApplied()->whereIn('id', explode(',', urldecode($project->use_case_invited_vendors)))->get(), 'client') === 'yes')
                    document.getElementById('rollbackSubmitButton_client_{{$useCase->id}}').addEventListener('click', (e) => {
                        $.post('/accenture/newProjectSetUp/rollbackClientSubmitUseCaseVendorEvaluation', {
                            useCaseId: {{$useCase->id}},
                            userCredential: {{$client}}
                        }).done(function () {
                            location.replace("{{route('accenture.projectHome', ['project' => $project])}}")
                        }).fail(handleAjaxError)
                    });
                @endif
            @endforeach
        @endforeach
    </script>
@endsection


