@extends('vendorViews.layouts.forms')

@php
    $useCaseId = ($currentUseCase ?? null) ?$currentUseCase->id : null;
@endphp

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects"/>

        <div class="page-wrapper">
            <div class="page-content">
                @if ($project->currentPhase === 'open')
                <x-vendor.projectNavbar section="useCasesSetUp" :project="$project"/>
                <br>
                @endif
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @if($project->useCasesPhase === 'evaluation')
                                    <h3>Use Cases Evaluation</h3>
                                @else
                                    <h3>Use Cases Set up</h3>
                                @endif
                                <br>
                                <div>
                                    <section>
                                        <div class="row">
                                            <aside class="col-3">
                                                <div id="subwizard_here">
                                                    <ul role="tablist">
                                                        @foreach ($useCases as $key=>$useCase)
                                                            <li
                                                                @if((($currentUseCase ?? null) && $currentUseCase->id === $useCase->id) || ($project->useCasesPhase === 'evaluation' && $key === 0 && $currentUseCase->id === 1))
                                                                class="active"
                                                                @else
                                                                class="use_cases"
                                                                @endif
                                                                >
                                                                <a href="{{route('vendor.applicationUseCasesSetUp', ['project' => $project, 'useCase' => $useCase->id])}}">
                                                                    {{$useCase->name}}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </aside>
                                            <div class="col-9 border-left flex-col">
                                                <div class="form-area
                                                    @if($project->useCasesPhase === 'evaluation')
                                                    area-evaluation
                                                    @endif
                                                    ">
                                                    <h4>Use case Content</h4>
                                                    <br>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="useCaseName">Name*</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <input
                                                                    type="text" class="form-control"
                                                                    id="useCaseName"
                                                                    data-changing="name"
                                                                    placeholder="Use case name"
                                                                    required
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="useCaseDescription">Description*</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <textarea
                                                                    class="form-control"
                                                                    id="useCaseDescription"
                                                                    placeholder="Add description"
                                                                    rows="5"
                                                                    required
                                                                    disabled>
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <x-useCaseQuestionForeach
                                                            :questions="$useCaseQuestions" :class="'useCaseQuestion'"
                                                            :disabled="true" :required="false"
                                                            :useCaseId="$useCaseId"
                                                        />
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <x-footer/>
        </div>
    </div>
@endsection

@section('head')
    @parent

    <style>

        .input-group input {
            border-right: none!important;
            padding-right: 0!important;
            padding-left: 0.5rem!important;
        }

        textarea {
            display: block!important;
            border: 1px solid #ccc!important;
        }

        textarea:focus, textarea:focus-visible, textarea:focus-within {
            display: block!important;
            border: 1px solid #ccc!important;
        }

        select.form-control {
            color: #495057;
        }

        .select2-results__options [aria-disabled=true] {
            display: none;
        }

        #subwizard_here ul > li {
            display: block;
        }

        .form-area {
            background-color: #eee;
            border-radius: 5px;
            padding: 20px;
            /*margin-top: 25px;*/
        }

        .area-evaluation {
            background-color: #f2f4f8;;
        }

        #summary i {
            font-size: 25px;
            padding: 15px;
        }

        #summary .fa-check-circle {
            font-size: 25px;
            color: forestgreen;
        }

        #summary .fa-times-circle {
            font-size: 25px;
            color: red;
        }

        button {
            font-size: 15px;
        }

        b {
            font-size: 15px;
        }

        table button {
            font-size: 15px;
        }

        #subwizard_here li.active {
            background: #7a00c3;
            color: #ffffff;
            border-radius: 3px;
            padding: .4rem 1rem;
            margin-bottom: 5px;
            width: 100%;
        }

        #subwizard_here li.use_cases {
            background: #38005a;
            color: #ffffff;
            border-radius: 3px;
            padding: .4rem 1rem;
            margin-bottom: 5px;
            width: 100%;
        }

        #subwizard_here li.use_cases a, #subwizard_here li.active a {
            text-decoration: inherit;
            color: inherit;
        }

        .valuePadding input {
            border: none;
            padding:0px;
            outline: none;
        }

    </style>
    <link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
@endsection


@section('scripts')
    @parent
    <script>
        // Removes the get params cause I'm sure they'll share the url with the get param and then they won't see the name and they will think it's a bug
        // and I'll get angry that this is the best implementation I could think of and then I'll get angry that they're dumb and lazy and don't want to have to
        // remove a placeholder name cause ofc that's too much work
        // I'm not mad :)
        window.history.pushState({}, document.title, window.location.pathname);

        jQuery.expr[':'].hasValue = function (el, index, match) {
            return el.value != "";
        };

        function disableQuestionsByPractice() {
            var practiceToShow = 'practice' + '{{$project->practice_id}}';
            var array = $('.questionDiv');
            for (let i = 0; i < array.length; i++) {
                if($(array[i]).hasClass(practiceToShow)){
                    $(array[i]).show();
                } else {
                    $(array[i]).hide();
                }
            }
        }

        $(document).ready(function () {

            $(".js-example-basic-single").select2();
            $(".js-example-basic-multiple").select2();

            disableQuestionsByPractice();
            @if($currentUseCase ?? null)
            $('#useCaseName').val("{{$currentUseCase->name}}")
            $('#useCaseDescription').val("{{$currentUseCase->description}}")
            @foreach($useCaseResponses as $useCaseResponse)
            var element{{$useCaseResponse->use_case_questions_id}} = document.getElementById('useCaseQuestion{{$useCaseResponse->use_case_questions_id}}');
            if (element{{$useCaseResponse->use_case_questions_id}}){
                switch (element{{$useCaseResponse->use_case_questions_id}}.tagName.toLowerCase()) {
                    case 'input':
                        switch ($('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').attr('type').toLowerCase()) {
                            case 'text':
                                $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseResponse->response}}"))
                                break;
                            case 'number':
                                $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val(parseInt('{{$useCaseResponse->response}}', 10))
                                break;
                        }
                        break;
                    case 'select':
                        if($('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').hasClass('js-example-basic-multiple')) {
                            $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseResponse->response}}").split(","))
                            $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').select2().trigger('change')
                        } else {
                            $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val('{{$useCaseResponse->response}}')
                        }
                        break;
                    case 'textarea':
                        $('#useCaseQuestion{{$useCaseResponse->use_case_questions_id}}').val(decodeURIComponent("{{$useCaseResponse->response}}"))
                        break;
                }
            }
            @endforeach
            @endif
            @foreach ($useCaseQuestions as $question)
            $('#errorrQuestion' + '{{$question->id}}').hide();
            @endforeach
        });
    </script>
@endsection
