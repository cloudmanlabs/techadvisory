@extends('clientViews.layouts.benchmark')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-client.projectNavbar section="projectBenchmark" subsection="overall" />

                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Benchmark and Analytics</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            Please choose the Vendors you'd like to add in the comparison tables:
                                            <br><br>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                                <option selected>Vendor 1</option>
                                                <option selected>Vendor 2</option>
                                                <option selected>Vendor 3</option>
                                                <option selected>Vendor 4</option>
                                                <option selected>Vendor 5</option>
                                                <option>Vendor 6</option>
                                                <option>Vendor 7</option>
                                                <option>Vendor 8</option>
                                                <option>Vendor 9</option>
                                                <option>Vendor 10</option>
                                            </select>
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
                                <h3>Overall score table</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="table-dark">
                                                <th>Criteria</th>
                                                <th>Vendor 1</th>
                                                <th>Vendor 2</th>
                                                <th>Vendor 3</th>
                                                <th>Vendor 4</th>
                                                <th>Vendor 5</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>1.Fit Gap</th>
                                                <td>3,2</td>
                                                <td>7</td>
                                                <td>9</td>
                                                <td>8,5</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <th>2. Vendor</th>
                                                <td>5</td>
                                                <td>5,2</td>
                                                <td>9</td>
                                                <td>9,8</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <th>3.Experience</th>
                                                <td>3</td>
                                                <td>5</td>
                                                <td>7</td>
                                                <td>8</td>
                                                <td>4,3</td>
                                            </tr>
                                            <tr>
                                                <th>4.Innovation</th>
                                                <td>3,2</td>
                                                <td>5</td>
                                                <td>7,5</td>
                                                <td>5</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <th>5.Implementation and Commercials</th>
                                                <td>4</td>
                                                <td>3,2</td>
                                                <td>7</td>
                                                <td>2,1</td>
                                                <td>6</td>
                                            </tr>
                                            <tr class="table-dark">
                                                <th>OVERALL SCORE</th>
                                                <td>3,68</td>
                                                <td>5,08</td>
                                                <td>7,90</td>
                                                <td>6,68</td>
                                                <td>3,06</td>
                                            </tr class="table-dark">
                                        </tbody>
                                    </table>
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
                                <h3>Vendor score per criteria</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>VENDOR COMPARISON</h4>
                                                <br>
                                                <div id="apexRadar1"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>HEATMAP</h4>
                                                <div id="apexHeatMap"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>DOWNLOAD EXTRACTION DATA</h4>
                                                <div style="text-align: center; margin-top: 30px;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text" href="client_project_home.html">
                                                        <i data-feather="download"></i> &nbsp;
                                                        Extract vendor replies for all RFP questions
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="client_project_home.html">
                                        <i data-feather="arrow-left"></i>
                                        Go back to project
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-client.footer />
        </div>
    </div>
@endsection
