@extends('layouts.base')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectBenchmark" :subsection="$subsection" :project="$project"/>

                <br>
                <x-projectBenchmarkVendorFilter :applications="$applications"/>

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Overall vendor ranking</h3>
                                <p class="welcome_text extra-top-15px">
                                    This is the ranking of vendors according to overall score,
                                    which is estimated based on the weights defined for each section.
                                </p>
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
                                            <tr class="filterByVendor"
                                                data-vendor="{{optional($application->vendor)->name ?? '' ?? ''}}">
                                                <th>{{optional($application->vendor)->name ?? '' ?? ''}}</th>
                                                @if($application->useCasesInfo ?? null)
                                                <td>{{number_format($application->useCaseTotalScore, 2)}}</td>
                                                @else
                                                <td>{{number_format($application->totalScore(), 2)}}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Overall score table</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectBenchmark_overallScore') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr class="table-dark">
                                            <th>Criteria</th>
                                            @foreach ($applications as $application)
                                                <th class="filterByVendor"
                                                    data-vendor="{{optional($application->vendor)->name ?? ''}}">{{optional($application->vendor)->name ?? ''}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>1. Fit Gap</th>
                                            @foreach ($applications as $application)
                                                <th class="filterByVendor"
                                                    data-vendor="{{optional($application->vendor)->name ?? ''}}">{{number_format($application->fitgapScore(), 2) }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th>2. Vendor</th>
                                            @foreach ($applications as $application)
                                                <th class="filterByVendor"
                                                    data-vendor="{{optional($application->vendor)->name ?? ''}}">{{number_format($application->vendorScore(), 2) }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th>3.Experience</th>
                                            @foreach ($applications as $application)
                                                <th class="filterByVendor"
                                                    data-vendor="{{optional($application->vendor)->name ?? ''}}">{{number_format($application->experienceScore(), 2) }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th>4.Innovation</th>
                                            @foreach ($applications as $application)
                                                <th class="filterByVendor"
                                                    data-vendor="{{optional($application->vendor)->name ?? ''}}">{{number_format($application->innovationScore(), 2) }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th>5.Implementation and Commercials</th>
                                            @foreach ($applications as $application)
                                                <th class="filterByVendor"
                                                    data-vendor="{{optional($application->vendor)->name ?? ''}}">{{number_format($application->implementationScore(), 2 )}}</th>
                                            @endforeach
                                        </tr>
                                        @if($application->useCasesInfo ?? null)
                                        <tr>
                                            <th>6.Use Cases</th>
                                            @foreach ($applications as $application)
                                                <th class="filterByVendor"
                                                    data-vendor="{{optional($application->vendor)->name ?? ''}}">{{number_format($application->useCasesInfo->total, 2 )}}</th>
                                            @endforeach
                                        </tr>
                                        @endif
                                        <tr class="table-dark">
                                            <th>OVERALL SCORE</th>
                                            @foreach ($applications as $application)
                                                <th class="filterByVendor"
                                                @if($application->useCasesInfo ?? null)
                                                data-vendor="{{optional($application->vendor)->name ?? ''}}">{{number_format($application->useCaseTotalScore, 2)}}</th>
                                                @else
                                                data-vendor="{{optional($application->vendor)->name ?? ''}}">{{number_format($application->totalScore(), 2)}}</th>
                                                @endif
                                            @endforeach
                                        </tr>
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
                                    {{nova_get_setting('accenture_projectBenchmark_vendorScore') ?? ''}}
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
                                                <h4>Extract vendor replies for all RFP questions</h4>
                                                <div style="text-align: center; margin-top: 30px;">
                                                    <button class="btn btn-primary btn-lg btn-icon-text"
                                                            target="_blank"
                                                            id="exportExcelButton">
                                                        <i data-feather="download"></i> &nbsp;
                                                        Download responses
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="float: left; margin-top: 20px;">
                                    <button id="publishAnalytics" class="btn btn-primary btn-lg">
                                        {{ $project->publishedAnalytics ? 'Reverse publish analytics' : 'Publish Analytics' }}
                                    </button>
                                </div>

                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                       href="{{route('accenture.projectHome', ['project' => $project])}}">
                                        <i data-feather="arrow-left"></i>
                                        Go back to project
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer/>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        function togglePublishAnalytics() {
            $.post('/accenture/newProjectSetUp/togglePublishProjectAnalytics', {
                project_id: '{{$project->id}}',
            }).done(function () {
                location.reload()
            }).fail(handleAjaxError)
        }

        $(document).ready(function () {

            $('#publishAnalytics').click(togglePublishAnalytics);

            $("#exportExcelButton").click(function () {
                let url = "{{route('accenture.exportAnalytics', ['project' => $project])}}";

                var selectedVendors = $('#vendorSelect').select2('data').map(function(el) {
                    return $(el.element).data('vendorId')
                });
                if (selectedVendors.length == 0) {
                    selectedVendors = $('#vendorSelect').children().toArray().map(function(el) {
                        return $(el).data('vendorId')
                    });
                }

                @if($subsection === 'useCasesOverall')
                window.open(url + "?vendors=" + JSON.stringify(selectedVendors) + '&includeUseCases=1', '_blank')
                @else
                window.open(url + "?vendors=" + JSON.stringify(selectedVendors), '_blank')
                @endif
            });


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
                        name: "{{optional($application->vendor)->name ?? ''}}",
                        data: [
                            {{$application->fitgapScore()}},
                            {{$application->vendorScore()}},
                            {{$application->experienceScore()}},
                            {{$application->innovationScore()}},
                            {{$application->implementationScore()}},
                            @if($application->useCasesInfo ?? null)
                            {{$application->useCasesInfo->total}}
                            @endif
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
                    "Implementation and Commercials",
                    @if($subsection === 'useCasesOverall')
                    "Use Cases"
                    @endif
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
                        name: "{{optional($application->vendor)->name ?? ''}}",
                        data: [
                            {x: 'w1', y: {{$application->fitgapScore()}} },
                            {x: 'w2', y: {{$application->vendorScore()}} },
                            {x: 'w3', y: {{$application->experienceScore()}} },
                            {x: 'w4', y: {{$application->innovationScore()}} },
                            {x: 'w5', y: {{$application->implementationScore()}} },
                            @if($application->useCasesInfo ?? null)
                            {x: 'w6', y: {{$application->useCasesInfo->total}} }
                            @endif
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
                        "Implementation",
                        @if($subsection === 'useCasesOverall')
                        "Use Cases"
                        @endif
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
