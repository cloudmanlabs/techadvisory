@extends('accentureViews.layouts.forms')

@section('content')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="sections" />


    <div class="page-wrapper">
        <div class="page-content">

            <x-accenture.projectNavbar section="projectOrals" :project="$project" />

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Session details</h3>

                            <div class="form-group">
                                <div class="form-group">
                                    <label for="exampleInputText1">Location</label>
                                    <input
                                        id="location"
                                        type="text"
                                        class="form-control"
                                        placeholder="Location"
                                        value="{{$project->oralsLocation}}"
                                        required>
                                </div>
                            </div>

                            <br>

                            <label for="exampleFormControlSelect1">From Date</label>
                            <div class="input-group date datepicker" id="datePicker1" data-initialvalue="{{$project->oralsFromDate}}">
                                <input
                                    id="fromDate"
                                    type="text"
                                    class="form-control"
                                    value="{{$project->oralsFromDate}}"
                                >
                                <span class="input-group-addon">
                                    <i data-feather="calendar"></i>
                                </span>
                            </div>

                            <br> <br>

                            <label for="exampleFormControlSelect1">To Date</label>
                            <div class="input-group date datepicker" id="datePicker2" data-initialvalue="{{$project->oralsToDate}}">
                                <input
                                    id="toDate"
                                    type="text"
                                    class="form-control"
                                    value="{{$project->oralsToDate}}"
                                >
                                <span class="input-group-addon">
                                    <i data-feather="calendar"></i>
                                </span>
                            </div>

                            <br><br><br>

                            <div style="display: flex; justify-content: space-between">
                                <h3>Oral Status</h3>
                                <a class="btn btn-primary btn-lg btn-icon-text" id="saveButton" href="#">
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
                                        @foreach ($applications as $application)
                                        <tr>
                                            <td>{{$application->vendor->name}}</td>
                                            <td>{{$application->vendor->getVendorResponse('vendorSegment', '-')}}</td>
                                            <td>
                                                <input
                                                    type="checkbox"
                                                    class="invitedToOrals"
                                                    data-changing="{{$application->id}}"
                                                    {{$application->invitedToOrals ? 'checked' : ''}}
                                                >
                                            </td>
                                            <td>
                                                <input
                                                    type="checkbox"
                                                    class="oralsCompleted"
                                                    data-changing="{{$application->id}}"
                                                    {{$application->oralsCompleted ? 'checked' : ''}}
                                                >
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div style="float: right; margin-top: 20px;">
                                <a class="btn btn-primary btn-lg btn-icon-text"
                                    href="{{route('accenture.projectHome', ['project' => $project])}}">
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

    .select2-results__options .select2-results__option[aria-disabled=true] {
        display: none;
    }
</style>
@endsection


@section('scripts')
@parent
<script>
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

    $(document).ready(function() {
        $('#location')
            .change(function (e) {
                var value = $(this).val();
                $.post('/accenture/orals/changeLocation', {
                    project_id: {{$project->id}},
                    location: value
                })

                showSavedToast();
            });

        $('#fromDate')
            .change(function (e) {
                var value = $(this).val();
                $.post('/accenture/orals/changeFromDate', {
                    project_id: {{$project->id}},
                    value: value
                })

                showSavedToast();
            });

        $('#toDate')
            .change(function (e) {
                var value = $(this).val();
                $.post('/accenture/orals/changeToDate', {
                    project_id: {{$project->id}},
                    value: value
                })

                showSavedToast();
            });

        $('.invitedToOrals')
            .change(function (e) {
                $.post('/accenture/orals/changeInvitedToOrals', {
                    changing: $(this).data('changing'),
                    value: $(this).prop("checked")
                })

                showSavedToast();
            });

        $('.oralsCompleted')
            .change(function (e) {
                $.post('/accenture/orals/changeOralsCompleted', {
                    changing: $(this).data('changing'),
                    value: $(this).prop("checked")
                })

                showSavedToast();
            });

        $('.datepicker').each(function(){
            var date = new Date($(this).data('initialvalue'));

            $(this).datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $(this).datepicker('setDate', date);
        });

        $('#saveButton').click(function(e){
            e.preventDefault();

            showSavedToast()
        })
    });
</script>
@endsection
