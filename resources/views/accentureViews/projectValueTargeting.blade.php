@extends('accentureViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-accenture.projectNavbar section="projectValueTargeting" :project="$project" />

                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Discovery week configuration</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            The first phase of the process is ipsum dolor sit amet, consectetur
                                            adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a.
                                            Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc
                                            pellentesque luctus. ipsum dolor
                                            sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut
                                            dictum nunc pharetra a.
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
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <div class="form-group">
                                    <label for="exampleInputText1">Upload Value Levers</label>

                                    <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                        name="exampleDropzone">
                                    </form>
                                </div>
                                <br><br><br>

                                <h3>Business Opportunity Details</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <div class="form-group">
                                    <label for="exampleInputText1">Upload Opportunity Details</label>

                                    <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                        name="exampleDropzone">
                                    </form>
                                </div>



                                <br><br><br>

                                <h3>Conclusions</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <div class="form-group">
                                    <label for="exampleInputText1">Upload Conclusions</label>

                                    <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                        name="exampleDropzone">
                                    </form>
                                </div>




                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="accenture_project_home.html">
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
