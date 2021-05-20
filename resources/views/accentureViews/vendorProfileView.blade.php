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
                                    <h3>Complete the Profile</h3>
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('accenture.vendorProfileEdit', ['vendor' => $vendor])}}">Edit</a>
                                </div>


                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_vendorProfileView_Title') ?? ''}}
                                </p>

                                <br>

                                <div id="wizardVendorAccenture">
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
                                            <label for="exampleInputText1">Vendor company contact email</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter E-mail"
                                                type="email"
                                                value="{{$vendor->email}}"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="accentureCCEmail">Resend credentials to this email (Accenture)</label>
                                            <input id="accentureCCEmail"
                                                   class="form-control"
                                                   type="email"
                                                   value="{{$vendor->accenture_cc_email}}"
                                                   disabled>
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

                                        <div class="form-group">
                                            <label for="vendorNameInput">First user email</label>
                                            <input class="form-control" id="vendorEmailInput" disabled value="{{optional($vendor->credentials->first())->email}}" type="text">
                                        </div>

                                        <div class="form-group">
                                            <label for="vendorNameInput">First user name</label>
                                            <input class="form-control" id="vendorEmailInput" disabled
                                                value="{{optional($vendor->credentials->first())->name}}" type="text">
                                        </div>


                                        <br>
                                        <div class="form-group">
                                            <label>Logo</label>
                                            <img src="{{url($vendor->logo ? ('/storage/' . $vendor->logo) : '/assets/images/user.png')}}" alt=""
                                                style="max-height: 5rem">
                                        </div>
                                        <br>

                                        <x-questionForeach :questions="$generalQuestions" :class="'profileQuestion'" :disabled="true" :required="false" />
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

@section('scripts')
@parent
<script src="{{url('assets/js/select2.js')}}"></script>
@endsection
