@extends('accentureViews.layouts.benchmark')

@php
    /*foreach ($industriesToFilter as $industry){
        $a = in_array($industry,$industriesToFilter);
        var_dump($industry);
        var_dump($a);
    }*/
@endphp
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
                                            <br>
                                            <label for="practice-select">Chose a Industry</label>
                                            <select id="industry-select" multiple>
                                                @foreach($industries as $industry)
                                                    <option
                                                        value="{{$industry}}"
                                                    @if($industriesToFilter)
                                                        {{ in_array($industry,$industriesToFilter)? 'selected="selected"' : ''}}
                                                        @endif
                                                    >
                                                        {{$industry}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            <label for="region-select">Chose a region</label>
                                            <select id="region-select" multiple>
                                                @foreach ($regions as $region)
                                                    <option
                                                        value="{{$region}}"
                                                    @if($regionsToFilter)
                                                        {{ in_array($region,$regionsToFilter)? 'selected="selected"' : ''}}
                                                        @endif
                                                    >
                                                        {{$region}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            <label for="practice-select">Chose a Practice</label>
                                            <select id="practice-select" multiple>
                                                @foreach ($practices as $practice)
                                                    <option
                                                        value="{{$practice->id}}"
                                                    @if($practicesToFilter)
                                                        {{ in_array($practice->id,$practicesToFilter)? 'selected="selected"' : ''}}
                                                        @endif
                                                    >
                                                        {{$practice->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            <button id="filter-btn" class="btn btn-primary btn-lg btn-icon-text">
                                                Click to Filter
                                            </button>
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

        $('#industry-select').select2();
        $('#region-select').select2();
        $('#practice-select').select2();

        $('#filter-btn').click(function () {
            var industry = encodeURIComponent($('#industry-select').val());
            var regions = encodeURIComponent($('#region-select').val());
            var practices = encodeURIComponent($('#practice-select').val());

            var currentUrl = '/accenture/benchmark/overview/historical';
            var url = currentUrl + '?' + 'regions=' + regions + '&industries=' + industry + '&practices=' + practices;
            location.replace(url);
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
                datasets: [
                    {
                        data: [
                            @foreach($years as $year)
                            {{$year->projectCount}},
                            @endforeach
                        ],
                        label: "Total",
                        borderColor: "#27003d",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },

                        @if(count($transportProjectsByYears))
                    {
                        data: [
                            @foreach($transportProjectsByYears as $year)
                            {{$year->projectCount}},
                            @endforeach
                        ],
                        label: "Transport",
                        borderColor: "#460D72",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                        @endif

                        @if(count($planningProjectsByYears))
                    {
                        data: [
                            @foreach($planningProjectsByYears as $year)
                            {{$year->projectCount}},
                            @endforeach
                        ],
                        label: "Planning",
                        borderColor: "#A12BFE",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                        @endif

                        @if(count($manufacturingProjectsByYears))
                    {
                        data: [
                            @foreach($manufacturingProjectsByYears as $year)
                            {{$year->projectCount}},
                            @endforeach
                        ],
                        label: "Manufacturing",
                        borderColor: "#234DFF",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                        @endif

                        @if(count($warehousingProjectsByYears))
                    {
                        data: [
                            @foreach($warehousingProjectsByYears as $year)
                            {{$year->projectCount}},
                            @endforeach
                        ],
                        label: "Warehousing",
                        borderColor: "#5A5A5A",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                        @endif

                        @if(count($warehousingProjectsByYears))
                    {
                        data: [
                            @foreach($sourcingProjectsByYears as $year)
                            {{$year->projectCount}},
                            @endforeach
                        ],
                        label: "Sourcing",
                        borderColor: "#111",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                    @endif
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

