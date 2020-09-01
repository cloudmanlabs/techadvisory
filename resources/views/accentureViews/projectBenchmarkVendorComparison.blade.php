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
    function getAllVendorsAndScores($applications){
        $vendorsAndScores = [];
        foreach ($applications as $key=>$application){
            $vendorsAndScores[$application->vendor->id] = number_format($application->totalScore(), 2);
        }
        return $vendorsAndScores;
    }

    function getScoresFromVendor($applications,$vendor){
        $scores = [];
        foreach ($applications as $key=>$application){
            if($application->vendor->id == $vendor){
                $scores[0] = number_format($application->fitgapScore(), 2);
                $scores[1] = number_format($application->vendorScore(), 2);
                $scores[2] = number_format($application->experienceScore(), 2);
                $scores[3] = number_format($application->innovationScore(), 2);
                $scores[4] = number_format($application->implementationScore(), 2);
            }
        }
        return $scores;
    }

    function ponderateScoresByClient($bestScores,$actualScores){
        $scoresPonderated = [];
        foreach ($actualScores as $key=>$actualScore){
            $scoresPonderated[$key] = $actualScores[$key]*10*($bestScores[$key]/100);
        }
        return $scoresPonderated;
    }

    $bestVendorsScoreDatasets = [];
    $allVendorsAndScores = getAllVendorsAndScores($applications);
    if (!empty($allVendorsAndScores)){
        $bestScore = max($allVendorsAndScores);
        $bestVendor = array_search($bestScore,$allVendorsAndScores);
        $bestVendorScores = getScoresFromVendor($applications,$bestVendor);
        $bestVendorsScoreDatasets = ponderateScoresByClient($bestPossibleDatasets,$bestVendorScores);
    }

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
    if (!empty($allVendorsAndScores)){
        $averages = [];
        $averages[0] = getAverageScore($applications,"fitgapScore");
        $averages[1] = getAverageScore($applications,"vendorScore");
        $averages[2] = getAverageScore($applications,"experienceScore");
        $averages[3] = getAverageScore($applications,"innovationScore");
        $averages[4] = getAverageScore($applications,"implementationScore");
        $averageBestVendorsDatasets = ponderateScoresByClient($bestPossibleDatasets,$averages);
    }


@endphp

@php
    // Values from selected vendor
    $selectedVendor = $vendor;
    $vendorSelectedDatasets = [];
    if(!empty($vendor)){
        $scores = getScoresFromVendor($applications, $selectedVendor);
        $vendorSelectedDatasets = [];
        $vendorSelectedDatasets = ponderateScoresByClient($bestPossibleDatasets,$scores);
    }

@endphp

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections"/>

        <div class="page-wrapper">
            <div class="page-content">
                <x-accenture.projectNavbar section="projectBenchmark" subsection="VendorComparison"
                                           :project="$project"/>
                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Benchmark and Analytics</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            Please choose the Vendors you'd like to add in the comparison tables:
                                            <br><br>
                                            <select id="vendorSelect" class="w-100" required>
                                                <option disabled selected value> -- select a vendor -- </option>
                                                @foreach ($applications as $application)
                                                    <option data-vendor-id="{{optional($application->vendor)->id}}">{{optional($application->vendor)->name}}</option>
                                                @endforeach
                                            </select>
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

        $('#vendorSelect').change(function(){
            var selectedVendor = $(this).children("option:selected").data('vendorId');
            var projectId = {{$project->id}}
            var url_args = '?vendor='+selectedVendor;
            // pass vendor id through url params as get paramether
            location.replace('/accenture/project/benchmark/vendorComparison/'+projectId+url_args);
        });

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

        var vendorSelectedDatasets = [
            @foreach ($vendorSelectedDatasets as $dataset)
            {{$dataset}},
            @endforeach
        ];

        var ctx = document.getElementById('bestVendorGraph');
        var stackedBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Best Possible', 'Best Vendors', 'Average', 'Selected Vendor'],
                datasets: [
                    {
                        label: 'FitGap',
                        data: [bestPossibleDatasets[0], bestVendorsValuesDatasets[0],
                            averageBestVendorsDatasets[0], vendorSelectedDatasets[0]],
                        backgroundColor: '#608FD1'
                    },
                    {
                        label: 'Vendor',
                        data: [bestPossibleDatasets[1], bestVendorsValuesDatasets[1],
                            averageBestVendorsDatasets[1], vendorSelectedDatasets[1]],
                        backgroundColor: '#E08733'
                    },
                    {
                        label: 'Experience',
                        data: [bestPossibleDatasets[2], bestVendorsValuesDatasets[2],
                            averageBestVendorsDatasets[2], vendorSelectedDatasets[2]],
                        backgroundColor: '#4A922A'
                    },
                    {
                        label: 'Innovation & vision',
                        data: [bestPossibleDatasets[3], bestVendorsValuesDatasets[3],
                            averageBestVendorsDatasets[3], vendorSelectedDatasets[3]],
                        backgroundColor: '#C645D5'
                    },
                    {
                        label: 'Implementation & Commercials',
                        data: [bestPossibleDatasets[4], bestVendorsValuesDatasets[4],
                            averageBestVendorsDatasets[4], vendorSelectedDatasets[4]],
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
