@extends('clientViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-client.projectNavbar section="projectView" :project="$project" />

                <br>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>View project information</h3>
                                <br>
                                <div class="alert alert-warning" role="alert">
                                    <p>For any modification, please contact Accenture.</p>
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

                                        <x-questionForeach :questions="$generalInfoQuestions" :class="'generalQuestion'" :disabled="true"
                                            :required="false" />
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP</h4>
                                        <br>
                                        <x-folderFileUploader :folder="$project->rfpFolder" label="Upload your RFP" :disabled="true" :timeout="1000" />

                                        <div class="form-group">
                                            <label for="rfpOtherInfo">Other information</label>
                                            <textarea class="form-control" id="rfpOtherInfo" rows="14" disabled>{{$project->rfpOtherInfo}}</textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <x-questionForeach :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="true"
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

                                                <x-fitgapMainModal :project="$project" />

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
                                                <x-scoringCriteriaBricksView :project="$project"/>
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
                                                <x-options.vendorList :selected="['1', '3']" />
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
