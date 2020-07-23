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
                                    <h3>Complete the Profile</h3>
                                    <a id="submitButton" class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('accenture.clientProfileView', ['client' => $client])}}">Save</a>
                                </div>


                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_clientProfileEdit_Title') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div class="form-group">
                                    <label for="clientNameInput">Client company name*</label>
                                    <input class="form-control" id="clientNameInput" value="{{$firstTime ? '' : $client->name}}" type="text" required>
                                </div>

                                <div class="form-group">
                                    <label for="clientEmailInput">Client company contact email*</label>
                                    <input class="form-control" id="clientEmailInput" value="{{$firstTime ? '' : $client->email}}" type="text">
                                </div>

                                @if(!$client->credentials->first())
                                    <div class="form-group">
                                        <label for="clientFirstEmailInput">First user email*</label>
                                        <input class="form-control" id="clientFirstEmailInput" value="{{optional($client->credentials->first())->email}}" type="text"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="clientFirstNameInput">First user name*</label>
                                        <input class="form-control" id="clientFirstNameInput" value="{{optional($client->credentials->first())->name}}"
                                            type="text" required>
                                    </div>

                                    <button class="btn btn-primary btn-lg" id="createFirstCredential">
                                        Send sign up email to first user
                                    </button>
                                @endif

                                <br>
                                <br>
                                <br>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Industry Experience*</label>
                                    <select class="form-control" id="exampleFormControlSelect1" required>
                                        <option selected>
                                            Please select your industry
                                        </option>

                                        <option>
                                            Automative
                                        </option>

                                        <option selected>
                                            Consumer goods & services
                                        </option>

                                        <option>
                                            Industrial Equipement
                                        </option>

                                        <option>
                                            Life Sciences
                                        </option>

                                        <option>
                                            Retail
                                        </option>

                                        <option>
                                            Transport services
                                        </option>

                                        <option>
                                            Travel
                                        </option>

                                        <option>
                                            Chemical
                                        </option>

                                        <option>
                                            Energy
                                        </option>

                                        <option>
                                            Natural Resources
                                        </option>

                                        <option>
                                            Utilities
                                        </option>

                                        <option>
                                            Communications & Media
                                        </option>

                                        <option>
                                            High tech
                                        </option>

                                        <option>
                                            CMT SW&P
                                        </option>

                                        <option>
                                            Health
                                        </option>

                                        <option>
                                            Public Service
                                        </option>

                                        <option>
                                            Banking
                                        </option>

                                        <option>
                                            Capital Markets
                                        </option>

                                        <option>
                                            Insurance
                                        </option>
                                    </select>
                                </div>
                                <br>
                                <x-questionForeach :questions="$questions" :class="'profileQuestion'" :disabled="false" :required="true" />

                                <br>
                                <div class="form-group">
                                    <label>Upload client logo</label>
                                    <input id="logoInput" class="file-upload-default" name="img[]" type="file">

                                    <div class="input-group col-xs-12">
                                        <input id="fileNameInput" disabled class="form-control file-upload-info"
                                            value="{{$client->logo ? 'logo.jpg' : 'No file selected'}}" type="text">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">
                                                <span class="input-group-append"
                                                    id="logoUploadButton">{{$client->logo ? 'Replace file' : 'Select file'}}</span>
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <p style="font-size: 12px">
                                    Do not include personal, sensitive data, personal data relating to criminal convictions and offences or financial data
                                    in this free form text field or upload screen shots containing personal data, unless you are consenting and assuming
                                    responsibility for the processing of this personal data (either your personal data or the personal data of others) by
                                    Accenture.
                                </p>

                                <br>

                                <x-folderFileUploader :folder="$client->profileFolder" :timeout="1000" />

                                <br>
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
    window.history.pushState({}, document.title, window.location.pathname);

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
            if(!$(array[i]).is(':hasValue') || $(array[i]).hasClass('invalid')){
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

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        if(checkIfAllRequiredsAreFilled()){
            $('#submitButton').removeClass('disabled')
        } else {
            $('#submitButton').addClass('disabled')
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
        $('.profileQuestion input,.profileQuestion textarea,.profileQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/accenture/clientProfileEdit/changeResponse', {
                    changing: $(this).data('changing'),
                    value: value
                })

                showSavedToast();
                updateSubmitButton();
            });

        $('#clientNameInput')
            .change(function (e) {
                var value = $(this).val();
                $.post('/accenture/clientProfileEdit/changeName', {
                    client_id: {{$client->id}},
                    value: value
                })

                showSavedToast();
                updateSubmitButton();
            });

        $('#clientEmailInput')
            .change(function (e) {
                var value = $(this).val();
                $.post('/accenture/clientProfileEdit/changeEmail', {
                    client_id: {{$client->id}},
                    value: value
                })

                showSavedToast();
                updateSubmitButton();
            });

        $('#createFirstCredential')
            .click(function (e) {
                var email = $('#clientFirstEmailInput').val();
                var name = $('#clientFirstNameInput').val();
                $.post('/accenture/clientProfileEdit/createFirstCredential', {
                    client_id: {{$client->id}},
                    email,
                    name
                })

                showSavedToast();
                updateSubmitButton();

                $(this).attr('disabled', true);
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

        $('.file-upload-browse').on('click', function(e) {
            $("#logoInput").trigger('click');
        });

        $("#logoInput").change(function (){
            var fileName = $(this).val().split('\\').pop();;

            $("#fileNameInput").val(fileName);
            $('#logoUploadButton').html('Replace file')


            var formData = new FormData();
            formData.append('user_id', '{{$client->id}}')
            formData.append('image', $(this).get(0).files[0]);
            $.ajax({
                url : "/accenture/changeSomeoneElsesLogo",
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
