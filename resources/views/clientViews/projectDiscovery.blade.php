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

                {{-- TODO Hide this on this screen while the project is in preparation phase --}}
                <x-client.projectNavbar section="projectDiscovery" />

                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Your discovery week</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            The first phase of the process is ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a. Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque luctus. ipsum dolor
                                            sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a.
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Selected Value Levers</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/VL1.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">Palletization</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/VL2.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">Carrier Selection</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/VL3.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">Direct Shipment</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/VL4.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">Triangular Movements</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/VL5.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">Shipment Scheduler</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br><br><br>

                                <h3>Business Opportunity Details</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/BO1.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">ABInBev - Global Transport Transformation</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/BO2.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">Implementation Journey</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <br><br><br>

                                <h3>Conclusions</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-md-12 col-xl-12">
                                        <div class="card">
                                            <img src="{{url('/assets/images/DiscoveryWeekDemo/outcomes.jpg')}}" class="card-img-top card-shadow">
                                            <div class="card-body">
                                                <h5 class="card-title">DISCOVERY WEEK OUTCOMES – INDIA| Nov, 22th </h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <div style="text-align: center; margin-top: 5px;"><a href="#" class="btn btn-primary">View / Download</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.projectHome')}}">
                                        <i data-feather="arrow-left"></i>
                                        Go back to project
                                    </a>
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
