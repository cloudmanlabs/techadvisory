@props(['questions', 'class', 'disabled', 'required', 'fileUploadRoute', 'skipQuestionsInVendor'])

@php
    $skipQuestionsInVendor = $skipQuestionsInVendor ?? false;

    $questions = $questions->filter(function($question) use ($skipQuestionsInVendor){
        if(!$skipQuestionsInVendor) return true;

        return $question->originalQuestion->canVendorSee ?? true;
    });
@endphp

@foreach ($questions as $question)
    @switch($question->originalQuestion->type)
        @case('text')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
                <input
                    {{$required ? 'required' : ''}}
                    {{$question->originalQuestion->required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="form-control"
                    type="text"
                    data-changing="{{$question->id}}"
                    value="{{$question->response}}"
                    placeholder="{{$question->originalQuestion->placeholder}}">
            </div>
            @break
        @case('textarea')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
                <textarea
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    rows="14"
                    class="form-control"
                    data-changing="{{$question->id}}"
                    {{$question->originalQuestion->required ? 'required' : ''}}
                >{{$question->response}}</textarea>
            </div>
            @break
        @case('selectSingle')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
                <select
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="form-control"
                    data-changing="{{$question->id}}"
                    {{$question->originalQuestion->required ? 'required' : ''}}
                    >
                    <option @if($question->response == '') selected @endif disabled="">{{$question->originalQuestion->placeholder}}</option>

                    @if ($question->originalQuestion->presetOption == 'countries')
                        <x-options.countries :selected="[$question->response]" />
                    @else
                        @foreach ($question->originalQuestion->optionList() as $option)
                        <option value="{{$option}}" @if($question->response == $option) selected @endif>{{$option}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @break
        @case('selectMultiple')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
                <select
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="js-example-basic-multiple w-100"
                    data-changing="{{$question->id}}"
                    multiple="multiple"
                    {{$question->originalQuestion->required ? 'required' : ''}}
                    >
                    @php
                    $selectedOptions = json_decode($question->response ?? '[]');
                    @endphp

                    @if ($question->originalQuestion->presetOption == 'countries')
                        <x-options.countries :selected="$selectedOptions" />
                    @else
                        @foreach ($question->originalQuestion->optionList() as $option)
                        <option value="{{$option}}" {{in_array($option, $selectedOptions) ? 'selected' : ''}}>{{$option}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @break
        @case('date')
            <div class="questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
                <div class="input-group date datepicker" data-initialValue="{{$question->response}}">
                    <input
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    data-changing="{{$question->id}}"
                    value="{{$question->response}}"
                    {{$question->originalQuestion->required ? 'required' : ''}}
                    type="text"
                    class="form-control">
                    <span class="input-group-addon"><i data-feather="calendar"></i></span>
                </div>
            </div>
            @break
        @case('number')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
                <input
                    {{$required ? 'required' : ''}}
                    {{$disabled ? 'disabled' : ''}}
                    class="form-control"
                    type="number"
                    data-changing="{{$question->id}}"
                    {{$question->originalQuestion->required ? 'required' : ''}}
                    value="{{$question->response}}"
                    placeholder="{{$question->originalQuestion->placeholder}}">
            </div>
            @break
        @case('file')
            <div class="form-group questionDiv" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-questionFileUploader
                    :question="$question"
                    {{-- TODO Set the correct file uplaod route everywhere and remove this default --}}
                    :fileUploadRoute="$fileUploadRoute ?? '/selectionCriteriaQuestion/uploadFile'"
                    :disabled="$disabled"
                    :required="$required"
                />
            </div>
            @if (!$disabled)
                <p style="font-size: 12px">
                    Do not include personal, sensitive data, personal data relating to criminal convictions and offences or financial data
                    in this free form text field or upload screen shots containing personal data, unless you are consenting and assuming
                    responsibility for the processing of this personal data (either your personal data or the personal data of others) by
                    Accenture.
                </p>
            @endif
            @break
        @default

    @endswitch
@endforeach
