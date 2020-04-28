@extends('accentureViews.layouts.benchmark')

@section('content')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectBenchmark" subsection="implementation" :project="$project" />

                <br>

                <x-projectBenchmarkVendorFilter :applications="$applications" />

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendor Ranking by Implementation&Commercials section</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <br>
                                <div class="col-lg-4 col-mg-12 offset-lg-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Position</th>
                                                    <th>Vendor</th>
                                                    <th>Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="table-dark">1</th>
                                                    <td>Vendor 3</td>
                                                    <td>7</td>
                                                </tr>
                                                <tr>
                                                    <th class="table-dark">2</th>
                                                    <td>Vendor 5</td>
                                                    <td>6</td>
                                                </tr>
                                                <tr>
                                                    <th class="table-dark">3</th>
                                                    <td>Vendor 1</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <th class="table-dark">4</th>
                                                    <td>Vendor 2</td>
                                                    <td>3,2</td>
                                                </tr>
                                                <tr>
                                                    <th class="table-dark">5</th>
                                                    <td>Vendor 4</td>
                                                    <td>2,1</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                <h3>Vendor comparison</h3>
                                <p class="welcome_text extra-top-15px">In order to start using the Tech Advisory
                                    Platform, you'll need to follow some steps to complete your profile and set up your
                                    first project. Please check below the timeline and click "Let's start" when you are
                                    ready.</p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>VENDORS SORTED BY TOTAL COST OF OWNERSHIP</h4>
                                                <br>
                                                <canvas id="chartjsBar1"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>COST DETAIL</h4>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Cost</th>
                                                                <th>Vendor 1</th>
                                                                <th>Vendor 2</th>
                                                                <th>Vendor 3</th>
                                                                <th>Vendor 4</th>
                                                                <th>Vendor 5</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th class="table-dark">Implementation</th>
                                                                <td>$ 1.000.000</td>
                                                                <td>$ 2.000.000</td>
                                                                <td>$ 1.000.000</td>
                                                                <td>$ 800.000</td>
                                                                <td>$ 2.000.000</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="table-dark">Run (5 years)</th>
                                                                <td>$ 3.000.000</td>
                                                                <td>$ 2.500.000</td>
                                                                <td>$ 1.000.000</td>
                                                                <td>$ 4.000.000</td>
                                                                <td>$ 1.900.000</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <br><br><br>
                                                <canvas id="chartjsBar2"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('accenture.projectBenchmark', ['project' => $project])}}">
                                        <i data-feather="arrow-left"></i>
                                        Go back to Benchmark & Analytics
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

@section('scripts')
@parent
<script src="{{url('assets/js/chartsjs_techadvisory_client_benchmarks_view_implementation.js')}}"></script>
@endsection
