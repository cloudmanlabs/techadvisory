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
                                <h3><h3>{{$vendor->name}}</h3></h3>
                                <h4>Evaluate response</h4>
                                <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use
                                    the platform. It won't take you more than just a few minutes and you can do it
                                    today. Note that, if you do not currently have the info for some specific fields,
                                    you can leave them blank and fill up them later.</p>
                                <br>
                                <div id="viewVendorProposalEvaluationWizard">
                                    <h2>Fit Gap</h2>
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
                                        <div style="text-align: center;">
                                            <div class="input-group col-xs-12">
                                                <input class="form-control file-upload-info" placeholder="Upload Fit Gap model in CSV format" type="text">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">
                                                        <span class="input-group-append">Upload</span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Please
                                                                complete the Fit Gap table</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/doc.html')}}"
                                                                style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal"
                                                                data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-check-square btn-icon-prepend">
                                                                    <polyline points="9 11 12 14 22 4">
                                                                    </polyline>
                                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                                                                    </path>
                                                                </svg> Done</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br><br>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$fitgapQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="false" :required="false" />
                                    </section>

                                    <h2>Vendor</h2>
                                    <section>
                                        <h4>Corporate information</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$vendorCorporateQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="false"
                                            :required="false" />

                                        <br><br>
                                        <h4>Market presence</h4>
                                        <x-questionForeachWithEvaluate :questions="$vendorMarketQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="false"
                                            :required="false" />
                                    </section>

                                    <h2>Experience</h2>
                                    <section>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$experienceQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="false"
                                            :required="false" />
                                    </section>

                                    <h2>Innovation & Vision</h2>
                                    <section>
                                        <h4>IT Enablers</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$innovationDigitalEnablersQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="true" :evalDisabled="false" :required="false" />

                                        <h4>Alliances</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$innovationAlliancesQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="true" :evalDisabled="false" :required="false" />

                                        <h4>Product</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$innovationProductQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="false"
                                            :required="false" />

                                        <h4>Sustainability</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$innovationSustainabilityQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="true" :evalDisabled="false" :required="false" />
                                    </section>

                                    <h2>Implementation & Commercials</h2>
                                    <section>
                                        <h4>Implementation</h4>
                                        <br>
                                        <x-questionForeachWithEvaluate :questions="$implementationImplementationQuestions"
                                            :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="false" :required="false" />

                                        <h4>Deliverables per phase</h4>
                                        <x-questionForeachWithEvaluate :questions="$implementationRunQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :evalDisabled="false"
                                            :required="false" />
                                    </section>
                                </div>

                                <div style="float: right; margin-top: 20px;">
                                    <form action="{{route('accenture.project.submitEvaluation', ['project' => $project, 'vendor' => $vendor])}}"
                                        method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-lg btn-icon-text" id="submitButton" type="submit">
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
    jQuery.expr[':'].hasValue = function(el,index,match) {
        return el.value != "";
    };

    /**
     *  Returns false if any field is empty
     */
    function checkIfAllEvalsAreFilled(){
        let array = $('.evalDiv input').toArray();
		if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
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

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        if(checkIfAllEvalsAreFilled()){
            $('#submitButton').attr('disabled', false)
        } else {
            $('#submitButton').attr('disabled', true)
        }
    }


    $(document).ready(function() {
        $('.selectionCriteriaQuestion .evalDiv input')
            .change(function (e) {
                $.post('/selectionCriteriaQuestion/changeScore', {
                    changing: $(this).data('changingid'),
                    value: $(this).val()
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
                autoclose: true
            });
            $(this).datepicker('setDate', date);
        });

        updateSubmitButton();
    });
</script>
@endsection
