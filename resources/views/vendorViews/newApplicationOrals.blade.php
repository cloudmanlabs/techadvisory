@extends('layouts.base')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-vendor.projectNavbar section="projectOrals" :project="$project" />

                <br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Short Description</h3>
                                <br>
                                <p>
                                    {{ $project->shortDescription() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @if ($application->invitedToOrals)
                                    <h3>Session details</h3>
                                    <p class="welcome_text extra-top-15px">
                                        Congratulations! You have been selected to participate in the orals for
                                        this project! Below you will find the orals location and dates. Get ready!
                                    </p>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputText1">Location</label>
                                            <input type="text" class="form-control" id="exampleInputText1"
                                                value="{{$project->oralsLocation}}" disabled>
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
                                    <br><br>
                                @else
                                    <h3>You haven't been invited to Orals</h3>
                                @endif

                                <br>

                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.newApplication', ['project' => $project])}}">
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
                autoclose: true,
                startDate: "+0d"
            });
            $(this).datepicker('setDate', date);
        });
    });
</script>
@endsection
