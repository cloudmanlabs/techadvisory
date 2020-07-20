@props(['questions', 'class', 'disabled', 'required'])

@foreach ($questions as $question)
    @switch($question->originalQuestion->type)
        @case('text')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
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
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('textarea')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
                    <textarea
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        rows="14"
                        class="form-control"
                        data-changing="{{$question->id}}"
                        {{$question->originalQuestion->required ? 'required' : ''}}
                    >{{$question->response}}</textarea>
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('selectSingle')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
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
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('selectMultiple')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
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
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('date')
            <div class="questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
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
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('email')
            <div class="form-group questionDiv {{$class}} emailField" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required || $required? '*' : ''}}</label>
                    <input
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        class="form-control"
                        type="text"
                        data-changing="{{$question->id}}"
                        min="0"
                        {{$question->originalQuestion->required ? 'required' : ''}}
                        value="{{$question->response}}"
                        placeholder="{{$question->originalQuestion->placeholder}}">
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('percentage')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required || $required? '*' : ''}} (%)</label>
                    <input
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        class="form-control"
                        type="number"
                        min="0"
                        onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;"
                        onblur="this.value = this.value > 100 ? 100 : this.value"
                        data-changing="{{$question->id}}"
                        {{$question->originalQuestion->required ? 'required' : ''}}
                        value="{{$question->response}}"
                        placeholder="{{$question->originalQuestion->placeholder}}">
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @case('number')
            <div class="form-group questionDiv {{$class}}" data-practice="{{$question->originalQuestion->practice->id ?? ''}}">
                <x-accenture.shouldShowQuestion :changing="$question->id" :shouldShow="$question->shouldShow">
                    <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
                    <input
                        {{$required ? 'required' : ''}}
                        {{$disabled ? 'disabled' : ''}}
                        class="form-control"
                        type="number"
                        min="0"
                        {{-- oninput="this.value = this.value.replaceAll(/[^0-9]/g, '')" --}}
                        onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;"
                        data-changing="{{$question->id}}"
                        {{$question->originalQuestion->required ? 'required' : ''}}
                        value="{{$question->response}}"
                        placeholder="{{$question->originalQuestion->placeholder}}">
                </x-accenture.shouldShowQuestion>
            </div>
            @break
        @default

    @endswitch
@endforeach
