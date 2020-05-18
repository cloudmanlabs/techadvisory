@extends('accentureViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectEditView" :project="$project" />

                <br>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">
                                    <h3>Edit project information</h3>
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.projectView', ['project' => $project])}}">Save</a>
                                </div>
                                <br>
                                <div class="alert alert-warning" role="alert">Please note that this project is currently
                                    live and receiving applications from vendors. Edit it at your own discretion.</div>

                                <br>
                                <div id="projectEditWizard">
                                    <h2>General Info</h2>
                                    <section>
                                        <h4>1.1. Project Info</h4>
                                        <br>

                                        <div class="form-group">
                                            <label for="projectName">Project Name*</label>
                                            <input type="text" class="form-control" id="projectName" data-changing="name" placeholder="Project Name"
                                                value="{{$project->name}}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="chooseClientSelect">Client name*</label>
                                            <select class="form-control" id="chooseClientSelect" required>
                                                <option selected="" disabled="">Please select the Client Name</option>
                                                @php
                                                $currentlySelected = $project->client->id ?? -1;
                                                @endphp
                                                @foreach ($clients as $client)
                                                <option value="{{$client->id}}" @if($currentlySelected==$client->id) selected @endif
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
                                            <label for="oralsSelect">Orals*</label>
                                            <select class="form-control" id="oralsSelect" required>
                                                <option disabled="">Please select an option</option>
                                                <option value="yes" @if($project->hasOrals) selected @endif>Yes</option>
                                                <option value="no" @if(!$project->hasOrals) selected @endif>No</option>
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
                                            <select class="js-example-basic-multiple w-100" id="subpracticeSelect" multiple="multiple" required>
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
                                            <label for="projectType">Project Type*</label>
                                            <select class="form-control" id="projectType" required>
                                                <x-options.projectType :selected="$project->projectType ?? ''" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="deadline">Deadline*</label>
                                            <div class="input-group date datepicker" data-initialValue="{{$project->deadline}}">
                                                <input required id="deadline" value="{{$project->deadline}}" type="text" class="form-control">
                                                <span class="input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>

                                        <x-questionForeach :questions="$generalInfoQuestions" :class="'generalQuestion'" :disabled="false"
                                            :required="false" />

                                        <br>
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP</h4>
                                        <br>
                                        <x-folderFileUploader :folder="$project->rfpFolder" label="Upload your RFP" :timeout="1000" />

                                        <div class="form-group">
                                            <label for="rfpOtherInfo">Other information</label>
                                            <textarea class="form-control" id="rfpOtherInfo" rows="14">{{$project->rfpOtherInfo}}</textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <x-questionForeachWithActivate :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="false"
                                            :required="false" />

                                        <br><br>

                                        <button id="submitSizingInfo" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </section>

                                    <h2>Selection Criteria</h2>
                                    <section>
                                        <div id="subwizard">
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


                                                <br><br>
                                                <x-fitgapClientModal :project="$project" />

                                                <br><br>
                                                <h4>Questions</h4>
                                                <br>
                                                @foreach ($fitgapQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach
                                            </div>

                                            <h3>Vendor</h3>
                                            <div>
                                                <h4>Corporate information</h4>
                                                <br>
                                                @foreach ($vendorCorporateQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach

                                                <br><br>
                                                <h4>Market presence</h4>
                                                @foreach ($vendorMarketQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach
                                            </div>

                                            <h3>Experience</h3>
                                            <div>
                                                <h4>Questions</h4>
                                                <br>
                                                @foreach ($experienceQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach
                                            </div>

                                            <h3>Innovation & Vision</h3>
                                            <div>
                                                <h4>IT Enablers</h4>
                                                <br>
                                                @foreach ($innovationDigitalEnablersQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach

                                                <h4>Alliances</h4>
                                                <br>
                                                @foreach ($innovationAlliancesQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach

                                                <h4>Product</h4>
                                                <br>
                                                @foreach ($innovationProductQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach

                                                <h4>Sustainability</h4>
                                                <br>
                                                @foreach ($innovationSustainabilityQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach
                                            </div>

                                            <h3>Implementation & Commercials</h3>
                                            <div>
                                                <h4>Implementation</h4>
                                                <br>
                                                @foreach ($implementationImplementationQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach

                                                <h4>Deliverables per phase</h4>
                                                @foreach ($implementationRunQuestions as $question)
                                                <h6>
                                                    {{$question->label}}
                                                </h6>
                                                @endforeach
                                            </div>

                                            <h3>Scoring criteria</h3>
                                            <div>
                                                <x-scoringCriteriaBricks :isClient="false" :project="$project"/>
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
                                                class="js-example-basic-multiple w-100" multiple="multiple" style="width: 100%;">
                                                <x-options.vendorList :selected="$project->vendorsApplied()->pluck('id')->toArray()" />
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

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        let fieldsAreEmtpy = !checkIfAllRequiredsAreFilled();
        if(fieldsAreEmtpy){
            $('#submitSizingInfo').attr('disabled', true)
        } else {
            $('#submitSizingInfo').attr('disabled', false)
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

        $("#projectEditWizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            labels: {
                finish: "Save"
            },
            onFinishing: function(event, currentIndex) {
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
            onStepChanged: function(e, c, p) {
                for (let i = 0; i < 10; i++) {
                    $("#projectEditWizard-p-" + i).css("display", "none");
                }

                $("#projectEditWizard-p-" + c).css("display", "block");
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
            updateSubmitButton();
        });

        $('#chooseClientSelect').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectClient', {
                project_id: '{{$project->id}}',
                client_id: value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#valueTargeting').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectHasValueTargeting', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#oraslsSelect').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectHasOrals', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#bindingOption').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectIsBinding', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#practiceSelect').change(function (e) {
            var value = $(this).val();
            currentPracticeId = value;
            $.post('/accenture/newProjectSetUp/changePractice', {
                project_id: '{{$project->id}}',
                practice_id: value
            })

            showSavedToast();
            updateSubmitButton();

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
            updateSubmitButton();
        });

        $('#industrySelect').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeIndustry', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });
        $('#regionSelect').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeRegions', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });
        $('#projectType').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeProjectType', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });
        $('#deadline').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeDeadline', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });
        $('#rfpOtherInfo').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/newProjectSetUp/changeRFPOtherInfo', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
        });

        $('#saveVendorsButton').click(function(){
            $.post('/accenture/newProjectSetUp/updateVendors', {
                project_id: '{{$project->id}}',
                vendorList: $('#vendorSelection').val()
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
                updateSubmitButton();
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
                updateSubmitButton();
            });

        $('.sizingQuestion .checkboxesDiv input')
            .change(function (e) {
                $.post('/sizingQuestion/setShouldShow', {
                    changing: $(this).data('changingid'),
                    value: $(this).prop("checked")
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
        updateSubmitButton();
    });
</script>
@endsection
