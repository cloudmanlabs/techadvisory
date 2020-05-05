@extends('accentureViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />


        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectOrals" :project="$project" />

                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Project description</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            The project is about ipsum dolor sit amet, consectetur adipiscing elit.
                                            Donec aliquam ornare sapien, ut dictum nunc pharetra a. Phasellus vehicula
                                            suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque
                                            luctus. ipsum dolor
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
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Session details</h3>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleInputText1">Location</label>
                                        <input type="text" class="form-control" id="exampleInputText1"
                                            placeholder="Location" required>
                                    </div>
                                </div>
                                <br>
                                <label for="exampleFormControlSelect1">From Date</label>
                                <div class="input-group date datepicker" id="datePicker1">
                                    <input type="text" class="form-control"><span class="input-group-addon"><i
                                            data-feather="calendar"></i></span>
                                </div>
                                <br> <br>
                                <label for="exampleFormControlSelect1">To Date</label>
                                <div class="input-group date datepicker" id="datePicker2">
                                    <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                                <br><br><br>

                                <div style="display: flex; justify-content: space-between">
                                    <h3>Oral Status</h3>
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="#">
                                        Save
                                    </a>
                                </div>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-hover" style="text-align: center">
                                        <thead>
                                            <tr class="table-dark">
                                                <th>Vendor name</th>
                                                <th>Vendor segment</th>
                                                <th>Invited to orals</th>
                                                <th>Orals completed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vendors as $vendor)
                                            <tr>
                                                <td>{{$vendor->name}}</td>
                                                <td>{{$vendor->getVendorResponse('vendorSegment', '-')}}</td>
                                                <td>
                                                    <input type="checkbox" name="dfas" id="afs" checked>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="dfas" id="afs">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.projectHome', ['project' => $project])}}">
                                        <i data-feather="arrow-left"></i>
                                        Go back to project
                                    </a>
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

