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
                                    <h2>General Information</h2>
                                    <section>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor Name*</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter Name" type="text" value="{{$vendor->name}}"
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor main email</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter E-mail" type="email"
                                                value="{{$vendor->email}}" disabled>
                                        </div>

                                        <br>
                                        <div class="form-group">
                                            <label>Logo</label>
                                            <img src="{{url($vendor->logo ? ('/storage/' . $vendor->logo) : '/assets/images/user.png')}}" alt=""
                                                style="max-height: 5rem">
                                        </div>


                                        <x-questionForeachWithActivate :questions="$generalQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />

                                        <x-folderFileUploader :folder="$vendor->profileFolder" :disabled="true" :timeout="1000"/>
                                    </section>

                                    <h2>Economic information</h2>
                                    <section>
                                       <x-questionForeachWithActivate :questions="$economicQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />
                                    </section>


                                    <h2>Legal Info</h2>
                                    <section>
                                        <x-questionForeachWithActivate :questions="$legalQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />

                                        <br><br>
                                        <div>
                                            <form action="{{route('accenture.submitVendor', ['vendor' => $vendor])}}" method="post">
                                                @csrf
                                                <button class="btn btn-primary btn-lg btn-icon-text" id="submitButton" type="submit">
                                                    <i class="btn-icon-prepend" data-feather="check-square"></i> Save profile
                                                </button>
                                            </form>
                                        </div>
                                        <br><br>
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


    $(document).ready(function() {
        $('.profileQuestion .checkboxesDiv input')
            .change(function (e) {
                $.post('/accenture/vendorValidateResponses/setValidated/{{$vendor->id}}', {
                    changing: $(this).data('changingid'),
                    value: $(this).prop("checked")
                })

                showSavedToast();
            });
    });
</script>
@endsection
