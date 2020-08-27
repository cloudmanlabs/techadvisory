@extends('accentureViews.layouts.benchmark')

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
                                            {{nova_get_setting('accenture_analysisProjectVendor_title') ?? ''}}
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
                                <h3>Vendor Benchmarking</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_analysisProjectVendor_vendorBenchmarking') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>AVERAGE RESPONSE PER SC CAPABILITY (PRACTICE)</h4>
                                                <br><br>
                                                <canvas id="responsePerPracticeChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>PROJECTS ANSWERED BY VENDOR</h4>
                                                <br><br>
                                                <canvas id="responsePerVendor"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>VENDOR PERFOMANCE OVERVIEW</h4>
                                                <br><br>
                                                <canvas id="vendorPerformance"></canvas>
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
    // Bar chart
    new Chart($("#responsePerPracticeChart"), {
        type: 'bar',
        data: {
            labels: [
                @foreach($practices as $practice)
                    "{{$practice->name}}",
                @endforeach
            ],
            datasets: [
                {
                    label: "Population",
                    backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                    data: [
                        @foreach($practices as $practice)
                        "{{$practice->applicationsInProjectsWithThisPractice()}}",
                        @endforeach
                    ]
                }
            ]
        },
        options: {
            legend: { display: false },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 7,
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


    new Chart($('#responsePerVendor'), {
        type: 'bar',
        data: {
            labels: [
                @foreach($practices as $practice)
                    "{{$practice->name}}",
                @endforeach
            ],
            datasets: [
                @foreach($vendors as $vendor)
                    {
                        label: "{{$vendor->name}}",
                        backgroundColor: ["#27003d","#410066","#5a008f",
                        "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"][{{$loop->index}} % 12],
                        data: [
                            @foreach($practices as $practice)
                            "{{$practice->numberOfProjectsByVendor($vendor)}}",
                            @endforeach
                        ]
                    },
                @endforeach
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 9,
                        fontSize: 17
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontSize: 17
                    }
                }]
            }
        }
    });

    var vendorPerformance = new Chart($('#vendorPerformance'), {
        type: 'bubble',
        data: {
            labels: "",
            datasets: [
                @foreach($vendors as $vendor)
                    @php
                        // NOTE: We use 10 - val so we get the chart flipped horizontally
                        $ranking = 10 - $vendor->averageRanking();
                        $score = $vendor->averageScore() ?? 0;
                    @endphp
                    {
                        label: ["{{$vendor->name}}"],
                        backgroundColor: ["#27003d","#410066","#5a008f",
                        "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"][{{$loop->index}} % 12],
                        borderColor: ["#27003d","#410066","#5a008f",
                        "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"][{{$loop->index}} % 12],
                        data: [
                            {
                                x: {{$ranking}},
                                y: {{$score}},
                                r: {{ ($ranking + $score) * 3 }}
                            }
                        ],
                        hidden: {{$loop->index > 3 ? 'true' : 'false'}},
                    },
                @endforeach
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Av. Score",
                        fontSize: 17
                    },
                    ticks: {
                        beginAtZero: false,
                        min: 1,
                        max: 10,
                        fontSize: 17
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Av. Ranking",
                        fontSize: 17
                    },
                    ticks: {
                        beginAtZero: false,
                        min: 1,
                        max: 10,
                        fontSize: 17,
                        callback: function (tick, index, ticks) {
                            return (11 - tick).toString();
                        }
                    }
                }]
            }
        }
    });
});
</script>
@endsection
