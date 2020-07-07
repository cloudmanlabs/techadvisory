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
                                            {{nova_get_setting('accenture_analysisProjectClient_title') ?? ''}}
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
                                <h3>Client Benchmarking</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_analysisProjectClient_clientBenchmarking') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4># PROJECTS PER PRACTICE</h4>
                                                <br><br>
                                                <canvas id="projectsPerPractice"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4># PROJECTS PER CLIENT</h4>
                                                <br><br>
                                                <canvas id="projectsPerClient"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4># PROJECTS PER INDUSTRY</h4>
                                                <br><br>
                                                <canvas id="projectsPerIndustry"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4># PROJECTS PER REGION</h4>
                                                <br><br>
                                                <canvas id="projectsPerRegion"></canvas>
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
        ]

        new Chart($("#projectsPerPractice"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach($practices as $practice)
                    "{{$practice->name}}".replace('&amp;', '&'),
                    @endforeach
                ],
                datasets: [
                    {
                        label: "",
                        backgroundColor: longColorArray,
                        data: [
                            @foreach($practices as $practice)
                            "{{$practice->projects->count()}}",
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

        new Chart($("#projectsPerClient"), {
            type: 'bar'.replace('&amp;', '&'),
            data: {
                labels: [
                    @foreach($clients as $client)
                    "{{$client->name}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: "",
                        backgroundColor: longColorArray,
                        data: [
                            @foreach($clients as $client)
                            "{{$client->projectsClient->count()}}",
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

        new Chart($("#projectsPerIndustry"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach($industries as $industry)
                    "{{$industry->name}}".replace('&amp;', '&'),
                    @endforeach
                ],
                datasets: [
                    {
                        label: "",
                        backgroundColor: longColorArray,
                        data: [
                            @foreach($industries as $industry)
                            {{$industry->projectCount}},
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
        new Chart($("#projectsPerRegion"), {
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
                        backgroundColor: longColorArray,
                        data: [
                            @foreach($regions as $region)
                            {{$region->projectCount}},
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
});
</script>
@endsection
