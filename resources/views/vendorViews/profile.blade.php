@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening_file')" :text="nova_get_setting('video_openingVendor_text')"/>

                <br>
                <br>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display:flex; justify-content: space-between">
                                    <h3>View your profile</h3>
                                </div>

                                <p class="welcome_text extra-top-15px">
                                    <!-- {{nova_get_setting('vendor_profile_title') ?? ''}} -->
                                    Here are your company profile details.
                                </p>
                                <br>
                                <br>

                                <div id="wizardVendorProfile">
                                    <h2>Contact information</h2>
                                    <section>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor company name*</label>
                                            <input
                                                class="form-control"
                                                id="exampleInputText1"
                                                placeholder="Enter Name"
                                                type="text"
                                                value="{{$vendor->name}}"
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor contact email</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter E-mail"
                                                type="email"
                                                value="{{$vendor->email}}"
                                                disabled>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="vendorRoleInput">Vendor company contact role</label>
                                            <input class="form-control" id="vendorRoleInput" placeholder="Enter Role"
                                                type="text"
                                                value="{{$vendor->role}}" 
                                                disabled>
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label for="vendorAddressInput">Company address</label>
                                            <input class="form-control" id="vendorAddressInput" placeholder="Enter Address"
                                                type="text"
                                                value="{{$vendor->address}}" 
                                                disabled>
                                        </div> -->

                                        <div class="form-group">
                                            <label>Logo</label>

                                            <img src="{{url($vendor->logo ? ('/storage/' . $vendor->logo) : '/assets/images/user.png')}}" alt=""
                                                style="max-height: 5rem">
                                        </div>

                                        <x-questionForeach :questions="$generalQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />

                                        <x-folderFileUploader :folder="$vendor->profileFolder" :disabled="true" :timeout="1000"/>
                                    </section>


                                    <h2>Company information</h2>
                                    <section>
                                        <x-questionForeach :questions="$economicQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />
                                    </section>


                                    <h2>Economic information</h2>
                                    <section>
                                        <x-questionForeach :questions="$legalQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />
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


@section('scripts')
@parent
<script src="{{url('assets/js/select2.js')}}"></script>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function() {
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
