@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-vendor.projectNavbar section="apply" :project="$project"/>

                <x-video :src="nova_get_setting('video_application_file')" :text="nova_get_setting('video_application_text')"/>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Apply to project</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendro_newApplicationApply_title') ?? ''}}
                                </p>
                                <br>
                                <div id="wizard_vendor_go_to_home">
                                    <h2>Fit gap</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Provide your inputs on how your solution/s will cover the client’s functional, technical and service requirements, among others.
                                        </p>
                                        <p class="welcome_text extra-top-15px">
                                            Click Review Fit Gap Table to see all client requirements. Select the most suitable answer under the Vendor Score column and provide additional information or highlights in the Comments column.
                                        </p>
                                        <br><br>

                                        <x-fitgapVendorModal :vendor="auth()->user()" :project="$project" />

                                        <br><br>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeach :questions="$fitgapQuestions" :class="'selectionCriteriaQuestion'" :disabled="false"
                                            :required="false" />
                                    </section>

                                    <h2>Vendor</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Provide us with more insights about your company and presence in the market.
                                        </p>
                                        <br>
                                        <h4>Corporate information</h4>
                                        <p class="welcome_text extra-top-15px">
                                            Below is the questionnaire designed to know more about your company.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$vendorCorporateQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />
                                        
                                        <x-folderFileUploader :folder="/vendorApplication/Corporate" :timeout="1000" />
                                        
                                        <br><br>
                                        <h4>Market presence</h4>
                                        <p class="welcome_text extra-top-15px">
                                            Below is the questionnaire designed to know more about your presence in the market.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$vendorMarketQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />
                                    </section>

                                    <h2>Experience</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Inform us about your previous experiences in the industry and with other clients.
                                        </p>
                                        <br>
                                        <h4>Questions</h4>
                                        <p class="welcome_text extra-top-15px">
                                            Below is the questionnaire designed to know more about previous experiences with other clients and within the industry.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$experienceQuestions" :class="'selectionCriteriaQuestion'" :disabled="false"
                                            :required="false" />

                                        <x-folderFileUploader :folder="/vendorApplication/Question" :timeout="1000" />
                                        
                                    </section>

                                    <h2>Innovation & Vision</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Tell us about the IT enablers used by your solution/s, alliances in place, product insights and sustainability guidelines followed.
                                        </p>
                                        <br>
                                        <h4>IT Enablers</h4>
                                        <p class="welcome_text extra-top-15px">
                                        Below is the questionnaire designed to know more about the IT Enablers currently used by your solution/s.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$innovationDigitalEnablersQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />

                                        <h4>Alliances</h4>
                                        <p class="welcome_text extra-top-15px">
                                            Below is the questionnaire designed to know more about the alliances you have with other solution providers.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$innovationAlliancesQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />

                                        <h4>Product</h4>
                                        <p class="welcome_text extra-top-15px">
                                            Below is the questionnaire designed to get more insights about your products.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$innovationProductQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />

                                        <h4>Sustainability</h4>
                                        <p class="welcome_text extra-top-15px">
                                            Below is the questionnaire designed to know more about your sustainability guidelines.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$innovationSustainabilityQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />
                                    </section>

                                    <h2>Implementation & Commercials</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Let us know more about the project plan, main deliverables and RACI you proposed. Provide a cost estimation for both implementation and run phases.
                                        </p>
                                        <br>
                                        <h4>Implementation</h4>
                                        <p class="welcome_text extra-top-15px">
                                            Use the following section to provide all details regarding the implementation phase.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$implementationImplementationQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="false" :required="false" />

                                        <br><br>

                                        <x-selectionCriteria.solutionsUsed :vendorApplication="$vendorApplication" :disabled="false" />

                                        <br><br>

                                        <x-selectionCriteria.deliverables :vendorApplication="$vendorApplication" :evaluate="false"/>

                                        <br>
                                        <br>
                                        <x-selectionCriteria.raciMatrix :vendorApplication="$vendorApplication" :evaluate="false"/>

                                        <br>
                                        <br>
                                        <b>Implementation Cost</b>
                                        <p>
                                            Provide costs estimations for implementation phase.
                                        </p>
                                        <br>

                                        @if ($project->isBinding)
                                            <x-selectionCriteria.staffingCost :vendorApplication="$vendorApplication" :evaluate="false"/>

                                            <br>
                                            <x-selectionCriteria.travelCost :vendorApplication="$vendorApplication" :evaluate="false"/>

                                            <br>
                                            <x-selectionCriteria.additionalCost :vendorApplication="$vendorApplication" :evaluate="false"/>

                                            <p>Overall Implementation Cost: <span id="overallImplementationCost">0</span> {{$vendorApplication->project->currency ?? ''}}</p>
                                        @else
                                            <x-selectionCriteria.nonBindingImplementation :vendorApplication="$vendorApplication" :evaluate="false"/>
                                        @endif

                                        <br>
                                        <h4>Run</h4>
                                        <p class="welcome_text extra-top-15px">
                                            Use the following section to provide all details regarding the run phase.
                                        </p>
                                        <br>

                                        <x-selectionCriteria.pricingModel :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>

                                        <x-questionForeach :questions="$implementationRunQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="false" :required="false" />

                                        <br><br>

                                        @if ($project->isBinding)
                                            <x-selectionCriteria.estimate5Years :vendorApplication="$vendorApplication" :evaluate="false"/>
                                        @else
                                            <x-selectionCriteria.nonBindingEstimate5Years :vendorApplication="$vendorApplication" :evaluate="false" />
                                        @endif

                                        <x-selectionCriteria.detailedBreakdown :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false" />

                                        <br><br>

                                        <button
                                            class="btn btn-primary btn-lg btn-icon-text"
                                            id="finalSubmitButton"
                                            data-toggle="modal"
                                            data-target="#submitModal">
                                                Submit
                                            </button>

                                            <div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            Are you sure you want to submit your project application? Be aware
                                                            that no further modifications will be allowed on your answers once project application is submitted.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button id="submitButton" type="button" class="btn btn-primary">Submit</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <br><br>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                    <x-deadline :project="$project" />
                </div>
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
    jQuery.expr[':'].hasValue = function(el,index,match) {
        return el.value != "";
    };

    /**
     *  Returns false if any field is empty
     */
    function checkIfAllRequiredsAreFilled(){
        let array = $('input,textarea,select').filter('[required]').toArray();
		if(array.length == 0) return true;

        for (let i = 0; i < array.length; i++) {
            if(!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')){
                console.log(array[i])
                return false
            }
        }

        return true
    }

    function checkIfAllRequiredsInThisPageAreFilled(){
        let array = $('input,textarea,select').filter('[required]:visible').toArray();
        if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        if(checkIfAllRequiredsAreFilled()){
            $('#finalSubmitButton').attr('disabled', false)
        } else {
            $('#finalSubmitButton').attr('disabled', true)
        }
    }

    function showSavedToast()
    {
        $.toast({
            heading: 'Saved!',
            showHideTransition: 'slide',
            icon: 'success',
            hideAfter: 1000,
            position: 'bottom-right'
        })
    }

    $(document).ready(function() {
        $('.selectionCriteriaQuestion input,.selectionCriteriaQuestion textarea,.selectionCriteriaQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/selectionCriteriaQuestion/changeResponse', {
                    changing: $(this).data('changing'),
                    value
                })

                showSavedToast();
                updateSubmitButton();
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

        $('#submitButton').click(function(){
            $.post('{{route("vendor.application.setSubmitted", ["project" => $project])}}', {
                success: function () {
                    setTimeout(() => {
                        window.location.replace("/vendors/home");
                    }, 300);
                }
            })

            $.toast({
                heading: 'Submitted!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
            $('#submitModal').modal('hide')


        });

        updateSubmitButton();
    });

    function updateTotalImplementation(){
        let total = 0;

        let cost = $('#travelCostContainer').children()
            .map(function(){
                return $(this).children().get(0)
            })
            .map(function(){
                return {
                    title: $(this).children('.travelTitleInput').val(),
                    cost: $(this).children('.travelCostInput').val(),
                }
            }).toArray();

        total += cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)

        cost = $('#staffingCostContainer').children()
            .map(function(){
                return $(this).children().get(0)
            })
            .map(function(){
                return {
                    title: $(this).children('.staffingCostTitleInput').val(),
                    hours: $(this).children('.staffingCostHoursInput').val(),
                    rate: $(this).children('.staffingCostRateInput').val(),
                    cost: $(this).children('.staffingCostCostInput').val(),
                }
            }).toArray();

        total += cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)

        cost = $('#additionalCostContainer').children()
            .map(function(){
                return $(this).children().get(0)
            })
            .map(function(){
                return {
                    title: $(this).children('.additionalTitleInput').val(),
                    cost: $(this).children('.additionalCostInput').val(),
                }
            }).toArray();

        total += cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)

        $('#overallImplementationCost').html(total);
    }
</script>
@endsection
