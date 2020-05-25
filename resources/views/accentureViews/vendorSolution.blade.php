@extends('accentureViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">
                                    <h3>{{$solution->vendor->name}}'s solution</h3>
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('accenture.vendorSolutionEdit', ['solution' => $solution])}}">Edit</a>
                                </div>


                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_vendorSolution_title') ?? ''}}
                                </p>

                                <br>

                                <div class="form-group">
                                    <label for="solutionName">Solution name*</label>
                                    <input class="form-control"
                                        disabled
                                        id="solutionName" value="{{$solution->name}}" type="text">
                                </div>

                                <x-questionForeach :questions="$questions" :class="'solutionQuestion'" :disabled="true" :required="false" />

                                <x-folderFileUploader :folder="$solution->folder" :disabled="true" :timeout="1000"/>

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
