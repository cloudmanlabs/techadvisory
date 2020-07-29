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
                                {{nova_get_setting('accenture_vendorProposalView_Title') ?? ''}}
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

                                    <x-fitgapEvaluationModal :vendor="$vendor" :project="$project" :disabled="true"/>

                                    <br><br>
                                    <h4>Questions</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$fitgapQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="true" :required="false" />
                                </section>

                                <h2>Vendor</h2>
                                <section>
                                    <h4>Corporate information</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$vendorCorporateQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="true"
                                        :required="false" />

                                    <br><br>
                                    <h4>Market presence</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$vendorMarketQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="true"
                                        :required="false" />
                                </section>

                                <h2>Experience</h2>
                                <section>
                                    <h4>Questions</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$experienceQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="true"
                                        :required="false" />
                                </section>

                                <h2>Innovation & Vision</h2>
                                <section>
                                    <h4>IT Enablers</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$innovationDigitalEnablersQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="true" :evalDisabled="true" :required="false" />

                                    <h4>Alliances</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$innovationAlliancesQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="true" :evalDisabled="true" :required="false" />

                                    <h4>Product</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$innovationProductQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="true"
                                        :required="false" />

                                    <h4>Sustainability</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$innovationSustainabilityQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="true" :evalDisabled="true" :required="false" />
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

                                    <x-selectionCriteria.deliverables :vendorApplication="$vendorApplication" :disabled="true" :evaluate="true" :evalDisabled="true"/>

                                    <br>
                                    <br>
                                    <x-selectionCriteria.raciMatrix :vendorApplication="$vendorApplication" :disabled="true" :evaluate="true" :evalDisabled="true"/>

                                    <br>
                                    <br>
                                    <b>Implementation Cost</b>

                                    @if ($project->isBinding)
                                        <x-selectionCriteria.staffingCost :vendorApplication="$vendorApplication" :disabled="true" :evaluate="true" :evalDisabled="true"/>

                                        <br>
                                        <x-selectionCriteria.travelCost :vendorApplication="$vendorApplication" :disabled="true" :evaluate="true" :evalDisabled="true"/>

                                        <br>
                                        <x-selectionCriteria.additionalCost :vendorApplication="$vendorApplication" :disabled="true" :evaluate="true" :evalDisabled="true"/>

                                        <p>Overall Implementation Cost: {{$vendorApplication->project->currency ?? ''}} <span id="overallImplementationCost">0</span></p>
                                    @else
                                        <x-selectionCriteria.nonBindingImplementation :vendorApplication="$vendorApplication" :disabled="true" :evaluate="true" :evalDisabled="true"/>
                                    @endif

                                    <br>
                                    <h4>Run</h4>
                                    <x-selectionCriteria.pricingModel :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false"/>

                                    <x-questionForeach :questions="$implementationRunQuestions" :class="'selectionCriteriaQuestion'"
                                        :disabled="true" :required="false" />

                                    <br><br>

                                    @if ($project->isBinding)
                                        <x-selectionCriteria.estimate5Years :vendorApplication="$vendorApplication" :disabled="true" :evaluate="true" :evalDisabled="true"/>
                                    @else
                                        <x-selectionCriteria.nonBindingEstimate5Years :vendorApplication="$vendorApplication" :disabled="true" :evaluate="true" :evalDisabled="true"/>
                                    @endif

                                    <x-selectionCriteria.detailedBreakdown :vendorApplication="$vendorApplication" :disabled="true" :evaluate="false" />
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

    #subwizard_here ul>li {
        display: block;
    }
</style>

<link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/techadvisory/viewVendorProposalEvaluation.css')}}">
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function() {
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

        console.log(total)

        $('#overallImplementationCost').html(total);
    }
</script>
@endsection
