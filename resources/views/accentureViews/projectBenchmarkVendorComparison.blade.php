<!-- Feature 1.2: New Tab for Best vendor Comparison graph -->
@extends('accentureViews.layouts.benchmark')

@php
    // Values for Best Possible
    $values = $project->scoringValues;
    $bestPossibleDatasets= [];
    foreach ($values as $key=>$bestPossible){
        $bestPossibleDatasets[$key] = $values[$key] * 5;
    }
@endphp

@php
    // Values for best from vendors
    function getMaxScore($applications,$scoreType){
        $array_temporal = [];
        foreach ($applications as $key=>$application){
            $array_temporal[$key] = number_format($application->$scoreType(), 2);
        }
        return max($array_temporal);
    }

    $bestVendorsScoreDatasets = [];
    $bestVendorsScoreDatasets[0] = getMaxScore($applications,"fitgapScore");
    $bestVendorsScoreDatasets[1] = getMaxScore($applications,"vendorScore");
    $bestVendorsScoreDatasets[2] = getMaxScore($applications,"experienceScore");
    $bestVendorsScoreDatasets[3] = getMaxScore($applications,"innovationScore");
    $bestVendorsScoreDatasets[4] = getMaxScore($applications,"implementationScore");
@endphp

@php
    // Values from average from vendors
    function getAverageScore($applications,$scoreType){
        $array_temporal = [];
        foreach ($applications as $key=>$application){
            $array_temporal[$key] = number_format($application->$scoreType(), 2);
        }
        $array_temporal = array_filter($array_temporal);
        $average = array_sum($array_temporal)/count($array_temporal);
        return $average;
    }

    $averageBestVendorsDatasets = [];
    $averageBestVendorsDatasets[0] = getAverageScore($applications,"fitgapScore");
    $averageBestVendorsDatasets[1] = getAverageScore($applications,"vendorScore");
    $averageBestVendorsDatasets[2] = getAverageScore($applications,"experienceScore");
    $averageBestVendorsDatasets[3] = getAverageScore($applications,"innovationScore");
    $averageBestVendorsDatasets[4] = getAverageScore($applications,"implementationScore");
@endphp

@php
    // Values from selected vendor
/*
    function getVendorScore($applications,$scoreType){
        $array_temporal = [];
        $applications->filter(function (User $vendor) {
                    return $vendor->name == 'Vendor 2';
                })->$scoreType;
    }
    dd(getVendorScore($applications,"fitgapScore"));*/
@endphp



@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">
                <x-accenture.projectNavbar section="projectBenchmark" subsection="VendorComparison"
                                           :project="$project"/>
                <br>
                <x-projectBenchmarkVendorFilter :applications="$applications"/>
                <br><br>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendor comparison</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectBenchmarkVendor_comparison') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>Best vendor comparison</h4>
                                                <br>
                                                <br>
                                                <canvas id="bestVendorGraph"></canvas>
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
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>

        var bestPossibleDatasets = [
            @foreach ($bestPossibleDatasets as $dataset)
            {{$dataset}},
            @endforeach
        ]
        var bestVendorsValuesDatasets = [
            @foreach ($bestVendorsScoreDatasets as $dataset)
            {{$dataset}},
            @endforeach
        ];

        var averageBestVendorsDatasets = [
            @foreach ($averageBestVendorsDatasets as $dataset)
            {{$dataset}},
            @endforeach
        ];

        var vendorSelected = [];

        var ctx = document.getElementById('bestVendorGraph');
        var stackedBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Best Possible', 'Best Vendors', 'Average', 'Selected Vendor'],
                datasets: [
                    {
                        label: 'FitGap',
                        data: [bestPossibleDatasets[0], bestVendorsValuesDatasets[0],
                            averageBestVendorsDatasets[0], vendorSelected[0]],
                        backgroundColor: '#608FD1'
                    },
                    {
                        label: 'Vendor',
                        data: [bestPossibleDatasets[1], bestVendorsValuesDatasets[1],
                            averageBestVendorsDatasets[1], vendorSelected[1]],
                        backgroundColor: '#E08733'
                    },
                    {
                        label: 'Experience',
                        data: [bestPossibleDatasets[2], bestVendorsValuesDatasets[2],
                            averageBestVendorsDatasets[2], vendorSelected[2]],
                        backgroundColor: '#4A922A'
                    },
                    {
                        label: 'Innovation & vision',
                        data: [bestPossibleDatasets[3], bestVendorsValuesDatasets[3],
                            averageBestVendorsDatasets[3], vendorSelected[3]],
                        backgroundColor: '#C645D5'
                    },
                    {
                        label: 'Implementation & Commercials',
                        data: [bestPossibleDatasets[4], bestVendorsValuesDatasets[4],
                            averageBestVendorsDatasets[4], vendorSelected[4]],
                        backgroundColor: '#a30749'
                    }
                ]
            },
            options: {
                scales: {
                    xAxes: [{stacked: true}],
                    yAxes: [{stacked: true}]
                }
            }
        });

    </script>
@endsection
