@extends('clientViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

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
                                            <label for="exampleInputText1">Project Name</label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="Project Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Client contact e-mail</label>
                                            <input type="email" class="form-control" id="exampleInputText1"
                                                disabled value="Client contact e-mail">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Client telefono</label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="Client telefono">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Accenture contact e-mail</label>
                                            <input type="email" class="form-control" id="exampleInputText1"
                                                disabled value="Accenture contact e-mail">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Accenure telefono</label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="Accenure telefono">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Project Type</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option>Please select the Project Type</option>
                                                <option selected>Transportation Business Case</option>
                                                <option>Software selection</option>
                                                <option>Value Based Software Selection</option>
                                                <option>Client Satisfaction Survey</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Project description</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="14"
                                                disabled>Response</textarea>
                                        </div>

                                        <br>
                                        <h4>1.2. Scope</h4>
                                        <br>


                                        <div class="form-group">
                                            <label>Region Served</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                disabled>
                                                <x-options.countries :selected="['ES']"/>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Flows</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                disabled>
                                                <option selected>International Trade</option>
                                                <option>Domestic</option>
                                                <option>Inbound</option>
                                                <option>Last Mille</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Transport Mode</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                disabled>
                                                <option selected>Road</option>
                                                <option>Maritime</option>
                                                <option selected>Air</option>
                                                <option>Train</option>
                                                <option>Fluvial</option>
                                                <option>Others</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Transport Type</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                disabled>
                                                <option selected>FTL</option>
                                                <option>LTL</option>
                                                <option>Parcel</option>
                                                <option>Others</option>
                                            </select>
                                        </div>

                                        <br>

                                        <h4>1.3. Timeline</h4>
                                        <br>

                                        <label for="exampleFormControlSelect1">Tentative date for project set - up
                                            completion</label>
                                        <div class="input-group date datepicker" id="datePicker1">
                                            <input type="text" class="form-control" disabled>
                                            <span class="input-group-addon">
                                                <i data-feather="calendar"></i>
                                            </span>
                                        </div>


                                        <label for="exampleFormControlSelect1">Tentative date for Value Enablers
                                            completion</label>
                                        <div class="input-group date datepicker" id="datePicker2">
                                            <input type="text" class="form-control" disabled><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


                                        <label for="exampleFormControlSelect1">Tentative date for Vendor Response
                                            completion</label>
                                        <div class="input-group date datepicker" id="datePicker3">
                                            <input type="text" class="form-control" disabled><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


                                        <label for="exampleFormControlSelect1">Tentative date for Analytics
                                            completion</label>
                                        <div class="input-group date datepicker" id="datePicker4">
                                            <input type="text" class="form-control" disabled><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


                                        <label for="exampleFormControlSelect1">Tentative date fot Conclusions &
                                            Recomendations completion</label>
                                        <div class="input-group date datepicker" id="datePicker5">
                                            <input type="text" class="form-control" disabled><span class="input-group-addon"><i
                                                    data-feather="calendar"></i></span>
                                        </div>


                                        <br>

                                        <h4>1.4. Solution Type</h4>
                                        <br>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Business Process Level 1</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option>Please select your Transport Mode
                                                </option>
                                                <option selected>Transport </option>
                                                <option>Planning</option>
                                                <option>Manufacturing</option>
                                                <option>Warehousing</option>
                                                <option>Sourcing</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Business Process Level 2</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                disabled>
                                                <option>Logistics Procurement</option>
                                                <option>Tactical Planning</option>
                                                <option selected>Order Management</option>
                                                <option selected>Transport Planning</option>
                                                <option>Tendering & Spot buying</option>
                                                <option>Execution & Visbility</option>
                                                <option>Document management</option>
                                                <option>Trade complaince</option>
                                                <option>FBA</option>
                                                <option>Reporting and Analytics </option>
                                            </select>

                                        </div>
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

                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <h4>3.1. Sizing Info</h4>
                                        <br>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Annual # shipments
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="Annual # shipments">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Average number of shimpments per month valley
                                                season
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="Average number of shimpments per month valley season">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Average number of shimpments per month peak
                                                season
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="Average number of shimpments per month peak season">
                                        </div>

                                        <div class="form-group">
                                            <label>Countries</label><br>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled
                                                style="width: 100%;">
                                                <x-options.countries :selected="['ES']"/>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Transport Spend
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="Transport Spend">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Suppliers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="# Suppliers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Plants
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="Plants">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Warehouses
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="# Warehouses">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Direct customers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="# Direct customers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Final Clients
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="# Final Clients">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Complex movements (different than OW)
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Complex movements (different than OW)">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># carriers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="# carriers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% own fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% own fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% dedicated fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% dedicated fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% contracted fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% contracted fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Road movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Road movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Maritime movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Maritime movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Air movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Air movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Rail movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Rail movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Fluvial movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Fluvial movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Intermodal movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Intermodal movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% International
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% International">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Domestic
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Domestic">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Inbound
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Inbound">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Last mile
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% Last mile">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% FTL vs parcial
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                disabled value="% FTL vs parcial">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Maximum number of concurrent users
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="Maximum number of concurrent users">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Number of named users
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                disabled value="Number of named users">
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
