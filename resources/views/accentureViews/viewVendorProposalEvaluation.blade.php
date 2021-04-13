@extends('layouts.base')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectHome" :project="$project"/>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3><h3>{{$vendor->name}}</h3></h3>
                                <h4>Evaluate response</h4>
                                <p class="welcome_text extra-top-15px">
                                    Please complete your profile and get ready to use
                                    the platform. It won't take you more than just a few minutes and you can do it
                                    today. Note that, if you do not currently have the info for some specific fields,
                                    you can leave them blank and fill up them later.</p>
                                <br>
                                <div id="viewVendorProposalEvaluationWizard">
                                    <h2>Vendor</h2>
                                    <section>
                                        <h4>Corporate information</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$vendorCorporateQuestions"
                                                                       :class="'selectionCriteriaQuestion'"
                                                                       :disabled="true" :evalDisabled="false"
                                                                       :required="false"/>

                                        <br><br>
                                        <h4>Market presence</h4>
                                        <x-questionForeachWithEvaluate :questions="$vendorMarketQuestions"
                                                                       :class="'selectionCriteriaQuestion'"
                                                                       :disabled="true" :evalDisabled="false"
                                                                       :required="false"/>
                                    </section>

                                    <h2>Experience</h2>
                                    <section>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$experienceQuestions"
                                                                       :class="'selectionCriteriaQuestion'"
                                                                       :disabled="true" :evalDisabled="false"
                                                                       :required="false"/>
                                    </section>

                                    <h2>Innovation & Vision</h2>
                                    <section>
                                        <h4>IT Enablers</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$innovationDigitalEnablersQuestions"
                                                                       :class="'selectionCriteriaQuestion'"
                                                                       :disabled="true" :evalDisabled="false"
                                                                       :required="false"/>

                                        <h4>Alliances</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$innovationAlliancesQuestions"
                                                                       :class="'selectionCriteriaQuestion'"
                                                                       :disabled="true" :evalDisabled="false"
                                                                       :required="false"/>

                                        <h4>Product</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$innovationProductQuestions"
                                                                       :class="'selectionCriteriaQuestion'"
                                                                       :disabled="true" :evalDisabled="false"
                                                                       :required="false"/>

                                        <h4>Sustainability</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$innovationSustainabilityQuestions"
                                                                       :class="'selectionCriteriaQuestion'"
                                                                       :disabled="true" :evalDisabled="false"
                                                                       :required="false"/>
                                    </section>
                                </div>

                                <div style="float: right; margin-top: 20px;">
                                    <form
                                        action="{{route('accenture.project.submitEvaluation', ['project' => $project, 'vendor' => $vendor])}}"
                                        method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-lg btn-icon-text" id="submitButton"
                                                type="submit">
                                            <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            Submit evaluation
                                        </button>
                                    </form>
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
    <link rel="stylesheet" href="{{url('/assets/css/techadvisory/viewVendorProposalEvaluation.css')}}">
@endsection

@section('scripts')
    @parent
    <script>
        jQuery.expr[':'].hasValue = function (el, index, match) {
            return el.value != "";
        };

        /**
         *  Returns false if any field is empty
         */
        function checkIfAllEvalsAreFilled() {
            let array = $('.evalDiv input')
                .filter('[required]')
                .toArray();

            if (array.length == 0) return true;

            for (let i = 0; i < array.length; i++) {
                if (!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')) {
                    return false
                }
            }

            return true
        }

        function updateSubmitButton() {
            // If we filled all the fields, remove the disabled from the button.
            if (checkIfAllEvalsAreFilled()) {
                $('#submitButton').attr('disabled', false)
            } else {
                $('#submitButton').attr('disabled', true)
            }
        }

        $(document).ready(function () {
            $('.selectionCriteriaQuestion .evalDiv input').change(function (e) {
                score = $(this).val();
                $.post('/selectionCriteriaQuestion/changeScore', {
                    changing: $(this).data('changingid'),
                    value: limitScoreValue(score),
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                }).fail(handleAjaxError)
            });

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

            updateSubmitButton();
        });

        function limitScoreValue(score) {
            if (score > 10) {
                score = 10
            }
            if (score < 0) {
                score = 0
            }
            return score;
        }


        function updateTotalImplementation() {
            let total = 0;

            let cost = $('#travelCostContainer')
                .children()
                .map(function () {
                    return $(this).children().get(0)
                })
                .map(function () {
                    return {
                        title: $(this).children('.travelTitleInput').val(),
                        cost: $(this).children('.travelCostInput').val(),
                    }
                })
                .toArray();

            total += cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)

            cost = $('#staffingCostContainer')
                .children()
                .map(function () {
                    return $(this).children().get(0)
                })
                .map(function () {
                    return {
                        title: $(this).children('.staffingCostTitleInput').val(),
                        hours: $(this).children('.staffingCostHoursInput').val(),
                        rate: $(this).children('.staffingCostRateInput').val(),
                        cost: $(this).children('.staffingCostCostInput').val(),
                    }
                })
                .toArray();

            total += cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)

            cost = $('#additionalCostContainer')
                .children()
                .map(function () {
                    return $(this).children().get(0)
                })
                .map(function () {
                    return {
                        title: $(this).children('.additionalTitleInput').val(),
                        cost: $(this).children('.additionalCostInput').val(),
                    }
                })
                .toArray();

            total += cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)

            $('#overallImplementationCost').html(total);
        }
    </script>
@endsection
