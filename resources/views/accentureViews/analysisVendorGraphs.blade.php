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
                                            {{nova_get_setting('accenture_analysisVendorGraphs_title') ?? ''}}
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
                                <h3>Graphs</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_analysisVendorGraphs_graphs') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>VENDORS BY PRACTICE</h4>
                                                <br><br>
                                                <canvas id="chartPractice"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>VENDORS PER INDUSTRY</h4>
                                                <br><br>
                                                <canvas id="chartIndustry"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>VENDORS PER REGION</h4>
                                                <br><br>
                                                <canvas id="chartRegion"></canvas>
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
    // COMPLETE: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
    // SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],

        const colors = ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"];
        const longColorArray = [
            ...colors,
            ...colors.splice(0,colors.length-1).reverse(), // We use the split so we don't repeat a color
            ...colors.splice(1,colors.length)
        ];
        const shortColorArray = ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"]

        new Chart($("#chartPractice"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach($practices as $practice)
                    "{{$practice->name}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: "",
                        backgroundColor: shortColorArray,
                        data: [
                            @foreach($practices as $practice)
                            "{{$practice->count}}",
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
                            integer: true,
                            fontSize: 17,
                            suggestedMax: 20,
                            step: 1
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

        new Chart($("#chartIndustry"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach($industries as $industry)
                    "{{$industry->name}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: "",
                        backgroundColor: longColorArray,
                        data: [
                            @foreach($industries as $industry)
                            "{{$industry->count}}",
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
                            integer: true,
                            suggestedMax: 20,
                            fontSize: 17,
                            step: 1
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

        new Chart($("#chartRegion"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach($regions as $region)
                    "{{$region->name}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: "",
                        backgroundColor: shortColorArray,
                        data: [
                            @foreach($regions as $region)
                            "{{$region->count}}",
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
                            integer: true,
                            fontSize: 17,
                            suggestedMax: 20,
                            step: 1
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
