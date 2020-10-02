@extends('accentureViews.layouts.benchmark')
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
                <div class="row">
                    <div class="col-12 grid-margin">
                        @include('accentureViews.benchmarkNavBar')
                        @include('accentureViews.benchmarkProjectResultsNavBar')
                    </div>
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
                                    <select id="practice-select">
                                        <option value="null" selected>Chose a Practice</option>
                                        @foreach ($practices as $practice)
                                            <option value="{{$practice->id}}">{{$practice->name}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    @if(count($subpractices)>0)
                                        <select id="subpractice-select">
                                            <option value="null" selected>Chose a Subpractice</option>
                                            @foreach ($subpractices as $subpracice)
                                                <option value="{{$subpractice->id}}">{{$subpractice->name}}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                    @endif
                                    <select id="years-select">
                                        <option value="null" selected>Chose a Year</option>
                                        @foreach ($projectsByYears as $year)
                                            <option value="{{$year->year}}">{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <select id="industries-select">
                                        <option value="null" selected>Chose a Industry</option>
                                        @foreach ($industries as $industry)
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
                                </aside>
                                <div id="charts-container" class="col-8 border-left">
                                    <div class="row pl-3">
                                        <h3>Overall Results</h3>
                                        <p class="welcome_text extra-top-15px">
                                        </p>
                                    </div>
                                    <br>
                                    <div id="information-panels">
                                        <div class="row justify-content-center" id="information-panels-row1">
                                            <div class="col-5 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <h5>Total Clients</h5>
                                                        <br>
                                                        <h3>48</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <h5>Total Vendors</h5>
                                                        <br>
                                                        <h3>48</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center" id="information-panels-row2">
                                            <div class="col-5 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <h5>Total Proyects</h5>
                                                        <br>
                                                        <h3>48</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <h5>Total Solutions</h5>
                                                        <br>
                                                        <h3>48</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="chart1-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Best Vendors Overall</h4>
                                                    <br><br>
                                                    <canvas id="region-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="chart2-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Vendor Performance Overview</h4>
                                                    <br>
                                                    <canvas id="vendor-performance-chart"></canvas>
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


@section('scripts')
    @parent
    <script>
        var vendorPerformance = new Chart($('#vendor-performance-chart'), {
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
                        backgroundColor: ["#27003d", "#410066", "#5a008f",
                            "#7400b8", "#8e00e0", "#9b00f5", "#a50aff", "#c35cff", "#d285ff", "#e9c2ff", "#f0d6ff", "#f8ebff"][{{$loop->index}} % 12],
                borderColor: ["#27003d", "#410066", "#5a008f",
                    "#7400b8", "#8e00e0", "#9b00f5", "#a50aff", "#c35cff", "#d285ff", "#e9c2ff", "#f0d6ff", "#f8ebff"][{{$loop->index}} % 12
        ],
        data: [
            {
                x: {{$ranking}},
                y: {{$score}},
                r: {{ ($ranking + $score) * 3 }}
            }
        ],
            hidden
        : {{$loop->index > 3 ? 'true' : 'false'}},
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
                    xAxes
            :
                [{
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
        })
        ;
    </script>
@endsection
