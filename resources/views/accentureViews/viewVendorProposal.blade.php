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
                            <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use
                                the platform. It won't take you more than just a few minutes and you can do it
                                today. Note that, if you do not currently have the info for some specific fields,
                                you can leave them blank and fill up them later.</p>
                            <br>
                            <div id="wizard_accenture">
                                <h2>Fit gap</h2>
                                <section>
                                    <h4>Fit Gap</h4>
                                    <br>
                                    <p>
                                        Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu
                                        nunc
                                        pellentesque luctus. ipsum dolor sit amet, consectetur adipiscing elit.
                                        Donec
                                        aliquam ornare sapien, ut dictum nunc pharetra a.Phasellus vehicula
                                        suscipit
                                        mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque luctus.
                                        ipsum
                                        dolor sit amet.
                                    </p>
                                    <br><br>

                                    <x-fitgapVendorModal :vendor="$vendor" :project="$project" />

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
                                    <x-questionForeachWithEvaluate :questions="$implementationImplementationQuestions"
                                        :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="true" :required="false" />

                                    <h4>Deliverables per phase</h4>
                                    <br>
                                    <x-questionForeachWithEvaluate :questions="$implementationRunQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="true"
                                        :required="false" />
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
                autoclose: true
            });
            $(this).datepicker('setDate', date);
        });
    });
</script>
@endsection
