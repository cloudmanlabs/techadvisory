@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="solutions" />

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
                                    <label for="solutionName">Solution name</label>
                                    <input class="form-control"
                                        id="solutionName" value="{{$solution->name}}" type="text">
                                </div>

                                <x-questionForeach :questions="$questions" :class="'solutionQuestion'" :disabled="false" :required="true" />

                                <x-folderFileUploader :folder="$solution->folder" :timeout="1000"/>

                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('vendor.createSolution')}}"><i class="btn-icon-prepend"
                                            data-feather="check-square"></i> Save and add another</a>
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.solutions')}}"><i
                                            class="btn-icon-prepend" data-feather="check-square"></i> Save and go to
                                        Dashboard</a>
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
        let array = $('input,textarea,select').filter('[required]').toArray();
		if(array.length == 0) return true;

        for (let i = 0; i < array.length; i++) {
            if(!$(array[i]).is(':hasValue')){
                console.log(array[i])
                return false
            }
        }

        return true
    }

    function checkIfAllRequiredsInThisPageAreFilled(){
        let array = $('input,textarea,select').filter('[required]:visible').toArray();
        if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
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

    $(document).ready(function() {
        $('#solutionName').change(function (e) {
            var value = $(this).val();
            $.post('/vendors/solution/changeName', {
                solution_id: '{{$solution->id}}',
                newName: value
            })

            showSavedToast();
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

                $.post('/vendors/solution/changeResponse', {
                    changing: $(this).data('changing'),
                    value: value
                })

                showSavedToast();
            });

        $(".js-example-basic-single").select2();
        $(".js-example-basic-multiple").select2();

        $('.datepicker').each(function(){
            var date = new Date($(this).data('initialvalue'));

            $(this).datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $(this).datepicker('setDate', date);
        });

    });
</script>
@endsection
