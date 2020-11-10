@extends('accentureViews.layouts.forms')
@section('head')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
@endsection

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">
                <x-video :src="nova_get_setting('video_newProject_file')"
                         :text="nova_get_setting('video_newProject_text')"/>
                <br><br>

                <!-- Summary Pannel -->
                <div id="summary" class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3 style="cursor:pointer">Summary +</h3>
                                <div id="summaryColapse">
                                    <p class="welcome_text extra-top-15px">Check the project summary and execute
                                        rollback
                                        to the previous state. </p>
                                    <br>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td> Accenture submitted First 3 pages</td>
                                            <td>
                                                @if($project->step3SubmittedAccenture)
                                                    <i class="far fa-check-circle"></i>
                                                @else
                                                    <i class="far fa-times-circle"></i>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if($project->step3SubmittedAccenture && !$project->step3SubmittedClient &&
                                                !$project->step4SubmittedAccenture && !$project->step4SubmittedClient)
                                                    <button id="rollback1"
                                                            class="btn btn-primary btn-lg btn-icon-text">
                                                        Rollback
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Client submitted First 3 pages</td>
                                            <td>
                                                @if($project->step3SubmittedClient)
                                                    <i class="far fa-check-circle"></i>
                                                @else
                                                    <i class="far fa-times-circle"></i>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if($project->step3SubmittedAccenture && $project->step3SubmittedClient &&
                                                !$project->step4SubmittedAccenture && !$project->step4SubmittedClient)
                                                    <button id="rollback2"
                                                            class="btn btn-primary btn-lg btn-icon-text">
                                                        Rollback
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Accenture submitted Selection Criteria</td>
                                            <td>
                                                @if($project->step4SubmittedAccenture)
                                                    <i class="far fa-check-circle"></i>
                                                @else
                                                    <i class="far fa-times-circle"></i>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if($project->step3SubmittedAccenture && $project->step3SubmittedClient &&
                                                $project->step4SubmittedAccenture && !$project->step4SubmittedClient)
                                                    <button id="rollback3"
                                                            class="btn btn-primary btn-lg btn-icon-text">
                                                        Rollback
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Client submitted Selection Criteria</td>
                                            <td>
                                                @if($project->step4SubmittedClient)
                                                    <i class="far fa-check-circle"></i>
                                                @else
                                                    <i class="far fa-times-circle"></i>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if($project->step3SubmittedAccenture && $project->step3SubmittedClient &&
                                                $project->step4SubmittedAccenture && $project->step4SubmittedClient)
                                                    <button id="rollback4"
                                                            class="btn btn-primary btn-lg btn-icon-text">
                                                        Rollback
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Project Set up</h3>

                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectSetUp_description') ?? ''}}
                                </p>

                                <br>
                                <div id="wizard_accenture_newProjectSetUp">
                                    <h2>General Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Input all relevant information concerning project type, scope and timelines.
                                            Client
                                            company name and contacts will not be shared with vendors.
                                        </p>
                                        <br><br>

                                        <x-generalInfoQuestions
                                            :project="$project"
                                            :clients="$clients"
                                            :disableSpecialQuestions="false"
                                            :disabled="false"
                                            :required="false"
                                            :allOwners="$allOwners"
                                            :firstTime="$firstTime"/>
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP document</h4>
                                        <br>
                                        <x-folderFileUploader :folder="$project->rfpFolder" label="Upload your RFP"
                                                              :timeout="1000"/>

                                        <div class="form-group">
                                            <label for="rfpOtherInfo">Other information</label>
                                            <textarea class="form-control" id="rfpOtherInfo"
                                                      rows="14">{{$project->rfpOtherInfo}}</textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Select the set of questions that must be answered by the client to provide
                                            vendors
                                            with required project information to perform the sizing of hteir proposals.
                                            You can also provide your inputs based on the client information you have.
                                        </p>
                                        <br>
                                        <x-questionForeachWithActivate :questions="$sizingQuestions"
                                                                       :class="'sizingQuestion'" :disabled="false"
                                                                       :required="false"/>

                                        <br><br>

                                        <div>
                                            <button
                                                class="btn btn-primary"
                                                id="selectAllSizingQuestions"
                                            >
                                                Select all
                                            </button>
                                            <button
                                                class="btn btn-primary"
                                                id="unselectAllSizingQuestions"
                                            >
                                                Unselect all
                                            </button>
                                        </div>

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
                                                        <input id="fitgapUpload" class="file-upload-default" name="img"
                                                               type="file">

                                                        <div class="input-group col-xs-12">
                                                            <input id="fileNameInput" disabled
                                                                   class="form-control file-upload-info"
                                                                   value="{{$project->hasUploadedFitgap ? 'File uploaded' : 'No file selected'}}"
                                                                   type="text">
                                                            <span class="input-group-append">
                                                                <button class="file-upload-browse btn btn-primary"
                                                                        type="button">
                                                                    <span class="input-group-append"
                                                                          id="logoUploadButton">Select file</span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p>
                                                        Please reload the page after uploading a new Fitgap
                                                    </p>
                                                    <br>
                                                    <p style="font-size: 12px">
                                                        Do not include personal, sensitive data, personal data relating
                                                        to criminal convictions and offences or financial
                                                        data
                                                        in this free form text field or upload screen shots containing
                                                        personal data, unless you are consenting and assuming
                                                        responsibility for the processing of this personal data (either
                                                        your personal data or the personal data of others)
                                                        by
                                                        Accenture.
                                                    </p>
                                                    <br>

                                                    <br><br>
                                                    <x-fitgapClientModal :project="$project"/>

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
                                                    :project="$project"
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
                                                    <br>
                                                    <x-scoringCriteriaWeights :isClient="false" :project="$project"/>

                                                    <br><br>
                                                    @if (!$project->step4SubmittedAccenture)
                                                        <button
                                                            class="btn btn-primary"
                                                            id="step4Submit"
                                                            {{-- $project->hasUploadedFitgap ? '' : 'disabled'--}}
                                                            {{ !$project->step3SubmittedAccenture ? 'disabled' : ''}}
                                                        >{{ $project->step4SubmittedAccenture ? 'Submitted' : 'Submit'}}
                                                        </button>
                                                    @endif

                                                    <br><br>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Publish / Invite vendors</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            This is the last step of project setup. Select the appropriate
                                            vendors to invite to provide proposals. Click Done to send them
                                            the invitation. The Done button will be blocked until the client
                                            submits the complete project setup.
                                        </p>
                                        <br>
                                        {{-- <textarea name="projectDescription" id="projectDescription" cols="80" rows="10"></textarea> --}}

                                        <br>
                                        <br>
                                        <h4>Vendor invite</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Select vendors to be invited to this project</label><br>
                                            <select
                                                id="vendorSelection"
                                                class="js-example-basic-multiple w-100" multiple="multiple"
                                                style="width: 100%;">
                                                <x-options.vendorList
                                                    :selected="$project->vendorsApplied()->pluck('id')->toArray()"/>
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
                                                ? 'disabled' : ''}}>Done
                                        </button>
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

        #summary i {
            font-size: 25px;
            padding: 15px;
        }

        #summary .fa-check-circle {
            font-size: 25px;
            color: forestgreen;
        }

        #summary .fa-times-circle {
            font-size: 25px;
            color: red;
        }

        #summary, button {
            font-size: 15px;
        }

        #summary, b {
            font-size: 15px;
        }

        table button {
            font-size: 15px;
        }
    </style>
    <link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
