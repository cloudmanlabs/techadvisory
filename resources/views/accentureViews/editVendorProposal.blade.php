@extends('accentureViews.layouts.forms')

@section('content')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="sections" />

    <div class="page-wrapper">
        <div class="page-content">
            <x-accenture.projectNavbar section="projectHome" :project="$project" />

            <div class="row" style="margin-top: 25px;">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>{{$vendor->name}}</h3>
                            <h4>Review application</h4>
                            <p class="welcome_text extra-top-15px">
                                {{nova_get_setting('accenture_vendorProposalEdit_Title') ?? ''}}
                            </p>
                            <br>
                            <div id="wizard_accenture">
                                <h2>Fit gap</h2>
                                <section>
                                    <h4>Fit Gap</h4>
                                    <br>
                                    <p>
                                        {{nova_get_setting('fitgap_description') ?? ''}}
                                    </p>
                                    <br><br>

                                    <x-fitgapVendorModal :vendor="$vendor" :project="$project" />

                                    <br><br>
                                    <h4>Questions</h4>
                                    <br>
                                    <x-questionForeach :questions="$fitgapQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />
                                </section>

                                <h2>Vendor</h2>
                                <section>
                                    <h4>Corporate information</h4>
                                    <br>
                                    <x-questionForeach :questions="$vendorCorporateQuestions" :class="'selectionCriteriaQuestion'" :disabled="false"
                                        :required="false" />

                                    <br><br>
                                    <h4>Market presence</h4>
                                    <x-questionForeach :questions="$vendorMarketQuestions" :class="'selectionCriteriaQuestion'" :disabled="false"
                                        :required="false" />
                                </section>

                                <h2>Experience</h2>
                                <section>
                                    <h4>Questions</h4>
                                    <br>
                                    <x-questionForeach :questions="$experienceQuestions" :class="'selectionCriteriaQuestion'" :disabled="false"
                                        :required="false" />
                                </section>

                                <h2>Innovation & Vision</h2>
                                <section>
                                    <h4>IT Enablers</h4>
                                    <br>
                                    <x-questionForeach :questions="$innovationDigitalEnablersQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="false" :required="false" />

                                    <h4>Alliances</h4>
                                    <br>
                                    <x-questionForeach :questions="$innovationAlliancesQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="false" :required="false" />

                                    <h4>Product</h4>
                                    <br>
                                    <x-questionForeach :questions="$innovationProductQuestions" :class="'selectionCriteriaQuestion'" :disabled="false"
                                        :required="false" />

                                    <h4>Sustainability</h4>
                                    <br>
                                    <x-questionForeach :questions="$innovationSustainabilityQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="false" :required="false" />
                                </section>

                                <h2>Implementation & Commercials</h2>
                                <section>
                                    @if ($project->id == 139)
                                    <p class="welcome_text extra-top-15px" style="color:red">
                                        This section covered as part of RFP response document. To complete questionnaire please only fill "Solutions used" with
                                        the solutions you are offering, and implementation & run costs with a "0". Finally, click on Submit to send your
                                        application.
                                    </p>
                                    @endif
                                    @if ($project->id == 140)
                                    <p class="welcome_text extra-top-15px" style="color:red">
                                        This section covered as part of RFP response document. To complete questionnaire please only fill "Solutions used" with
                                        the solutions you are offering, and implementation & run costs with a "0". Finally, click on Submit to send your
                                        application.
                                    </p>
                                    @endif

                                    <h4>Implementation</h4>
                                    <br>
                                    <x-questionForeach :questions="$implementationImplementationQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="false" :required="false" />

                                    <br><br>

                                    <x-selectionCriteria.solutionsUsed :vendorApplication="$vendorApplication" :disabled="false" />

                                    <br><br>

                                    <x-selectionCriteria.deliverables :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>

                                    <br>
                                    <br>
                                    <x-selectionCriteria.raciMatrix :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>

                                    <br>
                                    <br>
                                    <b>Implementation Cost</b>

                                    @if ($project->isBinding)
                                        <x-selectionCriteria.staffingCost :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>

                                        <br>
                                        <x-selectionCriteria.travelCost :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>

                                        <br>
                                        <x-selectionCriteria.additionalCost :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>

                                        <p>Overall Implementation Cost: {{$vendorApplication->project->currency ?? ''}} <span id="overallImplementationCost">0</span></p>
                                    @else
                                        <x-selectionCriteria.nonBindingImplementation :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>
                                    @endif

                                    <br>
                                    <h4>Run</h4>
                                    <x-selectionCriteria.pricingModel :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>

                                    <x-questionForeach :questions="$implementationRunQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="false" :required="false" />

                                    <br><br>

                                    @if ($project->isBinding)
                                        <x-selectionCriteria.estimate5Years :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>
                                    @else
                                        <x-selectionCriteria.nonBindingEstimate5Years :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false"/>
                                    @endif

                                    <x-selectionCriteria.detailedBreakdown :vendorApplication="$vendorApplication" :disabled="false" :evaluate="false" />
                                </section>
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

        return array.reduce(function(prev, current) {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        if(checkIfAllRequiredsAreFilled()){
            $('#submitButton').attr('disabled', false)
        } else {
            $('#submitButton').attr('disabled', true)
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
                    value: value
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
