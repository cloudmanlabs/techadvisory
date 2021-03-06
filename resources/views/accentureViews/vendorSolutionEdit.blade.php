@extends('layouts.base')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">
                                    <h3>{{$solution->vendor->name}}'s solution</h3>
                                </div>


                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_vendorSolutionEdit_title') ?? ''}}
                                </p>

                                <br>

                                <div class="form-group">
                                    <label for="solutionName">Solution name*</label>
                                    <input class="form-control"
                                        required
                                        id="solutionName" value="{{$solution->name}}" type="text"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="practiceSelect">SC Capabilities (Practice)*</label>
                                    <select class="form-control" id="practiceSelect" required>
                                        <x-options.practices :selected="$solution->practice->id ?? -1" />
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subpracticeSelect">TMS Capabilities (Subpractice)*</label>
                                    <select
                                        class="js-example-basic-multiple w-100"
                                        id="subpracticeSelect"
                                        multiple="multiple"
                                    >
                                        @php
                                            $select = $solution->subpractices()->pluck('subpractices.id')->toArray();
                                        @endphp
                                        <x-options.subpractices :selected="$select"/>
                                    </select>
                                </div>

                                <x-questionForeach :questions="$questions" :class="'solutionQuestion'" :disabled="false" :required="true" />

                                <x-folderFileUploader :folder="$solution->folder" :timeout="1000" />

                                <div style="float: right; margin-top: 20px;">
                                    <a id="saveButton" class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('accenture.vendorList')}}"><i class="btn-icon-prepend"
                                            data-feather="check-square"></i>Save</a>
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
        let array = $('input,textarea,select').filter('[required]:visible').toArray();
		if(array.length == 0) return true;

        for (let i = 0; i < array.length; i++) {
            if(!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')){
                return false
            }
        }

        return true
    }

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        let fieldsAreEmtpy = !checkIfAllRequiredsAreFilled();
        if(fieldsAreEmtpy){
            $('#saveButton').addClass('disabled')
        } else {
            $('#saveButton').removeClass('disabled')
        }
    }

    var currentPracticeId = {{$solution->practice->id ?? -1}};
    function updateShownQuestionsAccordingToPractice(){
        $('.questionDiv').each(function () {
            let practiceId = $(this).data('practice');

            if(practiceId == currentPracticeId || practiceId == "") {
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

    $(document).ready(function() {
        $('#solutionName').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/vendorSolution/changeName', {
                solution_id: '{{$solution->id}}',
                newName: value
            }).done(function () {
                showSavedToast();
                updateSubmitButton();
            }).fail(handleAjaxError)
        });

        $('#practiceSelect').change(function (e) {
            var value = $(this).val();
            currentPracticeId = value;
            $.post('/accenture/vendorSolution/changePractice', {
                solution_id: '{{$solution->id}}',
                practice_id: value
            }).done(function () {
                showSavedToast();
                updateShownQuestionsAccordingToPractice();
                updateSubmitButton();
                updateShownSubpracticeOptionsAccordingToPractice(true);
            }).fail(handleAjaxError)
        });

        $('#subpracticeSelect').change(function (e) {
            var value = $(this).val();
            if (value && (value.length > 0)) {
              $.post('/accenture/vendorSolution/changeSubpractice', {
                  solution_id: '{{$solution->id}}',
                  subpractices: value
              }).done(function () {
                  showSavedToast();
                  updateSubmitButton();
              }).fail(handleAjaxError)
            }
        });

        $('.solutionQuestion input,.solutionQuestion textarea,.solutionQuestion select')
            .filter(function() {
                return $(this).data('changing') !== undefined
            })
            .change(function () {
                var $input = $(this)
                var value = $input.val();

                if($.isArray(value) && value.length === 0 && $input.attr('multiple') !== undefined) {
                    value = '[]'
                }

                if($input.prop('required') && !value) {
                    return
                }

                $.post('/accenture/vendorSolution/changeResponse', {
                    changing: $input.data('changing'),
                    value: value
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                }).fail(handleAjaxError)
            });

        $('.datepicker').each(function(){
            var date = new Date($(this).data('initialvalue'));

            $(this).datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                autoclose: true,
                startDate: "+0d"
            });
            $(this).datepicker('setDate', date);
        });

        updateSubmitButton();
        updateShownQuestionsAccordingToPractice();
        updateShownSubpracticeOptionsAccordingToPractice(false);
    });
</script>
@endsection
