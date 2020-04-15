@extends('clientViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-client.video />

                <br>
                <br>


                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Registration Timeline</h3>


                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>


                                <div id="content">
                                    <ul class="timeline">
                                        <li class="event" data-date="~ 15 minutes">
                                            <h3>Registration</h3>


                                            <p>Complete your profile and get ready to use the platform. It won't take you more than just a few minutes and you can do it today.</p>
                                        </li>


                                        <li class="event" data-date="~ 3-5 hours">
                                            <h3>Complete your first project info</h3>


                                            <p>We've divided the project setting process in 4 phases. Completing each one of them should not take more than one hour.</p>
                                        </li>


                                        <li class="event" data-date="15 days">
                                            <h3>Open project for vendors</h3>


                                            <p>Once the project is live, our fully reviewed Vendors Network will have 15 days to send their applications through the platform.</p>
                                        </li>


                                        <li class="event" data-date="~ 2 hours">
                                            <h3>Closure meeting</h3>


                                            <p>By the end of the process, Accenture will conduct a meeting to show you the results, benchmarks and analytics and help you make the right decission.</p>
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
