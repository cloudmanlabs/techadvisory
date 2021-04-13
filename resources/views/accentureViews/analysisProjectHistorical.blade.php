@extends('layouts.base')

@section('content')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="benchmark" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Global Analysis & Analytics</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            {{nova_get_setting('accenture_analysisProjectHistorical_title') ?? ''}}
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
                                <h3>Historical Benchmarking</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_analysisProjectHistorical_historicalBenchmarking') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>TOTAL</h4>
                                                <br><br>
                                                <canvas id="projectsByYear"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>BY SC CAPABILITY (PRACTICE)</h4>
                                                <br><br>
                                                <canvas id="projectsByYearAndPractice"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>BY REGION</h4>
                                                <br><br>
                                                <canvas id="projectsByYearnAndRegion"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>BY INDUSTRY</h4>
                                                <br><br>
                                                <canvas id="projectsByYearAndIndustry"></canvas>
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

@section('scripts')
@parent
<script>
    $(function () {
        const colors = ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"];
        const longColorArray = colors.concat(colors.splice(0,colors.length-1).reverse()).concat(colors.splice(1,colors.length));

        new Chart($('#projectsByYear'), {
            type: 'line',
            data: {
                labels: [
                    @foreach($years as $year)
                    {{$year->year}},
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach($years as $year)
                        {{$year->projectCount}},
                        @endforeach
                    ],
                    label: "Total",
                    borderColor: "#27003d",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }]
            },
            options: {
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 20,
                            fontSize: 17
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            stacked: true,
                            fontSize: 17,
                        }
                    }]
                }
            }
        });

    // SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],

        new Chart($('#projectsByYearAndPractice'), {
            type: 'line',
            data: {
                labels: [
                    @foreach($years as $year)
                    {{$year->year}},
                    @endforeach
                ],
                datasets: [
                    @foreach($practices as $practice)
                    {
                        data: [
                            @foreach($years as $year)
                            {{$practice->projects->filter(function($project) use ($year){
                                return $project->created_at->year == $year->year;
                            })->count()}},
                            @endforeach
                        ],
                        label: "{{$practice->name}}",
                        borderColor: longColorArray[{{$loop->index}} % 12],
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                    @endforeach
                ]
            },
            options: {
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 20,
                            stepSize: 1,
                            fontSize: 17
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            stacked: true,
                            fontSize: 17,
                        }
                    }]
                }
            }
        });

        new Chart($('#projectsByYearnAndRegion'), {
            type: 'line',
            data: {
                labels: [
                    @foreach($years as $year)
                    {{$year->year}},
                    @endforeach
                ],
                datasets: [
                    @foreach($regions as $region)
                    {
                        data: [
                            @foreach($region->projectCounts as $count)
                            {{$count}},
                            @endforeach
                        ],
                        label: "{{$region->name}}",
                        borderColor: longColorArray[{{$loop->index}} % 12],
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                    @endforeach
                ]
            },
            options: {
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 20,
                            stepSize: 1,
                            fontSize: 17
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            stacked: true,
                            fontSize: 17,
                        }
                    }]
                }
            }
        });

        new Chart($('#projectsByYearAndIndustry'), {
            type: 'line',
            data: {
                labels: [
                    @foreach($years as $year)
                    {{$year->year}},
                    @endforeach
                ],
                datasets: [
                    @foreach($industries as $industry)
                    {
                        data: [
                            @foreach($industry->projectCounts as $count)
                            {{$count}},
                            @endforeach
                        ],
                        label: "{{$industry->name}}",
                        borderColor: longColorArray[{{$loop->index}} % 12],
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                    @endforeach
                ]
            },
            options: {
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 20,
                            stepSize: 1,
                            fontSize: 17
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            stacked: true,
                            fontSize: 17,
                        }
                    }]
                }
            }
        });
    });
</script>
@endsection
