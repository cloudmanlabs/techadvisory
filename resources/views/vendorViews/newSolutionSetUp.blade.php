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
                                <h3>Add a solution</h3>


                                <p class="welcome_text extra-top-15px">Please add your solutions to complete your
                                    profile and get ready to use the platform. It won't take you more than just a few
                                    minutes and you can do it today. Note that, if you do not currently have the info
                                    for some specific fields, you can leave them blank and fill them up later.</p>
                                <br>
                                <br>


                                <div class="form-group">
                                    <label for="solutionName">Solution name</label>
                                    <input class="form-control"
                                        id="solutionName" value="{{$solution->name}}" type="text">
                                </div>

                                @foreach ($questions as $question)
                                    @switch($question->original->type)
                                        @case('text')
                                            <div class="form-group questionDiv solutionQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}*</label>
                                                <input
                                                    required
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
                                                    required
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
                                                    required
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
                                                    required
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
                                                        required
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
                                                    required
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

                                <x-folderFileUploader :folder="$solution->folder" />

                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('vendor.createSolution')}}"><i class="btn-icon-prepend"
                                            data-feather="check-square"></i> Save and add another</a>
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.solutions')}}"><i
                                            class="btn-icon-prepend" data-feather="check-square"></i> Save and go to
                                        Dashboard</a>
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
    jQuery.expr[':'].hasValue = function(el,index,match) {
        return el.value != "";
    };

    /**
     *  Returns false if any field is empty
     */
    function checkIfAllRequiredsAreFilled(){
        let array = $('input,textarea,select').filter('[required]').toArray();
		if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function checkIfAllRequiredsInThisPageAreFilled(){
        let array = $('input,textarea,select').filter('[required]:visible').toArray();
        if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

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
        $('#solutionName').change(function (e) {
            var value = $(this).val();
            $.post('/vendors/solution/changeName', {
                solution_id: '{{$solution->id}}',
                newName: value
            })

            showSavedToast();
        });

        $('.solutionQuestion input,.solutionQuestion textarea,.solutionQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/vendors/solution/changeResponse', {
                    changing: $(this).data('changing'),
                    value: value
                })

                showSavedToast();
            });

        $(".js-example-basic-single").select2();
        $(".js-example-basic-multiple").select2();

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
