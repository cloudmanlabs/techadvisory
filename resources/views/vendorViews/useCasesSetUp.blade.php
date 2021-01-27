@extends('vendorViews.layouts.forms')

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
                                    <h2>Use Cases</h2>
                                    <section>
                                        <div class="row">
                                            <aside class="col-2">
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
                                            <div class="col-8 border-left flex-col">
                                                <h3>Use case</h3>
                                                <div class="form-area">
                                                    <h4>Use case Content</h4>
                                                    <br>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label for="useCaseName">Name</label>
                                                            </div>
                                                            <div class="col-12">
                                                                <h6>Name of the use case.</h6>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label for="useCaseDescription">Description</label>
                                                            </div>
                                                            <div class="col-12">
                                                                <h6>Description of this use case.</h6>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <label>Questions</label>
                                                        @foreach ($useCaseQuestions as $question)
                                                            <h6 class="questionDiv practice{{$question->practice->id ?? ''}}" style="margin-bottom: 1rem">
                                                                {{$question->label}}
                                                            </h6>
                                                        @endforeach
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
            margin-top: 25px;
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
            disableQuestionsByPractice();
        });
    </script>
@endsection
