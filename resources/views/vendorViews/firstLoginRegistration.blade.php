@extends('vendorViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening')" />

                <br>
                <br>


                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Registration Timeline</h3>

                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <br>

                                <div id="content">
                                    <ul class="timeline">
                                        <li class="event" data-date="~ 15 minutes">
                                            <h3>Registration</h3>


                                            <p>Complete your profile and get ready to use the platform. It won't take
                                                you more than just a few minutes and you can do it today.</p>
                                        </li>


                                        <li class="event" data-date="~ 3-5 hours">
                                            <h3>Add your solutions to the platform</h3>


                                            <p>We've divided the solution setting process in 3 phases. Completing each
                                                one of them should not take more than one hour.</p>
                                        </li>


                                        <li class="event" data-date="15-45 days">
                                            <h3>Receive invitations for projects</h3>
                                            <p>Once your company is live and approved, Accenture will invite you to
                                                projects you can apply.</p>
                                        </li>


                                        <li class="event" data-date="~ 1-2 days">
                                            <h3>Apply to projects</h3>
                                            <p>Typical application process to a project can take between 8 and 15 hours
                                                of work of a team of 2 technicians.</p>
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
