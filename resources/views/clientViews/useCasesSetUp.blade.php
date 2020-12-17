@extends('accentureViews.layouts.forms')
@section('head')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
@endsection

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">
                <x-video :src="nova_get_setting('video_newProject_file')"
                         :text="nova_get_setting('video_newProject_text')"/>
                <x-accenture.setUpNavbar section="useCasesSetUp" :project="$project" :isClient="true"/>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Project Set up</h3>
                                <br>
                                @if(!$currentUseCase)
                                    <p>
                                        Use cases should be created before clients can do something here.
                                    </p>
                                @else
                                    <div id="wizard_accenture_useCasesSetUp">
                                        <h2>Use Cases</h2>
                                        <section>
                                            <div class="row">
                                                <aside class="col-2">
                                                    <div id="subwizard_here">
                                                        <ul role="tablist">
                                                            @foreach ($useCases as $useCase)
                                                                <li
                                                                    @if(($currentUseCase ?? null) && $currentUseCase->id == $useCase->id)
                                                                    class="active"
                                                                    @else
                                                                    class="use_cases"
                                                                    @endif
                                                                >
                                                                    <a href="{{route('client.useCasesSetUp', ['project' => $project, 'useCase' => $useCase->id])}}">
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
                                                        <h4>General Info</h4>
                                                        <br>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <label for="useCaseName">Name</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="text" class="form-control"
                                                                           id="useCaseName"
                                                                           data-changing="name"
                                                                           placeholder="Use case name"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <label for="useCaseDescription">Description</label>
                                                                </div>
                                                                <div class="col-6">
                                                                <textarea
                                                                    class="form-control"
                                                                    id="useCaseDescription"
                                                                    placeholder="Add description"
                                                                    rows="5"
                                                                ></textarea>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <label for="useCaseExpectedResults">Expected results</label>
                                                                </div>
                                                                <div class="col-6">
                                                                <textarea
                                                                    class="form-control"
                                                                    id="useCaseExpectedResults"
                                                                    placeholder="Add expected results"
                                                                    rows="5"
                                                                ></textarea>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <label for="processL1">Process L1</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="text" class="form-control"
                                                                           id="processL1"
                                                                           data-changing="processL1"
                                                                           placeholder="Use case Process L1"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <label for="processL2">Process L2</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="text" class="form-control"
                                                                           id="processL2"
                                                                           data-changing="processL2"
                                                                           placeholder="Use case Process L2"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <label for="processL3">Process L3</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="text" class="form-control"
                                                                           id="processL3"
                                                                           data-changing="processL3"
                                                                           placeholder="Use case Process L3"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button id="saveUseCaseButton" class="btn btn-primary btn-right">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </section>

                                        <h2>General Scoring Criteria</h2>
                                        <section>
                                        </section>

                                        <h2>Invited Vendors</h2>
                                        <section>
                                        </section>
                                    </div>
                                @endif
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
        .btn-right {
            float: right;
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

        function checkIfAllRequiredsAreFilled() {
            let array = $('input,textarea,select')
                .filter('[required]')
                .toArray();
            if (array.length == 0) return true;

            for (let i = 0; i < array.length; i++) {
                if (!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')) {
                    console.log(array[i])
                    return false
                }
            }

            return true
        }

        function showSavedToast() {
            $.toast({
                heading: 'Saved!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        }

        function showInvalidFormToast() {
            $.toast({
                heading: 'Fill all required fields!',
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'bottom-right'
            })
        }

        $(document).ready(function () {
            $("#wizard_accenture_useCasesSetUp").steps({
                headerTag: "h2",
                bodyTag: "section",
                forceMoveForward: false,
                showFinishButtonAlways: false,
                enableFinishButton: false,
                enablePagination: false,
                enableAllSteps: true,
                onFinishing: function (event, currentIndex) {
                    // TODO Only let the client submit if all the fields are full
                    window.location.replace("/accenture/home");
                },
                onStepChanged: function (e, c, p) {
                    updateSubmitStep3();
                    for (let i = 0; i < 10; i++) {
                        $('#wizard_accenture_useCasesSetUp-p-' + i).css('display', 'none')
                    }
                    $('#wizard_accenture_useCasesSetUp-p-' + c).css('display', 'block')
                }
            });

            $('#saveUseCaseButton').click(function () {
                if (!checkIfAllRequiredsAreFilled()) {
                    return showInvalidFormToast();
                }

                var body = {
                    @if($currentUseCase ?? null)
                    id: {{$currentUseCase->id}},
                    @endif
                    project_id: {{$project->id}},
                    name: $('#useCaseName').val(),
                    description: $('#useCaseDescription').val(),
                    expected_results: $('#useCaseExpectedResults').val(),
                    processL1: $('#processL1').val(),
                    processL2: $('#processL2').val(),
                    processL3: $('#processL3').val(),
                };

                $.post('/client/newProjectSetUp/saveCaseUse', body)

                showSavedToast();
            });

            $(".js-example-basic-single").select2();
            $(".js-example-basic-multiple").select2();

            @if($currentUseCase ?? null)
            $('#useCaseName').val("{{$currentUseCase->name}}")
            $('#useCaseDescription').val("{{$currentUseCase->description}}")
            $('#useCaseExpectedResults').val("{{$currentUseCase->expected_results}}")
            $('#processL1').val("{{$currentUseCase->processL1}}")
            $('#processL2').val("{{$currentUseCase->processL2}}")
            $('#processL3').val("{{$currentUseCase->processL3}}")
            @endif
        });
    </script>
@endsection
