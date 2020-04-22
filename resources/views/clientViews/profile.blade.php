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

                <x-video :src="nova_get_setting('client_Profile')" />

                <br>
                <br>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display:flex; justify-content: space-between">
                                    <h3>View your profile</h3>
                                    {{-- <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.profileEdit')}}">Edit</a> --}}
                                </div>

                                <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use the platform. It won't take you more than just a few minutes and you can do it today. Note that, if you do not currently have the info for some specific fields, you can leave them blank and fill up them later.</p>
                                <br>
                                <br>


                                <div class="form-group">
                                    <label for="exampleInputText1">Client name</label>
                                    <input class="form-control" id="exampleInputText1" disabled value="{{$client->name}}" type="text">
                                </div>

                                <br>
                                <div class="form-group">
                                    <label>Logo</label> <input class="file-upload-default" name="img[]" type="file">

                                    <img src="{{url($client->logo ? ('/storage/' . $client->logo) : '/assets/images/user.png')}}" alt="" style="max-height: 5rem">
                                </div>
                                <br>

                                @foreach ($questions as $question)
                                    @switch($question->original->type)
                                        @case('text')
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                <input
                                                    disabled
                                                    class="form-control"
                                                    type="text"
                                                    data-changing="{{$question->id}}"
                                                    {{$question->original->required ? 'required' : ''}}
                                                    value="{{$question->response}}"
                                                    placeholder="{{$question->original->placeholder}}">
                                            </div>
                                            @break
                                        @case('textarea')
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                <textarea
                                                    disabled
                                                    rows="14"
                                                    class="form-control"
                                                    data-changing="{{$question->id}}"
                                                    {{$question->original->required ? 'required' : ''}}
                                                >{{$question->response}}</textarea>
                                            </div>
                                            @break
                                        @case('selectSingle')
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                <select
                                                    class="form-control"
                                                    data-changing="{{$question->id}}"
                                                    {{$question->original->required ? 'required' : ''}}
                                                    disabled
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
                                            </div>
                                            @break
                                        @case('selectMultiple')
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                <select class="js-example-basic-multiple w-100"
                                                    data-changing="{{$question->id}}"
                                                    multiple="multiple"
                                                    {{$question->original->required ? 'required' : ''}}
                                                    disabled
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
                                                <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                <div class="input-group date datepicker" data-initialValue="{{$question->response}}">
                                                    <input
                                                        disabled
                                                        data-changing="{{$question->id}}"
                                                        value="{{$question->response}}"
                                                        {{$question->original->required ? 'required' : ''}}
                                                        type="text"
                                                        class="form-control">
                                                    <span class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                            @break
                                        @case('number')
                                            <div class="form-group questionDiv profileQuestion" data-practice="{{$question->original->practice->id ?? ''}}">
                                                <label>{{$question->original->label}}{{$question->original->required ? '*' : ''}}</label>
                                                <input
                                                    disabled
                                                    class="form-control"
                                                    type="number"
                                                    data-changing="{{$question->id}}"
                                                    {{$question->original->required ? 'required' : ''}}
                                                    value="{{$question->response}}"
                                                    placeholder="{{$question->original->placeholder}}">
                                            </div>
                                            @break
                                        @default

                                    @endswitch
                                @endforeach

                                <x-folderFileUploader :folder="$client->profileFolder" :disabled="true" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection


@section('scripts')
@parent
    <script src="{{url('assets/js/select2.js')}}"></script>
@endsection
