@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-vendor.projectNavbar section="preview" :project="$project" />

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>View project information</h3>
                                <p calss="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_project_information') ?? ''}}
                                </p>
                                <br>
                                <div id="wizaaard">
                                    <h2>General Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            This section contains all relevant information concerning project type, scope and timelines.
                                        </P>
                                        <br>
                                        <x-generalInfoQuestions
                                            :project="$project"
                                            :clients="$clients"
                                            :disableSpecialQuestions="true"
                                            :hideQuestionsForVendor="true"
                                            :disabled="true"
                                            :required="false" />
                                    </section>


                                    <h2>RFP Upload</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            This section contains the physical RFP document provided by the client.
                                        </p>
                                        <br>
                                        <h4>2.1 Upload your RFP</h4>
                                        <br>
                                        <x-folderFileUploader :folder="$project->rfpFolder" label="Upload your RFP" :disabled="true" :timeout="1000" />

                                        <div class="form-group">
                                            <label for="rfpOtherInfo">Other information</label>
                                            <textarea class="form-control" id="rfpOtherInfo" rows="14" disabled>{{$project->rfpOtherInfo}}</textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            This section contains useful information for you to consider in the sizing of your proposal.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="true"
                                            :required="false" />
                                    </section>
                                </div>
                            </div>

                            <div style="display:flex; justify-content:space-evenly; padding: 1.5rem 1.5rem;">
                                <div style="text-align: right; width: 17%;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('vendor.application.setRejected', ['project' => $project])}}"
                                        onclick="event.preventDefault(); document.getElementById('reject-project-{{$project->id}}-form').submit();">
                                        Reject
                                    </a>
                                    <form id="reject-project-{{$project->id}}-form"
                                        action="{{ route('vendor.application.setRejected', ['project' => $project]) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                                <div style="text-align: right; width: 17%;">
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
                            </div>

                            <br><br>
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

    .select2-results__options .select2-results__option[aria-disabled=true] {
        display: none;
    }

    #subwizard_here ul>li {
        display: block;
    }
</style>
<link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
@endsection

@section('scripts')
@parent
<script>
    var currentPracticeId = {{$project->practice->id ?? -1}};
    function updateShownQuestionsAccordingToPractice(){
        $('.questionDiv').each(function () {
            var practiceId = $(this).data('practice');

            if(practiceId == currentPracticeId || practiceId == "") {
                $(this).css('display', 'block')
            } else {
                $(this).css('display', 'none')
            }
        });
    }

    $(document).ready(function() {
        $("#wizaaard").steps({
            headerTag: "h2",
            bodyTag: "section",
            showFinishButtonAlways: false,
            enableFinishButton: false,
            enableAllSteps: true,
            enablePagination: false,
            // HACK Cause otherwise subwizards don't work
            onStepChanged: function(e, c, p) {
                for (var i = 0; i < 10; i++) {
                    $("#projectViewWizard-p-" + i).css("display", "none");
                }

                $("#projectViewWizard-p-" + c).css("display", "block");
            }
        });

        $(".js-example-basic-single").select2();
        $(".js-example-basic-multiple").select2();

        $('.datepicker').each(function(){
            var date = new Date($(this).data('initialvalue'));

            $(this).datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                autoclose: true,
                startDate: "+0d"
            });
            $(this).datepicker('setDate', date);
        });

        updateShownQuestionsAccordingToPractice()
    });
</script>
@endsection
