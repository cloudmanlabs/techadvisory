@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening')" :text="nova_get_setting('video_opening_text')"/>

                <br>
                <br>


                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Complete your profile</h3>
                                <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use the platform. It won't take you more than just a few minutes and you can do it today. Note that, if you do not currently have the info for some specific fields, you can leave them blank and fill up them later.</p>
                                <br>
                                <div id="wizard_vendor_profile_create_here">
                                    <h2>General information</h2>
                                    <section>
                                        <div class="form-group">
                                            <label>Vendor Name</label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                value="{{$vendor->name}}"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label>Vendor contact email</label>
                                            <input
                                                class="form-control"
                                                disabled
                                                value="{{$vendor->name}}"
                                                type="email">
                                        </div>

                                        <br>
                                        <div class="form-group">
                                            <label>Upload your logo</label>
                                            <input id="logoInput" class="file-upload-default" name="img[]" type="file">

                                            <div class="input-group col-xs-12">
                                                <input id="fileNameInput" disabled class="form-control file-upload-info"
                                                    value="{{$vendor->logo ? 'logo.jpg' : 'No file selected'}}" type="text">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">
                                                        <span class="input-group-append"
                                                            id="logoUploadButton">{{$vendor->logo ? 'Replace file' : 'Select file'}}</span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <br>

                                        <x-questionForeach :questions="$generalQuestions" :class="'profileQuestion'" :disabled="false" :required="true" />

                                        <x-folderFileUploader :folder="$vendor->profileFolder" />
                                    </section>

                                    <h2>Economic information</h2>
                                    <section>
                                        <x-questionForeach :questions="$economicQuestions" :class="'profileQuestion'" :disabled="false" :required="true" />
                                    </section>

                                    <h2>Legal information</h2>
                                    <section>
                                        <x-questionForeach :questions="$legalQuestions" :class="'profileQuestion'" :disabled="false" :required="true" />
                                    </section>
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

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function checkIfAllRequiredsInThisPageAreFilled(){
        let array = $('input,textarea,select').filter('[required]:visible').toArray();
        if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        if(checkIfAllRequiredsAreFilled()){
            $('#submitButton').attr('disabled', false)
        } else {
            $('#submitButton').attr('disabled', true)
        }
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
        $("#wizard_vendor_profile_create_here").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            showFinishButtonAlways: false,
            enableFinishButton: false,
        });


        $('.profileQuestion input,.profileQuestion textarea,.profileQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/vendors/profile/changeResponse', {
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
                autoclose: true
            });
            $(this).datepicker('setDate', date);
        });

        $('.file-upload-browse').on('click', function(e) {
            $("#logoInput").trigger('click');
        });

        $("#logoInput").change(function (){
            var fileName = $(this).val().split('\\').pop();;

            $("#fileNameInput").val(fileName);
            $('#logoUploadButton').html('Replace file')


            var formData = new FormData();
            formData.append('image', $(this).get(0).files[0]);
            $.ajax({
                url : "/user/changeLogo",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,
            });

            showSavedToast();
        });

        updateSubmitButton();
    });
</script>
@endsection
