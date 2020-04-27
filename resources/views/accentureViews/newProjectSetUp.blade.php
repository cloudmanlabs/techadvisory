@extends('accentureViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-video :src="nova_get_setting('accenture_NewProjectSetUp')" />

                <br><br>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Project Set up</h3>

                                <p class="welcome_text extra-top-15px">
                                    Please complete all fields marked with an *.
                                    <br>
                                    Note: Finishing this form will not publish the project.
                                    To publish please press the Publish button on the last screen.
                                </p>

                                <br>
                                <div id="wizard_accenture_newProjectSetUp">
                                    <h2>General Info</h2>
                                    <section>
                                        <h4>1.1. Project Info</h4>
                                        <br>

                                        <div class="form-group">
                                            <label for="projectName">Project Name*</label>
                                            <input type="text" class="form-control"
                                                id="projectName"
                                                data-changing="name"
                                                placeholder="Project Name"
                                                value="{{$project->name}}"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="chooseClientSelect">Client name*</label>
                                            <select class="form-control" id="chooseClientSelect"
                                                required>
                                                <option selected="" disabled="">Please select the Client Name</option>
                                                @php
                                                    $currentlySelected = $project->client->id ?? -1;
                                                @endphp
                                                @foreach ($clients as $client)
                                                <option
                                                    value="{{$client->id}}"
                                                    @if($currentlySelected == $client->id) selected @endif
                                                    >{{$client->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="valueTargeting">Value Targeting*</label>
                                            <select class="form-control" id="valueTargeting" required>
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
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                                    name="exampleDropzone">
                                                </form>
                                            </div>

                                            <div class="form-group">
                                                <label for="otherInformation">Other information</label>
                                                <textarea class="form-control" id="otherInformation"
                                                    rows="14"></textarea>
                                            </div>

                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <x-questionForeachWithActivate :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="false" :required="false" />

                                        <br><br>

                                        <button
                                            id="step3Submit"
                                            class="btn btn-primary"
                                            {{ $project->step3SubmittedAccenture ? 'disabled' : ''}}
                                            data-submitted="{{ $project->step3SubmittedAccenture }}"
                                        >
                                            {{ $project->step3SubmittedAccenture ? 'Submitted' : 'Submit'}}
                                        </button>
                                    </section>

                                    <h2>Selection Criteria</h2>
                                    <section>
                                        <div>
                                            <div id="subwizard_here">
                                                <h3>Fit gap</h3>
                                                <div>
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
                                                            <input class="form-control file-upload-info"
                                                                placeholder="Upload Fit Gap model in CSV format"
                                                                type="text">
                                                            <span class="input-group-append">
                                                                <button
                                                                    class="file-upload-browse btn btn-primary"
                                                                    type="button">
                                                                    <span class="input-group-append">Upload</span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <div class="modal fade bd-example-modal-xl" tabindex="-1"
                                                            role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Please
                                                                            complete the Fit Gap table</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <iframe
                                                                            src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/doc.html')}}"
                                                                            style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-lg btn-icon-text"
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-xl"><svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-width="2" stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-check-square btn-icon-prepend">
                                                                                <polyline points="9 11 12 14 22 4">
                                                                                </polyline>
                                                                                <path
                                                                                    d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
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
                                                    <br>
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
                                                    <x-scoringCriteriaBricks :isClient="false" :project="$project"/>

                                                    <br><br>
                                                    <button
                                                        class="btn btn-primary"
                                                        id="step4Submit"
                                                        {{ !$project->step3SubmittedAccenture ? 'disabled' : ''}}
                                                        {{ $project->step4SubmittedAccenture ? 'disabled' : ''}}
                                                    >{{ $project->step4SubmittedAccenture ? 'Submitted' : 'Submit'}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Publish / Invite vendors</h2>
                                    <section>
                                        <p>Project Description</p>
                                        <textarea name="projectDescription" id="projectDescription" cols="80" rows="10"></textarea>

                                        <br>
                                        <br>

                                        <h4>Vendor invite</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Select vendors to be invited to this project</label><br>
                                            <select
                                                id="vendorSelection"
                                                class="js-example-basic-multiple w-100" multiple="multiple" style="width: 100%;">
                                                <x-options.vendorList :selected="$project->vendorsApplied()->pluck('id')->toArray()" />
                                            </select>
                                        </div>

                                        <br>
                                        <br>
                                        <button
                                            class="btn btn-primary btn-lg btn-icon-text"
                                            id="publishButton"
                                            data-clienthasfinished="{{$project->step3SubmittedClient && $project->step4SubmittedClient}}"
                                            {{
                                                !$project->step3SubmittedAccenture ||
                                                !$project->step3SubmittedClient ||
                                                !$project->step4SubmittedAccenture ||
                                                !$project->step4SubmittedClient
                                                ? 'disabled' : ''}}>Publish project</button>
                                        <br><br>
                                        <p>
                                            Please make sure everything is correct before publishing this project.
                                        </p>
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
    <link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
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





    $(document).ready(function() {
        weAreOnPage3 = false;

        $("#wizard_accenture_newProjectSetUp").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            forceMoveForward: false,
            labels: {
                finish: 'Submit general set up'
            },
            onFinishing: function (event, currentIndex) {
                // TODO Only let the client submit if all the fields are full

                window.location.replace("/accenture/home");
            },
            onStepChanged: function (e, c, p) {
                for (let i = 0; i < 10; i++) {
                    $('#wizard_accenture_newProjectSetUp-p-' + i).css('display', 'none')
                }
                $('#wizard_accenture_newProjectSetUp-p-' + c).css('display', 'block')
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
            $.post('/accenture/newProjectSetUp/changeProjectName', {
                project_id: '{{$project->id}}',
                newName: value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#chooseClientSelect').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectClient', {
                project_id: '{{$project->id}}',
                client_id: value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#valueTargeting').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectHasValueTargeting', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#bindingOption').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectIsBinding', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#practiceSelect').change(function (e) {
            var value = $(this).val();
            currentPracticeId = value;
            $.post('/accenture/newProjectSetUp/changePractice', {
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
            $.post('/accenture/newProjectSetUp/changeSubpractice', {
                project_id: '{{$project->id}}',
                subpractices: value
            })

            showSavedToast();
            updateSubmitStep3();
        });

        $('#step3Submit').click(function(){
            $.post('/accenture/newProjectSetUp/setStep3Submitted', {
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

            $('#step4Submit').attr('disabled', false);
        });

        $('#step4Submit').click(function(){
            $.post('/accenture/newProjectSetUp/setStep4Submitted', {
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

            // If the client has already accepted, set it as active
            if($('#publishButton').data('clienthasfinished') == '1'){
                $('#publishButton').attr('disabled', false);
            }
        });

        $('#publishButton').click(function(){
            $.post('/accenture/newProjectSetUp/publishProject', {
                project_id: '{{$project->id}}',
            })

            $.toast({
                heading: 'Published!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        });





        $('#vendorSelection').change(function(){
            $.post('/accenture/newProjectSetUp/updateVendors', {
                project_id: '{{$project->id}}',
                vendorList: $(this).val()
            })

            showSavedToast();
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
                return $(this).data('changing') !== undefined
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

        $('.sizingQuestion .checkboxesDiv input')
            .change(function (e) {
                $.post('/sizingQuestion/setShouldShow', {
                    changing: $(this).data('changingid'),
                    value: $(this).prop("checked")
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
        updateSubmitStep3();
    });
</script>
@endsection
