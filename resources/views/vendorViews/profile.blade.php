@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-vendor.video />

                <br>
                <br>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display:flex; justify-content: space-between">
                                    <h3>View your profile</h3>
                                </div>

                                <p class="welcome_text extra-top-15px">
                                    If any modifications are needed please contact the Accenture team.
                                </p>
                                <br>
                                <br>


                                <div class="form-group">
                                    <label for="exampleInputText1">Vendor name</label>
                                    <input class="form-control" id="exampleInputText1" disabled value="Name" value="Nestlé" type="text">
                                </div>


                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Industry Experience</label>
                                    <select class="form-control" id="exampleFormControlSelect1" disabled>
                                        <option disabled>
                                            Please select your industry
                                        </option>

                                        <option>
                                            Automative
                                        </option>

                                        <option selected>
                                            Consumer goods & services
                                        </option>

                                        <option>
                                            Industrial Equipement
                                        </option>

                                        <option>
                                            Life Sciences
                                        </option>

                                        <option>
                                            Retail
                                        </option>

                                        <option>
                                            Transport services
                                        </option>

                                        <option>
                                            Travel
                                        </option>

                                        <option>
                                            Chemical
                                        </option>

                                        <option>
                                            Energy
                                        </option>

                                        <option>
                                            Natural Resources
                                        </option>

                                        <option>
                                            Utilities
                                        </option>

                                        <option>
                                            Communications & Media
                                        </option>

                                        <option>
                                            High tech
                                        </option>

                                        <option>
                                            CMT SW&P
                                        </option>

                                        <option>
                                            Health
                                        </option>

                                        <option>
                                            Public Service
                                        </option>

                                        <option>
                                            Banking
                                        </option>

                                        <option>
                                            Capital Markets
                                        </option>

                                        <option>
                                            Insurance
                                        </option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputText1">Revenue for last exercise</label>
                                    <input class="form-control" id="exampleInputText1" disabled value="Enter amount" type="text">
                                </div>


                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Revenue currency</label>
                                    <select class="form-control" id="exampleFormControlSelect1" disabled>
                                        <option disabled>
                                            Please select your currency
                                        </option>

                                        <option selected>
                                            Euro
                                        </option>

                                        <option>
                                            USD
                                        </option>

                                        <option>
                                            CHF
                                        </option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Number of employees</label>
                                    <select class="form-control" id="exampleFormControlSelect1" disabled>
                                        <option disabled>
                                            Please select the range
                                        </option>

                                        <option selected>
                                        <option>
                                            0-50
                                        </option>

                                        <option>
                                            50-500
                                        </option>

                                        <option>
                                            500-5.000
                                        </option>

                                        <option>
                                            5.000 – 30.000
                                        </option>

                                        <option>
                                            + 30.000
                                        </option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Area served</label>
                                    <select class="form-control" id="exampleFormControlSelect1" disabled>
                                        <option disabled>
                                            Please select the area served
                                        </option>

                                        <option selected>
                                            Worldwide
                                        </option>

                                        <option>
                                            EMEA
                                        </option>

                                        <option>
                                            APAC
                                        </option>

                                        <option>
                                            NA
                                        </option>

                                        <option>
                                            LATAM
                                        </option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Upload your logo</label> <input class="file-upload-default" name="img[]" type="file">

                                    <div class="input-group col-xs-12">
                                        <input class="form-control file-upload-info" disabled disabled value="Upload Image" type="text"> <span class="input-group-append"><button class="file-upload-browse btn btn-primary" type="button"><span class="input-group-append">Upload</span></button></span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputText1">Link to your website</label> <input class="form-control" id="exampleInputText1" disabled value="https://..." type="text">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputText1">Upload any extra files</label>

                                    <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone" disabled aria-disabled="true">
                                    </form>
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
