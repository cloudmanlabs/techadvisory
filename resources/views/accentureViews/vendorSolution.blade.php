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

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">
                                    <h3>{{$solution->vendor->name}}'s solution</h3>
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('accenture.vendorSolutionEdit', ['solution' => $solution])}}">Edit</a>
                                </div>


                                <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use the platform. It won't take you more than just a few minutes and you can do it today. Note that, if you do not currently have the info for some specific fields, you can leave them blank and fill up them later.</p>

                                <br>

                                <div class="form-group">
                                    <label for="solutionName">Solution name*</label>
                                    <input class="form-control"
                                        disabled
                                        id="solutionName" value="{{$solution->name}}" type="text">
                                </div>

                                @foreach ($questions as $question)
                                    @switch($question->original->type)
                                        @case('text')
                                            <div class="form-group questionDiv solutionQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}*</label>
                                                <input
                                                    disabled
                                                    class="form-control"
                                                    type="text"
                                                    data-changing="{{$question->id}}"
                                                    value="{{$question->response}}"
                                                    placeholder="{{$question->original->placeholder}}">
                                            </div>
                                            @break
                                        @case('textarea')
                                            <div class="form-group questionDiv solutionQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}*</label>
                                                <textarea
                                                    disabled
                                                    rows="14"
                                                    class="form-control"
                                                    data-changing="{{$question->id}}"
                                                >{{$question->response}}</textarea>
                                            </div>
                                            @break
                                        @case('selectSingle')
                                            <div class="form-group questionDiv solutionQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}*</label>
                                                <select
                                                    disabled
                                                    class="form-control"
                                                    data-changing="{{$question->id}}"
                                                    >
                                                    <option @if($question->response == '') selected @endif="">{{$question->original->placeholder}}</option>

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
                                            <div class="form-group questionDiv solutionQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}*</label>
                                                <select class="js-example-basic-multiple w-100"
                                                    disabled
                                                    data-changing="{{$question->id}}"
                                                    multiple="multiple"
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
                                            <div class="questionDiv solutionQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}*</label>
                                                <div class="input-group date datepicker" data-initialValue="{{$question->response}}">
                                                    <input
                                                        disabled
                                                        data-changing="{{$question->id}}"
                                                        value="{{$question->response}}"
                                                        type="text"
                                                        class="form-control">
                                                    <span class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                            @break
                                        @case('number')
                                            <div class="form-group questionDiv solutionQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}*</label>
                                                <input
                                                    disabled
                                                    class="form-control"
                                                    type="number"
                                                    data-changing="{{$question->id}}"
                                                    value="{{$question->response}}"
                                                    placeholder="{{$question->original->placeholder}}">
                                            </div>
                                            @break
                                        @default

                                    @endswitch
                                @endforeach

                                <x-folderFileUploader :folder="$solution->folder" :disabled="true" />

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
