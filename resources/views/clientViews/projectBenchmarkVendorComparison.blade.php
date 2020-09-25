@extends('clientViews.layouts.benchmark')

@php
    // Values for Best Possible
    $values = $project->scoringValues;
    $bestPossibleDatasets= [];
    if(!empty($values)){
        foreach ($values as $key=>$bestPossible){
            $bestPossibleDatasets[$key] = $values[$key] * 5;
        }
    }

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

    // Values from average from vendors
    function getAverageScore($applications,$scoreType){
        $array_temporal = [];
        foreach ($applications as $key=>$application){
            $array_temporal[$key] = number_format($application->$scoreType(), 2);
        }
        $array_temporal = array_filter($array_temporal);
        $average = 0;
        if(count($array_temporal)>0){
            $average = array_sum($array_temporal)/count($array_temporal);
        }
        $average = round($average,2);
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


    // Values from selected vendor
    $selectedVendor = $vendor;
    $vendorSelectedDatasets = [];
    if(!empty($vendor)){
        $scores = getScoresFromVendor($applications, $selectedVendor);
        $vendorSelectedDatasets = [];
        $vendorSelectedDatasets = ponderateScoresByClient($bestPossibleDatasets,$scores);
    }

@endphp

@php
    // fitgap graphic ***********************************************************

    // Arrays for graphics.
    $bestFitgapPossible = [];
    $bestFitgapVendor = [];
    $averageFitgap = [];
    $selectedFitgap= [];

    $weightValues = [
        isset($project->fitgapFunctionalWeight) ? $project->fitgapFunctionalWeight / 5 : 5,
        isset($project->fitgapTechnicalWeight) ? $project->fitgapTechnicalWeight / 5 : 5,
        isset($project->fitgapServiceWeight) ? $project->fitgapServiceWeight / 5 : 5,
        isset($project->fitgapOthersWeight) ? $project->fitgapOthersWeight / 5 : 5
    ];

    // Fitgap 1st column: Best possible.
    if(!empty($weightValues)){
        for($i=0;$i<count($weightValues);$i++){
            $bestFitgapPossible[$i] = $weightValues[$i] * 5;
        }
    }

    // These are the generic scores from the vendors fitgap overall scores.
    // We search these in order to get the best vendor in fitgap terms.
    $orderedApps = $applications->map(function($application, $key){
        return (object)[
            'id' => $application->vendor->id,
            'score' => $application->fitgapScore()
        ];
    })
    ->sortByDesc('score');

    $bestVendorFitgapOverall = $orderedApps->first();
    if(!empty($bestVendorFitgapOverall)){
        $bestFitgapVendor = getFitgapScoresFromVendor($applications,$bestVendorFitgapOverall->id);
        $bestFitgapVendor = ponderateScoresByClient($bestFitgapPossible,$bestFitgapVendor);
    }

    function getFitgapScoresFromVendor($applications,$vendor_id){
        $scores = [];
        foreach($applications as $application){
            if($application->vendor->id == $vendor_id){
                $scores[0] = number_format($application->fitgapFunctionalScore(), 2);
                $scores[1] = number_format($application->fitgapTechnicalScore(), 2);
                $scores[2] = number_format($application->fitgapServiceScore(), 2);
                $scores[3] = number_format($application->fitgapOtherScore(), 2);
            }
        }
        return $scores;
    }

    // Fitgap 3st colunm
    if(!empty($orderedApps)){
        $averageFitgap[0] = getAverageScore($applications,"fitgapFunctionalScore");
        $averageFitgap[1] = getAverageScore($applications,"fitgapTechnicalScore");
        $averageFitgap[2] = getAverageScore($applications,"fitgapServiceScore");
        $averageFitgap[3] = getAverageScore($applications,"fitgapOtherScore");
        $averageFitgap = ponderateScoresByClient($bestFitgapPossible,$averageFitgap);
    }

    // Fitgap 4th column
    $selectedVendor = (int)$vendor;
    if(is_int($selectedVendor)){
        $selectedFitgap = getFitgapScoresFromVendor($applications, $selectedVendor);
        $selectedFitgap = ponderateScoresByClient($bestFitgapPossible,$selectedFitgap);
    }

@endphp

@php

    // Implementation & Commercials Graphic *********************************************

    // Arrays for graphics.
    $bestImplementationPossible = [];
    $bestImplementationVendor = [];
    $averageImplementation = [];
    $selectedImplementation= [];

    $implementationValues = [
        isset($project->implementationImplementationWeight) ? $project->implementationImplementationWeight / 5 : 10,
        isset($project->implementationRunWeight) ? $project->implementationRunWeight / 5 : 10
    ];

    $bestImplementationPossible = [];
    if(!empty($implementationValues)){
        for($i=0;$i<count($implementationValues);$i++){
            $bestImplementationPossible[$i] = $implementationValues[$i] * 5;
        }
    }

    // These are the generic scores from the vendors Implementation overall scores.
    // We search these in order to get the best vendor in Implementation terms.
    $orderedApps = $applications->map(function($application, $key){
        return (object)[
            'id' => $application->vendor->id,
            'score' => $application->implementationScore()
        ];
    })
    ->sortByDesc('score');
    $bestVendorImplementationOverall = $orderedApps->first();

    if(!empty($bestVendorImplementationOverall)){
        $bestImplementationVendor = getImplementationScores($applications,$bestVendorImplementationOverall->id);
        $bestImplementationVendor = ponderateScoresByClient($bestImplementationPossible,$bestImplementationVendor);
    }

    function getImplementationScores($applications,$vendor_id){
        $scores = [];

        foreach($applications as $application){
            if($application->vendor->id == $vendor_id){
                $scores[0] = (float)number_format($application->implementationImplementationScore(), 2);
                $scores[1] = (float)number_format($application->implementationRunScore(), 2);
            }
        }

        return $scores;
    }

    // Implementation 3st column
    if(!empty($orderedApps)){
        $averageImplementation[0] = getAverageScore($applications,"implementationImplementationScore");
        $averageImplementation[1] = getAverageScore($applications,"implementationRunScore");
        $averageImplementation = ponderateScoresByClient($bestImplementationPossible,
                                                        $averageImplementation);
    }

    // Implementation 4th column
    if(is_int($selectedVendor)){
        $selectedImplementation = getImplementationScores($applications, $selectedVendor);
        $selectedImplementation = ponderateScoresByClient($bestImplementationPossible,
                                                            $selectedImplementation);
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
                <!-- Vendor selector -->
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
                                                <option disabled selected value> -- select a vendor --</option>
                                                @foreach ($applications as $application)
                                                    <option
                                                        data-vendor-id="{{optional($application->vendor)->id}}"
                                                        data-vendor-name="{{optional($application->vendor)->name}}">
                                                        {{optional($application->vendor)->name}}</option>
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
                <!-- Graphic best vendor (Overall)-->
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
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <!-- Graphic best fitgap (Overall)-->
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>FitGap Vendor comparison</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectBenchmarkVendor_comparison') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>Best FitGap vendor comparison</h4>
                                                <br>
                                                <br>
                                                <canvas id="bestFitgapGraph"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <!-- Graphic best Implementation & Commercials (Overall)-->
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Implementation & Commercials Vendor comparison</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectBenchmarkVendor_comparison') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>Best Implementation & Commercials vendor comparison</h4>
                                                <br>
                                                <br>
                                                <canvas id="bestImplementationGraph"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                       href="{{route('client.projectBenchmark', ['project' => $project])}}">
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

        $('#vendorSelect').change(function () {
            var selectedVendor = $(this).children("option:selected").data('vendorId');
            var projectId = {{$project->id}};
            var url_args = '?vendor=' + selectedVendor;
            // pass vendor id through url params as get paramether
            location.replace('/client/project/benchmark/vendorComparison/' + projectId + url_args);
        });

        var selectedVendorBarTag = '{{$vendorName}}';
        var colorsPaletteHEX = [
            '#27003d',
            '#460073',
            '#5a008f',
            '#7500c0',
            '#a100ff'
        ];

        // Chart for best Vendor (Overall) ********************************************
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
                labels: ['Best Possible', 'Best Vendors', 'Average', selectedVendorBarTag],
                datasets: [
                    {
                        label: 'FitGap',
                        data: [bestPossibleDatasets[0], bestVendorsValuesDatasets[0],
                            averageBestVendorsDatasets[0], vendorSelectedDatasets[0]],
                        backgroundColor: colorsPaletteHEX[0]
                    },
                    {
                        label: 'Vendor',
                        data: [bestPossibleDatasets[1], bestVendorsValuesDatasets[1],
                            averageBestVendorsDatasets[1], vendorSelectedDatasets[1]],
                        backgroundColor: colorsPaletteHEX[1]
                    },
                    {
                        label: 'Experience',
                        data: [bestPossibleDatasets[2], bestVendorsValuesDatasets[2],
                            averageBestVendorsDatasets[2], vendorSelectedDatasets[2]],
                        backgroundColor: colorsPaletteHEX[2]
                    },
                    {
                        label: 'Innovation & vision',
                        data: [bestPossibleDatasets[3], bestVendorsValuesDatasets[3],
                            averageBestVendorsDatasets[3], vendorSelectedDatasets[3]],
                        backgroundColor: colorsPaletteHEX[3]
                    },
                    {
                        label: 'Implementation & Commercials',
                        data: [bestPossibleDatasets[4], bestVendorsValuesDatasets[4],
                            averageBestVendorsDatasets[4], vendorSelectedDatasets[4]],
                        backgroundColor: colorsPaletteHEX[4]
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

        // Chart for Fitgap (Overall) *************************************************
        var bestFitgapPossible = [
            @foreach($bestFitgapPossible as $dataset)
            {{$dataset}},
            @endforeach
        ];
        var bestFitgapVendor = [
            @foreach($bestFitgapVendor as $dataset)
            {{$dataset}},
            @endforeach
        ];
        var averageFitgap = [
            @foreach($averageFitgap as $dataset)
            {{$dataset}},
            @endforeach
        ];
        var selectedFitgap = [
            @foreach($selectedFitgap as $dataset)
            {{$dataset}},
            @endforeach
        ];

        var ctxFitgap = document.getElementById('bestFitgapGraph');
        var stackedBarChartFitgap = new Chart(ctxFitgap, {
            type: 'bar',
            data: {
                labels: ['Best Possible', 'Best Vendors', 'Average', selectedVendorBarTag],
                datasets: [
                    {
                        label: 'Functional',
                        data: [bestFitgapPossible[0],bestFitgapVendor[0],
                        averageFitgap[0],selectedFitgap[0]],
                        backgroundColor: colorsPaletteHEX[0]
                    },
                    {
                        label: 'Technical',
                        data: [bestFitgapPossible[1],bestFitgapVendor[1],
                        averageFitgap[1],selectedFitgap[1]],
                        backgroundColor: colorsPaletteHEX[1]
                    },
                    {
                        label: 'Service',
                        data: [bestFitgapPossible[2],bestFitgapVendor[2],
                        averageFitgap[2],selectedFitgap[2]],
                        backgroundColor: colorsPaletteHEX[2]
                    },
                    {
                        label: 'Others',
                        data: [bestFitgapPossible[3],bestFitgapVendor[3],
                        averageFitgap[3],selectedFitgap[3]],
                        backgroundColor: colorsPaletteHEX[3]
                    },
                ]
            },
            options: {
                scales: {
                    xAxes: [{stacked: true}],
                    yAxes: [{stacked: true}]
                }
            }
        });

        // Chart for Implemetation & Comercials ***************************************
        var bestImplementationPossible = [
            @foreach($bestImplementationPossible as $dataset)
            {{$dataset}},
            @endforeach
        ];
        var bestImplementationVendor = [
            @foreach($bestImplementationVendor as $dataset)
            {{$dataset}},
            @endforeach
        ];
        var averageImplementation = [
            @foreach($averageImplementation as $dataset)
            {{$dataset}},
            @endforeach
        ];
        var selectedImplementation = [
            @foreach($selectedImplementation as $dataset)
            {{$dataset}},
            @endforeach
        ];

        var ctxImpl = document.getElementById('bestImplementationGraph');
        var stackedBarChartImplementation = new Chart(ctxImpl, {
            type: 'bar',
            data: {
                labels: ['Best Possible', 'Best Vendors', 'Average', selectedVendorBarTag],
                datasets: [
                    {
                        label: 'Implementation',
                        data: [bestImplementationPossible[0],bestImplementationVendor[0],
                        averageImplementation[0], selectedImplementation[0]],
                        backgroundColor: colorsPaletteHEX[0]
                    },
                    {
                        label: 'Run',
                        data: [bestImplementationPossible[1],bestImplementationVendor[1],
                        averageImplementation[1], selectedImplementation[1]],
                        backgroundColor: colorsPaletteHEX[1]
                    },
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
