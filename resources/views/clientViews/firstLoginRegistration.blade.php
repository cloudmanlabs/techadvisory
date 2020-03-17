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

                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Welcome</h3>
                                <br>

                                <div class="welcome_text welcome_box">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding-top: 16px; padding-left: 20px; padding-right: 20px;">
                                            Hello there. I'm Roger Foz, Lead of Accenture’s Capability Network Fulfillment Practice in Europe, and I'd like to welcome you to the Tech Advisory Platform. We've built this solution to help you overview, make decissions and take control over your projects within our network. Please take a minute to check out the video we've prepared for you.
                                        </div>
                                        <a data-target=".bd-example-modal-lg" data-thevideo="https://www.youtube.com/embed/IHjNcp_4QCs" data-toggle="modal" href="#"><img alt="..." class="wd-100p wd-sm-150 mb-3 mb-sm-0 ml-3" src="{{url('/assets/images/video_small.jpg')}}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <iframe height="450" src="" width="100%"></iframe>
                        </div>
                    </div>
                </div>
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
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.homeProfileCreate')}}"><i class="btn-icon-prepend" data-feather="check-square"></i> Let's start!</a>
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

@section('scripts')
    @parent
    <script>
        autoPlayYouTubeModal();

        //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG
        function autoPlayYouTubeModal() {
            var trigger = $("body").find('[data-toggle="modal"]');
            trigger.click(function () {
                var theModal = $(this).data("target"),
                    videoSRC = $(this).attr("data-theVideo"),
                    videoSRCauto = videoSRC + "?autoplay=1";
                $(theModal + ' iframe').attr('src', videoSRCauto);
                $(theModal + ' button.close').click(function () {
                    $(theModal + ' iframe').attr('src', videoSRC);
                });
            });
        }
    </script>
@endsection
