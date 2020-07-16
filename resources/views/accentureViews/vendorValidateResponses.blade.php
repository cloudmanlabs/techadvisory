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
                                <h3>Validate VENDOR NAME's profile</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_vendorValidateResponses_title') ?? ''}}
                                </p>

                                <br>

                                <div id="wizardVendorAccenture">
                                    <h2>Contact information</h2>
                                    <section>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor company name*</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter Name" type="text" value="{{$vendor->name}}"
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor company contact email</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter E-mail" type="email"
                                                value="{{$vendor->email}}" disabled>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="vendorRoleInput">Vendor company contact role</label>
                                            <input class="form-control" id="vendorRoleInput" placeholder="Enter Role"
                                                type="text"
                                                value="{{$vendor->role}}"
                                                 >
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label for="vendorAddressInput">Company address</label>
                                            <input class="form-control" id="vendorAddressInput" placeholder="Enter Address"
                                                type="text"
                                                value="{{$vendor->address}}"
                                                disabled>
                                        </div> -->

                                        <br>
                                        <div class="form-group">
                                            <label>Logo</label>
                                            <img src="{{url($vendor->logo ? ('/storage/' . $vendor->logo) : '/assets/images/user.png')}}" alt=""
                                                style="max-height: 5rem">
                                        </div>


                                        <x-questionForeachWithActivate :questions="$generalQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />
                                    </section>

                                    <h2>Company information</h2>
                                    <section>
                                       <x-questionForeachWithActivate :questions="$economicQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />
                                    </section>

                                    <h2>Economic information</h2>
                                    <section>
                                        <x-questionForeachWithActivate :questions="$legalQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />

                                        <br><br>
                                        <div>
                                            <form action="{{route('accenture.submitVendor', ['vendor' => $vendor])}}" method="post">
                                                @csrf
                                                <button class="btn btn-primary btn-lg btn-icon-text" id="submitButton" type="submit">
                                                    <i class="btn-icon-prepend" data-feather="check-square"></i> Submit validation
                                                </button>
                                            </form>
                                        </div>
                                        <br><br>
                                    </section>
                                </div>
                                <div>
                                    <x-folderFileUploader :folder="$vendor->profileFolder" :disabled="true" :timeout="1000"/>
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
    <link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
@endsection

@section('scripts')
@parent
<script src="{{url('assets/js/select2.js')}}"></script>
<script>
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

    function checkIfAllEvalsAreFilled(){
        let array = $('.checkboxesDiv input')
            .toArray();

		if(array.length == 0) return true;

        for (let i = 0; i < array.length; i++) {
            if(!$(array[i]).prop('checked')){
                console.log(array[i], $(array[i]).prop('checked'))
                return false
            } else {
                console.log(array[i], $(array[i]).prop('checked'))
            }
        }

        return true
    }

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        if(checkIfAllEvalsAreFilled()){
            $('#submitButton').attr('disabled', false)
        } else {
            $('#submitButton').attr('disabled', true)
        }
    }

    $(document).ready(function() {
        $('.profileQuestion .checkboxesDiv input')
            .change(function (e) {
                $.post('/accenture/vendorValidateResponses/setValidated/{{$vendor->id}}', {
                    changing: $(this).data('changingid'),
                    value: $(this).prop("checked")
                })

                updateSubmitButton();
                showSavedToast();
            });

        updateSubmitButton();
    });
</script>
@endsection
