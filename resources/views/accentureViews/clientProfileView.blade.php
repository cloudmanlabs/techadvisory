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
                                        href="{{route('accenture.clientProfileEdit', ['client' => $client])}}">Edit</a>
                                </div>



                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_clientProfileView_Title') ?? ''}}
                                </p>
                                <br>
                                <br>


                                <div class="form-group">
                                    <label for="exampleInputText1">Client company name*</label>
                                    <input class="form-control" id="exampleInputText1" disabled value="{{$client->name}}" type="text" >
                                </div>

                                <div class="form-group">
                                    <label for="clientNameInput">Client company contact email*</label>
                                    <input class="form-control" id="clientEmailInput" disabled value="{{$client->email}}" type="text">
                                </div>

                                <div class="form-group">
                                    <label for="clientNameInput">First user email</label>
                                    <input class="form-control" id="clientEmailInput" disabled value="{{optional($client->credentials->first())->email}}" type="text">
                                </div>

                                <div class="form-group">
                                    <label for="clientNameInput">First user name</label>
                                    <input class="form-control" id="clientEmailInput" disabled
                                        value="{{optional($client->credentials->first())->name}}" type="text">
                                </div>

                                <br>
                                <br>
                                <div class="form-group">
                                    <label>Logo</label>
                                    <img src="{{url($client->logo ? ('/storage/' . $client->logo) : '/assets/images/user.png')}}" alt=""
                                        style="max-height: 5rem">
                                </div>
                                <br>
                                <br>

                                <x-questionForeach :questions="$questions" :class="'profileQuestion'" :disabled="true" :required="true" />

                                <x-folderFileUploader :folder="$client->profileFolder" :disabled="true" :timeout="1000"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
