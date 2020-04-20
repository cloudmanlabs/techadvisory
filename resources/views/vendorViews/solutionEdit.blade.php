@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="solutions" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Edit solution</h3>

                                <p class="welcome_text extra-top-15px">Please add your solutions to complete your
                                    profile and get ready to use the platform. It won't take you more than just a few
                                    minutes and you can do it today. Note that, if you do not currently have the info
                                    for some specific fields, you can leave them blank and fill them up later.</p>
                                <br>
                                <br>


                                <div class="form-group">
                                    <label for="exampleInputText1">Solution name</label>
                                    <input class="form-control"
                                    id="exampleInputText1" value="{{$solution->name}}" type="text">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText1">Vendor solution contact email</label>
                                    <input
                                        class="form-control" id="exampleInputText1"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Vendor solution contact role</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText1">Vendor solution contact phone</label> <input
                                        class="form-control" id="exampleInputText1" placeholder="Enter Phone number"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Provide high-level description of your
                                        solution and vision</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="7"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Describe core modules of your solution and
                                        third party applications that complement your offering (ex: Maps
                                        provider)</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1"
                                        rows="12"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">SC Capabilities</label>
                                    <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                        <option>Sourcing</option>
                                        <option>Planning</option>
                                        <option>Manufacturing</option>
                                        <option>Warehousing</option>
                                        <option>Transport</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Integration method</label>
                                    <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                        <option>EDI</option>
                                        <option>API</option>
                                        <option>Web Services</option>
                                        <option>Others</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">TMS Capabilities</label>
                                    <select class="js-example-basic-multiple w-100" multiple="multiple" required>
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

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Transport Flows</label>
                                    <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                        <option>International</option>
                                        <option>Domestic</option>
                                        <option>Last Mille</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Transport Mode</label>
                                    <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                        <option>Road</option>
                                        <option>Ocean</option>
                                        <option>Train</option>
                                        <option>Air</option>
                                        <option>Intermodal</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Transport Type</label>
                                    <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                        <option>FTL</option>
                                        <option>LTL</option>
                                        <option>Parcel</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Digital enablers</label>
                                    <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                        <option>Internet of things</option>
                                        <option>Analitics & Big data</option>
                                        <option>Cloud</option>
                                        <option>Automation</option>
                                        <option>Artificial Intelligence</option>
                                        <option>Machine learning</option>
                                        <option>Mobility</option>
                                        <option>Stakeholders comunity</option>
                                        <option>Block chain</option>
                                        <option>Others</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Link to your website</label>
                                    <input class="form-control" id="exampleInputText1" placeholder="Enter Contact"
                                        type="text">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText1">Upload any extra files</label>

                                    <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                        name="exampleDropzone">
                                    </form>
                                </div>


                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('vendor.solutions')}}"><i class="btn-icon-prepend"
                                            data-feather="check-square"></i>Save</a>
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

