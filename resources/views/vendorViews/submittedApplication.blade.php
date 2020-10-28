@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-vendor.projectNavbar section="apply" :project="$project"/>

                <x-video :src="nova_get_setting('video_application_file')" :text="nova_get_setting('video_application_text')" />

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Apply to project</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendro_submittedApplication_title') ?? ''}}
                                </p>
                                <br>
                                <div id="wizaaard">
                                    <h2>Fit gap</h2>
                                    <section>
                                        <h4>Fit Gap</h4>
                                        <br>
                                        <!-- <p class="welcome_text extra-top-15px">
                                            Provide your inputs on how your solution/s will cover the client’s functional, technical and service requirements, among others.
                                        </p>
                                        <p class="welcome_text extra-top-15px">
                                            Click Review Fit Gap Table to see all client requirements. Select the most suitable answer under the Vendor Score column and provide additional information or highlights in the Comments column.
                                        </p>
                                        <br> -->
                                        <p>
                                            {{nova_get_setting('fitgap_description') ?? ''}}
                                        </p>
                                        <br><br>

                                        <x-fitgapVendorModal :vendor="auth()->user()" :project="$project" :disabled="true" />

                                        <br><br>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeach :questions="$fitgapQuestions" :class="'selectionCriteriaQuestion'" :disabled="true"
                                            :required="false" />
                                    </section>

                                    <h2>Vendor</h2>
                                    <section>
                                        <h4>Corporate information</h4>
                                        <br>
                                        <x-questionForeach :questions="$vendorCorporateQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />

                                        <br><br>
                                        <h4>Market presence</h4>
                                        <x-questionForeach :questions="$vendorMarketQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />
                                    </section>

                                    <h2>Experience</h2>
                                    <section>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeach :questions="$experienceQuestions" :class="'selectionCriteriaQuestion'" :disabled="true"
                                            :required="false" />
                                    </section>

                                    <h2>Innovation & Vision</h2>
                                    <section>
                                        <h4>IT Enablers</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationDigitalEnablersQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />

                                        <h4>Alliances</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationAlliancesQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />

                                        <h4>Product</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationProductQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />

                                        <h4>Sustainability</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationSustainabilityQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />
                                    </section>

                                    <h2>Implementation & Commercials</h2>
                                    <section>
                                        <h4>Implementation</h4>
                                        <br>
                                        <x-questionForeach :questions="$implementationImplementationQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="true" :required="false" />

                                        <br><br>

                                        <x-selectionCriteria.solutionsUsed :vendorApplication="$vendorApplication" :disabled="true" />

                                        <br><br>

                                        <x-selectionCriteria.deliverables :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>

                                        <br>
                                        <br>
                                        <x-selectionCriteria.raciMatrix :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>

                                        <br>
                                        <br>
                                        <b>Implementation Cost</b>

                                        @if ($project->isBinding)
                                            <x-selectionCriteria.staffingCost :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>

                                            <br>
                                            <x-selectionCriteria.travelCost :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>

                                            <br>
                                            <x-selectionCriteria.additionalCost :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>

                                            <p>Overall Implementation Cost: {{$vendorApplication->project->currency ?? ''}} <span id="overallImplementationCost">0</span></p>
                                        @else
                                            <x-selectionCriteria.nonBindingImplementation :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>
                                        @endif

                                        <br>
                                        <h4>Run</h4>

                                        <x-selectionCriteria.pricingModel :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>

                                        <x-questionForeach :questions="$implementationRunQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="true" :required="false" />

                                        <br><br>

                                        @if ($project->isBinding)
                                            <x-selectionCriteria.estimate5Years :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>
                                        @else
                                            <x-selectionCriteria.nonBindingEstimate5Years :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>
                                        @endif

                                        <x-selectionCriteria.detailedBreakdown :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false" />
                                    </section>
                                </div>
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

    .select2-results__options .select2-results__option[aria-disabled=true] {
        display: none;
    }
</style>
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

        updateShownQuestionsAccordingToPractice();
    });
</script>
@endsection
