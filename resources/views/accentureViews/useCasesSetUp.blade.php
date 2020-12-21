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
                <x-accenture.setUpNavbar section="useCasesSetUp" :project="$project" :isClient="false"/>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Project Set up</h3>
                                <br>
                                <div id="wizard_accenture_useCasesSetUp">
                                    <h2>Use Cases</h2>
                                    <section>
                                        <div class="row">
                                            <aside class="col-2">
                                                <div id="subwizard_here">
                                                    <ul role="tablist">
                                                        @foreach ($useCases as $useCase)
                                                            <li
                                                                @if(($currentUseCase ?? null) && $currentUseCase->id == $useCase->id)
                                                                class="active"
                                                                @else
                                                                class="use_cases"
                                                                @endif
                                                                >
                                                                <a href="{{route('accenture.useCasesSetUp', ['project' => $project, 'useCase' => $useCase->id])}}">
                                                                    {{$useCase->name}}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                        <li>
                                                            <a href="{{route('accenture.useCasesSetUp', ['project' => $project])}}">
                                                                + new use case
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </aside>
                                            <div class="col-8 border-left flex-col">
                                                <h3>Use case</h3>
                                                <div class="form-area">
                                                    <h4>General Info</h4>
                                                    <br>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="useCaseName">Name</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="text" class="form-control"
                                                                       id="useCaseName"
                                                                       data-changing="name"
                                                                       placeholder="Use case name"
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="useCaseDescription">Description</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <textarea
                                                                    class="form-control"
                                                                    id="useCaseDescription"
                                                                    placeholder="Add description"
                                                                    rows="5"
                                                                    ></textarea>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="useCaseExpectedResults">Expected results</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <textarea
                                                                    class="form-control"
                                                                    id="useCaseExpectedResults"
                                                                    placeholder="Add expected results"
                                                                    rows="5"
                                                                    ></textarea>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="practiceSelect">Practice</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <select id="practiceSelect" required>
                                                                    <option value="">-- Select a Practice --</option>
                                                                    @foreach ($practices as $practice)
                                                                        <option value="{{$practice->id}}">{{$practice->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="transportFlowSelect">Questions</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <select id="transportFlowSelect" required>
                                                                    <option value="">-- Select Transport Flow --</option>
                                                                    @foreach ($transportFlows as $transportFlow)
                                                                        <option value="{{$transportFlow}}">{{$transportFlow}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <br>
                                                                <select id="transportModeSelect" required>
                                                                    <option value="">-- Select Transport Mode --</option>
                                                                    @foreach ($transportModes as $transportMode)
                                                                        <option value="{{$transportMode}}">{{$transportMode}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <br>
                                                                <select id="transportTypeSelect" required>
                                                                    <option value="">-- Select Transport Type --</option>
                                                                    @foreach ($transportTypes as $transportType)
                                                                        <option value="{{$transportType}}">{{$transportType}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="form-area">
                                                    <h4>Users</h4>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label for="accentureUsers">Accenture</label>
                                                            <select id="accentureUsers" multiple required>
                                                                @foreach ($accentureUsers as $accentureUser)
                                                                    <option value="{{ $accentureUser->id }}">
                                                                        {{ $accentureUser->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="clientUsers">Clients</label>
                                                            <select id="clientUsers" multiple required>
                                                                @foreach ($clients as $client)
                                                                    <option value="{{ $client->id }}">
                                                                        {{ $client->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <button id="saveUseCaseButton" class="btn btn-primary btn-right">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </section>

                                    <h2>General Scoring Criteria</h2>
                                    <section>
                                        <div class="col-6" style="margin: 0 auto;">
                                            <div class="form-area">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="useCaseRFP">RFP</label>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group">
                                                            <input type="number" max="100" accuracy="2" min="0"
                                                                   style="text-align:left;" class="form-control"
                                                                   id="useCaseRFP" placeholder="40"
                                                                   required>
                                                            <div class="input-group-append simulateInputBox">
                                                                <span class="input-group-text simulateInput">%</span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    @foreach ($useCases as $useCase)
                                                        <div class="col-6">
                                                            <label for="scoringCriteria{{$useCase->id}}">{{$useCase->name}}</label>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="input-group">
                                                                <input type="number" max="100" accuracy="2" min="0"
                                                                       style="text-align:left;" class="form-control"
                                                                       id="scoringCriteria{{$useCase->id}}"
                                                                       placeholder="{{60 / count($useCases)}}" required>
                                                                <div class="input-group-append simulateInputBox">
                                                                    <span class="input-group-text simulateInput">%</span>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-area">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="useCaseSolutionFit">Solution Fit</label>
                                                        <br>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group">
                                                            <input type="number" max="100" accuracy="2" min="0"
                                                                   style="text-align:left;" class="form-control"
                                                                   id="useCaseSolutionFit" placeholder="20"
                                                                   required>
                                                            <div class="input-group-append simulateInputBox">
                                                                <span class="input-group-text simulateInput">%</span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="useCaseUsability">Usability</label>
                                                        <br>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group">
                                                            <input type="number" max="100" accuracy="2" min="0"
                                                                   style="text-align:left;" class="form-control"
                                                                   id="useCaseUsability" placeholder="40"
                                                                   required>
                                                            <div class="input-group-append simulateInputBox">
                                                                <span class="input-group-text simulateInput">%</span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="useCasePerformance">Performance</label>
                                                        <br>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group">
                                                            <input type="number" max="100" accuracy="2" min="0"
                                                                   style="text-align:left;" class="form-control"
                                                                   id="useCasePerformance" placeholder="10"
                                                                   required>
                                                            <div class="input-group-append simulateInputBox">
                                                                <span class="input-group-text simulateInput">%</span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="useCaseLookFeel">Look and Feel</label>
                                                        <br>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group">
                                                            <input type="number" max="100" accuracy="2" min="0"
                                                                   style="text-align:left;" class="form-control"
                                                                   id="useCaseLookFeel" placeholder="15"
                                                                   required>
                                                            <div class="input-group-append simulateInputBox">
                                                                <span class="input-group-text simulateInput">%</span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="useCaseOthers">Others</label>
                                                        <br>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group">
                                                            <input type="number" max="100" accuracy="2" min="0"
                                                                   style="text-align:left;" class="form-control"
                                                                   id="useCaseOthers" placeholder="15"
                                                                   required>
                                                            <div class="input-group-append simulateInputBox">
                                                                <span class="input-group-text simulateInput">%</span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <button id="saveScoringCriteria" class="btn btn-primary btn-right">
                                                Save
                                            </button>
                                        </div>
                                    </section>

                                    <h2>Invited Vendors</h2>
                                    <section>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="invitedVendors">Select vendors to be invited to this project</label>
                                            </div>
                                            <div class="col-12">
                                                <select id="invitedVendors" multiple required>
                                                    @foreach ($appliedVendors as $appliedVendor)
                                                        <option value="{{ $appliedVendor->id }}">
                                                            {{ $appliedVendor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
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
        .select2 {
            min-width: 100%;
        }

        .input-group input {
            border-right: none!important;
            padding-right: 0!important;
            padding-left: 0.5rem!important;
        }

        .simulateInputBox {
            display: block;
            border-top: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-left: none;
            border-top-right-radius: 2px;
            border-bottom-right-radius: 2px;
            background-color: white;

        }

        .simulateInput {
            background-color: white;
            border: none!important;
        }

        .btn-right {
            float: right;
        }

        textarea {
            display: block!important;
            border: 1px solid #ccc!important;
        }

        textarea:focus, textarea:focus-visible, textarea:focus-within {
            display: block!important;
            border: 1px solid #ccc!important;
        }

        select.form-control {
            color: #495057;
        }

        .select2-results__options [aria-disabled=true] {
            display: none;
        }

        #subwizard_here ul > li {
            display: block;
        }

        .form-area {
            background-color: #eee;
            border-radius: 5px;
            padding: 20px;
            margin-top: 25px;
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

        button {
            font-size: 15px;
        }

        b {
            font-size: 15px;
        }

        table button {
            font-size: 15px;
        }

        #subwizard_here li.active {
            background: #7a00c3;
            color: #ffffff;
            border-radius: 3px;
            padding: .4rem 1rem;
            margin-bottom: 5px;
            width: 100%;
        }

        #subwizard_here li.use_cases {
            background: #38005a;
            color: #ffffff;
            border-radius: 3px;
            padding: .4rem 1rem;
            margin-bottom: 5px;
            width: 100%;
        }

        #subwizard_here li.use_cases a, #subwizard_here li.active a {
            text-decoration: inherit;
            color: inherit;
        }

        .valuePadding {
            border: 1px inset #ccc;
        }

        .valuePadding input {
            border: none;
            padding:0px;
            outline: none;
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

        function checkIfSumOfSectionsIs100() {
            var upperForm = (
                @foreach($useCases as $useCase)
                parseFloat($('#scoringCriteria{{$useCase->id}}').val()) +
                @endforeach
                parseFloat($('#useCaseRFP').val())
            );

            var lowerForm = (
                parseFloat($('#useCaseSolutionFit').val()) +
                parseFloat($('#useCaseUsability').val()) +
                parseFloat($('#useCasePerformance').val()) +
                parseFloat($('#useCaseLookFeel').val()) +
                parseFloat($('#useCaseOthers').val())
            );

            return (upperForm === 100.00) && (lowerForm === 100.00);
        }

        function checkIfAllRequiredsInUseCaseScoringCriteriaAreFilled() {
            var array = [
                @foreach($useCases as $useCase)
                $('#scoringCriteria{{$useCase->id}}'),
                @endforeach
                $('#useCaseRFP'),
                $('#useCaseSolutionFit'),
                $('#useCaseUsability'),
                $('#useCasePerformance'),
                $('#useCaseLookFeel'),
                $('#useCaseOthers')
            ];

            for (let i = 0; i < array.length; i++) {
                if (!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')) {
                    console.log(array[i])
                    return false
                }
            }

            return true
        }

        function checkIfAllRequiredsInUseCaseCreationAreFilled() {
            var array = [
                $('#useCaseName'),
                $('#useCaseDescription'),
                $('#practiceSelect'),
                $('#transportFlowSelect'),
                $('#transportModeSelect'),
                $('#transportTypeSelect'),
                $('#accentureUsers'),
                $('#clientUsers')
            ];

            for (let i = 0; i < array.length; i++) {
                if (!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')) {
                    console.log(array[i])
                    return false
                }
            }

            return true
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

        function showInvalidFormToast() {
            $.toast({
                heading: 'Fill all required fields!',
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'bottom-right'
            })
        }

        function showInvalidScoringCriteriaToast() {
            $.toast({
                heading: 'Fill all fields and sum of each section must be 100!',
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'bottom-right'
            })
        }

        $(document).ready(function () {
            $("#wizard_accenture_useCasesSetUp").steps({
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
                    for (let i = 0; i < 10; i++) {
                        $('#wizard_accenture_useCasesSetUp-p-' + i).css('display', 'none')
                    }
                    $('#wizard_accenture_useCasesSetUp-p-' + c).css('display', 'block')
                }
            });

            $('#accentureUsers').select2();
            $('#clientUsers').select2();
            $('#invitedVendors').select2();

            $('#invitedVendors').change(function () {
                $.post('/accenture/newProjectSetUp/updateInvitedVendors', {
                    project_id: '{{$project->id}}',
                    vendorList: encodeURIComponent($(this).val())
                })

                showSavedToast();
            });

            $('#saveUseCaseButton').click(function () {
                if (!checkIfAllRequiredsInUseCaseCreationAreFilled()) {
                    return showInvalidFormToast();
                }

                var body = {
                    @if($currentUseCase ?? null)
                    id: {{$currentUseCase->id}},
                    @endif
                    project_id: {{$project->id}},
                    name: $('#useCaseName').val(),
                    description: $('#useCaseDescription').val(),
                    expected_results: $('#useCaseExpectedResults').val(),
                    practice_id: parseInt($('#practiceSelect').val(), 10),
                    transportFlow: $('#transportFlowSelect').val(),
                    transportMode: $('#transportModeSelect').val(),
                    transportType: $('#transportTypeSelect').val(),
                    accentureUsers: encodeURIComponent($('#accentureUsers').val()),
                    clientUsers: encodeURIComponent($('#clientUsers').val())
                };

                $.post('/accenture/newProjectSetUp/saveCaseUse', body)
                    .then(function (data) {
                        location.replace("{{route('accenture.useCasesSetUp', ['project' => $project])}}" + "?useCase=" + data.useCaseId);
                    });

                showSavedToast();
            });

            $('#saveScoringCriteria').click(function () {
                if (!checkIfAllRequiredsInUseCaseScoringCriteriaAreFilled() || !checkIfSumOfSectionsIs100()) {
                    return showInvalidScoringCriteriaToast();
                }


                @foreach($useCases as $useCase)
                var useCaseBody{{$useCase->id}} = {
                    useCaseId: {{$useCase->id}},
                    scoringCriteria: parseFloat($('#scoringCriteria{{$useCase->id}}').val())
                };

                $.post('/accenture/newProjectSetUp/saveUseCaseScoringCriteria', useCaseBody{{$useCase->id}})
                @endforeach

                var body = {
                    project_id: parseInt({{$project->id}}, 10),
                    rfp: parseFloat($('#useCaseRFP').val()),
                    solutionFit: parseFloat($('#useCaseSolutionFit').val()),
                    usability: parseFloat($('#useCaseUsability').val()),
                    performance: parseFloat($('#useCasePerformance').val()),
                    lookFeel: parseFloat($('#useCaseLookFeel').val()),
                    others: parseFloat($('#useCaseOthers').val())
                };

                $.post('/accenture/newProjectSetUp/saveProjectScoringCriteria', body)

                showSavedToast();
            });

            $(".js-example-basic-single").select2();
            $(".js-example-basic-multiple").select2();

            @if($currentUseCase ?? null)
            $('#useCaseName').val("{{$currentUseCase->name}}")
            $('#useCaseDescription').val("{{$currentUseCase->description}}")
            $('#useCaseExpectedResults').val("{{$currentUseCase->expected_results}}")
            $('#practiceSelect').val("{{$currentUseCase->practice_id}}")
            $('#transportFlowSelect').val("{{$currentUseCase->transportFlow}}")
            $('#transportModeSelect').val("{{$currentUseCase->transportMode}}")
            $('#transportTypeSelect').val("{{$currentUseCase->transportType}}")
            $('#accentureUsers').val(decodeURIComponent("{{$currentUseCase->accentureUsers}}").split(","))
            $('#accentureUsers').select2().trigger('change')
            $('#clientUsers').val(decodeURIComponent("{{$currentUseCase->clientUsers}}").split(","))
            $('#clientUsers').select2().trigger('change')
            @endif
            @if($project ?? null)
            @foreach($useCases as $useCase)
            $('#scoringCriteria{{$useCase->id}}').val(parseFloat({{$useCase->scoring_criteria}}))
            @endforeach
            $('#useCaseRFP').val(parseFloat({{$project->use_case_rfp}}))
            $('#useCaseSolutionFit').val(parseFloat({{$project->use_case_solution_fit}}))
            $('#useCaseUsability').val(parseFloat({{$project->use_case_usability}}))
            $('#useCasePerformance').val(parseFloat({{$project->use_case_performance}}))
            $('#useCaseLookFeel').val(parseFloat({{$project->use_case_look_feel}}))
            $('#useCaseOthers').val(parseFloat({{$project->use_case_others}}))
            $('#invitedVendors').val(decodeURIComponent("{{$project->use_case_invited_vendors}}").split(","))
            $('#invitedVendors').select2().trigger('change')
            @endif
            @if($appliedVendors)
            @foreach($appliedVendors as $appliedVendor)
            console.log('{{$appliedVendor->id}}' + ' : ' + '{{$appliedVendor->name}}');
            @endforeach
            @endif
        });
    </script>
@endsection
