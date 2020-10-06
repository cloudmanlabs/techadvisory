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
                                        <h3>Innovation & Vision Results</h3>
                                        <p class="welcome_text extra-top-15px">
                                        </p>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row" id="chart1-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Best {{count($vendorScoresInnovation)}} Vendors By Innovation & Vision Score</h4>
                                                    <br><br>
                                                    <canvas id="best-innovation-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="table-projects-count-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Number of projects</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Vendor name</th>
                                                            <th scope="col">Projects applied</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vendorScoresInnovation as $key=>$vendorScore)
                                                            <tr>
                                                                <td>{{\App\User::find($key)->name}}</td>
                                                                <td>{{count(\App\User::find($key)->vendorApplications)}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
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
        var inovationChart = new Chart($('#best-innovation-chart'), {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($vendorScoresInnovation as $key=>$value)
                            "{{\App\User::find($key)->name}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                            data: [
                                @foreach($vendorScoresInnovation as $key => $value)
                                    "{{$value}}",
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
                    }
                }
            }
        );
    </script>
@endsection