@endsection


@section('scripts')
    @parent
    <script>
        // Removes the get params cause I'm sure they'll share the url with the get param and then they won't see the name and they will think it's a bug
        // and I'll get angry that this is the best implementation I could think of and then I'll get angry that they're dumb and lazy and don't want to have to
        // remove a placeholder name cause ofc that's too much work
        // I'm not mad :)
        window.history.pushState({}, document.title, window.location.pathname);

        jQuery.expr[':'].hasValue = function (el, index, match) {
            return el.value != "";
        };

        // Hide Summary Panel.
        $('#summaryColapse').hide()
        $('#summary').click(function () {
            $('#summaryColapse').toggle()
        })

        /**
         *  Returns false if any field is empty
         */
        function checkIfAllRequiredsAreFilled() {
            let array = $('input,textarea,select')
                .filter('[required]')
                .toArray()
                .filter(function (el) {
                    const practiceId = $(el).parent('.questionDiv').data('practice');
                    return practiceId == currentPracticeId || practiceId == "";
                });
            if (array.length == 0) return true;

            for (let i = 0; i < array.length; i++) {
                if (!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')) {
                    console.log(array[i])
                    return false
                }
            }

            return true
        }

        function thereIsAtLeastOneSizingSelected() {
            let array = $('.checkboxesDiv input')
                .toArray();

            for (let i = 0; i < array.length; i++) {
                if ($(array[i]).prop('checked')) {
                    console.log('not checked', array[i])
                    return true;
                }
            }

            return false;
        }

        function updateSubmitStep3() {
            if (!thereIsAtLeastOneSizingSelected()) {
                $('#step3Submit').attr('disabled', true)
                return;
            }

            // If we filled all the fields, remove the disabled from the button.
            let fieldsAreEmtpy = !checkIfAllRequiredsAreFilled();
            console.log(fieldsAreEmtpy)
            if (fieldsAreEmtpy || $('#step3Submit').data('submitted') == 1) {
                $('#step3Submit').attr('disabled', true)
            } else {
                $('#step3Submit').attr('disabled', false)
            }
        }

        function showSavedToast() {
            $.toast({
                heading: 'Saved!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        }

        var currentPracticeId = {{$project->practice->id ?? -1}};

        function updateShownQuestionsAccordingToPractice() {
            $('.questionDiv').each(function () {
                let practiceId = $(this).data('practice');

                if (practiceId == currentPracticeId || practiceId == "") {
                    $(this).css('display', 'block')
                } else {
                    $(this).css('display', 'none')
                }
            });
        }

        function updateShownSubpracticeOptionsAccordingToPractice(removeCurrentSelection = true) {
            // Deselect the current subpractice
            if (removeCurrentSelection) {
                $('#subpracticeSelect').val([]);
                $('#subpracticeSelect').trigger('change');
            }

            $('#subpracticeSelect').children().each(function () {
                let practiceId = $(this).data('practiceid');

                if (practiceId == currentPracticeId) {
                    $(this).attr('disabled', false);
                } else {
                    $(this).attr('disabled', true);
                }
            })
        }


        $(document).ready(function () {
            weAreOnPage3 = false;

            $("#wizard_accenture_newProjectSetUp").steps({
                headerTag: "h2",
                bodyTag: "section",
                forceMoveForward: false,
                showFinishButtonAlways: false,
                enableFinishButton: false,
                enablePagination: false,
                enableAllSteps: true,
                onFinishing: function (event, currentIndex) {
                    // TODO Only let the client submit if all the fields are full
                    window.location.replace("/accenture/home");
                },
                onStepChanged: function (e, c, p) {
                    updateSubmitStep3();
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
                stepsOrientation: "vertical",
                showFinishButtonAlways: false,
                enableFinishButton: false,
                enableAllSteps: true,
                enablePagination: false,
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
            $('#ownerSelect').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeProjectOwner', {
                    project_id: '{{$project->id}}',
                    owner_id: value
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
            $('#currencySelect').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeCurrency', {
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

            $('#step3Submit').click(function () {
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
            });

            $('#step4Submit').click(function () {
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
                if ($('#publishButton').data('clienthasfinished') == '1') {
                    $('#publishButton').attr('disabled', false);
                }
            });

            $('#publishButton').click(function () {
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


            $('#vendorSelection').change(function () {
                $.post('/accenture/newProjectSetUp/updateVendors', {
                    project_id: '{{$project->id}}',
                    vendorList: $(this).val()
                })

                showSavedToast();
            });

            // On change for the rest

            $('.generalQuestion input,.generalQuestion textarea,.generalQuestion select')
                .filter(function (el) {
                    return $(this).data('changing') !== undefined
                })
                .change(function (e) {
                    var value = $(this).val();
                    if ($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined) {
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
                .filter(function (el) {
                    return $(this).data('changing') !== undefined
                })
                .change(function (e) {
                    var value = $(this).val();
                    if ($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined) {
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


            $('.file-upload-browse').on('click', function (e) {
                $("#fitgapUpload").trigger('click');
            });

            $("#fitgapUpload").change(function () {
                var fileName = $(this).val().split('\\').pop();
                ;

                $("#fileNameInput").val(fileName);

                var formData = new FormData();
                formData.append('excel', $(this).get(0).files[0]);
                $.ajax({
                    url: "/import5Columns/{{$project->id}}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function () {
                        console.log('hello')
                        $("iframe").each(function () {
                            $(this).attr("src", function (index, attr) {
                                return attr;
                            });
                        })
                        showSavedToast();
                    }
                });
            });

            $('#selectAllSizingQuestions').click(function () {
                $('.checkboxesDiv input').prop('checked', true);
                $('.checkboxesDiv input').change();
            });

            $('#unselectAllSizingQuestions').click(function () {
                $('.checkboxesDiv input').prop('checked', false);
                $('.checkboxesDiv input').change();
            });

            updateShownQuestionsAccordingToPractice();
            updateShownSubpracticeOptionsAccordingToPractice(false);
            updateSubmitStep3();
        });

        // Make Rollback from Accenture step 3 to initial state
        $('#rollback1').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep1Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                $(this).html('Rollback Completed')

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }).fail(function () {
                $(this).attr('disabled', false);
                $.toast({
                    heading: 'Rollback failed!',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right'
                })
            })
        });

        // Make Rollback from Client step 3 to Accenture step 3
        $('#rollback2').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep2Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                $(this).html('Rollback Completed')

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }).fail(function () {
                $(this).attr('disabled', false);
                $.toast({
                    heading: 'Rollback failed!',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right'
                })
            })
        });

        // Make Rollback from Accenture step 4 step 3 to Client step 3
        $('#rollback3').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep3Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                $(this).html('Rollback Completed')

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }).fail(function () {
                $(this).attr('disabled', false);
                $.toast({
                    heading: 'Rollback failed!',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right'
                })
            })
        });

        // Make Rollback from Client step 4 step 3 to Accenture step 4
        $('#rollback4').click(function () {
            $(this).attr('disabled', true);

            $.post('/accenture/ProjectController/setStep4Rollback', {
                project_id: '{{$project->id}}',
            }).done(function () {
                $(this).html('Rollback Completed')

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }).fail(function () {
                $(this).attr('disabled', false);
                $.toast({
                    heading: 'Rollback failed!',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right'
                })
            })
        });
    </script>
@endsection
