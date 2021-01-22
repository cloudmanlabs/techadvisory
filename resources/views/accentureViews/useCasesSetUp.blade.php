@extends('accentureViews.layouts.forms')

@php
    $useCaseTemplates = $useCaseTemplates ?? array();
    $useCaseTemplates = $useCaseTemplates ?? array();
    $useCaseId = ($currentUseCase ?? null) ?$currentUseCase->id : null;
@endphp

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
        <div class="page-wrapper">
            <div class="page-content">
                @if($project->currentPhase === 'preparation')
                <x-video :src="nova_get_setting('video_newProject_file')"
                         :text="nova_get_setting('video_newProject_text')"/>
                <x-accenture.setUpNavbar section="useCasesSetUp" :project="$project" :isClient="false"/>
                @endif
                @if ($project->currentPhase === 'open')
                <x-accenture.projectNavbar section="useCasesSetUp" :project="$project"/>
                <br>
                @endif
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @if($project->useCasesPhase === 'evaluation')
                                    <h3>Use Cases Evaluation</h3>
                                @else
                                    <h3>Use Cases Set up</h3>
                                @endif
                                <br>
                                @if($project->useCasesPhase === 'evaluation')
                                    <div>
                                @else
                                    <div id="wizard_accenture_useCasesSetUp">
                                @endif
                                    <h2>Use Cases</h2>
                                    <section>
                                        <div class="row">
                                            <aside class="col-2">
                                                <div id="subwizard_here">
                                                    <ul role="tablist">
                                                        @foreach ($useCases as $key=>$useCase)
                                                            <li
                                                                @if((($currentUseCase ?? null) && $currentUseCase->id === $useCase->id) || ($project->useCasesPhase === 'evaluation' && $key === 0 && $currentUseCase->id === 1))
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
                                                    </ul>
                                                </div>
                                                @if($project->useCasesPhase !== 'evaluation')
                                                    <br>
                                                    <div id="subwizard_here">
                                                        <ul role="tablist">
                                                            <li>
                                                                <select id="templateSelect">
                                                                    <option value="-1">-- Templates --</option>
                                                                    @foreach ($useCaseTemplates as $useCaseTemplate)
                                                                        <option value="{{$useCaseTemplate->id}}">{{$useCaseTemplate->name}} - {{\App\Subpractice::find($useCaseTemplate->subpractice_id)->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </li>
                                                            <li>
                                                                <a id="newUseCase" href="#">
                                                                    + new use case
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </aside>
                                            <div class="col-8 border-left flex-col">
                                                <h3>Use case</h3>
                                                <div class="form-area">
                                                    <h4>Use Case Category</h4>
                                                    <br>
                                                    <div class="form-group">
                                                        <div class="row">
                                                        @if($project->useCasesPhase === 'evaluation')
                                                            <div class="col-12">
                                                                <label for="useCaseName">Name</label>
                                                            </div>
                                                            <div class="col-12">
                                                                <h6>Name of the use case.</h6>
                                                            </div>
                                                        @else
                                                            <div class="col-3">
                                                                <label for="useCaseName">Name*</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="text" class="form-control"
                                                                       id="useCaseName"
                                                                       data-changing="name"
                                                                       placeholder="Use case name"
                                                                       required>
                                                            </div>
                                                        @endif
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                        @if($project->useCasesPhase === 'evaluation')
                                                            <div class="col-12">
                                                                <label for="useCaseDescription">Description</label>
                                                            </div>
                                                            <div class="col-12">
                                                                <h6>Description of this use case.</h6>
                                                            </div>
                                                        @else
                                                            <div class="col-3">
                                                                <label for="useCaseDescription">Description*</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <textarea
                                                                    class="form-control"
                                                                    id="useCaseDescription"
                                                                    placeholder="Add description"
                                                                    rows="5"
                                                                    required
                                                                ></textarea>
                                                            </div>
                                                        @endif

                                                        </div>
                                                        <br>
                                                        @if($project->useCasesPhase === 'evaluation')
                                                            <label>Questions</label>
                                                            @foreach ($useCaseQuestions as $question)
                                                                <h6 class="questionDiv practice{{$question->practice->id ?? ''}}" style="margin-bottom: 1rem">
                                                                    {{$question->label}}
                                                                </h6>
                                                            @endforeach
                                                        @else
                                                            <x-useCaseQuestionForeach :questions="$useCaseQuestions" :class="'useCaseQuestion'"
                                                                                      :disabled="false" :required="false"
                                                                                      :useCaseId="$useCaseId"
                                                            />
                                                        @endif

                                                        <br>
                                                    </div>
                                                </div>
                                                @if($project->useCasesPhase !== 'evaluation')
                                                    <div class="form-area">
                                                        <h4>Users</h4>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label for="accentureUsers">Accenture*</label>
                                                                <select id="accentureUsers" multiple required>
                                                                    @foreach ($accentureUsers as $accentureUser)
                                                                        <option value="{{ $accentureUser->id }}">
                                                                            {{ $accentureUser->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="clientUsers">Clients*</label>
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
                                                    <p id="errorSaveUseCase" style="color: darkred;">Fill all required fields!</p>
                                                @else
                                                    <br>
                                                    <table >
                                                        @foreach($selectedVendors as $selectedVendor)
                                                            @php
                                                                $evaluation = \App\VendorUseCasesEvaluation::findByIdsAndType($currentUseCase->id, $user_id, $selectedVendor->id, 'accenture');
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-10">
                                                                            <h6>
                                                                                {{$selectedVendor->name}}
                                                                            </h6>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <i class="fa fa-chevron-up" id="vendor{{$selectedVendor->id}}closed" style="float: right" aria-hidden="true"></i>
                                                                            <i class="fa fa-chevron-down" id="vendor{{$selectedVendor->id}}opened" style="float: right" aria-hidden="true"></i>
                                                                        </div>
                                                                        <div id="vendorBody{{$selectedVendor->id}}" style="padding-top: 15px;padding-left: 25px;padding-right: 25px;">
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <label for="vendor{{$selectedVendor->id}}SolutionFit">Solution Fit</label>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <select id="vendor{{$selectedVendor->id}}SolutionFit">
                                                                                        <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->solution_fit] : []"/>
                                                                                    </select>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="vendor{{$selectedVendor->id}}Usability">Usability</label>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <select id="vendor{{$selectedVendor->id}}Usability">
                                                                                        <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->usability] : []"/>
                                                                                    </select>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="vendor{{$selectedVendor->id}}Performance">Performance</label>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <select id="vendor{{$selectedVendor->id}}Performance">
                                                                                        <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->performance] : []"/>
                                                                                    </select>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="vendor{{$selectedVendor->id}}LookFeel">Look and Feel</label>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <select id="vendor{{$selectedVendor->id}}LookFeel">
                                                                                        <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->look_feel] : []"/>
                                                                                    </select>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="vendor{{$selectedVendor->id}}Others">Others</label>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <select id="vendor{{$selectedVendor->id}}Others">
                                                                                        <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->others] : []"/>
                                                                                    </select>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="vendor{{$selectedVendor->id}}Comments">Comments</label>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <p>{{$evaluation->comments ?? null}}</p>
                                                                                        <textarea
                                                                                            class="form-control"
                                                                                            id="vendor{{$selectedVendor->id}}Comments"
                                                                                            placeholder="Add your comments..."
                                                                                            rows="5"
                                                                                        >{{$evaluation->comments ?? null}}</textarea>
                                                                                    <br>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                    <br>
                                                    <button id="saveVendorsEvaluationButton" class="btn btn-primary btn-right">
                                                        Save
                                                    </button>
                                                    @foreach($selectedVendors as $selectedVendor)
                                                        @php
                                                            $evaluation = \App\VendorUseCasesEvaluation::findByIdsAndType($currentUseCase->id, $user_id, $selectedVendor->id, 'accenture');
                                                        @endphp
                                                        <p id="errorSaveVendorsEvaluation{{$selectedVendor->id}}" style="color: darkred;">Vendor {{$selectedVendor->name}} without evaluations can't be saved!</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </section>

                                    @if($project->useCasesPhase !== 'evaluation')
                                    <h2>General Scoring Criteria</h2>
                                    <section>
                                        @if(count($useCases ?? array()) > 0 )
                                            <div class="col-6" style="margin: 0 auto;">
                                            <div class="form-area">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="useCaseRFP">RFP*</label>
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
                                                    <div class="col-9">
                                                        <div class="row">
                                                            @foreach ($useCases as $useCase)
                                                                <div class="col-8">
                                                                    <label for="scoringCriteria{{$useCase->id}}">{{$useCase->name}}*</label>
                                                                </div>
                                                                <div class="col-4">
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
                                                    <div class="col-3">
                                                        <div class="brd-left">
                                                            <p class="text-center">60%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-area">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="useCaseSolutionFit">Solution Fit*</label>
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
                                                        <label for="useCaseUsability">Usability*</label>
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
                                                        <label for="useCasePerformance">Performance*</label>
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
                                                        <label for="useCaseLookFeel">Look and Feel*</label>
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
                                                        <label for="useCaseOthers">Others*</label>
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
                                            <p id="errorScoringCriteria" style="color: darkred;">Fill all fields and sum of each section must be 100!</p>
                                        </div>
                                        @endif
                                    </section>

                                    <h2>Invited Vendors</h2>
                                    <section>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="invitedVendors">Select vendors to be invited to this project</label>
                                                @if ($project->currentPhase === 'open')
                                                <span>*</span>
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <select id="invitedVendors" multiple required
                                                        @if ($project->currentPhase !== 'open')
                                                        disabled
                                                        @endif
                                                >
                                                    @foreach ($appliedVendors as $appliedVendor)
                                                        <option value="{{ $appliedVendor->id }}">
                                                            {{ $appliedVendor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($project->currentPhase === 'preparation')
                                                    <br>
                                                    <p style="color: darkred;">Decide vendors to participate on the use cases when the project is in open phase.</p>
                                                @endif
                                            </div>
                                            @if ($project->currentPhase === 'open')
                                            <div class="col-12">
                                                <br>
                                                <button class="btn btn-primary" id="publishButton">PUBLISH</button>
                                                <p id="errorPublish" style="color: darkred;">Fill all mandatory fields of the three sections before PUBLISH!</p>
                                                <br>
                                            </div>
                                            @endif
                                        </div>
                                    </section>
                                    @endif
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
        table {
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }

        .text-center {
            text-align: center !important;
            width: 100%;
        }

        .brd-left {
            border-left: 1px solid #727272;
            height: 93%;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

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

        function checkIfInvitedVendorsIsFilled() {
            if (!$('#invitedVendors').is(':hasValue') || $('#invitedVendors').hasClass('invalid')) {
                console.log($('#invitedVendors'))
                return false
            }

            return true
        }

        function checkIfAllRequiredsInUseCaseCreationAreFilled() {
            var array = [
                $('#useCaseName'),
                $('#useCaseDescription'),
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

        function showSavedEvaluationToast(vendorName) {
            $.toast({
                heading: 'Evaluations for vendor ' + vendorName + ' saved!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        }

        function showSavedQuestionToast(questionName) {
            $.toast({
                heading: 'Saved question: ' + questionName,
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        }

        function showPublishedToast() {
            $.toast({
                heading: 'Published!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        }

        function disableQuestionsByPractice() {
            var practiceToShow = 'practice' + '{{$project->practice_id}}';
            var array = $('.questionDiv');
            for (let i = 0; i < array.length; i++) {
                if($(array[i]).hasClass(practiceToShow)){
                    $(array[i]).show();
                } else {
                    $(array[i]).hide();
                }
            }
        }

        $(document).ready(function () {
            $('#saveVendorsEvaluationButton').click(function () {
                @foreach($selectedVendors as $selectedVendor)
                var solutionFit{{$selectedVendor->id}} = parseInt($('#vendor{{$selectedVendor->id}}SolutionFit').val(), 10);
                var usability{{$selectedVendor->id}} = parseInt($('#vendor{{$selectedVendor->id}}Usability').val(), 10);
                var performance{{$selectedVendor->id}} = parseInt($('#vendor{{$selectedVendor->id}}Performance').val(), 10);
                var lookFeel{{$selectedVendor->id}} = parseInt($('#vendor{{$selectedVendor->id}}LookFeel').val(), 10);
                var others{{$selectedVendor->id}} = parseInt($('#vendor{{$selectedVendor->id}}Others').val(), 10);
                var comments{{$selectedVendor->id}} = $('#vendor{{$selectedVendor->id}}Comments').val();
                if ((solutionFit{{$selectedVendor->id}} + usability{{$selectedVendor->id}} + performance{{$selectedVendor->id}} + lookFeel{{$selectedVendor->id}} + others{{$selectedVendor->id}}) === -5) {
                    $('#errorSaveVendorsEvaluation{{$selectedVendor->id}}').show();
                } else {
                    $('#errorSaveVendorsEvaluation{{$selectedVendor->id}}').hide();
                    var vendorEvaluation{{$selectedVendor->id}}Body = {
                        vendorId: {{$selectedVendor->id}},
                        useCaseId: {{$currentUseCase ? $currentUseCase->id : null}},
                        userCredential: {{$user_id}},
                        solutionFit: solutionFit{{$selectedVendor->id}},
                        usability: usability{{$selectedVendor->id}},
                        performance: performance{{$selectedVendor->id}},
                        lookFeel: lookFeel{{$selectedVendor->id}},
                        others: others{{$selectedVendor->id}},
                        comments: comments{{$selectedVendor->id}},
                    };

                    $.post('/accenture/newProjectSetUp/saveVendorEvaluation', vendorEvaluation{{$selectedVendor->id}}Body)
                        .then(function (data) {
                            showSavedEvaluationToast('{{$selectedVendor->name}}');
                        });
                }
                @endforeach
            });

            @if($project->useCasesPhase != 'evaluation')
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

            $('#newUseCase').click(function () {
                if ($('#templateSelect').val() === "-1") {
                    return location.replace("{{route('accenture.useCasesSetUp', ['project' => $project])}}");
                }

                return location.replace("{{route('accenture.useCasesSetUp', ['project' => $project])}}" + "?useCaseTemplate=" + $('#templateSelect').val());
            });

            $('#saveUseCaseButton').click(function () {
                if (!checkIfAllRequiredsInUseCaseCreationAreFilled()) {
                    return $('#errorSaveUseCase').show();
                } else {
                    $('#errorSaveUseCase').hide();
                }

                var body = {
                    @if($currentUseCase ?? null)
                    id: {{$currentUseCase->id}},
                    @endif
                    project_id: {{$project->id}},
                    name: $('#useCaseName').val(),
                    description: $('#useCaseDescription').val(),
                    accentureUsers: encodeURIComponent($('#accentureUsers').val()),
                    clientUsers: encodeURIComponent($('#clientUsers').val())
                };

                $.post('/accenture/newProjectSetUp/saveCaseUse', body)
                    .then(function (data) {
                        var array = $('.useCaseQuestion input,.useCaseQuestion textarea,.useCaseQuestion select')
                            .filter(function(el) {
                                return $( this ).data('changing') !== undefined
                            });
                        for (let i = 0; i < array.length; i++) {
                            var value = $(array[i]).val();
                            var changing = $(array[i]).data('changing');
                            if($.isArray(value) && value.length == 0 && $(array[i]).attr('multiple') !== undefined){
                                value = '[]'
                            }

                            $.post('/useCaseQuestionResponse/upsertResponse', {
                                changing: changing,
                                value: encodeURIComponent(value),
                                useCase: data.useCaseId,
                            }).done(function() {
                                showSavedQuestionToast(value);
                                console.log("success", value, changing);
                                $('#errorrQuestion' + changing).hide();
                            }).fail(function() {
                                console.log("error", value, changing);
                                $('#errorrQuestion' + changing).show();
                            });
                        }
                        location.replace("{{route('accenture.useCasesSetUp', ['project' => $project])}}" + "?useCase=" + data.useCaseId);
                    });

                showSavedToast();
            });

            $('#saveScoringCriteria').click(function () {
                if (!checkIfAllRequiredsInUseCaseScoringCriteriaAreFilled() || !checkIfSumOfSectionsIs100()) {
                    return $('#errorScoringCriteria').show();
                } else {
                    $('#errorScoringCriteria').hide();
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

            @if ($project->currentPhase === 'open')
            $('#publishButton').click(function () {
                if (
                    !checkIfAllRequiredsInUseCaseCreationAreFilled() ||
                    !checkIfAllRequiredsInUseCaseScoringCriteriaAreFilled() ||
                    !checkIfSumOfSectionsIs100() ||
                    !checkIfInvitedVendorsIsFilled()
                ) {
                    return $('#errorPublish').show();
                } else {
                    $('#errorPublish').hide();
                }

                $.post('/accenture/newProjectSetUp/publishUseCases', {
                    project_id: '{{$project->id}}',
                })
                    .then(function () {
                        showPublishedToast();
                        location.reload();
                    });
            });
            @endif

            $(".js-example-basic-single").select2();
            $(".js-example-basic-multiple").select2();

            @if($selectedUseCaseTemplate ?? null)
            $('#useCaseName').val("{{$selectedUseCaseTemplate->name}}")
            $('#useCaseDescription').val("{{$selectedUseCaseTemplate->description}}")
            @foreach($useCaseTemplateResponses as $useCaseTemplateResponse)
                var element{{$useCaseTemplateResponse->use_case_questions_id}} = document.getElementById('useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}');
                if (element{{$useCaseTemplateResponse->use_case_questions_id}}) {
                    switch (element{{$useCaseTemplateResponse->use_case_questions_id}}.tagName.toLowerCase()) {
                        case 'input':
                            switch ($('#useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}').attr('type').toLowerCase()) {
                                case 'text':
                                    $('#useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseTemplateResponse->response}}"))
                                    break;
                                case 'number':
                                    $('#useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}').val(parseInt('{{$useCaseTemplateResponse->response}}', 10))
                                    break;
                            }
                            break;
                        case 'select':
                            if($('#useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}').hasClass('js-example-basic-multiple')) {
                                $('#useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseTemplateResponse->response}}").split(","))
                                $('#useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}').select2().trigger('change')
                            } else {
                                $('#useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}').val('{{$useCaseTemplateResponse->response}}')
                            }
                            break;
                        case 'textarea':
                            $('#useCaseQuestion{{$useCaseTemplateResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseTemplateResponse->response}}"))
                            break;
                    }
                }
            @endforeach
            @endif
            @if($currentUseCase ?? null)
            $('#useCaseName').val("{{$currentUseCase->name}}")
            $('#useCaseDescription').val("{{$currentUseCase->description}}")
            $('#accentureUsers').val(decodeURIComponent("{{$currentUseCase->accentureUsers}}").split(","))
            $('#accentureUsers').select2().trigger('change')
            $('#clientUsers').val(decodeURIComponent("{{$currentUseCase->clientUsers}}").split(","))
            $('#clientUsers').select2().trigger('change')
            @foreach($useCaseResponses as $useCaseResponse)
            var element{{$useCaseResponse->use_case_questions_id}} = document.getElementById('useCaseQuestion{{$useCaseResponse->use_case_questions_id}}');
            if (element{{$useCaseResponse->use_case_questions_id}})
                switch (element{{$useCaseResponse->use_case_questions_id}}.tagName.toLowerCase()) {
                case 'input':
                    switch ($('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').attr('type').toLowerCase()) {
                        case 'text':
                            $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseResponse->response}}"))
                            break;
                        case 'number':
                            $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val(parseInt('{{$useCaseResponse->response}}', 10))
                            break;
                    }
                    break;
                case 'select':
                    if($('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').hasClass('js-example-basic-multiple')) {
                        $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseResponse->response}}").split(","))
                        $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').select2().trigger('change')
                    } else {
                        $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val('{{$useCaseResponse->response}}')
                    }
                    break;
                case 'textarea':
                    $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseResponse->response}}"))
                    break;
            }
            @endforeach
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
            @foreach ($useCaseQuestions as $question)
            $('#errorrQuestion' + '{{$question->id}}').hide();
            @endforeach
            $('#errorPublish').hide();
            $('#errorScoringCriteria').hide();
            $('#errorSaveUseCase').hide();
            @else
            @foreach($selectedVendors as $selectedVendor)
            $('#errorSaveVendorsEvaluation{{$selectedVendor->id}}').hide();
            $('#vendor{{$selectedVendor->id}}closed').click(function() {
                $('#vendor{{$selectedVendor->id}}closed').hide();
                $('#vendor{{$selectedVendor->id}}opened').show();
                $('#vendorBody{{$selectedVendor->id}}').show();
            });
            $('#vendor{{$selectedVendor->id}}opened').click(function() {
                $('#vendor{{$selectedVendor->id}}closed').show();
                $('#vendor{{$selectedVendor->id}}opened').hide();
                $('#vendorBody{{$selectedVendor->id}}').hide();
            });
            $('#vendor{{$selectedVendor->id}}closed').show();
            $('#vendor{{$selectedVendor->id}}opened').hide();
            $('#vendorBody{{$selectedVendor->id}}').hide();
            @endforeach
            @endif
            disableQuestionsByPractice();
        });
    </script>
@endsection
