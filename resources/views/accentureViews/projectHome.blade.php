@extends('accentureViews.layouts.app')
@section('head')
    @parent

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
    <style>
        select.form-control {
            color: #495057;
        }

        /* feature 2.8: icons */
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
        #summary button {
            font-size: 15px;
        }

        #vendorApplyCard a  {
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

                <!-- feature 2.8-->
                <div id="summary" class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Summary</h3>
                                <p class="welcome_text extra-top-15px">Check the project summary and execute rollback
                                    to the previous state. </p>
                                <br>

                                <!-- feature 2.8: Accenture-Client Rollbacks display -->
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td> Accenture submitted First 3 pages</td>
                                        <td>
                                            @if($project->step3SubmittedAccenture)
                                                <i class="far fa-check-circle"></i>
                                            @else
                                                <i class="far fa-times-circle"></i>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if($project->step3SubmittedAccenture && !$project->step3SubmittedClient &&
                                            !$project->step4SubmittedAccenture && !$project->step4SubmittedClient)
                                                <button id="rollback1"
                                                        class="btn btn-primary btn-lg btn-icon-text">
                                                    Rollback
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Client submitted First 3 pages</td>
                                        <td>
                                            @if($project->step3SubmittedClient)
                                                <i class="far fa-check-circle"></i>
                                            @else
                                                <i class="far fa-times-circle"></i>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if($project->step3SubmittedAccenture && $project->step3SubmittedClient &&
                                            !$project->step4SubmittedAccenture && !$project->step4SubmittedClient)
                                                <button id="rollback2"
                                                        class="btn btn-primary btn-lg btn-icon-text">
                                                    Rollback
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Accenture submitted Selection Criteria</td>
                                        <td>
                                            @if($project->step4SubmittedAccenture)
                                                <i class="far fa-check-circle"></i>
                                            @else
                                                <i class="far fa-times-circle"></i>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if($project->step3SubmittedAccenture && $project->step3SubmittedClient &&
                                            $project->step4SubmittedAccenture && !$project->step4SubmittedClient)
                                                <button id="rollback3"
                                                        class="btn btn-primary btn-lg btn-icon-text">
                                                    Rollback
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Client submitted Selection Criteria</td>
                                        <td>
                                            @if($project->step4SubmittedClient)
                                                <i class="far fa-check-circle"></i>
                                            @else
                                                <i class="far fa-times-circle"></i>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if($project->step3SubmittedAccenture && $project->step3SubmittedClient &&
                                            $project->step4SubmittedAccenture && $project->step4SubmittedClient)
                                                <button id="rollback4"
                                                        class="btn btn-primary btn-lg btn-icon-text">
                                                    Rollback
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <!-- feature 2.8 Vendor rollback -->
                                        <div style="text-align: right; width: 15%; margin-right: 1rem">
                                            <a class="btn btn-primary btn-lg btn-icon-text text-white cursor-pointer">
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
                                    </x-vendorCard>
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
        // feature 2.8: Make Rollback from Accenture step 3 to initial state
        $('#rollback1').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep1Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                $(this).html('Rollback Completed')
                $.toast({
                    heading: 'Rollback completed!',
                    showHideTransition: 'slide',
                    icon: 'success',
                    hideAfter: 1000,
                    position: 'bottom-right'
                })
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }).fail(function () {
                $(this).attr('disabled', false);
                $.toast({
                    heading: 'Rollback failed!',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right'
                })
            })
        });

        // feature 2.8: Make Rollback from Client step 3 to Accenture step 3
        $('#rollback2').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep2Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                $(this).html('Rollback Completed')
                $.toast({
                    heading: 'Rollback completed!',
                    showHideTransition: 'slide',
                    icon: 'success',
                    hideAfter: 1000,
                    position: 'bottom-right'
                })
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }).fail(function () {
                $(this).attr('disabled', false);
                $.toast({
                    heading: 'Rollback failed!',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right'
                })
            })
        });

        // feature 2.8: Make Rollback from Accenture step 4 step 3 to Client step 3
        $('#rollback3').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep3Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                $(this).html('Rollback Completed')
                $.toast({
                    heading: 'Rollback completed!',
                    showHideTransition: 'slide',
                    icon: 'success',
                    hideAfter: 1000,
                    position: 'bottom-right'
                })
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }).fail(function () {
                $(this).attr('disabled', false);
                $.toast({
                    heading: 'Rollback failed!',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right'
                })
            })
        });

        // feature 2.8: Make Rollback from Client step 4 step 3 to Accenture step 4
        $('#rollback4').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep4Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                $(this).html('Rollback Completed')
                $.toast({
                    heading: 'Rollback completed!',
                    showHideTransition: 'slide',
                    icon: 'success',
                    hideAfter: 1000,
                    position: 'bottom-right'
                })
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }).fail(function () {
                $(this).attr('disabled', false);
                $.toast({
                    heading: 'Rollback failed!',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right'
                })
            })
        });
    </script>
@endsection


