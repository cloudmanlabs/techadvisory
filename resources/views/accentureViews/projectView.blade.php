@extends('accentureViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectEditView" :project="$project"/>

                <br>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">
                                    <h3>View project information</h3>
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                       href="{{route('accenture.projectEdit', ['project' => $project])}}">Edit</a>
                                </div>
                                <br>
                                <div id="projectViewWizard">
                                    <h2>General Info</h2>
                                    <section>
                                        <x-generalInfoQuestions
                                            :project="$project"
                                            :clients="$clients"
                                            :disableSpecialQuestions="false"
                                            :disabled="true"
                                            :allOwners="$allOwners"
                                            :required="false"/>
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP</h4>
                                        <br>
                                        <x-folderFileUploader :folder="$project->rfpFolder" label="Upload your RFP"
                                                              :disabled="true" :timeout="1000"/>

                                        <div class="form-group">
                                            <label for="rfpOtherInfo">Other information</label>
                                            <textarea class="form-control" id="rfpOtherInfo" rows="14"
                                                      disabled>{{$project->rfpOtherInfo}}</textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <x-questionForeach :questions="$sizingQuestions" :class="'sizingQuestion'"
                                                           :disabled="true"
                                                           :required="false"/>
                                    </section>


                                    <h2>Selection Criteria</h2>
                                    <section>
                                        <div id="subwizard">
                                            <h3>Fit gap</h3>
                                            <div>
                                                <h4>4.1. Fit Gap</h4>
                                                <br>
                                                <p>
                                                    {{nova_get_setting('fitgap_description') ?? ''}}
                                                </p>
                                                <br><br>

                                                <x-fitgapClientModal :project="$project" :disabled="true"/>

                                                <br><br>
                                                <h4>Questions</h4>
                                                <br>
                                                @foreach ($fitgapQuestions as $question)
                                                    <h6>
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach
                                            </div>

                                            <x-selectionCriteriaQuestionsForAccentureAndClient
                                                :vendorCorporateQuestions="$vendorCorporateQuestions"
                                                :project="$project"
                                                :vendorMarketQuestions="$vendorMarketQuestions"
                                                :experienceQuestions="$experienceQuestions"
                                                :innovationDigitalEnablersQuestions="$innovationDigitalEnablersQuestions"
                                                :innovationAlliancesQuestions="$innovationAlliancesQuestions"
                                                :innovationProductQuestions="$innovationProductQuestions"
                                                :innovationSustainabilityQuestions="$innovationSustainabilityQuestions"
                                                :implementationImplementationQuestions="$implementationImplementationQuestions"
                                                :implementationRunQuestions="$implementationRunQuestions"/>

                                            <h3>Scoring criteria</h3>
                                            <div>
                                                <x-scoringCriteriaBricksView :project="$project"/>
                                                <br>
                                                <x-scoringCriteriaWeightsView :project="$project"/>
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Invited vendors</h2>
                                    <section>
                                        <h4>Vendors</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Vendors invited to this project</label><br>
                                            <select
                                                id="vendorSelection"
                                                disabled
                                                class="js-example-basic-multiple w-100" multiple="multiple"
                                                style="width: 100%;">
                                                <x-options.vendorList
                                                    :selected="$project->vendorsApplied()->pluck('id')->toArray()"/>
                                            </select>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer/>
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

        #subwizard_here ul > li {
            display: block;
        }
    </style>
    <link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
@endsection

@section('scripts')
    @parent
    <script>
        var currentPracticeId = {{$project->practice->id ?? -1}};

        function updateShownQuestionsAccordingToPractice() {
            $('.questionDiv').each(function () {
                let practiceId = $(this).data('practice');

                if (practiceId == currentPracticeId || practiceId == "") {
                    $(this).css('display', 'block')
                } else {
                    $(this).css('display', 'none')
                }
            });
        }

        $(document).ready(function () {
            $(".js-example-basic-single").select2();
            $(".js-example-basic-multiple").select2();

            $('.datepicker').each(function () {
                var date = new Date($(this).data('initialvalue'));

                $(this).datepicker({
                    format: "mm/dd/yyyy",
                    todayHighlight: true,
                    autoclose: true,
                    startDate: "+0d"
                });
                $(this).datepicker('setDate', date);
            });

            updateShownQuestionsAccordingToPractice();
        });
    </script>
@endsection
