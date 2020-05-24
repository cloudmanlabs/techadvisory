@extends('clientViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening')" :text="nova_get_setting('video_opening_text')"/>

                <br>
                <br>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display:flex; justify-content: space-between">
                                    <h3>View your profile</h3>
                                    {{-- <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.profileEdit')}}">Edit</a> --}}
                                </div>

                                <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use the platform. It won't take you more than just a few minutes and you can do it today. Note that, if you do not currently have the info for some specific fields, you can leave them blank and fill up them later.</p>
                                <br>
                                <br>


                                <div class="form-group">
                                    <label for="exampleInputText1">Client name</label>
                                    <input class="form-control" id="exampleInputText1" disabled value="{{$client->name}}" type="text">
                                </div>

                                <br>
                                <div class="form-group">
                                    <label>Logo</label>
                                    <img src="{{url($client->logo ? ('/storage/' . $client->logo) : '/assets/images/user.png')}}" alt="" style="max-height: 5rem">
                                </div>
                                <br>

                                <x-questionForeach :questions="$questions" :class="'profileQuestion'" :disabled="true" :required="false" />

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


@section('scripts')
@parent
    <script src="{{url('assets/js/select2.js')}}"></script>
@endsection
