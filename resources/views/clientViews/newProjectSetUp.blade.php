@extends('clientViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />
        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-video :src="nova_get_setting('client_NewProjectSetUp')" />

                <br><br>

                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Redistribution of processes at Nestlé</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            The first phase of the process is ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a. Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque luctus. ipsum dolor
                                            sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a.
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
                                    All changes will be automatically saved. You can go to home screen by clicking on the Home button and
                                    finish the Project Set up on another moment.
                                </p>

                                <br>
                                <div id="wizard_client_newProjectSetUp">
                                    <h2>General Info</h2>
                                    <section>
                                        <h4>1.1. Project Info</h4>
                                        <br>

                                        <div class="form-group">
                                            <label for="projectName">Project Name*</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="projectName"
                                                data-changing="name"
                                                placeholder="Project Name"
                                                value="{{$project->name}}"
                                                disabled
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="valueTargeting">Value Targeting*</label>
                                            <select class="form-control" id="valueTargeting" required disabled>
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
                                            <select class="js-example-basic-multiple w-100" id="subpracticeSelect" multiple="multiple" required>
                                                @php
                                                $select = $project->subpractices()->pluck('subpractices.id')->toArray();
                                                @endphp
                                                <x-options.subpractices :selected="$select" />
                                            </select>
                                        </div>


                                        @foreach ($generalInfoQuestions as $question)
                                            @switch($question->original->type)
                                                @case('text')
                                                <div class="form-group questionDiv generalQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                    <input class="form-control" type="text" data-changing="{{$question->id}}"
                                                        {{$question->original->required ? 'required' : ''}} value="{{$question->response}}"
                                                        placeholder="{{$question->original->placeholder}}">
                                                </div>
                                                @break
                                                @case('textarea')
                                                <div class="form-group questionDiv generalQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                    <textarea rows="14" class="form-control" data-changing="{{$question->id}}"
                                                        {{$question->original->required ? 'required' : ''}}>{{$question->response}}</textarea>
                                                </div>
                                                @break
                                                @case('selectSingle')
                                                <div class="form-group questionDiv generalQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                    <select class="form-control" data-changing="{{$question->id}}"
                                                        {{$question->original->required ? 'required' : ''}}>
                                                        <option @if($question->response == '') selected @endif disabled="">{{$question->original->placeholder}}
                                                        </option>

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
                                                <div class="form-group questionDiv generalQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                    <select class="js-example-basic-multiple w-100" data-changing="{{$question->id}}" multiple="multiple"
                                                        {{$question->original->required ? 'required' : ''}}>
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
                                                <div class="questionDiv generalQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                    <div class="input-group date datepicker" data-initialValue="{{$question->response}}">
                                                        <input data-changing="{{$question->id}}" value="{{$question->response}}"
                                                            {{$question->original->required ? 'required' : ''}} type="text" class="form-control">
                                                        <span class="input-group-addon"><i data-feather="calendar"></i></span>
                                                    </div>
                                                </div>
                                                @break
                                                @case('number')
                                                    <div class="form-group questionDiv generalQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                        <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                        <input
                                                            class="form-control"
                                                            type="number"
                                                            data-changing="{{$question->id}}"
                                                            {{$question->original->required ? 'required' : ''}}
                                                            value="{{$question->response}}"
                                                            placeholder="{{$question->original->placeholder}}">
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
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone">
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Extra information</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="14" required></textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        @foreach ($sizingQuestions as $question)
                                            @switch($question->original->type)
                                                @case('text')
                                                    <div class="form-group questionDiv sizingQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                                    <div class="form-group questionDiv sizingQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                                    <div class="form-group questionDiv sizingQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                                    <div class="form-group questionDiv sizingQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                                    <div class="questionDiv sizingQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                                    </div>
                                                    @break
                                                @case('number')
                                                    <div class="form-group questionDiv sizingQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                        <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                        <input
                                                            class="form-control"
                                                            type="number"
                                                            data-changing="{{$question->id}}"
                                                            {{$question->original->required ? 'required' : ''}}
                                                            value="{{$question->response}}"
                                                            placeholder="{{$question->original->placeholder}}">
                                                    </div>
                                                    @break
                                                @default

                                            @endswitch
                                        @endforeach
                                    </section>

                                    <h2>Selection Criteria</h2>
                                    <section>
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
                                                    <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal"
                                                        data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-check-square btn-icon-prepend">
                                                            <polyline points="9 11 12 14 22 4"></polyline>
                                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                        </svg> Open Fit Gap table</button>

                                                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Please complete the Fit Gap table</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <iframe src="{{url("/assets/vendors_techadvisory/jexcel-3.6.1/doc.html")}}"
                                                                        style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal"
                                                                        data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="feather feather-check-square btn-icon-prepend">
                                                                            <polyline points="9 11 12 14 22 4"></polyline>
                                                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                                        </svg>
                                                                        Done
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <h3>Vendor</h3>
                                            <div>
                                                <h4>4.2. Corporate</h4>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>ID</th>
                                                                <th>Question</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit?
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>2</th>
                                                                <td>Donec sapien purus, mollis ut leo eget, sodales
                                                                    tincidunt
                                                                    elit. Vestibulum varius congue blandit. Vestibulum
                                                                    pulvinar
                                                                    volutpat ultrices?</td>
                                                            </tr>
                                                            <tr>
                                                                <th>3</th>
                                                                <td>Integer ornare feugiat libero, non consectetur odio
                                                                    imperdiet rutrum?</td>
                                                            </tr>
                                                            <tr>
                                                                <th>4</th>
                                                                <td>Phasellus non sagittis dolor. Duis in suscipit ante.
                                                                    Vestibulum eu consequat augue?</td>
                                                            </tr>
                                                            <tr>
                                                                <th>5</th>
                                                                <td>Vivamus semper magna ac nulla interdum, vitae
                                                                    placerat
                                                                    erat
                                                                    viverra?</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <h3>Experience</h3>
                                            <div>
                                                <h4>4.3. Market presence</h4>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>ID</th>
                                                                <th>Question</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>Headquarters</td>
                                                            </tr>
                                                            <tr>
                                                                <th>2</th>
                                                                <td>Commercial Offices</td>
                                                            </tr>
                                                            <tr>
                                                                <th>3</th>
                                                                <td>Service Team Offices</td>
                                                            </tr>
                                                            <tr>
                                                                <th>4</th>
                                                                <td>Geographies with solution implementations</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                            <h3>Innovation & Vision</h3>
                                            <div>
                                                <h4>4.5. IT Enablers</h4>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>ID</th>
                                                                <th>Question</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>List your IT Enablers</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br><br>
                                                <h4>4.6. Alliances</h4>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>ID</th>
                                                                <th>Question</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>Partnership 1</td>
                                                            </tr>
                                                            <tr>
                                                                <th>2</th>
                                                                <td>Partnership 2</td>
                                                            </tr>
                                                            <tr>
                                                                <th>3</th>
                                                                <td>Partnership 3</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br><br>
                                                <h4>4.4. Experience</h4>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>ID</th>
                                                                <th>Question</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>Industry Experience</td>
                                                            </tr>
                                                            <tr>
                                                                <th>2</th>
                                                                <td>List all active clients</td>
                                                            </tr>
                                                            <tr>
                                                                <th>3</th>
                                                                <td>List how many successful implementations you
                                                                    performed
                                                                    within last 4 years</td>
                                                            </tr>
                                                            <tr>
                                                                <th>4</th>
                                                                <td>Share 3 customer references for implementation with
                                                                    similar
                                                                    size & scope (same industry preferred)</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br><br>
                                                <h4>4.7. Product</h4>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>ID</th>
                                                                <th>Question</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit?
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>2</th>
                                                                <td>Donec sapien purus, mollis ut leo eget, sodales
                                                                    tincidunt
                                                                    elit. Vestibulum varius congue blandit. Vestibulum
                                                                    pulvinar
                                                                    volutpat ultrices?</td>
                                                            </tr>
                                                            <tr>
                                                                <th>3</th>
                                                                <td>Integer ornare feugiat libero, non consectetur odio
                                                                    imperdiet rutrum?</td>
                                                            </tr>
                                                            <tr>
                                                                <th>4</th>
                                                                <td>Phasellus non sagittis dolor. Duis in suscipit ante.
                                                                    Vestibulum eu consequat augue?</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br><br>
                                                <h4>4.8. Sustainability</h4>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>ID</th>
                                                                <th>Question</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit?
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>2</th>
                                                                <td>Donec sapien purus, mollis ut leo eget, sodales
                                                                    tincidunt
                                                                    elit. Vestibulum varius congue blandit. Vestibulum
                                                                    pulvinar
                                                                    volutpat ultrices?</td>
                                                            </tr>
                                                            <tr>
                                                                <th>3</th>
                                                                <td>Integer ornare feugiat libero, non consectetur odio
                                                                    imperdiet rutrum?</td>
                                                            </tr>
                                                            <tr>
                                                                <th>4</th>
                                                                <td>Phasellus non sagittis dolor. Duis in suscipit ante.
                                                                    Vestibulum eu consequat augue?</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                            <h3>Implementation & Commercials</h3>
                                            <div>
                                                <h4>4.9. Implementation</h4>
                                                <br>
                                                <h6>Deliverables per phase</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Phase</th>
                                                                <th>Deliverables</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>

                                                <br>
                                                <h6>RACI Matrix</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Task</th>
                                                                <th>Client</th>
                                                                <th>Vendor</th>
                                                                <th>Accenture</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>


                                                <br>
                                                <h6>Implementation Cost</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Staffing Cost</th>
                                                                <th>Role</th>
                                                                <th>Estimated number of hours</th>
                                                                <th>Hourly rate</th>
                                                                <th>Staffing Cost</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <br>

                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Travel Cost</th>
                                                                <th>Month</th>
                                                                <th>Monthly Travel Cost</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <br>

                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Additional Cost</th>
                                                                <th>Item</th>
                                                                <th>Cost</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>


                                                <br><br>
                                                <h4>4.10. Run</h4>
                                                <br>
                                                <h6>Pricing Model</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <br>
                                                <h6>Estimate first 5 years billing plan</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Yearly cost</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>Year 0 (Total Implementation Cost)</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Year 1</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Year 2</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Year 3</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Year 4</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Year 5</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Total cost</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <h3>Scoring criteria</h3>
                                            <div>
                                                <x-scoringCriteriaBricksView />

                                                <br>
                                                <br>
                                                <button class="btn btn-primary" id="step4Submit">Submit</button>
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

    #subwizard_here ul > li{
        display: block;
    }
