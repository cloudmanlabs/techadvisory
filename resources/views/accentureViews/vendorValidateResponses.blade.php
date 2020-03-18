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

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Validate VENDOR NAME's profile</h3>
                                <p class="welcome_text extra-top-15px">Please validate vendor information that vendor has filled in.
                                    Each field must be flagged by an Accenture user. Vendor will recieve a notification to correct wrong fields.
                                    Note that, vendor will not be able to participate in any project until all information has been validated.
                                </p>

                                <br>

                                <div id="wizardVendorAccenture">
                                    <h2>General Information</h2>
                                    <section>
                                        <x-accenture.validateInputGroup>
                                            <label for="exampleInputText1">Vendor Name</label>
                                            <input class="form-control" id="exampleInputText1" type="text" value="Ventix Pro Corp." disabled>
                                        </x-accenture.validateInputGroup>
                                        <x-accenture.validateInputGroup>
                                            <label for="exampleInputText1">Vendor contact email</label>
                                            <input class="form-control" id="exampleInputText1" type="email" value="vendor@vendor.com" disabled>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Vendor contact role</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled
                                            >Vendor response here</textarea>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Address</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled
                                            >Vendor response here</textarea>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Vendor contact phone</label>
                                            <input class="form-control" id="exampleInputText1" value="+000 000 000" type="text" disabled>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Link to your website</label>
                                            <input class="form-control" id="exampleInputText1" value="https://vendor.com" type="text" disabled>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Foundation year</label>
                                            <input class="form-control" id="exampleInputText1" value="2000" type="text" disabled>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Specify Senior Management team (name, title & years in the company)</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled
                                            >Vendor response here</textarea>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Company Vision</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled
                                            >Vendor response here</textarea>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">High-level development strategy</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled
                                            >Vendor response here</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label>Headquarters</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
                                                <x-options.countries :selected="['ES', 'RU']" />
                                            </select>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label>Commercials Offices</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
                                                <x-options.countries :selected="['ES', 'CA']" />
                                            </select>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label>Services Team Offices</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
                                                <x-options.countries :selected="['ES', 'CA']" />
                                            </select>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlSelect1">Vendor segment</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" disabled>
                                                <x-options.vendorSegments :selected="['specific']" />
                                            </select>
                                        </x-accenture.validateInputGroup>
                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlSelect1">Number of employees</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <x-options.employeesRanges :selected="['more']" />
                                            </select>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleInputText1">Number of employees in R&D</label>
                                            <input class="form-control" id="exampleInputText1" value="3" type="number" disabled>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlSelect1">Geographies with solution implementations</label>
                                            <select class="form-control" disabled>
                                                <x-options.geographies :selected="['latam']" />
                                            </select>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlSelect1">Industry Experience</label>
                                            <select class="form-control" disabled>
                                                <x-options.industryExperience :selected="['consumer']" />
                                            </select>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label>Uploaded logo</label> <input class="file-upload-default" name="img[]" type="file">

                                            <img src="@logo" style="max-width: 30rem" alt="">
                                        </x-accenture.validateInputGroup>

                                        <br>
                                        {{-- TODO Make something here to download the files the vendor has uploaded --}}
                                        <x-accenture.validateInputGroup>
                                            <label for="exampleInputText1">Upload any extra files</label>

                                            <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone">
                                            </form>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Partnerships</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder=""></textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlSelect1">Indicate if your company is Public or private</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option disabled>
                                                    Please select
                                                </option>
                                                <option selected>
                                                    Public
                                                </option>
                                                <option>
                                                    Private
                                                </option>
                                            </select>
                                        </x-accenture.validateInputGroup>
                                    </section>


                                    <h2>Economic information</h2>
                                    <section>
                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Stock exchange and ticker symbol</label>
                                            <input class="form-control" id="exampleInputText1" value="AAPL" type="text" disabled>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Describe ownership structure (attach additional information if required)</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor response here</textarea>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Month in which fiscal year ends</label>
                                            <input class="form-control" id="exampleInputText1" value="July" type="text" disabled>
                                        </x-accenture.validateInputGroup>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlSelect1">Finance currency</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option disabled>
                                                    Please select
                                                </option>
                                                <option selected>
                                                    €
                                                </option>
                                                <option>
                                                    USD
                                                </option>
                                            </select>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Indicate YTD Results 2020 - Revenue, Profit, R&D Expenses</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Indicate 2019 Results - Revenue, Profit, R&D Expenses</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Indicate 2018 Results - Revenue, Profit, R&D Expenses</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Current Balance Sheet Information</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>



                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Cash and cash equivalents</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Other current assets</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Current liabilities</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Quick ratio (current assets - current liabilities)</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Total amount of debt</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>

                                    </section>


                                    <h2>Legal Info</h2>
                                    <section>

                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Any litigation pending?</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Number of lawsuits in history of company?</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>


                                        <x-accenture.validateInputGroup>
                                            <label for="exampleFormControlTextarea1">Are you currently in any discussions about being acquired? </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled
                                            >Vendor Response</textarea>
                                        </x-accenture.validateInputGroup>
                                    </section>
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

@section('head')
    @parent
    <link rel="stylesheet" href="{{url('/assets/css/techadvisory/vendorValidateResponses.css')}}">
@endsection
