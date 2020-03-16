@extends('accentureViews.layouts.forms')

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

            <div class="row">
                <div class="col-12 col-xl-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div style="float: left;">
                                <h3>Redistribution of processes at Nestlé</h3>
                            </div>

                            <div style="float: right; width: 35%;">
                                Application status
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 10%;" aria-valuenow="10"
                                        aria-valuemin="0" aria-valuemax="100">10%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-page">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="profile-header">
                            <div class="header-links">
                                <ul class="links d-flex align-items-center mt-3 mt-md-0">
                                    <li class="header-link-item d-flex align-items-center active">
                                        <i data-feather="bookmark"
                                            style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i> <a
                                            class="pt-1px d-none d-md-block"
                                            {{-- TODO I'm not sure what link this is supposed to be --}}
                                            href="#">Application by Vendix Solutions
                                            S.L.</a>
                                    </li>


                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <div class="row" style="margin-top: 25px;">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Vendor name</h3>
                            <h4>Review application</h4>
                            <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use
                                the platform. It won't take you more than just a few minutes and you can do it
                                today. Note that, if you do not currently have the info for some specific fields,
                                you can leave them blank and fill up them later.</p>
                            <br>
                            <div id="wizard_accenture">
                                <h2>Fit Gap</h2>
                                <section>
                                    <br>
                                    Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc
                                    pellentesque luctus. ipsum dolor sit amet, consectetur adipiscing elit. Donec
                                    aliquam ornare sapien, ut dictum nunc pharetra a.Phasellus vehicula suscipit
                                    mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque luctus. ipsum
                                    dolor sit amet.
                                    <br><br>
                                    <div style="text-align: center;">
                                        <button type="button" class="btn btn-primary btn-lg btn-icon-text"
                                            data-toggle="modal" data-target=".bd-example-modal-xl"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-check-square btn-icon-prepend">
                                                <polyline points="9 11 12 14 22 4"></polyline>
                                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                                                </path>
                                            </svg> Review Fit Gap table</button>

                                        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                                            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Please
                                                            complete the Fit Gap table</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe
                                                            src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/doc_vendor.html')}}"
                                                            style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="btn btn-primary btn-lg btn-icon-text"
                                                            data-toggle="modal" data-target=".bd-example-modal-xl"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-check-square btn-icon-prepend">
                                                                <polyline points="9 11 12 14 22 4"></polyline>
                                                                <path
                                                                    d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                                                                </path>
                                                            </svg> Done</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </section>

                                <h2>Vendor</h2>
                                <section>
                                    <h4>2.1 Corporate information</h4>
                                    <br>
                                    <div class="form-group">
                                        <h6>
                                            1. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                        <h6>
                                            2. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                        <h6>
                                            3. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                        <h6>
                                            4. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                        <h6>
                                            5. Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                        <h4>2.1 Market presence</h4>
                                        <br>
                                        <h6>
                                            1. Headquarters
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>
                                        <h6>
                                            2. Commercial Offices
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>
                                        <h6>
                                            3. Service Team Offices
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>
                                        <h6>
                                            4. Geographies with solution implementations
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                    </div>

                                </section>

                                <h2>Experience</h2>
                                <section>

                                    <h4>3.1 Questions</h4>
                                    <br>
                                    <div class="form-group">
                                        <h6>
                                            1. Industry Experience
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                        <h6>
                                            2. List all active clients
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                        <h6>
                                            3. List how many successful implementations you performed within last 4
                                            years
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>


                                        <h6>
                                            4. List how many successful implementations you performed within last 4
                                            years
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comments
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br>



                                        <h6>
                                            4. Share 3 customer references for implementation with similar size &
                                            scope (same industry preferred)
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">

                                            <label for="exampleInputText1">
                                                Customer 1
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact Name 1
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact Role 1
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact E-mail 1
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Comments 1
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Upload any extra info 1
                                            </label>
                                            <div class="form-group">
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                                    name="exampleDropzone">
                                                </form>
                                            </div>

                                            <br><br>

                                            <label for="exampleInputText1">
                                                Customer 2
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact Name 2
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact Role 2
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact E-mail 2
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Comments 2
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Upload any extra info 2
                                            </label>
                                            <div class="form-group">
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                                    name="exampleDropzone">
                                                </form>
                                            </div>

                                            <br><br>

                                            <label for="exampleInputText1">
                                                Customer 3
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact Name 3
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact Role 3
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Contact E-mail 3
                                            </label>
                                            <input type="number" class="form-control" id="exampleInputText1"
                                                placeholder="">
                                            <label for="exampleInputText1">
                                                Comments 3
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Upload any extra info 3
                                            </label>
                                            <div class="form-group">
                                                <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                                    name="exampleDropzone">
                                                </form>
                                            </div>

                                            <br><br>
                                        </div>
                                        <br>
                                    </div>

                                </section>

                                <h2>Innovation & Vision</h2>
                                <section>

                                    <h4>4.1. IT Enablers</h4>
                                    <br>
                                    <div class="form-group">
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>

                                        </div>
                                    </div>


                                    <h4>4.2. Alliances</h4>
                                    <div class="form-group">
                                        <br>
                                        <h6>
                                            Partnership 1
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Partnership Functionalities Vendor
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br><br>
                                        <h6>
                                            Partnership 2
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Partnership Functionalities Vendor
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br><br>
                                        <h6>
                                            Partnership 3
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Partnership Functionalities Vendor
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <br><br>
                                        </div>
                                    </div>



                                    <h4>4.3. Product</h4>
                                    <div class="form-group">
                                        <br>
                                        <h6>
                                            Question 1
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comment
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br><br>
                                        <h6>
                                            Question 2
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comment
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br><br>
                                        <h6>
                                            Question 3
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comment
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <br><br>
                                        </div>
                                    </div>




                                    <h4>4.4. Sustainability</h4>
                                    <div class="form-group">
                                        <br>
                                        <h6>
                                            Question 1
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comment
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br><br>
                                        <h6>
                                            Question 2
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comment
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br><br>
                                        <h6>
                                            Question 3
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Comment
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <br><br>
                                        </div>
                                    </div>


                                </section>

                                <h2>Implementation & Commercials</h2>
                                <section>
                                    <h4>5.1. Implementation</h4>
                                    <br>
                                    <label for="exampleInputText1">
                                        Project plan upload
                                    </label>
                                    <div class="form-group">
                                        <form action="/file-upload" class="dropzone" id="exampleDropzone"
                                            name="exampleDropzone">
                                        </form>
                                    </div>

                                    <h4>5.2. Deliverables per phase</h4>
                                    <div class="form-group">
                                        <br>
                                        <h6>
                                            Phase 1
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Deliverables
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br><br>
                                        <h6>
                                            Phase 2
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Deliverables
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                        </div>
                                        <br><br>
                                        <h6>
                                            Phase 3
                                        </h6>
                                        <div style="margin-left: 20px; margin-top: 20px;">
                                            <label for="exampleInputText1">
                                                Response
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <label for="exampleInputText1">
                                                Deliverables
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                required></textarea>
                                            <br><br>
                                        </div>
                                    </div>

                                </section>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-accenture.footer />
    </div>
</div>
@endsection