</style>
@endsection

@section('scripts')
@parent
{{-- NOT SURE IF THE CLIENT CAN EDIT THIS --}}
{{--
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="{{url('assets/js/bricks.js')}}"></script> --}}

<script src="{{url('assets/js/select2.js')}}"></script>
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
            $('#wizard_client_newProjectSetUp-next').addClass('disabled')
        } else {
            $('#wizard_client_newProjectSetUp-next').removeClass('disabled')
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

    var currentPracticeId = {{$project->practice->id}};
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





    var weAreOnPage3 = false;

    $(document).ready(function() {
        weAreOnPage3 = false;

        $("#wizard_client_newProjectSetUp").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            forceMoveForward: false,
            labels: {
                finish: 'Submit general set up'
            },
            onFinishing: function (event, currentIndex) {
                // TODO Only let the client submit if all the fields are full

                window.location.replace("/client/home");
            },
            onStepChanged: function (e, c, p) {
                for (let i = 0; i < 10; i++) {
                    $('#wizard_client_newProjectSetUp-p-' + i).css('display', 'none')
                }
                $('#wizard_client_newProjectSetUp-p-' + c).css('display', 'block')
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
            $.post('/client/newProjectSetUp/changeProjectName', {
                project_id: '{{$project->id}}',
                newName: value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#valueTargeting').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeProjectHasValueTargeting', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#bindingOption').change(function (e) {
            var value = $(this).val();
            $.post('/client/newProjectSetUp/changeProjectIsBinding', {
                project_id: '{{$project->id}}',
                value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#practiceSelect').change(function (e) {
            var value = $(this).val();
            currentPracticeId = value;
            $.post('/client/newProjectSetUp/changePractice', {
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
            $.post('/client/newProjectSetUp/changeSubpractice', {
                project_id: '{{$project->id}}',
                subpractices: value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#step4Submit').click(function(){
            $.post('/client/newProjectSetUp/setStep4Finished', {
                project_id: '{{$project->id}}',
            })

            $.toast({
                heading: 'Submitted!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        });



        // On change for the rest

        $('.generalQuestion input,.generalQuestion textarea,.generalQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                console.log('general');
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
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                console.log('sizing');

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
        updateShownSubpracticeOptionsAccordingToPractice(false);
    });
</script>
@endsection
