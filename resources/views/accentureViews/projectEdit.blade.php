@extends('layouts.base')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectEditView" :project="$project"/>

                <br>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">
                                    <h3>Edit project information</h3>
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                       href="{{route('accenture.projectView', ['project' => $project])}}">View</a>
                                </div>
                                <br>
                                <div class="alert alert-warning" role="alert">Please note that this project is currently
                                    live and receiving applications from vendors. Edit it at your own discretion.
                                </div>

                                <br>
                                <div id="projectEditWizard">
                                    <h2>General Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            Input all relevant information concerning project type, scope and timelines.
                                            Client
                                            company name and contacts will not be shared with vendors.
                                        </p>
                                        <br>
                                        <x-generalInfoQuestions
                                            :project="$project"
                                            :clients="$clients"
                                            :disableSpecialQuestions="false"
                                            :disabled="false"
                                            :required="false"
                                            :allOwners="$allOwners"
                                            :projectEdit="true"/>
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
                                        <x-questionForeach :questions="$sizingQuestions" :class="'sizingQuestion'"
                                                           :disabled="false"
                                                           :required="false"/>

                                        <br><br>

                                        <button id="submitSizingInfo" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </section>

                                    <h2>Selection Criteria</h2>
                                    <section>
                                        <div id="subwizard_projectEdit">
                                            <h3>Fit gap</h3>
                                            <div>
                                                <h4>4.1. Fit Gap</h4>
                                                <br>
                                                <p>{{nova_get_setting('fitgap_description') ?? ''}}</p>
                                                <br>

                                                @if($fitgapQuestions->count() == 0)
                                                    <div class="form-group">
                                                        <label>Upload a new Fitgap</label>
                                                        <input id="fitgapUpload" class="file-upload-default" name="img"
                                                               type="file">

                                                        <div class="input-group col-xs-12">
                                                            <input id="fileNameInput" disabled
                                                                   class="form-control file-upload-info"
                                                                   value="No file selected" type="text">
                                                            <span class="input-group-append">
                                                            <button class="file-upload-browse btn btn-primary"
                                                                    type="button">
                                                                <span class="input-group-append" id="logoUploadButton">
                                                                    Select file
                                                                </span>
                                                            </button>
                                                        </span>
                                                        </div>
                                                    </div>
                                                    <br>
                                                @endif

                                                <p style="font-size: 12px">
                                                    Do not include personal, sensitive data, personal data relating
                                                    to
                                                    criminal convictions and offences or financial
                                                    data
                                                    in this free form text field or upload screen shots containing
                                                    personal data, unless you are consenting and assuming
                                                    responsibility for the processing of this personal data (either
                                                    your
                                                    personal data or the personal data of others)
                                                    by
                                                    Accenture.
                                                </p>
                                                <br><br>
                                                <x-fitgapClientModal :project="$project"/>

                                                @if($fitgapQuestions->count() > 0)
                                                    <br>
                                                    <h4>Questions</h4>
                                                    <br>
                                                    @foreach ($fitgapQuestions as $question)
                                                        <h6 style="margin-bottom: 1rem">{{$question->label}}</h6>
                                                    @endforeach
                                                @endif
                                            </div>

                                            <x-selectionCriteriaQuestionsForAccentureAndClient
                                                :vendorCorporateQuestions="$vendorCorporateQuestions"
                                                :project="$project"
                                                :vendorMarketQuestions="$vendorMarketQuestions"
                                                :experienceQuestions="$experienceQuestions"
                                                :innovationDigitalEnablersQuestions="$innovationDigitalEnablersQuestions"
                                                :innovationAlliancesQuestions="$innovationAlliancesQuestions"
                                                :innovationProductQuestions="$innovationProductQuestions"
                                                :innovationSustainabilityQuestions="$innovationSustainabilityQuestions"
                                                :implementationImplementationQuestions="$implementationImplementationQuestions"
                                                :implementationRunQuestions="$implementationRunQuestions"
                                                :project="$project"/>

                                            <h3>Scoring criteria</h3>
                                            <div>
                                                <x-scoringCriteriaBricks :isClient="false" :project="$project"/>
                                                <br>
                                                <x-scoringCriteriaWeights :project="$project"/>
                                                <br>
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Invited vendors</h2>
                                    <section>
                                        <h4>Vendors</h4>
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

                                            <br><br><br>
                                            <button id="saveVendorsButton" class="btn btn-primary btn-lg btn-icon-text">
                                                Save vendors
                                            </button>
                                        </div>
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

        #subwizard_projectEdit ul > li {
            display: block;
        }
    </style>
    <link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
