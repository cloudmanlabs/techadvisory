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

                <x-accenture.projectNavbar section="projectHome" />

                <br>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendors applicating</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <br>

                                <x-vendorCard>
                                    <div style=" text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.viewVendorProposal')}}">View/Edit
                                        </a>
                                    </div>
                                </x-vendorCard>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendors pending evaluation</h3>
                                <p class="welcome_text extra-top-15px">The following vendors have submitted the
                                    selection criteria section for this project. In order to allow them to continue the
                                    process, please evaluate vendor response for each area.</p>
                                <br>
                                <br>

                                <x-vendorCard>
                                    <div style="text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.viewVendorProposalEvaluation')}}">Evaluate Response
                                        </a>
                                    </div>
                                </x-vendorCard>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Release vendor responses</h3>
                                <p class="welcome_text extra-top-15px">The following vendors have already been evaluated by Accenture.</p>
                                <br>
                                <br>

                                <x-vendorCard :showProgressBar="false">
                                    <div style="text-align: right; width: 15%; ">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.projectHome')}}">Disqualify vendor
                                        </a>
                                    </div>
                                    <div style="text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.projectHome')}}">Release Response</a>
                                    </div>
                                </x-vendorCard>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Released responses</h3>
                                <p class="welcome_text extra-top-15px">The following responses have already been released.
                                </p>
                                <br>
                                <br>

                                <x-vendorCard :showProgressBar="false">
                                    <div style="text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="#">Download response
                                        </a>
                                    </div>
                                </x-vendorCard>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendors invited</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <br>

                                <x-vendorCard :showProgressBar="false">
                                    <div style="float: right; text-align: right; width: 25%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="#" data-toggle="modal"
                                            data-target="#resend_invite_modal">Resend invite <i class="btn-icon-prepend" data-feather="mail"></i></a>
                                    </div>
                                </x-vendorCard>

                                <div class="modal fade" id="resend_invite_modal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="resend_invite_modal">Resend invitation to
                                                    vendor</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="message-text"
                                                            class="col-form-label">Message:</label>
                                                        <textarea class="form-control" id="message-text"
                                                            style="min-height: 400px;">Dear Vendor, &#10;&#10;We would like to invite dolor sit amet, consectetur adipiscing elit. Etiam in eros libero. &#10;&#10;Curabitur quis ipsum in purus imperdiet dictum. Vivamus at varius sapien. Aenean et bibendum diam, in condimentum erat. Duis sed odio quis nulla venenatis cursus et eu sapien. &#10;&#10;Phasellus hendrerit pharetra turpis. Aliquam lobortis scelerisque dui, at accumsan nunc vehicula laoreet. Proin auctor, nisi emollis ipsum at this link:&#10;&#10;[INVITATION LINK]&#10;&#10;Thank you,&#10;Accenture Team
                                                            </textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Resend invitation</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Disqualified Vendors</h3>
                                <p class="welcome_text extra-top-15px">The following vendors have been marked as disqualified from  this project.</p>
                                <br>
                                <br>

                                <x-vendorCard>
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.viewVendorProposal')}}">View Response</a>
                                </x-vendorCard>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Project deadline</h3>
                                <br>

                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="text-align: center;">
                                            <div id="clockdiv">
                                                <div>
                                                    <span class="days">83</span>
                                                    <div class="smalltext">Days</div>
                                                </div>
                                                <div>
                                                    <span class="hours">05</span>
                                                    <div class="smalltext">Hours</div>
                                                </div>
                                                <div>
                                                    <span class="minutes">47</span>
                                                    <div class="smalltext">Minutes</div>
                                                </div>
                                                <div>
                                                    <span class="seconds">19</span>
                                                    <div class="smalltext">Seconds</div>
                                                </div>
                                            </div>
                                        </div>
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
