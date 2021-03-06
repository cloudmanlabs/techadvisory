@extends('layouts.base')

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
                                            <label for="industries-select">Choose an industry</label>
                                            <select id="industries-select" multiple>
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
                                            <label for="regions-select">Choose a region</label>
                                            <select id="regions-select" multiple>
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
                                                            <h4>NUMBER OF PROJECTS PER SC CAPABILITY (PRACTICE) AND CREATION YEAR</h4>
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

        $('#industries-select').select2({
            maximumSelectionLength: 1
        });
        $('#regions-select').select2();
        $('#practices-select').select2();

        $('#filter-btn').click(function () {
            var industries = encodeURIComponent($('#industries-select').val());
            var regions = encodeURIComponent($('#regions-select').val());

            var currentUrl = '/accenture/benchmark/overview/historical';
            var url = currentUrl + '?' + 'regions=' + regions + '&industries=' + industries;
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
                        borderColor: "{{config('colors.grey')}}",
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
                        borderColor: "{{config('colors.greenBlue')}}",
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
                        borderColor: "{{config('colors.blue')}}",
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
                        borderColor: "{{config('colors.purple')}}",
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
                        borderColor: "{{config('colors.black')}}",
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
                        borderColor: "{{config('colors.rose')}}",
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
                            fontSize: 17,
                            precision: 0,
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

