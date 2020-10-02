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
                                            <select id="industry-select">
                                                <option value="null" selected>Chose a Industry</option>
                                                @foreach($industries as $industry)
                                                    <option value="{{$industry}}">{{$industry}}</option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <select id="region-select">
                                                <option value="null" selected>Chose a Region</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{$region}}">{{$region}}</option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <select id="practice-select">
                                                <option value="null" selected>Chose a Practice</option>
                                                @foreach ($practices as $practice)
                                                    <option value="{{$practice->id}}">{{$practice->name}}</option>
                                                @endforeach
                                            </select>
                                        </aside>
                                        <div id="charts-container" class="col-8 border-left">
                                            <div class="row pl-3">
                                                <h3>Historical Benchmarking</h3>
                                                <p class="welcome_text extra-top-15px">
                                                    {{nova_get_setting('accenture_analysisProjectHistorical_historicalBenchmarking') ?? ''}}
                                                </p>
                                            </div>
                                            <br>
                                            <div class="row" id="chart1-row">
                                                <div class="col-xl-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4>TOTAL</h4>
                                                            <br><br>
                                                            <canvas id="projects-by-year-chart"></canvas>
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

        $('#industry-select').change(function () {
            var selected = $(this).children("option:selected").val();
            var url_args = '?industry=' + selected;
            location.replace('/accenture/benchmark/overview/historical' + url_args);
        });
        $('#region-select').change(function () {
            var selected = $(this).children("option:selected").val();
            var url_args = '?region=' + selected;
            location.replace('/accenture/benchmark/overview/historical' + url_args);
        });
        $('#practice-select').change(function () {
            var selected = $(this).children("option:selected").val();
            var url_args = '?practice=' + selected;
            location.replace('/accenture/benchmark/overview/historical' + url_args);
        });

        // Chart 1
        new Chart($('#projects-by-year-chart'), {
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

    </script>
@endsection

