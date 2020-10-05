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
                                            <select id="year-select">
                                                <option value="null" selected>Chose a Year</option>
                                                @foreach ($years as $year)
                                                    <option value="{{$year->year}}">{{$year->year}}</option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <select id="region-select">
                                                <option value="null" selected>Chose a Region</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{$region}}">{{$region}}</option>
                                                @endforeach
                                            </select>
                                        </aside>
                                        <div id="charts-container" class="col-8 border-left">
                                            <div class="row pl-3">
                                                <h3>General Charts</h3>
                                                <p class="welcome_text extra-top-15px">
                                                    {{nova_get_setting('accenture_analysisProjectVendor_vendorBenchmarking') ?? ''}}
                                                </p>
                                            </div>
                                            <br>
                                            <div class="row" id="chart1-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4>AVERAGE RESPONSE PER SC CAPABILITY (PRACTICE)</h4>
                                                            <br><br>
                                                            <canvas id="response-per-practice-chart"></canvas>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="chart2-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4>PROJECTS ANSWERED BY VENDOR</h4>
                                                            <br><br>
                                                            <canvas id="response-per-vendor-chart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="chart3-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4># PROJECTS PER SC CAPABILITY (PRACTICE)</h4>
                                                            <br><br>
                                                            <canvas id="projects-per-practice-chart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="chart4-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4># PROJECTS PER CLIENT</h4>
                                                            <br><br>
                                                            <canvas id="projects-per-client-chart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="chart5-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4># PROJECTS PER INDUSTRY</h4>
                                                            <br><br>
                                                            <canvas id="projects-per-industry-chart"></canvas>
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
        $('#region-select').change(function () {
            var selectedRegion = $(this).children("option:selected").val();
            var url_args = '?region=' + selectedRegion;
            location.replace('/accenture/benchmark/overview' + url_args);
        });

        $('#year-select').change(function () {
            var selected = $(this).children("option:selected").val();
            var url_args = '?year=' + selected;
            location.replace('/accenture/benchmark/overview' + url_args);
        });

        // Chart 1
        new Chart($("#response-per-practice-chart"), {
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
                legend: {display: false},
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

        // Chart 2
        new Chart($('#response-per-vendor-chart'), {
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
                        backgroundColor: ["#27003d", "#410066", "#5a008f",
                            "#7400b8", "#8e00e0", "#9b00f5", "#a50aff", "#c35cff", "#d285ff", "#e9c2ff", "#f0d6ff", "#f8ebff"][{{$loop->index}} % 12],
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
                    xAxes
            :
                [{
                    ticks: {
                        fontSize: 17
                    }
                }]
            }
        }
        })
        ;

        const colors = ["#27003d", "#410066", "#5a008f", "#7400b8", "#8e00e0", "#9b00f5", "#a50aff", "#c35cff", "#d285ff", "#e9c2ff", "#f0d6ff", "#f8ebff"];
        const longColorArray = [
            ...colors,
            ...colors.splice(0, colors.length - 1).reverse(), // We use the split so we don't repeat a color
            ...colors.splice(1, colors.length)
        ]
        // Chart 3
        new Chart($("#projects-per-practice-chart"), {
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
                legend: {display: false},
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

        // Chart 4
        new Chart($("#projects-per-client-chart"), {
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
                legend: {display: false},
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

        // Chart 5
        new Chart($("#projects-per-industry-chart"), {
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
                legend: {display: false},
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

    </script>
@endsection