@endsection


@section('scripts')
    @parent
    <script>
        jQuery.expr[':'].hasValue = function (el, index, match) {
            return el.value != "";
        };

        if ('{{ $project->useCases }}' === 'no') {
            $('#useCaseMenuOption').attr('style', 'display:none !important');//.css('display', 'none!important');
        } else {
            $('#useCaseMenuOption').attr('style', 'display:inherit !important');//.css('display', 'inherit!important');
        }

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
            if (array.length === 0) return true;

            for (let i = 0; i < array.length; i++) {
                if (!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')) {
                    return false
                }
            }

            return true
        }

        function checkIfAllRequiredsInThisPageAreFilled() {
            let array = $('input,textarea,select').filter('[required]:visible').toArray();
            if (array.length == 0) return true;

            return array.reduce(function (prev, current) {
                return !prev ? false : $(current).is(':hasValue')
            }, true)
        }

        function updateSubmitButton() {
            // If we filled all the fields, remove the disabled from the button.
            let fieldsAreEmtpy = !checkIfAllRequiredsAreFilled();
            if (fieldsAreEmtpy) {
                $('#submitSizingInfo').attr('disabled', true)
            } else {
                $('#submitSizingInfo').attr('disabled', false)
            }
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

        function updateShownSubpracticeOptionsAccordingToPractice(removeCurrentSelection) {
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

            $("#projectEditWizard").steps({
                headerTag: "h2",
                bodyTag: "section",
                enableAllSteps: true,
                enablePagination: false,
                labels: {
                    finish: "Save"
                },
                onFinishing: function (event, currentIndex) {
                    // TODO Here check if all thingies have a value
                    window.location.replace("/accenture/project/view/{{$project->id}}");
                },
                // onStepChanging: function(e, c, n) {
                //     if (n == 2) {
                //         $("#projectEditWizard-next").html("Submit");
                //     } else {
                //         $("#projectEditWizard-next").html("Next");
                //     }

                //     return true;
                // },
                // HACK Cause otherwise subwizards don't work
                onStepChanged: function (e, c, p) {
                    for (let i = 0; i < 10; i++) {
                        $("#projectEditWizard-p-" + i).css("display", "none");
                    }

                    $("#projectEditWizard-p-" + c).css("display", "block");
                }
            });

            // NOTE remember to keep this after the main wizard, else it breaks. haha so fun pls kill me
            $("#subwizard_projectEdit").steps({
                headerTag: "h3",
                bodyTag: "div",
                showFinishButtonAlways: false,
                enableFinishButton: false,
                enableAllSteps: true,
                enablePagination: false,
                stepsOrientation: "vertical"
            });


            // On change for the 4 default ones

            $('#projectName').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeProjectName', {
                    project_id: '{{$project->id}}',
                    newName: value
                }).done(function () {
                    showSavedToast()
                    updateSubmitButton()
                }).fail(handleAjaxError)
            });

            $('#ownerSelect').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeProjectOwner', {
                    project_id: '{{$project->id}}',
                    owner_id: value
                }).done(function () {
                    showSavedToast()
                    updateSubmitStep3()
                }).fail(handleAjaxError)
            });

            $('#chooseClientSelect').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeProjectClient', {
                    project_id: '{{$project->id}}',
                    client_id: value
                }).done(function () {
                    showSavedToast()
                    updateSubmitButton()
                }).fail(handleAjaxError)
            });

            $('#valueTargeting').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeProjectHasValueTargeting', {
                    project_id: '{{$project->id}}',
                    value
                }).done(function () {
                    showSavedToast()
                    updateSubmitButton()
                }).fail(handleAjaxError)
            });

            $('#oralsSelect').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeProjectHasOrals', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast()
                    updateSubmitButton()
                }).fail(handleAjaxError)
            });

            $('#useCasesSelect').change(function (e) {
                var value = $(this).val();
                if (value === 'no') {
                    $('#useCaseMenuOption').attr('style', 'display:none !important');//.css('display', 'none!important');
                } else {
                    $('#useCaseMenuOption').attr('style', 'display:inherit !important');//.css('display', 'inherit!important');
                }
                $.post('/accenture/newProjectSetUp/changeProjectUseCases', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast()
                    updateSubmitStep3()
                }).fail(handleAjaxError)
            });

            $('#bindingOption').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeProjectIsBinding', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast()
                    updateSubmitButton()
                }).fail(handleAjaxError)
            });

            $('#practiceSelect').change(function (e) {
                var value = $(this).val();
                currentPracticeId = value;
                $.post('/accenture/newProjectSetUp/changePractice', {
                    project_id: '{{$project->id}}',
                    practice_id: value
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();

                    updateShownQuestionsAccordingToPractice();
                    updateShownSubpracticeOptionsAccordingToPractice(true);
                }).fail(handleAjaxError)
            });

            $('#subpracticeSelect').change(function (e) {
                var value = $(this).val();
                if (value && (value.length > 0)) {
                    $.post('/accenture/newProjectSetUp/changeSubpractice', {
                        project_id: '{{$project->id}}',
                        subpractices: value
                    }).done(function () {
                        showSavedToast();
                        updateSubmitButton();
                    }).fail(handleAjaxError)
                }
            });

            $('#industrySelect').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeIndustry', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                }).fail(handleAjaxError)
            });
            $('#regionSelect').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeRegions', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                }).fail(handleAjaxError)
            });

            $('#projectType').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeProjectType', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                }).fail(handleAjaxError)
            });

            $('#currencySelect').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeCurrency', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast();
                    updateSubmitStep3();
                }).fail(handleAjaxError)
            });

            $('#timezone').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeTimezone', {
                    project_id: '{{$project->id}}',
                    timezone: value,
                    deadline: $('#deadline').val() || undefined
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                }).fail(handleAjaxError)
            });

            $('#deadline').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeDeadline', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                }).fail(handleAjaxError)
            });

            $('#rfpOtherInfo').change(function (e) {
                var value = $(this).val();
                $.post('/accenture/newProjectSetUp/changeRFPOtherInfo', {
                    project_id: '{{$project->id}}',
                    value: value
                }).done(function () {
                    showSavedToast();
                }).fail(handleAjaxError)
            });

            $('#saveVendorsButton').click(function () {
                const submittedVendors = [
                    @foreach($project->vendorApplications->filter(function($application){
                        return $application->phase == "submitted";
                    }) as $application)
                        "{{$application->vendor->id}}",
                    @endforeach
                ]

                const listOfVendors = $('#vendorSelection').val();

                function intersect(a, b) {
                    var t;
                    if (b.length > a.length) t = b, b = a, a = t; // indexOf to loop over shorter
                    return a.filter(function (e) {
                        return b.indexOf(e) > -1;
                    });
                }

                if (intersect(submittedVendors, listOfVendors).length != submittedVendors.length) {
                    $.toast({
                        heading: 'Can\'t remove vendors who have submitted!',
                        showHideTransition: 'slide',
                        icon: 'error',
                        hideAfter: 1000,
                        position: 'bottom-right'
                    })
                    return;
                }

                $.post('/accenture/newProjectSetUp/updateVendors', {
                    project_id: '{{$project->id}}',
                    vendorList: $('#vendorSelection').val()
                }).done(function () {
                    showSavedToast();
                }).fail(handleAjaxError)
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
                    }).done(function () {
                        showSavedToast();
                        updateSubmitButton();
                    }).fail(handleAjaxError)
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
                    }).done(function () {
                        showSavedToast();
                        updateSubmitButton();
                    }).fail(handleAjaxError)
                });

            $('.sizingQuestion .checkboxesDiv input')
                .change(function (e) {
                    $.post('/sizingQuestion/setShouldShow', {
                        changing: $(this).data('changingid'),
                        value: $(this).prop("checked")
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


            $('.file-upload-browse').on('click', function (e) {
                $("#fitgapUpload").trigger('click');
            });

            $("#fitgapUpload").change(function () {
                var fileName = $(this).val().split('\\').pop();

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
                        location.reload()
                    },
                    error: handleAjaxError
                });
            });

            updateShownQuestionsAccordingToPractice();
            updateShownSubpracticeOptionsAccordingToPractice(false);
            updateSubmitButton();
        });
    </script>
@endsection
