@extends('clientViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-client.video />

                <br>
                <br>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Complete your profile</h3>


                                <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use the platform. It won't take you more than just a few minutes and you can do it today. Note that, if you do not currently have the info for some specific fields, you can leave them blank and fill up them later.</p>
                                <br>
                                <br>


                                <div class="form-group">
                                    <label for="exampleInputText1">Client name</label>
                                    <input class="form-control" id="exampleInputText1" disabled value="{{$client->name}}" type="text">
                                </div>

                                <br>
                                <div class="form-group">
                                    <label>Upload your logo</label>
                                    <input
                                        id="logoInput"
                                        class="file-upload-default" name="img[]" type="file">

                                    <div class="input-group col-xs-12">
                                        <input
                                            id="fileNameInput"
                                            disabled
                                            class="form-control file-upload-info"
                                            value="{{$client->logo ? 'logo.jpg' : 'No file selected'}}"
                                            type="text">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">
                                                <span class="input-group-append" id="logoUploadButton">{{$client->logo ? 'Replace file' : 'Select file'}}</span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <br>

                                @foreach ($questions as $question)
                                    @switch($question->original->type)
                                        @case('text')
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                            <div class="questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
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

                                <div class="form-group">
                                    <label for="exampleInputText1">Upload any extra files</label>

                                    <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone">
                                    </form>
                                </div>

                                <div style="float: right; margin-top: 20px;">
                                    <form action="{{route('client.profile.submit')}}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-lg btn-icon-text" id="submitButton" type="submit">
                                            <i class="btn-icon-prepend" data-feather="check-square"></i> Save profile
                                        </button>
                                    </form>
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

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        if(checkIfAllRequiredsAreFilled()){
            $('#submitButton').attr('disabled', false)
        } else {
            $('#submitButton').attr('disabled', true)
        }
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
        $('.profileQuestion input,.profileQuestion textarea,.profileQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/client/profile/changeResponse', {
                    changing: $(this).data('changing'),
                    value: value
                })

                showSavedToast();
                updateSubmitButton();
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

        $('.file-upload-browse').on('click', function(e) {
            $("#logoInput").trigger('click');
        });

        $("#logoInput").change(function (){
            var fileName = $(this).val().split('\\').pop();;

            $("#fileNameInput").val(fileName);
            $('#logoUploadButton').html('Replace file')


            var formData = new FormData();
            formData.append('image', $(this).get(0).files[0]);
            $.ajax({
                url : "/user/changeLogo",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,
            });

            showSavedToast();
        });

        updateSubmitButton();
    });
</script>
@endsection
