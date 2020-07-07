@extends('clientViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening_file')" :text="nova_get_setting('video_opening_text')"/>

                <br>
                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Registration Timeline</h3>

                                <p class="welcome_text extra-top-15px">
                                    <!-- {{nova_get_setting('client_firsLoginRegistration_timeline') ?? ''}} -->
                                    To start using the Tech Advisory Platform, you will need to complete your profile and set up
                                    your first project. Check the timeline below and click Let's start when you are ready.
                                </p>
                                <br>
                                <br>

                                <div id="content">
                                    <ul class="timeline">
                                        <li class="event" data-date="~ 10 minutes">
                                            <h3>Registration</h3>

                                            <p>
                                                <!-- {{nova_get_setting('client_firsLoginRegistration_registration') ?? ''}} -->
                                                Complete your profile and get ready to use the platform.
                                            </p>
                                        </li>


                                        <li class="event" data-date="~ 4 weeks">
                                            <h3>Set up your first project</h3>

                                            <p>
                                                <!-- {{nova_get_setting('client_firsLoginRegistration_completeProjectInfo') ?? ''}} -->
                                                We divided the project setup process into four phases to make
                                                sure we gather all relevant information about the project scope and your requirements.
                                            </p>
                                        </li>


                                        <li class="event" data-date="~ 4 weeks">
                                            <h3>Open project for vendors</h3>

                                            <p>
                                                <!-- {{nova_get_setting('client_firsLoginRegistration_OpenProject') ?? ''}} -->
                                                Once the project is set up, suitable vendors from our verified network will
                                                submit their applications through the platform to provide you the needed solutions.
                                            </p>
                                        </li>


                                        <li class="event" data-date="~ 2 weeks">
                                            <h3>Obtain vendor analysis and conclusions</h3>

                                            <p>
                                                <!-- {{nova_get_setting('client_firsLoginRegistration_Closure') ?? ''}} -->
                                                By the end of the process, Accenture will analyze all vendor responses and
                                                prepare the final conclusions and recommendations
                                            </p>
                                        </li>
                                    </ul>


                                    <div style="float: right; margin-top: 20px;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.profile.create')}}"><i class="btn-icon-prepend" data-feather="check-square"></i> Let's start!</a>
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
