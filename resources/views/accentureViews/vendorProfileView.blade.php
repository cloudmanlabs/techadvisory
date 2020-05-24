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
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('accenture.vendorProfileEdit', ['vendor' => $vendor])}}">Edit</a>
                                </div>


                                <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use the platform. It won't take you more than just a few minutes and you can do it today. Note that, if you do not currently have the info for some specific fields, you can leave them blank and fill up them later.</p>

                                <br>

                                <div id="wizardVendorAccenture">
                                    <h2>Contact information</h2>
                                    <section>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor Name*</label>
                                            <input
                                                class="form-control"
                                                id="exampleInputText1"
                                                placeholder="Enter Name"
                                                type="text"
                                                value="{{$vendor->name}}"
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor main email</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter E-mail"
                                                type="email"
                                                value="{{$vendor->email}}"
                                                disabled>
                                        </div>

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

                                        <x-folderFileUploader :folder="$vendor->profileFolder" :disabled="true" />
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
