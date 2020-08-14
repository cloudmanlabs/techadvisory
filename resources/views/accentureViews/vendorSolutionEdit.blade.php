@extends('accentureViews.layouts.forms')

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

                                <x-questionForeach :questions="$questions" :class="'solutionQuestion'" :disabled="false" :required="true" />

                                <x-folderFileUploader :folder="$solution->folder" :timeout="1000" />

                                <div style="float: right; margin-top: 20px;">
                                    <a id="saveButton" class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('vendor.solutions')}}"><i class="btn-icon-prepend"
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
                console.log(array[i])
                return false
            }
        }

        return true
    }

    function showSavedToast()
    {
        $.toast({
            heading: 'Saved!',
            showHideTransition: 'slide',
            icon: 'success',
            hideAfter: 1000,
            position: 'bottom-right'
        })
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

    $(document).ready(function() {
        $('#solutionName').change(function (e) {
            var value = $(this).val();
            $.post('/accenture/vendorSolution/changeName', {
                solution_id: '{{$solution->id}}',
                newName: value
            })

            showSavedToast();
            updateSubmitButton();
        });

        $('#practiceSelect').change(function (e) {
            var value = $(this).val();
            currentPracticeId = value;
            $.post('/accenture/vendorSolution/changePractice', {
                solution_id: '{{$solution->id}}',
                practice_id: value
            })

            showSavedToast();
            updateShownQuestionsAccordingToPractice();
            updateSubmitButton();
        });

        $('.solutionQuestion input,.solutionQuestion textarea,.solutionQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/accenture/vendorSolution/changeResponse', {
                    changing: $(this).data('changing'),
                    value: value
                })

                showSavedToast();
                updateSubmitButton();
            });

        $(".js-example-basic-single").select2();
        $(".js-example-basic-multiple").select2();

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
    });
</script>
@endsection
