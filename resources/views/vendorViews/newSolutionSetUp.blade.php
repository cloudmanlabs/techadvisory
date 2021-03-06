@extends('layouts.base')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="solutions"/>

        <div class="page-wrapper">
            <div class="page-content">
                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Add a solution</h3>

                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendro_newSolution_addSolution') ?? ''}}
                                </p>

                                <br>
                                <br>

                                <div class="form-group">
                                    <label for="solutionName">Solution name*</label>
                                    <input class="form-control"
                                           id="solutionName" value="{{$firstTime ? '' : $solution->name}}" type="text"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="practiceSelect">SC Capabilities (Practice)*</label>
                                    <select class="form-control" id="practiceSelect" required>
                                        <x-options.practices :selected="$solution->practice->id ?? -1"/>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subpracticeSelect">TMS Capabilities (Subpractice)*</label>
                                    <select
                                        class="js-example-basic-multiple w-100"
                                        id="subpracticeSelect"
                                        multiple="multiple"
                                        required
                                    >
                                        @php
                                            $select = $solution->subpractices()->pluck('subpractices.id')->toArray();
                                        @endphp
                                        <x-options.subpractices :selected="$select"/>
                                    </select>
                                </div>

                                <x-questionForeach :questions="$questions" :class="'solutionQuestion'" :disabled="false"
                                                   :required="false"/>

                                <x-folderFileUploader :folder="$solution->folder" :timeout="1000"/>

                                <div style="float: right; margin-top: 20px;">
                                    <a id="saveAndAnother" class="btn btn-primary btn-lg btn-icon-text disabled"
                                       href="{{route('vendor.createSolution')}}"
                                       onclick="event.preventDefault(); document.getElementById('save-and-create-solution-form').submit();">
                                        <i class="btn-icon-prepend" data-feather="check-square"></i> Save and add
                                        another
                                    </a>
                                    <form id="save-and-create-solution-form"
                                          action="{{ route('vendor.createSolution') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                    <a id="saveAndDashboard" class="btn btn-primary btn-lg btn-icon-text disabled"
                                       href="{{route('vendor.solutions')}}"><i
                                            class="btn-icon-prepend" data-feather="check-square"></i> Save and go to
                                        Dashboard</a>
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
        select.form-control {
            color: #495057;
        }

        .select2-results__options .select2-results__option[aria-disabled=true] {
            display: none;
        }

        a.disabled {
            pointer-events: none;
        }
    </style>
@endsection


@section('scripts')
    @parent
    <script>
        window.history.pushState({}, document.title, window.location.pathname);

        jQuery.expr[':'].hasValue = function (el, index, match) {
            return el.value != "";
        };

        /**
         *  Returns false if any field is empty
         */
        function checkIfAllRequiredsAreFilled() {
            let array = $('input,textarea,select').filter('[required]').toArray();
            if (array.length == 0) return true;

            for (let i = 0; i < array.length; i++) {
                if (!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')) {
                    return false;
                }
            }

            return true
        }

        function updateSubmitButton() {
            // If we filled all the fields, remove the disabled from the button.
            let fieldsAreEmtpy = !checkIfAllRequiredsAreFilled();
            if (fieldsAreEmtpy) {
                $('#saveAndAnother').addClass('disabled')
                $('#saveAndDashboard').addClass('disabled')
            } else {
                $('#saveAndAnother').removeClass('disabled')
                $('#saveAndDashboard').removeClass('disabled')
            }
        }

        var currentPracticeId = {{$solution->practice->id ?? -1}};

        function updateShownQuestionsAccordingToPractice() {
            $('.questionDiv').each(function () {
                let practiceId = $(this).data('practice');

                if (practiceId == currentPracticeId || practiceId == "") {
                    $(this).css('display', 'block')
                } else {
                    $(this).css('display', 'none')
                }
            });
        }

        function updateShownSubpracticeOptionsAccordingToPractice(removeCurrentSelection) {
            // Deselect the current subpractice
            if (removeCurrentSelection) {
                $('#subpracticeSelect').val([]);
                $('#subpracticeSelect').trigger('change');
            }

            $('#subpracticeSelect').children().each(function () {
                let practiceId = $(this).data('practiceid');

                if (practiceId == currentPracticeId) {
                    $(this).attr('disabled', false);
                } else {
                    $(this).attr('disabled', true);
                }
            })
        }

        $(document).ready(function () {
            $('#solutionName').change(function (e) {
                var value = $(this).val();
                $.post('/vendors/solution/changeName', {
                    solution_id: '{{$solution->id}}',
                    newName: value
                }).done(function () {
                    updateSubmitButton();
                    showSavedToast();
                }).fail(handleAjaxError)
            });


            $('#practiceSelect').change(function (e) {
                var value = $(this).val();
                currentPracticeId = value;
                $.post('/vendors/solution/changePractice', {
                    solution_id: '{{$solution->id}}',
                    practice_id: value
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                    updateShownQuestionsAccordingToPractice();
                    updateShownSubpracticeOptionsAccordingToPractice(true);
                }).fail(handleAjaxError)
            });

            $('#subpracticeSelect').change(function (e) {
                var value = $(this).val();
                if (value && (value.length > 0)) {
                  $.post('/vendors/solution/changeSubpractice', {
                      solution_id: '{{$solution->id}}',
                      subpractices: value
                  }).done(function () {
                      showSavedToast();
                      updateSubmitButton();
                  }).fail(handleAjaxError)
                }
            });

            $('.solutionQuestion input,.solutionQuestion textarea,.solutionQuestion select')
                .filter(function (el) {
                    return $(this).data('changing') !== undefined
                })
                .change(function (e) {
                    var value = $(this).val();
                    if ($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined) {
                        value = '[]'
                    }

                    $.post('/vendors/solution/changeResponse', {
                        changing: $(this).data('changing'),
                        value: value
                    }).done(function () {
                        updateSubmitButton();
                        showSavedToast();
                    }).fail(handleAjaxError)
                });

            $('.datepicker').each(function () {
                var date = new Date($(this).data('initialvalue'));

                $(this).datepicker({
                    format: "mm/dd/yyyy",
                    todayHighlight: true,
                    autoclose: true,
                    startDate: "+0d"
                });
                $(this).datepicker('setDate', date);
            });

            updateSubmitButton()
            updateShownQuestionsAccordingToPractice();
            updateShownSubpracticeOptionsAccordingToPractice(false);
        });
    </script>
@endsection
