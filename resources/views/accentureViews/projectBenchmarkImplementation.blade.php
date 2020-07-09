@extends('accentureViews.layouts.benchmark')

@php
    //NOTE This is basically to have the table ordered when the scores are random
    $orderedApps = $applications->map(function($application, $key){
        return (object)[
            'name' => $application->vendor->name,
            'score' => $application->implementationScore()
        ];
    })
    ->sortByDesc('score');
@endphp

@section('content')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectBenchmark" subsection="implementation" :project="$project" />

                <br>

                <x-projectBenchmarkVendorFilter :applications="$applications" />

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendor Ranking by Implementation&Commercials section</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectBenchmarkImplementation_ranking') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="col-lg-6 col-mg-12 offset-lg-3">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Position</th>
                                                    <th>Vendor</th>
                                                    <th>Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orderedApps as $obj)
                                                <tr class="filterByVendor" data-vendor="{{$obj->name}}">
                                                    <th class="table-dark">{{ $loop->iteration }}</th>
                                                    <td>{{$obj->name}}</td>
                                                    <td>{{number_format($obj->score, 2)}}</td>
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

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendor comparison</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectBenchmarkImplementation_comparison') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>VENDORS SORTED BY TOTAL COST OF OWNERSHIP</h4>
                                                <br>
                                                <canvas id="innovationScoreGraph"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>COST DETAIL</h4>
                                                <p class="welcome_text extra-top-15px">
                                                    Below is a breakdown of the vendors’ cost detail covering implementation cost and average yearly run cost.
                                                </p>
                                                <br />
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Cost</th>
                                                                @foreach ($applications as $application)
                                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">{{$application->vendor->name}}</th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th class="table-dark">Implementation</th>
                                                                @foreach ($applications as $application)
                                                                <td class="filterByVendor" data-vendor="{{$application->vendor->name}}">{{$project->currency ?? ''}} {{number_format($application->implementationCost(), 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th class="table-dark">Average Yearly Run</th>
                                                                @foreach ($applications as $application)
                                                                <td class="filterByVendor" data-vendor="{{$application->vendor->name}}">{{$project->currency ?? ''}} {{number_format($application->runCost(), 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br><br><br>
                                                <canvas id="chartjsBar2"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                        href="{{route('accenture.projectBenchmark', ['project' => $project])}}">
                                        <i data-feather="arrow-left"></i>
                                        Go back to Benchmark & Analytics
                                    </a>
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
        new Chart($("#innovationScoreGraph"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($orderedApps as $obj)
                        "{{$obj->name}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: "",
                        backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                        data: [
                            @foreach ($orderedApps as $obj)
                                {{$obj->score}},
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
                            max: 10,
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

        new Chart($("#chartjsBar2"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($applications as $application)
                    "{{$application->vendor->name}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: "Implementation",
                        backgroundColor: ["#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d"],
                        data: [
                            @foreach ($applications as $application)
                            {{$application->implementationCost()}},
                            @endforeach
                        ],
                        stack: 'Stack 0'
                    },
                    {
                        label: "Average yearly run",
                        backgroundColor: ["#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f"],
                        data: [
                            @foreach ($applications as $application)
                            {{$application->averageRunCost()}},
                            @endforeach
                        ],
                        stack: 'Stack 0'
                    }
                ]
            },
            options: {
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stacked: true,
                            callback: function (value, index, values) {
                                return '{{$project->currency ?? ''}} ' + value;
                            },
                            fontSize: 17
                        }
                    }], xAxes: [{
                        ticks: {
                            stacked: true,
                            fontSize: 17
                        }
                    }]
                }
            }
        });
});
</script>
@endsection
