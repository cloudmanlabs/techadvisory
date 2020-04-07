@extends('accentureViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>New project creation</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            The first phase of the process is ipsum dolor sit amet, consectetur
                                            adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a.
                                            Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc
                                            pellentesque luctus. ipsum dolor
                                            sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut
                                            dictum nunc pharetra a.
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
                                    Please complete all fields marked with an *.
                                    <br>
                                    Note: Finishing this form will not publish the project.
                                    To publish please press the Publish button on the last screen.
                                </p>

                                <br>
                                <div id="wizard_accenture_newProjectSetUp">
                                    <h2>General Info</h2>
                                    <section>
                                        <h4>1.1. Project Info</h4>
                                        <br>

                                        <div class="form-group">
                                            <label for="projectName">Project Name*</label>
                                            <input type="text" class="form-control"
                                                id="projectName"
                                                data-changing="name"
                                                placeholder="Project Name"
                                                value="{{$project->name}}"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="chooseClientSelect">Client name*</label>
                                            <select class="form-control" id="chooseClientSelect"
                                                required>
                                                <option selected="" disabled="">Please select the Client Name</option>
                                                @php
                                                    $currentlySelected = $project->client->id ?? -1;
                                                @endphp
                                                @foreach ($clients as $client)
                                                <option
                                                    value="{{$client->id}}"
                                                    @if($currentlySelected == $client->id) selected @endif
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
                                                <x-options.practices :selected="$project->practice->id" />
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="subpracticeSelect">Subpractice*</label>
                                            <select
                                                class="js-example-basic-multiple w-100"
                                                id="subpracticeSelect"
                                                multiple="multiple" required>
                                                @php
                                                $select = $project->subpractices()->pluck('subpractices.id')->toArray();
                                                @endphp
                                                <x-options.subpractices :selected="$select" />
                                            </select>
                                        </div>


                                        @foreach ($generalInfoQuestions as $question)
                                            @switch($question->original->type)
                                                @case('text')
                                                    <div class="form-group">
                                                        <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                        <input
                                                            class="form-control"
                                                            type="text"
                                                            data-changing="{{$question->id}}"
                                                            {{$question->original->required ? 'required' : ''}}
                                                            value="{{$question->response}}"
                                                            placeholder="{{$question->original->placeholder}}">
                                                    </div>
                                                    @break
                                                @case('textarea')
                                                    <div class="form-group">
                                                        <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                        <textarea
                                                            rows="14"
                                                            class="form-control"
                                                            data-changing="{{$question->id}}"
                                                            {{$question->original->required ? 'required' : ''}}
                                                        >{{$question->response}}</textarea>
                                                    </div>
                                                    @break
                                                @case('selectSingle')
                                                    <div class="form-group">
                                                        <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                        <select
                                                            class="form-control"
                                                            data-changing="{{$question->id}}"
                                                            {{$question->original->required ? 'required' : ''}}
                                                            >
                                                            <option @if($question->response == '') selected @endif disabled="">{{$question->original->placeholder}}</option>

                                                            @if ($question->original->presetOption == 'countries')
                                                                <x-options.countries :selected="[$question->response]" />
                                                            @else
                                                                @foreach ($question->original->optionList() as $option)
                                                                <option value="{{$option}}" @if($question->response == $option) selected @endif>{{$option}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @break
                                                @case('selectMultiple')
                                                    <div class="form-group">
                                                        <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                        <select class="js-example-basic-multiple w-100"
                                                            data-changing="{{$question->id}}"
                                                            multiple="multiple"
                                                            {{$question->original->required ? 'required' : ''}}
                                                            >
                                                            @php
                                                            $selectedOptions = json_decode($question->response ?? '[]');
                                                            @endphp

                                                            @if ($question->original->presetOption == 'countries')
                                                                <x-options.countries :selected="$selectedOptions" />
                                                            @else
                                                                @foreach ($question->original->optionList() as $option)
                                                                <option value="{{$option}}" {{in_array($option, $selectedOptions) ? 'selected' : ''}}>{{$option}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @break
                                                @case('date')
                                                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                    <div class="input-group date datepicker" data-initialValue="{{$question->response}}">
                                                        <input
                                                            data-changing="{{$question->id}}"
                                                            value="{{$question->response}}"
                                                            {{$question->original->required ? 'required' : ''}}
                                                            type="text"
                                                            class="form-control">
                                                        <span class="input-group-addon"><i data-feather="calendar"></i></span>
                                                    </div>
                                                    @break
                                                @default

                                            @endswitch
                                        @endforeach

                                        <br>
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <h4>2.1 Upload your RFP</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Upload your RFP</label>

                                            <div class="form-group">
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                                    name="exampleDropzone">
                                                </form>
                                            </div>

                                            <div class="form-group">
                                                <label for="otherInformation">Other information</label>
                                                <textarea class="form-control" id="otherInformation"
                                                    rows="14"></textarea>
                                            </div>

                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <h4>3.1. Sizing Info</h4>
                                        <br>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Maximum number of concurrent users
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="Maximum number of concurrent users">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Number of named users
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="Number of named users">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Annual number shipments
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="Annual # shipments">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Average number of shipments per month valley
                                                season
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="Average number of shimpments per month valley season">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Average number of shipments per month peak
                                                season
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="Average number of shimpments per month peak season">
                                        </div>

                                        <div class="form-group">
                                            <label>Countries</label><br>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                style="width: 100%;">
                                                <x-options.countries :selected="[]" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Transport Spend
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="Transport Spend">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Suppliers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="# Suppliers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Plants
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="Plants">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Warehouses
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="# Warehouses">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Direct customers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="# Direct customers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Final Clients
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="# Final Clients">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Complex movements (different than OW)
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Complex movements (different than OW)">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># carriers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="# carriers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% own fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% own fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% dedicated fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% dedicated fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% contracted fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% contracted fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Road movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Road movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Maritime movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Maritime movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Air movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Air movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Rail movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Rail movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Fluvial movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Fluvial movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Intermodal movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Intermodal movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% International
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% International">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Domestic
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Domestic">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Inbound
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Inbound">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Last mile
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% Last mile">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% FTL vs parcial
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="% FTL vs parcial">
                                        </div>
                                    </section>

                                    <h2>Selection Criteria</h2>
                                    <section>
                                        <div>
                                            <div id="subwizard_here">
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
                                                            <input class="form-control file-upload-info"
                                                                placeholder="Upload Fit Gap model in CSV format"
                                                                type="text">
                                                            <span class="input-group-append">
                                                                <button
                                                                    class="file-upload-browse btn btn-primary"
                                                                    type="button">
                                                                    <span class="input-group-append">Upload</span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <div class="modal fade bd-example-modal-xl" tabindex="-1"
                                                            role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Please
                                                                            complete the Fit Gap table</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <iframe
                                                                            src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/doc.html')}}"
                                                                            style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-lg btn-icon-text"
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-xl"><svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-width="2" stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-check-square btn-icon-prepend">
                                                                                <polyline points="9 11 12 14 22 4">
                                                                                </polyline>
                                                                                <path
                                                                                    d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                                                                                </path>
                                                                            </svg> Done</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                                <h3>Vendor</h3>
                                                <div>
                                                    <h4>2.1 Corporate information</h4>
                                                    <br>
                                                    <div class="form-group">
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                1. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>

                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                2. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>


                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                3. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>


                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                4. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>


                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                5. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>


                                                        <h4>2.1 Market presence</h4>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                1. Headquarters
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>

                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                2. Commercial Offices
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>

                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                3. Service Team Offices
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>

                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                4. Geographies with solution implementations
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <br>


                                                    </div>

                                                    <br><br>
                                                    <a href="#" class="btn btn-primary btn-lg btn-icon-text">Save</a>
                                                    <br><br>
                                                </div>

                                                <h3>Experience</h3>
                                                <div>
                                                    <h4>3.1 Questions</h4>
                                                    <br>
                                                    <div class="form-group">
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                1. Industry Experience
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>

                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                2. List all active clients
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>


                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                3. List how many successful implementations you performed within last 4
                                                                years
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>


                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                4. List how many successful implementations you performed within last 4
                                                                years
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>

                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                5. Share 3 customer references for implementation with similar size &
                                                                scope (same industry preferred)
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <br>
                                                    </div>

                                                    <br><br>
                                                    <a href="#" class="btn btn-primary btn-lg btn-icon-text">Save</a>
                                                    <br><br>
                                                </div>

                                                <h3>Innovation & Vision</h3>
                                                <div>
                                                    <h4>4.1. IT Enablers</h4>
                                                    <br>
                                                    <div class="form-group">
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Question
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                    </div>

                                                    <h4>4.2. Alliances</h4>
                                                    <div class="form-group">
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Partnership 1
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Partnership 2
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Partnership 3
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                    </div>

                                                    <h4>4.3. Product</h4>
                                                    <div class="form-group">
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Question 1
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Question 2
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Question 3
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                    </div>

                                                    <h4>4.4. Sustainability</h4>
                                                    <div class="form-group">
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Question 1
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Question 2
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Question 3
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                    </div>

                                                    <br><br>
                                                    <a href="#" class="btn btn-primary btn-lg btn-icon-text">Save</a>
                                                    <br><br>
                                                </div>

                                                <h3>Implementation & Commercials</h3>
                                                <div>
                                                    <h4>5.1. Implementation</h4>
                                                    <br>
                                                    <x-accenture.activateQuestion>
                                                        <h6>
                                                            Project plan upload
                                                        </h6>
                                                    </x-accenture.activateQuestion>
                                                    <br>

                                                    <h4>5.2. Deliverables per phase</h4>
                                                    <div class="form-group">
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Phase 1
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Phase 2
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                        <x-accenture.activateQuestion>
                                                            <h6>
                                                                Phase 3
                                                            </h6>
                                                        </x-accenture.activateQuestion>
                                                        <br>
                                                    </div>

                                                    <br><br>
                                                    <a href="#" class="btn btn-primary btn-lg btn-icon-text">Save</a>
                                                    <br><br>
                                                </div>



                                                <h3>Scoring criteria</h3>
                                                <div>
                                                    <x-scoringCriteriaBricks />
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Publish / Invite vendors</h2>
                                    <section>
                                        <p>Project Description</p>
                                        <textarea name="projectDescription" id="projectDescription" cols="80" rows="10"></textarea>

                                        <br>
                                        <br>

                                        <h4>Vendor invite</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Select vendors to be invited to this project</label><br>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" style="width: 100%;">
                                                {{-- Selected is the ids of the vendors --}}
                                                <x-options.vendorList :selected="['1', '3']" />
                                            </select>
                                        </div>

                                        <br>
                                        <br>
                                        <a href="#" class="btn btn-primary btn-lg btn-icon-text">Publish project</a>
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
    </style>
@endsection


@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="{{url('assets/js/bricks.js')}}"></script>
<link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">

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
        // If we filled all the fields, remove the disabled from the button. This is incase we fill the last field on the last page
        let fieldsAreEmtpy = !checkIfAllRequiredsAreFilled();
        if(fieldsAreEmtpy && weAreOnPage3){
            $('#wizard_accenture_newProjectSetUp-next').addClass('disabled')
        } else {
            $('#wizard_accenture_newProjectSetUp-next').removeClass('disabled')
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

    var weAreOnPage3 = false;

    $(document).ready(function() {
        weAreOnPage3 = false;

        $("#wizard_accenture_newProjectSetUp").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            forceMoveForward: false,
            labels: {
                finish: 'Submit general set up'
            },
            onFinishing: function (event, currentIndex) {
                // TODO Only let the client submit if all the fields are full

                window.location.replace("/accenture/home");
            },
            onStepChanging: function (e, c, n) {
                if (n == 2) {
                    weAreOnPage3 = true;
                    $('#wizard_accenture_newProjectSetUp-next').html('Submit')
                    let fieldsAreEmtpy = !checkIfAllRequiredsAreFilled();
                    if(fieldsAreEmtpy){
                        $('#wizard_accenture_newProjectSetUp-next').addClass('disabled')
                    } else {
                        $('#wizard_accenture_newProjectSetUp-next').removeClass('disabled')
                    }
                } else {
                    weAreOnPage3 = false;
                    $('#wizard_accenture_newProjectSetUp-next').removeClass('disabled')

                    $('#wizard_accenture_newProjectSetUp-next').html('Next')
                }

                return true
            },
            onStepChanged: function (e, c, p) {
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
            $.post('/accenture/newProjectSetUp/changePractice', {
                project_id: '{{$project->id}}',
                practice_id: value
            })

            showSavedToast();
            updateSubmitButton();
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



        // On change for the rest

        $('input,textarea,select')
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
    });
</script>
@endsection
