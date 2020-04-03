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
                                            <label for="projectNameInput">Project Name*</label>
                                            <input type="text" class="form-control"
                                                id="projectNameInput"
                                                placeholder="Project Name"
                                                value="{{$project->name}}"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Short description*</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="14"
                                                required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="chooseClientSelect">Client name*</label>
                                            <select class="form-control" id="chooseClientSelect" required>
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
                                            <label for="exampleInputText1">Client contact e-mail</label>
                                            <input type="email" class="form-control" id="exampleInputText1"
                                                placeholder="Client contact e-mail" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Client contact phone</label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="Client contact phone">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Accenture contact e-mail</label>
                                            <input type="email" class="form-control" id="exampleInputText1"
                                                placeholder="Accenture contact e-mail" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Accenture contact phone</label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                placeholder="Accenture contact phone">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Project Type*</label>
                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                <option selected="" disabled="">Please select the Project Type</option>
                                                <option>Business Case</option>
                                                <option>Software selection</option>
                                                <option>Value Based Software Selection</option>
                                                <option>Client Satisfaction Survey</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Value Targeting*</label>
                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                <option selected="" disabled="">Please select the Project Type</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Project Currency*</label>
                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                <option selected="" disabled="">Please select the Project Type</option>
                                                <option>€</option>
                                                <option>$</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Binding/Non-binding*</label>
                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                <option selected="" disabled="">Please select the Project Type</option>
                                                <option>Binding</option>
                                                <option>Non-binding</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Detailed description</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="14"
                                                required></textarea>
                                        </div>

                                        <br>

                                        <h4>1.2. Practice</h4>
                                        <br>

                                        <div class="form-group">
                                            <label for="practiceSelect">Practice*</label>
                                            <select class="form-control" id="practiceSelect" required>
                                                <option selected="" disabled="">Please select your Transport Mode
                                                </option>
                                                <option>Transport </option>
                                                <option>Planning</option>
                                                <option>Manufacturing</option>
                                                <option>Warehousing</option>
                                                <option>Sourcing</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Subpractice*</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                required>
                                                <option>Logistics Procurement</option>
                                                <option>Tactical Planning</option>
                                                <option>Order Management</option>
                                                <option>Transport Planning</option>
                                                <option>Tendering & Spot buying</option>
                                                <option>Execution & Visbility</option>
                                                <option>Document management</option>
                                                <option>Trade complaince</option>
                                                <option>FBA</option>
                                                <option>Reporting and Analytics </option>
                                            </select>

                                        </div>
                                        <br>
                                        <h4>1.3. Scope</h4>
                                        <br>
                                        <div class="form-group">
                                            <label>Region Served</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                required>
                                                <x-options.countries :selected="[]" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Transport Flows</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                required>
                                                <option>International Trade</option>
                                                <option>Domestic</option>
                                                <option>Inbound</option>
                                                <option>Last Mile</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Transport Mode</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                required>
                                                <option>Road</option>
                                                <option>Maritime</option>
                                                <option>Air</option>
                                                <option>Train</option>
                                                <option>Fluvial</option>
                                                <option>Others</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Transport Type</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                required>
                                                <option>FTL</option>
                                                <option>LTL</option>
                                                <option>Parcel</option>
                                                <option>Others</option>
                                            </select>
                                        </div>

                                        <br>

                                        <h4>1.4. Timeline</h4>
                                        <br>

                                        <label for="exampleFormControlSelect1">Tentative date for project set - up
                                            completion</label>
                                        <div class="input-group date datepicker" id="datePicker1">
                                            <input type="text" class="form-control"><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


                                        <label for="exampleFormControlSelect1">Tentative date for Value Enablers
                                            completion</label>
                                        <div class="input-group date datepicker" id="datePicker2">
                                            <input type="text" class="form-control"><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


                                        <label for="exampleFormControlSelect1">Tentative date for Vendor Response
                                            completion</label>
                                        <div class="input-group date datepicker" id="datePicker3">
                                            <input type="text" class="form-control"><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


                                        <label for="exampleFormControlSelect1">Tentative date for Analytics
                                            completion</label>
                                        <div class="input-group date datepicker" id="datePicker4">
                                            <input type="text" class="form-control"><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


                                        <label for="exampleFormControlSelect1">Tentative date fot Conclusions &
                                            Recomendations completion</label>
                                        <div class="input-group date datepicker" id="datePicker5">
                                            <input type="text" class="form-control"><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


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
                                                <label for="exampleFormControlTextarea1">Other information</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                                    rows="14" required></textarea>
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
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" required
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
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" required style="width: 100%;">
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
    $(document).ready(function() {
        $('#projectNameInput').change(function(){
            var newName = $(this).val();

            $.post('/accenture/changeProjectName', {
                project_id: '{{$project->id}}',
                newName
            })

            $.toast({
                heading: 'Saved!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        })

        $('#chooseClientSelect').on('change', function (e) {
            var client_id = $(this).val()

            $.post('/accenture/changeProjectName', {
                project_id: '{{$project->id}}',
                client_id
            })

            $.toast({
                heading: 'Saved!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        });
    });
</script>
@endsection
