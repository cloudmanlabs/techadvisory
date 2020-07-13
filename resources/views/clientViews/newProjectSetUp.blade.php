@extends('clientViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />
        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_newProject_file')" :text="nova_get_setting('video_newProject_text')" />

                <br><br>

                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>{{$project->name}}</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            {{nova_get_setting('client_newProjectSetup_title') ?? ''}}
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
                                    This is the first step of project setup. Fill in all
                                    mandatory fields under the General Info, RFP Upload and
                                    Sizing Info sections. It is not required to fill in all fields at
                                    once, but the second step of project setup will be only activated after
                                    completion of all mandatory fields.
                                </p>

                                <br>
                                <div id="wizard_client_newProjectSetUp">
                                    <h2>General Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Input all relevant information concerning project type, scope and timelines. Client company name nd contacts will not be shared with vendors.
                                        </p>
                                        <br>
                                        <x-generalInfoQuestions
                                            :project="$project"
                                            :clients="$clients ?? []"
                                            :disableSpecialQuestions="true"
                                            :disabled="false"
                                            :required="false" />
                                    </section>


                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP document</h4>
                                        <br>
                                        <x-folderFileUploader :folder="$project->rfpFolder" label="Upload your RFP" :timeout="1000" />

                                        <div class="form-group">
                                            <label for="rfpOtherInfo">Other information</label>
                                            <textarea class="form-control" id="rfpOtherInfo" rows="14">{{$project->rfpOtherInfo}}</textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Input all required project information that vendors will use to perform the sizing of their proposals.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="false" :required="true" />

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
                                        <p class="welcome_text extra-top-15px">
                                            {{nova_get_setting('client_selectionCriteria_title') ?? ''}}
                                        </p>
                                        <br>
                                        <div id="subwizard_here">
                                            <h3>Fit gap</h3>
                                            <div>
                                                <h4>4.1. Fit Gap</h4>
                                                <p class="welcome_text extra-top-15px">
                                                    This section includes all your functional, technical and service requirements, among others.
                                                </p>
                                                <br>
                                                <p>
                                                    Click Review Fit Gap Table to see all requirements gathered and logged by Accenture.
                                                    Review the requirements and contact Accenture in case anything is not accurate, and
                                                    provide or adjust requirement importance by filling in the Client Score.
                                                </p>
                                                <br>

                                                <div class="form-group">
                                                    <label>Upload a new Fitgap</label>
                                                    <input id="fitgapUpload" class="file-upload-default" name="img" type="file">

                                                    <div class="input-group col-xs-12">
                                                        <input id="fileNameInput" disabled class="form-control file-upload-info" value="No file selected" type="text">
                                                        <span class="input-group-append">
                                                            <button class="file-upload-browse btn btn-primary" type="button">
                                                                <span class="input-group-append" id="logoUploadButton">Select file</span>
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
                                                <br><br>

                                                <x-fitgapClientModal :project="$project" :isAccenture="false" />

                                                <br><br>
                                                <p class="welcome_text extra-top-15px">
                                                    Below is the questionnaire designed to know more about the vendor’s previous experiences with other clients and within the industry.
                                                </p>
                                                <br>
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
                                                :implementationRunQuestions="$implementationRunQuestions" />

                                            <h3>Scoring criteria</h3>
                                            <div>
                                                <x-scoringCriteriaBricks :isClient="true" :project="$project"/>
                                                <br>

                                                <x-scoringCriteriaWeights :isClient="true" :project="$project"/>

                                                <br>
                                                <br>

                                                <button
                                                    id = "step4SubmitButton"
                                                    type="button"
                                                    class="btn btn-primary btn-lg btn-icon-text"
                                                    data-toggle="modal"
                                                    data-target="#step4SubmitModal"
                                                    {{ !$project->step3SubmittedClient ? 'disabled' : ''}}
                                                    {{ $project->step4SubmittedClient ? 'disabled' : ''}}
                                                    >
                                                    {{ $project->step4SubmittedClient ? 'Submitted' : 'Submit'}}
                                                </button>
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
                                                <x-options.vendorList :selected="$project->vendorsApplied()->pluck('id')->toArray()" />
                                            </select>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="step4SubmitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                        Are you sure you want to submit the project set-up? Be aware that no further
                        modifications will be allowed on your end once project set-up is submitted.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button id="step4Submit" type="button" class="btn btn-primary">Submit</button>
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
        let array = $('input,textarea,select')
            .filter('[required]')
            .toArray()
            .filter(function(el){
                // we only want the questions that are being shown now to be required
                return $(el).parent('.questionDiv').is(":visible");
            });
		if(array.length == 0) return true;

        for (let i = 0; i < array.length; i++) {
            console.log(array[i])
            if(!$(array[i]).is(':hasValue')){
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





//     var weAreOnPage3 = false;

    $(document).ready(function() {
//         weAreOnPage3 = false;

        $("#wizard_client_newProjectSetUp").steps({
            headerTag: "h2",
            bodyTag: "section",
            forceMoveForward: false,
            showFinishButtonAlways: false,
            enableFinishButton: false,
            enableAllSteps: true,
            enablePagination: false,
            onInit: function () {
                if({{$project->step4SubmittedAccenture ? 'false' : 'true'}}) {
                    $('#wizard_client_newProjectSetUp-t-3').parent().addClass('disabled');
                    $('#wizard_client_newProjectSetUp-t-3').parent().attr('aria-disabled', true);

                    $('#wizard_client_newProjectSetUp-t-4').parent().addClass('disabled');
                    $('#wizard_client_newProjectSetUp-t-4').parent().attr('aria-disabled', true);
                }
            },
            onFinishing: function (event, currentIndex) {
                window.location.replace("/client/home");
            },
//             onStepChanging: function (e, c, n) {
//                 if (n == 2) {
//                     weAreOnPage3 = true;
//
//                     if({{$project->step4SubmittedAccenture ? 'false' : 'true'}}){
//                         $('#wizard_client_newProjectSetUp-next').addClass('disabled')
//                     }
//                 } else {
//                     weAreOnPage3 = false;
//                     $('#wizard_client_newProjectSetUp-next').removeClass('disabled')
//                     $('#wizard_client_newProjectSetUp-next').html('Next')
//                 }
//                 return true
//             },
            onStepChanged: function (e, c, p) {
                updateSubmitStep3();
                for (let i = 0; i < 10; i++) {
                    $('#wizard_client_newProjectSetUp-p-' + i).css('display', 'none');
                }
                $('#wizard_client_newProjectSetUp-p-' + c).css('display', 'block');
            }
        });


        // NOTE remember to keep this after the main wizard, else it breaks. haha so fun pls kill me
        $("#subwizard_here").steps({
            headerTag: "h3",
            bodyTag: "div",
            stepsOrientation: "vertical",
            showFinishButtonAlways: false,
            enableFinishButton: false,
            enableAllSteps: true,
            enablePagination: false,
            stepsOrientation: "vertical"
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

        $('#oralsSelect').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeProjectHasOrals', {
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
        $('#projectType').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeProjectType', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitStep3();
        });
        $('#currencySelect').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeCurrency', {
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
        $('#rfpOtherInfo').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeRFPOtherInfo', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
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

            $('#step4SubmitButton').attr('disabled', true);
            $('#step4SubmitButton').html('Submitted')
            $('#step4SubmitModal').modal('hide')
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
