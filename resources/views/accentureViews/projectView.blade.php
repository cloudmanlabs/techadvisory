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
                                    <h3>View project information</h3>
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.projectEdit', ['project' => $project])}}">Edit</a>
                                </div>
                                <br>
                                <div id="projectViewWizard">
                                    <h2>General Info</h2>
                                    <section>
                                        <h4>1.1. Project Info</h4>
                                        <br>

                                        <div class="form-group">
                                            <label for="projectName">Project Name*</label>
                                            <input type="text" class="form-control" id="projectName" data-changing="name" placeholder="Project Name"
                                                value="{{$project->name}}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="chooseClientSelect">Client name*</label>
                                            <select class="form-control" id="chooseClientSelect" disabled>
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
                                            <select class="form-control" id="valueTargeting" disabled>
                                                <option disabled="">Please select an option</option>
                                                <option value="yes" @if($project->hasValueTargeting) selected @endif>Yes</option>
                                                <option value="no" @if(!$project->hasValueTargeting) selected @endif>No</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="oralsSelect">Orals*</label>
                                            <select class="form-control" id="oralsSelect" disabled>
                                                <option disabled="">Please select an option</option>
                                                <option value="yes" @if($project->hasOrals) selected @endif>Yes</option>
                                                <option value="no" @if(!$project->hasOrals) selected @endif>No</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="bindingOption">Binding/Non-binding*</label>
                                            <select class="form-control" id="bindingOption" disabled>
                                                <option disabled="">Please select an option</option>
                                                <option value="yes" @if($project->isBinding) selected @endif>Binding</option>
                                                <option value="no" @if(!$project->isBinding) selected @endif>Non-binding</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="practiceSelect">Practice*</label>
                                            <select class="form-control" id="practiceSelect" disabled>
                                                <x-options.practices :selected="$project->practice->id ?? -1" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="subpracticeSelect">Subpractice*</label>
                                            <select class="js-example-basic-multiple w-100" id="subpracticeSelect" multiple="multiple" disabled>
                                                @php
                                                $select = $project->subpractices()->pluck('subpractices.id')->toArray();
                                                @endphp
                                                <x-options.subpractices :selected="$select" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="industrySelect">Industry*</label>
                                            <select class="form-control" id="industrySelect" disabled>
                                                <x-options.industryExperience :selected="$project->industry ?? ''" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="regionSelect">Regions*</label>
                                            <select class="js-example-basic-multiple w-100" id="regionSelect" multiple="multiple" disabled>
                                                <x-options.geographies :selected="$project->regions ?? []" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="projectType">Project Type*</label>
                                            <select class="form-control" id="projectType" disabled>
                                                <x-options.projectType :selected="$project->projectType ?? ''" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="deadline">Deadline*</label>
                                            <div class="input-group date datepicker" data-initialValue="{{$project->deadline}}">
                                                <input disabled id="deadline" value="{{$project->deadline}}" type="text" class="form-control">
                                                <span class="input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>

                                        <x-questionForeach :questions="$generalInfoQuestions" :class="'generalQuestion'" :disabled="true" :required="false" />
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Upload your RFP</label>

                                            <div class="form-group">
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                                    name="exampleDropzone" disabled aria-disabled="true">
                                                </form>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Other information</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                                    rows="14" disabled>Response</textarea>
                                            </div>


                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <x-questionForeachWithActivate :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="true"
                                            :required="false" />
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
                                                <br><br>
                                                <div style="text-align: center;">
                                                    <div class="input-group col-xs-12">
                                                        <input class="form-control file-upload-info" placeholder="Upload Fit Gap model in CSV format"
                                                            type="text">
                                                        <span class="input-group-append">
                                                            <button class="file-upload-browse btn btn-primary" type="button">
                                                                <span class="input-group-append">Upload</span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                                                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Please
                                                                        complete the Fit Gap table</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <iframe src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/doc.html')}}"
                                                                        style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal"
                                                                        data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                            class="feather feather-check-square btn-icon-prepend">
                                                                            <polyline points="9 11 12 14 22 4">
                                                                            </polyline>
                                                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
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
                                                <x-scoringCriteriaBricksView :project="$project" />
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Invited vendors</h2>
                                    <section>
                                        <h4>Vendors</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Vendors invited to this project</label><br>
                                            <select
                                                id="vendorSelection"
                                                disabled
                                                class="js-example-basic-multiple w-100" multiple="multiple" style="width: 100%;">
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

    $(document).ready(function() {
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
    });
</script>
@endsection
