{{--
    Shows all the $questions, each with it's corresponding type
    --}}

@props(['questions', 'class', 'disabled', 'required', 'fileUploadRoute', 'skipQuestionsInVendor'])

@php
    $skipQuestionsInVendor = $skipQuestionsInVendor ?? false;

    //$questions = $questions ?? array();
    $questions = $questions->filter(function($question) use ($skipQuestionsInVendor){
        if(!$skipQuestionsInVendor) return true;

        return $question->canVendorSee ?? true;
    });
@endphp

@foreach ($questions as $question)
    @switch($question->type)
        @case('text')
            <div class="form-group questionDiv {{$class}} practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <label>{{$question->label}}{{$question->required || $required  ? '*' : ''}}</label>
                <input
                    {{$required ? 'required' : ''}}
                    {{$question->required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="form-control"
                    type="text"
                    data-changing="{{$question->id}}"
                    value="{{$question->response}}"
                    placeholder="{{$question->placeholder}}"
                    id="useCaseQuestion{{$question->id}}">
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
            </div>
            @break
        @case('textarea')
            <div class="form-group questionDiv {{$class}} practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <label>{{$question->label}}{{$question->required || $required ? '*' : ''}}</label>
                <textarea
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    rows="14"
                    class="form-control"
                    data-changing="{{$question->id}}"
                    {{$question->required ? 'required' : ''}}
                    placeholder="{{$question->placeholder}}"
                    id="useCaseQuestion{{$question->id}}"
                >{{$question->response}}</textarea>
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
            </div>
            @break
        @case('selectSingle')
            <div class="form-group questionDiv {{$class}} practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <label>{{$question->label}}{{$question->required || $required ? '*' : ''}}</label>
                <select
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="form-control"
                    data-changing="{{$question->id}}"
                    {{$question->required ? 'required' : ''}}
                    id="useCaseQuestion{{$question->id}}"
                >
                    <option @if($question->response == '') selected @endif disabled="">{{$question->placeholder}}</option>

                    @if ($question->presetOption == 'countries')
                        <x-options.countries :selected="[$question->response]" />
                    @else
                        @foreach ($question->optionList() as $option)
                        <option value="{{$option}}" @if($question->response == $option) selected @endif>{{$option}}</option>
                        @endforeach
                    @endif
                </select>
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
            </div>
            @break
        @case('selectMultiple')
            <div class="form-group questionDiv {{$class}} practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <label>{{$question->label}}{{$question->required || $required ? '*' : ''}}</label>
                <select
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="js-example-basic-multiple w-100"
                    data-changing="{{$question->id}}"
                    multiple="multiple"
                    {{$question->required ? 'required' : ''}}
                    id="useCaseQuestion{{$question->id}}"
                >
                    @php
                    $selectedOptions = json_decode($question->response ?? '[]');
                    @endphp

                    @if ($question->presetOption == 'countries')
                        <x-options.countries :selected="$selectedOptions" />
                    @else
                        @foreach ($question->optionList() as $option)
                        <option value="{{$option}}" {{in_array($option, $selectedOptions) ? 'selected' : ''}}>{{$option}}</option>
                        @endforeach
                    @endif
                </select>
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
            </div>
            @break
        @case('date')
            <div class="questionDiv {{$class}} practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <label>{{$question->label}}{{$question->required || $required ? '*' : ''}}</label>
                <div class="input-group date datepicker" data-initialValue="{{$question->response}}">
                    <input
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    data-changing="{{$question->id}}"
                    value="{{$question->response}}"
                    {{$question->required ? 'required' : ''}}
                    type="text"
                    class="form-control"
                    id="useCaseQuestion{{$question->id}}">
                    <span class="input-group-addon"><i data-feather="calendar"></i></span>
                </div>
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
            </div>
            @break
        @case('number')
            <div class="form-group questionDiv {{$class}} practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <label>{{$question->label}}{{$question->required || $required? '*' : ''}}</label>
                <input
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="form-control"
                    type="number"
                    min="0"
                    onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;"
                    data-changing="{{$question->id}}"
                    {{$question->required ? 'required' : ''}}
                    value="{{$question->response}}"
                    placeholder="{{$question->placeholder}}"
                    id="useCaseQuestion{{$question->id}}">
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
            </div>
            @break
        @case('email')
            <div class="form-group questionDiv {{$class}} emailField practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <label>{{$question->label}}{{$question->required || $required? '*' : ''}}</label>
                <input
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="form-control"
                    type="text"
                    data-changing="{{$question->id}}"
                    min="0"
                    {{$question->required ? 'required' : ''}}
                    value="{{$question->response}}"
                    placeholder="{{$question->placeholder}}"
                    id="useCaseQuestion{{$question->id}}">
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
            </div>
            @break
        @case('percentage')
            <div class="form-group questionDiv {{$class}} practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <label>{{$question->label}}{{$question->required || $required? '*' : ''}} (%)</label>
                <input
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="form-control"
                    type="number"
                    min="0"
                    onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;"
                    onblur="this.value = this.value > 100 ? 100 : this.value"
                    data-changing="{{$question->id}}"
                    {{$question->required ? 'required' : ''}}
                    value="{{$question->response}}"
                    placeholder="{{$question->placeholder}}"
                    id="useCaseQuestion{{$question->id}}">
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
            </div>
            @break
        @case('file')

{{--        <div class="card-body">--}}
{{--            <div style="float: left;">--}}
{{--                <h3>Project conclusions</h3>--}}
{{--            </div>--}}

{{--            <br><br>--}}

{{--            <p class="welcome_text extra-top-15px">--}}
{{--                {{nova_get_setting('accenture_projectConclusions_title') ?? ''}}--}}
{{--            </p>--}}
{{--            <br>--}}
{{--            <br>--}}

{{--            <x-folderFilePreview :folder="$project->conclusionsFolder" />--}}

{{--            <div class="row">--}}
{{--                <div class="col-12 col-md-12 col-xl-12">--}}
{{--                    <x-folderFileUploader :folder="$project->conclusionsFolder" :disabled="$project->currentPhase == 'old'" :timeout="1000"/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
            <div class="form-group questionDiv practice{{$question->practice->id ?? ''}}" data-practice="{{$question->practice->id ?? ''}}">
                <x-useCaseQuestionFileUploader
                    :question="$question"
                    {{-- TODO Set the correct file uplaod route everywhere and remove this default --}}
                    :fileUploadRoute="$fileUploadRoute ?? '/useCaseQuestionResponse/uploadFile'"
                    :disabled="$disabled"
                    :required="$required"
                />
                <p id="errorrQuestion{{$question->id}}" style="color: darkred;">Error saving the response of this question.</p>
                @if (!$disabled)
                    <p style="font-size: 12px">
                        Do not include personal, sensitive data, personal data relating to criminal convictions and offences or financial data
                        in this free form text field or upload screen shots containing personal data, unless you are consenting and assuming
                        responsibility for the processing of this personal data (either your personal data or the personal data of others) by
                        Accenture.
                    </p>
                    <br>
                @endif
            </div>
            @break
        @default

    @endswitch
@endforeach
