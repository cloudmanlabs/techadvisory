@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-vendor.projectNavbar section="preview" :project="$project" />

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>View project information</h3>

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
                                                <option disabled="">Please select the Project Type</option>
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
                                                <option disabled="">Please select the Project Type</option>
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
                                        <div class="form-group">
                                            <label>Upload your RFP</label>

                                            <div class="form-group">
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone" disabled
                                                    aria-disabled="true">
                                                </form>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Other information</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="14" disabled>Response</textarea>
                                            </div>


                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <x-questionForeach :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="true"
                                            :required="false" />
                                    </section>
                                </div>
                            </div>

                            <div style="display:flex; justify-content:space-evenly; padding: 1.5rem 1.5rem;">
                                <div style="text-align: right; width: 17%;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('vendor.application.setRejected', ['project' => $project])}}"
                                        onclick="event.preventDefault(); document.getElementById('reject-project-{{$project->id}}-form').submit();">
                                        Reject
                                    </a>
                                    <form id="reject-project-{{$project->id}}-form"
                                        action="{{ route('vendor.application.setRejected', ['project' => $project]) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                                <div style="text-align: right; width: 17%;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('vendor.application.setAccepted', ['project' => $project])}}"
                                        onclick="event.preventDefault(); document.getElementById('accepted-project-{{$project->id}}-form').submit();">
                                        Accept
                                    </a>
                                    <form id="accepted-project-{{$project->id}}-form"
                                        action="{{ route('vendor.application.setAccepted', ['project' => $project]) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                            <br><br>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
