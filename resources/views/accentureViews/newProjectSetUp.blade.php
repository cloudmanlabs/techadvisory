@extends('accentureViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-video :src="nova_get_setting('video_newProject')" :text="nova_get_setting('video_newProject_text')"/>

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
                                        <x-generalInfoQuestions
                                            :project="$project"
                                            :clients="$clients"
                                            :disableSpecialQuestions="false"
                                            :disabled="false"
                                            :required="false" />
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP</h4>
                                        <br>
                                        <x-folderFileUploader :folder="$project->rfpFolder" label="Upload your RFP" :timeout="1000" />

                                        <div class="form-group">
                                            <label for="rfpOtherInfo">Other information</label>
                                            <textarea class="form-control" id="rfpOtherInfo"
                                            rows="14">{{$project->rfpOtherInfo}}</textarea>
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
                                                        {{nova_get_setting('fitgap_description') ?? ''}}
                                                    </p>

                                                    <br>

                                                    <div class="form-group">
                                                        <label>Upload a new Fitgap</label>
                                                        <input id="fitgapUpload" class="file-upload-default" name="img" type="file">

                                                        <div class="input-group col-xs-12">
                                                            <input id="fileNameInput" disabled class="form-control file-upload-info"
                                                                value="No file selected" type="text">
                                                            <span class="input-group-append">
                                                                <button class="file-upload-browse btn btn-primary" type="button">
                                                                    <span class="input-group-append"
                                                                        id="logoUploadButton">Select file</span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <p style="font-size: 12px">
                                                        Do not include personal, sensitive data, personal data relating to criminal convictions and offences or financial
                                                        data
                                                        in this free form text field or upload screen shots containing personal data, unless you are consenting and assuming
                                                        responsibility for the processing of this personal data (either your personal data or the personal data of others)
                                                        by
                                                        Accenture.
                                                    </p>
                                                    <br>

                                                    <br><br>
                                                    <x-fitgapClientModal :project="$project" />

                                                    <br><br>
                                                    <h4>Questions</h4>
                                                    <br>
                                                    @foreach ($fitgapQuestions as $question)
                                                        <h6 style="margin-bottom: 1rem">
                                                            {{$question->label}}
                                                        </h6>
                                                    @endforeach
                                                </div>

                                                <x-selectionCriteriaQuestionsForAccentureAndClient
                                                    :vendorCorporateQuestions="$vendorCorporateQuestions"
                                                    :vendorMarketQuestions="$vendorMarketQuestions"
                                                    :experienceQuestions="$experienceQuestions"
                                                    :innovationDigitalEnablersQuestions="$innovationDigitalEnablersQuestions"
                                                    :innovationAlliancesQuestions="$innovationAlliancesQuestions"
                                                    :innovationProductQuestions="$innovationProductQuestions"
                                                    :innovationSustainabilityQuestions="$innovationSustainabilityQuestions"
                                                    :implementationImplementationQuestions="$implementationImplementationQuestions"
                                                    :implementationRunQuestions="$implementationRunQuestions"
                                                />

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
                                                ? 'disabled' : ''}}>Done</button>
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
        let array = $('input,textarea,select')
            .filter('[required]')
            .toArray()
            .filter(function(el){
                // we only want the questions that are being shown now to be required
                return $(el).parent('.questionDiv').is(":visible");
            });
		if(array.length == 0) return true;

        for (let i = 0; i < array.length; i++) {
            if(!$(array[i]).is(':hasValue')){
                console.log(array[i])
                return false
            }
        }

        return true
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
            showFinishButtonAlways: false,
            enableFinishButton: false,
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

        $('#oralsSelect').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectHasOrals', {
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
        $('#industrySelect').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeIndustry', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });
        $('#regionSelect').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeRegions', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });
        $('#projectType').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectType', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });
        $('#deadline').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeDeadline', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });
        $('#rfpOtherInfo').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeRFPOtherInfo', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
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


        $('.file-upload-browse').on('click', function(e) {
            $("#fitgapUpload").trigger('click');
        });

        $("#fitgapUpload").change(function (){
            var fileName = $(this).val().split('\\').pop();;

            $("#fileNameInput").val(fileName);

            var formData = new FormData();
            formData.append('excel', $(this).get(0).files[0]);
            $.ajax({
                url : "/import5Columns/{{$project->id}}",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,

                success: function(){
                    console.log('hello')
                    $("iframe").each(function(){
                        $(this).attr("src", function(index, attr){
                            return attr;
                        });
                    })
                    showSavedToast();
                }
            });
        });

        updateShownQuestionsAccordingToPractice();
        updateShownSubpracticeOptionsAccordingToPractice(false);
        updateSubmitStep3();
    });
</script>
@endsection
