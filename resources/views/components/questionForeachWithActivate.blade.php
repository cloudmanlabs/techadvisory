@props(['questions', 'class', 'disabled', 'required'])

@foreach ($questions as $question)
    @switch($question->original->type)
        @case('text')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->original->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                    <input
                        {{$required ? 'required' : ''}}
                        {{$question->original->required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        class="form-control"
                        type="text"
                        data-changing="{{$question->id}}"
                        value="{{$question->response}}"
                        placeholder="{{$question->original->placeholder}}">
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('textarea')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->original->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                    <textarea
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        rows="14"
                        class="form-control"
                        data-changing="{{$question->id}}"
                        {{$question->original->required ? 'required' : ''}}
                    >{{$question->response}}</textarea>
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('selectSingle')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->original->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                    <select
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        class="form-control"
                        data-changing="{{$question->id}}"
                        {{$question->original->required ? 'required' : ''}}
                        >
                        <option @if($question->response == '') selected @endif disabled="">{{$question->original->placeholder}}</option>

                        @if ($question->original->presetOption == 'countries')
                            <x-options.countries :selected="[$question->response]" />
                        @else
                            @foreach ($question->original->optionList() as $option)
                            <option value="{{$option}}" @if($question->response == $option) selected @endif>{{$option}}</option>
                            @endforeach
                        @endif
                    </select>
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('selectMultiple')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->original->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                    <select
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        class="js-example-basic-multiple w-100"
                        data-changing="{{$question->id}}"
                        multiple="multiple"
                        {{$question->original->required ? 'required' : ''}}
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
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('date')
            <div class="questionDiv {{$class}}" data-practice="{{$question->original->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                    <div class="input-group date datepicker" data-initialValue="{{$question->response}}">
                        <input
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        data-changing="{{$question->id}}"
                        value="{{$question->response}}"
                        {{$question->original->required ? 'required' : ''}}
                        type="text"
                        class="form-control">
                        <span class="input-group-addon"><i data-feather="calendar"></i></span>
                    </div>
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('number')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->original->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                    <input
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        class="form-control"
                        type="number"
                        data-changing="{{$question->id}}"
                        {{$question->original->required ? 'required' : ''}}
                        value="{{$question->response}}"
                        placeholder="{{$question->original->placeholder}}">
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @default

    @endswitch
@endforeach
