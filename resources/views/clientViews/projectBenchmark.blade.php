@extends('clientViews.layouts.benchmark')

@section('content')
    <div class="main-wrapper">
        <x-client.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-client.projectNavbar section="projectBenchmark" subsection="overall" :project="$project" />

                <br>
                <x-projectBenchmarkVendorFilter :applications="$applications" />
                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Overall vendor ranking</h3>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="table-dark">
                                                <th>Vendor name</th>
                                                <th>Total Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applications as $application)
                                            <tr class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                <th>{{$application->vendor->name}}</th>
                                                <td>{{number_format($application->totalScore(), 2)}}</td>
                                            </tr>
                                            @endforeach
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
                                <h3>Overall score table</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('client_projectBenchmark_overallScore') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="table-dark">
                                                <th>Criteria</th>
                                                @foreach ($applications as $application)
                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                    {{$application->vendor->name}}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>1. Fit Gap</th>
                                                @foreach ($applications as $application)
                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                    {{number_format($application->fitgapScore(), 2)}}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>2. Vendor</th>
                                                @foreach ($applications as $application)
                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                    {{number_format($application->vendorScore(), 2)}}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>3.Experience</th>
                                                @foreach ($applications as $application)
                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                    {{number_format($application->experienceScore(), 2)}}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>4.Innovation</th>
                                                @foreach ($applications as $application)
                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                    {{number_format($application->innovationScore(), 2)}}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th>5.Implementation and Commercials</th>
                                                @foreach ($applications as $application)
                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                    {{number_format($application->implementationScore(), 2)}}</th>
                                                @endforeach
                                            </tr>
                                            <tr class="table-dark">
                                                <th>OVERALL SCORE</th>
                                                @foreach ($applications as $application)
                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                    {{number_format($application->totalScore(), 2)}}</th>
                                                @endforeach
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
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('client_projectBenchmark_vendorScore') ?? ''}}
                                </p>
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
                                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.exportAnalytics', ['project' => $project])}}">
                                                        <i data-feather="download"></i> &nbsp;
                                                        Download analytics export
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

            <x-footer />
        </div>
    </div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function() {
    // Apex Radar chart start
    let radarChart = new ApexCharts(document.querySelector("#apexRadar1"), {
        chart: {
            height: 600,
            type: "radar",
            parentHeightOffset: 0
        },
        colors: ["#7a00c3", "#f77fb9", "#4d8af0", "#01e396", "#fbbc06"],
        grid: {
            borderColor: "rgba(77, 138, 240, .1)",
            padding: {
                bottom: -15
            }
        },
        legend: {
            position: "top",
            horizontalAlign: "left"
        },
        series: [
            @foreach ($applications as $application)
            {
                name: "{{$application->vendor->name}}",
                data: [
                    {{$application->fitgapScore()}},
                    {{$application->vendorScore()}},
                    {{$application->experienceScore()}},
                    {{$application->innovationScore()}},
                    {{$application->implementationScore()}}
                ]
            },
            @endforeach
        ],

        stroke: {
            width: 0
        },
        fill: {
            opacity: 0.4
        },
        markers: {
            size: 0
        },
        labels: [
            "Fit Gap",
            "Vendor",
            "Experience",
            "Innovation",
            "Implementation and Commercials"
        ]
    });
    radarChart.render();



    // Apex Heat chart start
    var heatChart = new ApexCharts(document.querySelector("#apexHeatMap"), {
        chart: {
            height: 300,
            type: "heatmap",
            parentHeightOffset: 0
        },
        grid: {
            borderColor: "rgba(77, 138, 240, .1)",
            padding: {
                bottom: -15
            }
        },
        dataLabels: {
            enabled: false
        },
        colors: ["#7a00c3"],
        series: [
            @foreach ($applications as $application)
            {
                name: "{{$application->vendor->name}}",
                data: [
                    { x: 'w1',  y: {{$application->fitgapScore()}} },
                    { x: 'w2',  y: {{$application->vendorScore()}} },
                    { x: 'w3',  y: {{$application->experienceScore()}} },
                    { x: 'w4',  y: {{$application->innovationScore()}} },
                    { x: 'w5',  y: {{$application->implementationScore()}} },
                ]
            },
            @endforeach
        ],
        xaxis: {
            type: "category",
            categories: [
                "Fit Gap",
                "Vendor",
                "Experience",
                "Innovation",
                "Implementation"
            ],
            labels: {
                style: {
                    fontSize: "17px"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: "17px"
                }
            }
        }
    });
    heatChart.render();
});
</script>
@endsection
