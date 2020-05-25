@extends('vendorViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening')" :text="nova_get_setting('video_opening_text')"/>

                <br>
                <br>


                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Registration Timeline</h3>

                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_firsLoginRegistration_timeline') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <div id="content">
                                    <ul class="timeline">
                                        <li class="event" data-date="~ 15 minutes">
                                            <h3>Registration</h3>

                                            <p>
                                                {{nova_get_setting('vendor_firsLoginRegistration_registration') ?? ''}}
                                            </p>
                                        </li>


                                        <li class="event" data-date="~ 3-5 hours">
                                            <h3>Add your solutions to the platform</h3>

                                            <p>
                                                {{nova_get_setting('vendor_firsLoginRegistration_addSolutions') ?? ''}}
                                            </p>
                                        </li>


                                        <li class="event" data-date="15-45 days">
                                            <h3>Receive invitations for projects</h3>

                                            <p>
                                                {{nova_get_setting('vendor_firsLoginRegistration_recieveInvitations') ?? ''}}
                                            </p>
                                        </li>


                                        <li class="event" data-date="~ 1-2 days">
                                            <h3>Apply to projects</h3>

                                            <p>
                                                {{nova_get_setting('vendor_firsLoginRegistration_apply') ?? ''}}
                                            </p>
                                        </li>
                                    </ul>

                                    <div style="float: right; margin-top: 20px;">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('vendor.profile.create')}}"><i class="btn-icon-prepend"
                                                data-feather="check-square"></i> Let's start!</a>
                                    </div>
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
