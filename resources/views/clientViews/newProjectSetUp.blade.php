@extends('clientViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />
        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('client_NewProjectSetUp')" />

                <br><br>

                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Redistribution of processes at Nestlé</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            The first phase of the process is ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a. Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque luctus. ipsum dolor
                                            sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Project Set up</h3>

                                <p class="welcome_text extra-top-15px">
                                    Please complete all fields marked with an *.
                                    <br>
                                    All changes will be automatically saved. You can go to home screen by clicking on the Home button and
                                    finish the Project Set up on another moment.
                                </p>

                                <br>
                                <div id="wizard_client_newProjectSetUp">
                                    <h2>General Info</h2>
                                    <section>
                                        <h4>1.1. Project Info</h4>
                                        <br>

                                        <div class="form-group">
                                            <label for="projectName">Project Name*</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="projectName"
                                                data-changing="name"
                                                placeholder="Project Name"
                                                value="{{$project->name}}"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="valueTargeting">Value Targeting*</label>
                                            <select class="form-control" id="valueTargeting" disabled>
                                                <option disabled="">Please select the Project Type</option>
                                                <option value="yes" @if($project->hasValueTargeting) selected @endif>Yes</option>
                                                <option value="no" @if(!$project->hasValueTargeting) selected @endif>No</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="bindingOption">Binding/Non-binding*</label>
                                            <select class="form-control" id="bindingOption" required>
                                                <option disabled="">Please select the Project Type</option>
                                                <option value="yes" @if($project->isBinding) selected @endif>Binding</option>
                                                <option value="no" @if(!$project->isBinding) selected @endif>Non-binding</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="practiceSelect">Practice*</label>
                                            <select class="form-control" id="practiceSelect" required>
                                                <x-options.practices :selected="$project->practice->id ?? -1" />
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="subpracticeSelect">Subpractice*</label>
                                            <select
                                                class="js-example-basic-multiple w-100"
                                                id="subpracticeSelect"
                                                multiple="multiple" required>
                                                @php
                                                $select = $project->subpractices()->pluck('subpractices.id')->toArray();
                                                @endphp
                                                <x-options.subpractices :selected="$select" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="industrySelect">Industry*</label>
                                            <select class="form-control" id="industrySelect" required>
                                                <x-options.industryExperience :selected="$project->industry ?? ''" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="regionSelect">Regions*</label>
                                            <select class="js-example-basic-multiple w-100" id="regionSelect" multiple="multiple" required>
                                                <x-options.geographies :selected="$project->regions ?? []" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="deadline">Deadline*</label>
                                            <div class="input-group date datepicker" data-initialValue="{{$project->deadline}}">
                                                <input required id="deadline" value="{{$project->deadline}}" type="text" class="form-control">
                                                <span class="input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>

                                        <x-questionForeach :questions="$generalInfoQuestions" :class="'generalQuestion'" :disabled="false" :required="false" />

                                        <br>
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Upload your RFP</label>

                                            <div class="form-group">
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone">
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Extra information</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="14" required></textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <x-questionForeach :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="false" :required="false" />

                                        <br>
                                        <br>

                                        <button
                                            id="step3Submit"
                                            class="btn btn-primary"
                                            {{ $project->step3SubmittedClient ? 'disabled' : ''}}
                                            data-submitted="{{ $project->step3SubmittedClient }}">
                                            {{ $project->step3SubmittedClient ? 'Submitted' : 'Submit'}}
                                        </button>
                                    </section>

                                    <h2>Selection Criteria</h2>
                                    <section>
                                        <div id="subwizard_here">
                                            <h3>Fit gap</h3>
                                            <div>
                                                <h4>4.1. Fit Gap</h4>
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
                                                    <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal"
                                                        data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-check-square btn-icon-prepend">
                                                            <polyline points="9 11 12 14 22 4"></polyline>
                                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                        </svg> Open Fit Gap table</button>

                                                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Please complete the Fit Gap table</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <iframe src="{{url("/assets/vendors_techadvisory/jexcel-3.6.1/doc.html")}}"
                                                                        style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal"
                                                                        data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="feather feather-check-square btn-icon-prepend">
                                                                            <polyline points="9 11 12 14 22 4"></polyline>
                                                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                                        </svg>
                                                                        Done
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <br><br>
                                                <h4>Questions</h4>
                                                <br>
                                                @foreach ($fitgapQuestions as $question)
                                                <h6 style="margin-bottom: 1rem">
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach
                                            </div>

                                            <h3>Vendor</h3>
                                            <div>
                                                <h4>Corporate information</h4>
                                                <br>
                                                @foreach ($vendorCorporateQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach

                                                <br><br>
                                                <h4>Market presence</h4>
                                                @foreach ($vendorMarketQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach
                                            </div>

                                            <h3>Experience</h3>
                                            <div>
                                                <h4>Questions</h4>
                                                <br>
                                                @foreach ($experienceQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach
                                            </div>

                                            <h3>Innovation & Vision</h3>
                                            <div>
                                                <h4>IT Enablers</h4>
                                                <br>
                                                @foreach ($innovationDigitalEnablersQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach

                                                <h4>Alliances</h4>
                                                <br>
                                                @foreach ($innovationAlliancesQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach

                                                <h4>Product</h4>
                                                <br>
                                                @foreach ($innovationProductQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach

                                                <h4>Sustainability</h4>
                                                <br>
                                                @foreach ($innovationSustainabilityQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach
                                            </div>

                                            <h3>Implementation & Commercials</h3>
                                            <div>
                                                <h4>Implementation</h4>
                                                <br>
                                                @foreach ($implementationImplementationQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach

                                                <h4>Deliverables per phase</h4>
                                                <br>
                                                @foreach ($implementationRunQuestions as $question)
                                                    <h6 style="margin-bottom: 1rem">
                                                        {{$question->label}}
                                                    </h6>
                                                @endforeach
                                            </div>

                                            <h3>Scoring criteria</h3>
                                            <div>
                                                <x-scoringCriteriaBricks :isClient="true" :project="$project"/>

                                                <br>
                                                <br>
                                                <button
                                                    class="btn btn-primary"
                                                    id="step4Submit"
                                                    {{ !$project->step3SubmittedClient ? 'disabled' : ''}}
                                                    {{ $project->step4SubmittedClient ? 'disabled' : ''}}
                                                >{{ $project->step4SubmittedClient ? 'Submitted' : 'Submit'}}</button>
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Invited vendors</h2>
                                    <section>
                                        <h4>Vendors</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Vendors invited to this project</label><br>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled style="width: 100%;">
                                                {{-- Selected is the ids of the vendors --}}
                                                <x-options.vendorList :selected="['1', '3']" />
                                            </select>
                                        </div>
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

    #subwizard_here ul > li{
        display: block;
    }
</style>
@endsection

@section('scripts')
@parent
<link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">

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

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function checkIfAllRequiredsInThisPageAreFilled(){
        let array = $('input,textarea,select').filter('[required]:visible').toArray();
        if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function updateSubmitStep3()
    {
        // If we filled all the fields, remove the disabled from the button.
        let fieldsAreEmtpy = !checkIfAllRequiredsAreFilled();
        if(fieldsAreEmtpy || $('#step3Submit').data('submitted') == 1){
            $('#step3Submit').attr('disabled', true)
        } else {
            $('#step3Submit').attr('disabled', false)
            $('#wizard_client_newProjectSetUp-next').removeClass('disabled')
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

    var currentPracticeId = {{$project->practice->id ?? -1}};
    function updateShownQuestionsAccordingToPractice(){
        $('.questionDiv').each(function () {
            let practiceId = $(this).data('practice');

            if(practiceId == currentPracticeId || practiceId == "") {
                $(this).css('display', 'block')
            } else {
                $(this).css('display', 'none')
            }
        });
    }

    function updateShownSubpracticeOptionsAccordingToPractice(removeCurrentSelection = true){
        // Deselect the current subpractice
        if(removeCurrentSelection){
            $('#subpracticeSelect').val([]);
            $('#subpracticeSelect').trigger('change');
        }

        $('#subpracticeSelect').children().each(function(){
            let practiceId = $(this).data('practiceid');

            if(practiceId == currentPracticeId) {
                $(this).attr('disabled', false);
            } else {
                $(this).attr('disabled', true);
            }
        })
    }





    var weAreOnPage3 = false;

    $(document).ready(function() {
        weAreOnPage3 = false;

        $("#wizard_client_newProjectSetUp").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            forceMoveForward: false,
            labels: {
                finish: 'Submit general set up'
            },
            onFinishing: function (event, currentIndex) {
                window.location.replace("/client/home");
            },
            onStepChanging: function (e, c, n) {
                if (n == 2) {
                    weAreOnPage3 = true;

                    if({{$project->step4SubmittedAccenture ? 'false' : 'true'}}){
                        $('#wizard_client_newProjectSetUp-next').addClass('disabled')
                    }
                } else {
                    weAreOnPage3 = false;
                    $('#wizard_client_newProjectSetUp-next').removeClass('disabled')
                    $('#wizard_client_newProjectSetUp-next').html('Next')
                }
                return true
            },
            onStepChanged: function (e, c, p) {
                for (let i = 0; i < 10; i++) {
                    $('#wizard_client_newProjectSetUp-p-' + i).css('display', 'none')
                }
                $('#wizard_client_newProjectSetUp-p-' + c).css('display', 'block')
            }
        });

        // NOTE remember to keep this after the main wizard, else it breaks. haha so fun pls kill me
        $("#subwizard_here").steps({
            headerTag: "h3",
            bodyTag: "div",
            transitionEffect: "slideLeft",
            showFinishButtonAlways: false,
            enableFinishButton: false,
        });



        // On change for the 4 default ones

        $('#projectName').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeProjectName', {
                project_id: '{{$project->id}}',
                newName: value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#valueTargeting').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeProjectHasValueTargeting', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#bindingOption').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeProjectIsBinding', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#practiceSelect').change(function (e) {
            var value = $(this).val();
            currentPracticeId = value;
            $.post('/client/newProjectSetUp/changePractice', {
                project_id: '{{$project->id}}',
                practice_id: value
            })

            showSavedToast();
            updateSubmitStep3();

            updateShownQuestionsAccordingToPractice();
            updateShownSubpracticeOptionsAccordingToPractice();
        });

        $('#subpracticeSelect').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeSubpractice', {
                project_id: '{{$project->id}}',
                subpractices: value
            })

            showSavedToast();
            updateSubmitStep3();
        });
        $('#industrySelect').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeIndustry', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });
        $('#regionSelect').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeRegions', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });
        $('#deadline').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeDeadline', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#step3Submit').click(function(){
            $.post('/client/newProjectSetUp/setStep3Submitted', {
                project_id: '{{$project->id}}',
            })

            $.toast({
                heading: 'Submitted!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })

            $(this).attr('disabled', true);
            $(this).html('Submitted')
        });

        $('#step4Submit').click(function(){
            $.post('/client/newProjectSetUp/setStep4Submitted', {
                project_id: '{{$project->id}}',
            })

            $.toast({
                heading: 'Submitted!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })

            $(this).attr('disabled', true);
            $(this).html('Submitted')
        });



        // On change for the rest

        $('.generalQuestion input,.generalQuestion textarea,.generalQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/generalInfoQuestion/changeResponse', {
                    changing: $(this).data('changing'),
                    value: value
                })

                showSavedToast();
                updateSubmitStep3();
            });

        $('.sizingQuestion input,.sizingQuestion textarea,.sizingQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/sizingQuestion/changeResponse', {
                    changing: $(this).data('changing'),
                    value: value
                })

                showSavedToast();
                updateSubmitStep3();
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

        updateShownQuestionsAccordingToPractice();
        updateShownSubpracticeOptionsAccordingToPractice(false);
    });
</script>
@endsection
