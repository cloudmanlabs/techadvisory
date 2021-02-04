@extends('clientViews.layouts.forms')

@php
    $useCaseTemplates = $useCaseTemplates ?? array();
    $useCaseResponses = $useCaseResponses ?? array();
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
            <div class="page-content">
                    <x-client.projectNavbar section="useCasesSetUp" :project="$project"/>
                    <br>

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
                                        <h2>Use Cases</h2>
                                    @endif
                                        <section>
                                            <div class="row">
                                                <aside class="col-3">
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
                                                                <a id="useCaseSelection{{$useCase->id}}" href="{{route('client.useCasesSetUp', ['project' => $project, 'useCase' => $useCase->id])}}">
                                                                    {{$useCase->name ?? '** UNNAMED **'}}
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
                                            @if($currentUseCase ?? null)
                                                    <div class="col-9 border-left flex-col">
                                                        <div class="form-area
                                                        @if($project->useCasesPhase === 'evaluation')
                                                            area-evaluation
                                                        @endif
                                                            ">
                                                            <h4>Use case Content</h4>
                                                            <br>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <label for="useCaseName">Name*</label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <input type="text" class="form-control"
                                                                               id="useCaseName"
                                                                               data-changing="name"
                                                                               placeholder="Use case name"
                                                                               @if($project->useCasesPhase === 'evaluation')
                                                                               disabled
                                                                               @endif
                                                                               required>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <label for="useCaseDescription">Description*</label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                    <textarea
                                                                        class="form-control"
                                                                        id="useCaseDescription"
                                                                        placeholder="Add description"
                                                                        rows="5"
                                                                        @if($project->useCasesPhase === 'evaluation')
                                                                        disabled
                                                                        @endif
                                                                        required>
                                                                    </textarea>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <x-useCaseQuestionForeach :questions="$useCaseQuestions" :class="'useCaseQuestion'"
                                                                                          :disabled="$project->useCasesPhase === 'evaluation'" :required="false"
                                                                                          :useCaseId="$useCaseId"
                                                                />
                                                                <br>
                                                            </div>
                                                        </div>
                                                        @if($project->useCasesPhase !== 'evaluation')
                                                            <br>
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
                                                        @elseif($canEvaluateVendors)
                                                            <br>
                                                            <table >
                                                                @foreach($selectedVendors as $selectedVendor)
                                                                    @php
                                                                        $evaluation = \App\VendorUseCasesEvaluation::findByIdsAndType($currentUseCase->id, $client_id, $selectedVendor->id, 'client');
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
                                                                                        @if($project->use_case_solution_fit > 0)
                                                                                            <div class="col-6">
                                                                                                <label for="vendor{{$selectedVendor->id}}SolutionFit">Solution Fit</label>
                                                                                                <br>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <select id="vendor{{$selectedVendor->id}}SolutionFit"
                                                                                                        @if($evaluation->submitted === 'yes')
                                                                                                        disabled
                                                                                                    @endif
                                                                                                >
                                                                                                    <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->solution_fit] : []"/>
                                                                                                </select>
                                                                                                <br>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($project->use_case_usability > 0)
                                                                                            <div class="col-6">
                                                                                                <label for="vendor{{$selectedVendor->id}}Usability">Usability</label>
                                                                                                <br>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <select id="vendor{{$selectedVendor->id}}Usability"
                                                                                                        @if($evaluation->submitted === 'yes')
                                                                                                        disabled
                                                                                                    @endif
                                                                                                >
                                                                                                    <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->usability] : []"/>
                                                                                                </select>
                                                                                                <br>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($project->use_case_performance > 0)
                                                                                            <div class="col-6">
                                                                                                <label for="vendor{{$selectedVendor->id}}Performance">Performance</label>
                                                                                                <br>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <select id="vendor{{$selectedVendor->id}}Performance"
                                                                                                        @if($evaluation->submitted === 'yes')
                                                                                                        disabled
                                                                                                    @endif
                                                                                                >
                                                                                                    <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->performance] : []"/>
                                                                                                </select>
                                                                                                <br>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($project->use_case_look_feel > 0)
                                                                                            <div class="col-6">
                                                                                                <label for="vendor{{$selectedVendor->id}}LookFeel">Look and Feel</label>
                                                                                                <br>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <select id="vendor{{$selectedVendor->id}}LookFeel"
                                                                                                        @if($evaluation->submitted === 'yes')
                                                                                                        disabled
                                                                                                    @endif
                                                                                                >
                                                                                                    <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->look_feel] : []"/>
                                                                                                </select>
                                                                                                <br>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if($project->use_case_others > 0)
                                                                                            <div class="col-6">
                                                                                                <label for="vendor{{$selectedVendor->id}}Others">Others</label>
                                                                                                <br>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <select id="vendor{{$selectedVendor->id}}Others"
                                                                                                        @if($evaluation->submitted === 'yes')
                                                                                                        disabled
                                                                                                    @endif
                                                                                                >
                                                                                                    <x-options.vendorEvaluation :selected="$evaluation ? [$evaluation->others] : []"/>
                                                                                                </select>
                                                                                                <br>
                                                                                            </div>
                                                                                        @endif
                                                                                        <div class="col-6">
                                                                                            <label for="vendor{{$selectedVendor->id}}Comments">Comments</label>
                                                                                            <br>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                        <textarea
                                                                                            class="form-control"
                                                                                            id="vendor{{$selectedVendor->id}}Comments"
                                                                                            placeholder="Add your comments..."
                                                                                            rows="5"
                                                                                            @if($evaluation->submitted === 'yes')
                                                                                            disabled
                                                                                            @endif
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
                                                            @if($evaluationsSubmitted === 'no')
                                                                <button id="submitEvaluationsButton" class="btn btn-primary btn-right">
                                                                    Submit
                                                                </button>
                                                            @else
                                                                <button id="rollbackSubmitButton" class="btn btn-primary btn-right">
                                                                    Rollback Submit
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                            @endif
                                            </div>
                                    </section>

                                    @if($project->useCasesPhase !== 'evaluation')
                                    <h2>General Scoring Criteria</h2>
                                    <section>
                                        @if(count($useCases ?? array()) > 0)
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
                                                <select id="invitedVendors" multiple required disabled>
                                                    @foreach ($appliedVendors as $appliedVendor)
                                                        <option value="{{ $appliedVendor->id }}">
                                                            {{ $appliedVendor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($project->currentPhase === 'open')
                                                <div class="col-12">
                                                    <br>
                                                    <button class="btn btn-primary" id="publishButton" disabled>PUBLISH</button>
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
            /*margin-top: 25px;*/
        }

        .area-evaluation {
            background-color: #f2f4f8;;
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

        function showSubmitEvaluationToast(vendorName) {
            $.toast({
                heading: 'Evaluations for vendor ' + vendorName + ' submitted!',
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

        function disableSubmitEvaluationsButton() {
            $('#submitEvaluationsButton').prop('disabled', true);
        }

        function enableSubmitEvaluationsButton() {
            $('#submitEvaluationsButton').prop('disabled', false);
        }

        $(document).ready(function () {
            // $(".js-example-basic-single").select2();
            // $(".js-example-basic-multiple").select2();

            @if($project->useCasesPhase !== 'evaluation')
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
                    window.location.replace("/client/home");
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

            $('#newUseCase').click(function () {
                if ($('#templateSelect').val() === "-1") {
                    return location.replace("{{route('client.useCasesSetUp', ['project' => $project])}}" + "?createUseCase=1");
                }

                return location.replace("{{route('client.useCasesSetUp', ['project' => $project])}}" + "?createUseCase=1" + "&useCaseTemplate=" + $('#templateSelect').val());
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

                $.post('/client/newProjectSetUp/saveUseCaseScoringCriteria', useCaseBody{{$useCase->id}})
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

                $.post('/client/newProjectSetUp/saveProjectScoringCriteria', body)
                    .then(function () {
                        showSavedToast();
                    });
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

                $.post('/client/newProjectSetUp/publishUseCases', {
                    project_id: '{{$project->id}}',
                })
                    .then(function () {
                        showPublishedToast();
                        location.reload();
                    });
            });
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

            $('#invitedVendors').change(function () {
                $.post('/client/newProjectSetUp/updateInvitedVendors', {
                    project_id: '{{$project->id}}',
                    vendorList: encodeURIComponent($(this).val())
                })

                showSavedToast();
            });

            @if($appliedVendors)
            @foreach($appliedVendors as $appliedVendor)
            console.log('{{$appliedVendor->id}}' + ' : ' + '{{$appliedVendor->name}}');
            @endforeach
            @endif
            @else

            function checkEvaluationsForSubmit() {
                @foreach($selectedVendors as $selectedVendor)
                if($('#vendor{{$selectedVendor->id}}SolutionFit').val() == -1 && {{$project->use_case_solution_fit}} > 0) {
                    return disableSubmitEvaluationsButton();
                }

                if($('#vendor{{$selectedVendor->id}}Usability').val() == -1 && {{$project->use_case_usability}} > 0) {
                    return disableSubmitEvaluationsButton();
                }

                if($('#vendor{{$selectedVendor->id}}Performance').val() == -1 && {{$project->use_case_performance}} > 0) {
                    return disableSubmitEvaluationsButton();
                }

                if($('#vendor{{$selectedVendor->id}}LookFeel').val() == -1 && {{$project->use_case_look_feel}} > 0) {
                    return disableSubmitEvaluationsButton();
                }

                if($('#vendor{{$selectedVendor->id}}Others').val() == -1 && {{$project->use_case_others}} > 0) {
                    return disableSubmitEvaluationsButton();
                }
                @endforeach
                    return enableSubmitEvaluationsButton();
            }

            @if($evaluationsSubmitted === 'no')
            $('#submitEvaluationsButton').click(function() {
                $.when(
                    @foreach($selectedVendors as $selectedVendor)
                    @php
                        $evaluation = \App\VendorUseCasesEvaluation::findByIdsAndType($currentUseCase->id, $client_id, $selectedVendor->id, 'client');
                    @endphp
                    $.post('/client/newProjectSetUp/submitUseCaseVendorEvaluation', {
                        evaluationId: {{$evaluation->id}}
                    }).then(function () {
                        showSubmitEvaluationToast('{{$selectedVendor->name}}');
                    }),
                    @endforeach
                ).done(function(){
                    return location.replace("{{route('client.useCasesSetUp', ['project' => $project])}}" + "??useCase={{$currentUseCase->id}}");
                });
            });
            @else
            $('#rollbackSubmitButton').click(function() {
                $.post('/client/newProjectSetUp/rollbackSubmitUseCaseVendorEvaluation', {
                    useCaseId: {{$currentUseCase->id}},
                    userCredential: {{$client_id}}
                }).then(function () {
                    return location.replace("{{route('client.useCasesSetUp', ['project' => $project])}}" + "??useCase={{$currentUseCase->id}}");
                });
            });
            @endif

            @foreach($selectedVendors as $selectedVendor)

            $('#vendor{{$selectedVendor->id}}SolutionFit').change(function() {
                if ($(this).val() === -1) {
                    disableSubmitEvaluationsButton();
                } else {
                    checkEvaluationsForSubmit();
                }

                $.post('/client/newProjectSetUp/upsertEvaluationSolutionFit', {
                    useCaseId: {{$currentUseCase->id}},
                    userCredential: {{$client_id}},
                    vendorId: {{$selectedVendor->id}},
                    value: $(this).val()
                }).then(function () {
                    showSavedToast();
                });
            });

            $('#vendor{{$selectedVendor->id}}Usability').change(function() {
                if ($(this).val() === -1) {
                    disableSubmitEvaluationsButton();
                } else {
                    checkEvaluationsForSubmit();
                }

                $.post('/client/newProjectSetUp/upsertEvaluationUsability', {
                    useCaseId: {{$currentUseCase->id}},
                    userCredential: {{$client_id}},
                    vendorId: {{$selectedVendor->id}},
                    value: $(this).val()
                }).then(function () {
                    showSavedToast();
                });

            });

            $('#vendor{{$selectedVendor->id}}Performance').change(function() {
                if ($(this).val() === -1) {
                    disableSubmitEvaluationsButton();
                } else {
                    checkEvaluationsForSubmit();
                }

                $.post('/client/newProjectSetUp/upsertEvaluationPerformance', {
                    useCaseId: {{$currentUseCase->id}},
                    userCredential: {{$client_id}},
                    vendorId: {{$selectedVendor->id}},
                    value: $(this).val()
                }).then(function () {
                    showSavedToast();
                });
            });

            $('#vendor{{$selectedVendor->id}}LookFeel').change(function() {
                if ($(this).val() === -1) {
                    disableSubmitEvaluationsButton();
                } else {
                    checkEvaluationsForSubmit();
                }

                $.post('/client/newProjectSetUp/upsertEvaluationLookFeel', {
                    useCaseId: {{$currentUseCase->id}},
                    userCredential: {{$client_id}},
                    vendorId: {{$selectedVendor->id}},
                    value: $(this).val()
                }).then(function () {
                    showSavedToast();
                });
            });

            $('#vendor{{$selectedVendor->id}}Others').change(function() {
                if ($(this).val() === -1) {
                    disableSubmitEvaluationsButton();
                } else {
                    checkEvaluationsForSubmit();
                }

                $.post('/client/newProjectSetUp/upsertEvaluationOthers', {
                    useCaseId: {{$currentUseCase->id}},
                    userCredential: {{$client_id}},
                    vendorId: {{$selectedVendor->id}},
                    value: $(this).val()
                }).then(function () {
                    showSavedToast();
                });
            });

            $('#vendor{{$selectedVendor->id}}Comments').change(function() {
                $.post('/client/newProjectSetUp/upsertEvaluationComments', {
                    useCaseId: {{$currentUseCase->id}},
                    userCredential: {{$client_id}},
                    vendorId: {{$selectedVendor->id}},
                    value: $(this).val()
                }).then(function () {
                    showSavedToast();
                });
            });

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
            checkEvaluationsForSubmit();
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
            if (element{{$useCaseResponse->use_case_questions_id}}) {
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
            }
            @endforeach

            $('#accentureUsers').change(function () {
                $.post('/client/newProjectSetUp/upsertUseCaseAccentureUsers', {
                    useCaseId: {{$currentUseCase->id}},
                    userList: encodeURIComponent($(this).val())
                }).then(function () {
                    showSavedToast();
                });
            });

            $('#clientUsers').change(function () {
                $.post('/client/newProjectSetUp/upsertUseCaseClientUsers', {
                    useCaseId: {{$currentUseCase->id}},
                    clientList: encodeURIComponent($(this).val())
                }).then(function () {
                    showSavedToast();
                });
            });

            $('#useCaseName').change(function (e) {
                var value = $(this).val();
                $.post('/client/newProjectSetUp/upsertUseCaseName', {
                    useCaseId: {{$currentUseCase->id}},
                    newName: value
                }).then(function () {
                    $('#useCaseSelection{{$currentUseCase->id}}').text(value);
                    $("label[for='scoringCriteria{{$currentUseCase->id}}']").text(value + '*');
                    showSavedToast();
                });
            });

            $('#useCaseDescription').change(function (e) {
                var value = $(this).val();
                $.post('/client/newProjectSetUp/upsertUseCaseDescription', {
                    useCaseId: {{$currentUseCase->id}},
                    newDescription: value
                }).then(function () {
                    showSavedToast();
                });
            });

            setTimeout(function(){
                $('.useCaseQuestion input,.useCaseQuestion textarea,.useCaseQuestion select')
                    .filter(function (el) {
                        return $( this ).data('changing') !== undefined
                    })
                    .change(function (e) {
                        var value = $( this ).val();
                        var changing = $( this ).data('changing');
                        if ($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined) {
                            value = '[]'
                        }

                        $.post('/useCaseQuestionResponse/upsertResponse', {
                            changing: changing,
                            value: encodeURIComponent(value),
                            useCase: {{$currentUseCase->id}},
                        }).done(function() {
                            showSavedQuestionToast(value);
                            console.log("success", value, changing);
                            $('#errorrQuestion' + changing).hide();
                        }).fail(function() {
                            console.log("error", value, changing);
                            $('#errorrQuestion' + changing).show();
                        });
                    });
            }, 1000);

            @endif
            @foreach ($useCaseQuestions as $question)
            $('#errorrQuestion' + '{{$question->id}}').hide();
            @endforeach
            $('#errorPublish').hide();
            $('#errorScoringCriteria').hide();
            disableQuestionsByPractice();
        });
    </script>
@endsection
