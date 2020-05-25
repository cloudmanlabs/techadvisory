@extends('clientViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="sections" />


        <div class="page-wrapper">
            <div class="page-content">
                <x-client.projectNavbar section="projectOrals" :project="$project" />

                <br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Session details</h3>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleInputText1">Location</label>
                                        <input value="{{$project->oralsLocation}}" type="text" class="form-control" id="exampleInputText1"
                                            value="Barcelona" disabled>
                                    </div>
                                </div>
                                <br> <br>
                                <label for="exampleFormControlSelect1">From Date</label>
                                <div class="input-group date datepicker" id="datePicker1" data-initialvalue="{{$project->oralsFromDate}}">
                                    <input type="text" class="form-control" disabled value="{{$project->oralsFromDate}}">
                                    <span class="input-group-addon">
                                        <i data-feather="calendar"></i>
                                    </span>
                                </div>
                                <br> <br>
                                <label for="exampleFormControlSelect1">To Date</label>
                                <div class="input-group date datepicker" id="datePicker2" data-initialvalue="{{$project->oralsToDate}}">
                                    <input type="text" class="form-control" disabled value="{{$project->oralsToDate}}">
                                    <span class="input-group-addon">
                                        <i data-feather="calendar"></i>
                                    </span>
                                </div>
                                <br><br><br>

                                <h3>Oral Status</h3>

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
                                            @foreach ($applications as $application)
                                            <tr>
                                                <td>{{$application->vendor->name}}</td>
                                                <td>{{$application->vendor->getVendorResponse('vendorSegment', '-')}}</td>
                                                <td>
                                                    <input disabled type="checkbox" class="invitedToOrals"
                                                        {{$application->invitedToOrals ? 'checked' : ''}}>
                                                </td>
                                                <td>
                                                    <input disabled type="checkbox" class="oralsCompleted"
                                                        {{$application->oralsCompleted ? 'checked' : ''}}>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.projectHome', ['project' => $project])}}">
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
<script>
    $(document).ready(function() {
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

