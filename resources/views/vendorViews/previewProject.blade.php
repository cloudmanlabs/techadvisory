@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-vendor.projectNavbar section="preview" />

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
                                            <label for="exampleInputText1">Project Name</label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="Project Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Client contact e-mail</label>
                                            <input type="email" class="form-control" id="exampleInputText1" disabled
                                                value="Client contact e-mail">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Client telefono</label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="Client telefono">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Accenture contact e-mail</label>
                                            <input type="email" class="form-control" id="exampleInputText1" disabled
                                                value="Accenture contact e-mail">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Accenure telefono</label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="Accenure telefono">
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
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
                                                <x-options.countries :selected="['ES']" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Flows</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
                                                <option selected>International Trade</option>
                                                <option>Domestic</option>
                                                <option>Inbound</option>
                                                <option>Last Mille</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Transport Mode</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
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
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
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
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
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
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone"
                                                    disabled aria-disabled="true">
                                                </form>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Other information</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="14"
                                                    disabled>Response</textarea>
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
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="Annual # shipments">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Average number of shimpments per month valley
                                                season
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="Average number of shimpments per month valley season">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Average number of shimpments per month peak
                                                season
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="Average number of shimpments per month peak season">
                                        </div>

                                        <div class="form-group">
                                            <label>Countries</label><br>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled
                                                style="width: 100%;">
                                                <x-options.countries :selected="['ES']" />
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Transport Spend
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="Transport Spend">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Suppliers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="# Suppliers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Plants
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled value="Plants">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Warehouses
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="# Warehouses">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Direct customers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="# Direct customers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># Final Clients
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="# Final Clients">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Complex movements (different than OW)
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% Complex movements (different than OW)">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1"># carriers
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="# carriers">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% own fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled value="% own fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% dedicated fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% dedicated fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% contracted fleet
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% contracted fleet">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Road movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% Road movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Maritime movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% Maritime movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Air movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% Air movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Rail movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% Rail movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Fluvial movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% Fluvial movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Intermodal movements
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% Intermodal movements">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% International
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% International">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Domestic
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled value="% Domestic">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Inbound
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled value="% Inbound">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% Last mile
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled value="% Last mile">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">% FTL vs parcial
                                            </label>
                                            <input type="text" class="form-control" id="exampleInputText1" disabled
                                                value="% FTL vs parcial">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Maximum number of concurrent users
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="Maximum number of concurrent users">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Number of named users
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1" disabled
                                                value="Number of named users">
                                        </div>
                                    </section>
                                </div>
                            </div>

                            {{-- TODO Here we should mark the project as either rejected or accepted --}}
                            <div style="display:flex; justify-content:space-evenly; padding: 1.5rem 1.5rem;">
                                <div style="text-align: right; width: 17%;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.home')}}">
                                        Reject
                                    </a>
                                </div>
                                <div style="text-align: right; width: 17%;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.home')}}">
                                        Accept
                                    </a>
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
