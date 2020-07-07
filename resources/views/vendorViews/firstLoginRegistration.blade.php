@extends('vendorViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening_file')" :text="nova_get_setting('video_openingVendor_text')"/>

                <br>
                <br>


                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Registration Timeline</h3>

                                <p class="welcome_text extra-top-15px">
                                    <!-- {{nova_get_setting('vendor_firsLoginRegistration_timeline') ?? ''}} -->
                                    To start using the Tech Advisory Platform, you will need to complete your profile and
                                    set up your solutions portfolio. Check the timeline below and click Let's start when you are ready.
                                </p>
                                <br>
                                <br>

                                <div id="content">
                                    <ul class="timeline">
                                        <li class="event" data-date="~ 2 hours">
                                            <h3>Registration</h3>

                                            <p>
                                                <!-- {{nova_get_setting('vendor_firsLoginRegistration_registration') ?? ''}} -->
                                                Complete your profile and get ready to use the platform.
                                            </p>
                                        </li>


                                        <li class="event" data-date="~ 2 hours">
                                            <h3>Add your solutions to the platform</h3>

                                            <p>
                                                <!-- {{nova_get_setting('vendor_firsLoginRegistration_addSolutions') ?? ''}} -->
                                                Complete your solutions portfolio in the platform and prepare to submit project applications.
                                                To participate in a project, your solutions portfolio must be registered in the platform.
                                            </p>
                                        </li>


                                        <li class="event">
                                            <h3>Receive invitations for projects</h3>

                                            <p>
                                                <!-- {{nova_get_setting('vendor_firsLoginRegistration_recieveInvitations') ?? ''}} -->
                                                Once your company profile is approved and your solutions portfolio is registered, Accenture will invite you to projects.
                                            </p>
                                        </li>


                                        <li class="event" data-date="~ 4 weeks">
                                            <h3>Apply to projects</h3>

                                            <p>
                                                <!-- {{nova_get_setting('vendor_firsLoginRegistration_apply') ?? ''}} -->
                                                Read carefully all client requirements and provide your best answers to increase your chances of being selected.
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
