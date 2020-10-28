@extends('accentureViews.layouts.benchmark')
@section('content')

    <div class="main-wrapper">
        <x-accenture.navbar activeSection="benchmark"/>
        <div class="page-wrapper">
            <div class="page-content">

                <div class="row" id="benchmark-title-row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Welcome to Benchmark and Analytics</h3>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-page" id="benchmark-nav-container">
                    <div class="row" id="navs-container">
                        <div class="col-12 grid-margin">
                            @include('accentureViews.benchmarkNavBar')
                            @include('accentureViews.benchmarkOverviewNavBar')
                        </div>
                    </div>

                    <div class="row" id="content-container">
                        <div class="col-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <aside id="filters-container" class="col-4">
                                            <h3>Filters</h3>
                                            <br>
                                            <label>No filters availables for this section</label>
                                        </aside>
                                        <div id="charts-container" class="col-8 border-left">
                                            <div class="row pl-3">
                                                <h3>Vendor Benchmarking</h3>
                                                <p class="welcome_text extra-top-15px">
                                                </p>
                                            </div>
                                            <br>
                                            <div class="row" id="chart1-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4>VENDORS BY SC CAPABILITY (PRACTICE)</h4>
                                                            <br><br>
                                                            <canvas id="practice-chart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="chart2-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4>VENDORS PER INDUSTRY</h4>
                                                            <br><br>
                                                            <canvas id="industry-chart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="chart3-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4>VENDORS PER REGION</h4>
                                                            <br><br>
                                                            <canvas id="region-chart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endSection

@section('scripts')
    @parent
    <script>

        var shortColorArray = ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"]
        var colors = ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"];
        var longColorArray = [
            ...colors,
            ...colors.splice(0,colors.length-1).reverse(), // We use the split so we don't repeat a color
            ...colors.splice(1,colors.length)
        ];

        // Chart 1
        new Chart($("#practice-chart"), {
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
                legend: {display: false},
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            integer: true,
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

        // Chart 2
        new Chart($("#industry-chart"), {
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
                legend: {display: false},
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            integer: true,
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

        // Chart 3
        new Chart($("#region-chart"), {
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

    </script>
@endsection

