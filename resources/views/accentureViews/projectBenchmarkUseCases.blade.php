@extends('layouts.base')

@php
    //NOTE This is basically to have the table ordered when the scores are random
    $orderedApps = $applications->map(function($application, $key){
        return (object)[
            'name' => $application->vendor->name,
            'score' => $application->fitgapScore()
        ];
    })
    ->sortByDesc('score');
@endphp

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />


        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectBenchmark" subsection="useCases" :project="$project" />

                <br>
                <x-projectBenchmarkUseCaseFilter :useCases="$useCases" :selectedUseCases="$selectedUseCases" />

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendor Ranking by Use Case section</h3>
                                <p class="welcome_text extra-top-15px">
                                    Propose a weight over UseCases Section. The client will be able to modify your proposal after project setup submission.
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
                                                @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                                                <tr class="filterByVendor" data-vendor="{{$vendorProjectAnalysis->vendor_id}}">
                                                    <th class="table-dark">{{ $loop->iteration }}</th>
                                                    <td>{{$vendorProjectAnalysis->vendorName}}</td>
                                                    <td>{{number_format($vendorProjectAnalysis->total, 2)}}</td>
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
                                    Propose a weight over UseCases Section. The client will be able to modify your proposal after project setup submission.
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>Vendors sorted by Use Case score</h4>
                                                <br>
                                                <canvas id="useCasesScoreGraph"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>DETAILED USE CASES SCORE PER SCORING CRITERIA</h4>
                                                <br>
                                                <div class="media-body" style="padding: 20px;">
                                                    <p class="welcome_text">
                                                        Below is the Use Cases vendor score breakdown across the scoring criteria .
                                                    </p>
                                                    <select id="requirementSelect" class="w-100" multiple="multiple" required>
                                                        <option value="solutionFit">Solution Fit</option>
                                                        <option value="usability">Usability</option>
                                                        <option value="performance">Performance</option>
                                                        <option value="lookFeel">Look and Feel</option>
                                                        <option value="others">Others</option>
                                                    </select>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Requirement type</th>
                                                                @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                                                                <th class="filterByVendor" data-vendor="{{$vendorProjectAnalysis->vendor_id}}">{{$vendorProjectAnalysis->vendorName}}</th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="filterByRequirement" data-requirement="solutionFit">
                                                                <th class="table-dark">Solution Fit</th>
                                                                @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                                                                <td class="filterByVendor" data-vendor="{{$vendorProjectAnalysis->vendor_id}}">{{number_format($vendorProjectAnalysis->solution_fit, 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr class="filterByRequirement" data-requirement="usability">
                                                                <th class="table-dark">Usability</th>
                                                                @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                                                                <td class="filterByVendor" data-vendor="{{$vendorProjectAnalysis->vendor_id}}">{{number_format($vendorProjectAnalysis->usability, 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr class="filterByRequirement" data-requirement="performance">
                                                                <th class="table-dark">Performance</th>
                                                                @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                                                                <td class="filterByVendor" data-vendor="{{$vendorProjectAnalysis->vendor_id}}">{{number_format($vendorProjectAnalysis->performance, 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr class="filterByRequirement" data-requirement="lookFeel">
                                                                <th class="table-dark">Look and Feel</th>
                                                                @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                                                                    <td class="filterByVendor" data-vendor="{{$vendorProjectAnalysis->vendor_id}}">{{number_format($vendorProjectAnalysis->look_feel, 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr class="filterByRequirement" data-requirement="others">
                                                                <th class="table-dark">Others</th>
                                                                @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                                                                <td class="filterByVendor" data-vendor="{{$vendorProjectAnalysis->vendor_id}}">{{number_format($vendorProjectAnalysis->others, 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br><br><br>
                                                <canvas id="chartjsBar3"></canvas>
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
    function filterRequirements() {
        var selectedRequirements = $('#requirementSelect').val();

        if(selectedRequirements.length === 0){
            selectedRequirements = $('#requirementSelect').children().toArray().map(function(el) {
                return el.value
            });
        }

        $('.filterByRequirement').each(function () {
            const requirement = $(this).data('requirement');

            if ($.inArray(requirement, selectedRequirements) !== -1) {
                $(this).css('display', '')
            } else {
                $(this).css('display', 'none')
            }
        });
        recalculateBarChart()
    }

    $('#requirementSelect').select2();
    $('#requirementSelect').on('change', function (e) {
        filterRequirements();
    });
    filterRequirements();


  // COMPLETE: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
  // SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],

    new Chart($("#useCasesScoreGraph"), {
      type: 'bar',
      data: {
        labels: [
            @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                "{{$vendorProjectAnalysis->vendorName}}",
            @endforeach
        ],
        datasets: [
          {
            label: "",
            backgroundColor: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
            data: [
                @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                    "{{$vendorProjectAnalysis->total}}",
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
              fontSize: 17,
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

    function recalculateBarChart() {
        var selectedRequirements = $('#requirementSelect').val();

        var parsedDataSet = [];

        if (selectedRequirements.length === 0 || $.inArray('solutionFit', selectedRequirements) !== -1) {
            parsedDataSet.push({
                label: "Solution Fit",
                backgroundColor: ["#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d"],
                data: [
                    @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                    {{number_format($vendorProjectAnalysis->solution_fit, 2)}},
                    @endforeach
                ],
                stack: 'Stack 0'
            });
        }

        if (selectedRequirements.length === 0 || $.inArray('usability', selectedRequirements) !== -1) {
            parsedDataSet.push({
                label: "Usability",
                backgroundColor: ["#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f"],
                data: [
                    @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                    {{number_format($vendorProjectAnalysis->usability, 2)}},
                    @endforeach
                ],
                stack: 'Stack 0'
            });
        }

        if (selectedRequirements.length === 0 || $.inArray('performance', selectedRequirements) !== -1) {
            parsedDataSet.push({
                label: "Performance",
                backgroundColor: ["#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0"],
                data: [
                    @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                    {{number_format($vendorProjectAnalysis->performance, 2)}},
                    @endforeach
                ],
                stack: 'Stack 0'
            });
        }

        if (selectedRequirements.length === 0 || $.inArray('lookFeel', selectedRequirements) !== -1) {
            parsedDataSet.push({
                label: "Look and Feel",
                backgroundColor: ["#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff"],
                data: [
                    @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                    {{number_format($vendorProjectAnalysis->look_feel, 2)}},
                    @endforeach
                ],
                stack: 'Stack 0'
            });
        }

        if (selectedRequirements.length === 0 || $.inArray('others', selectedRequirements) !== -1) {
            parsedDataSet.push({
                label: "Others",
                backgroundColor: ["#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff"],
                data: [
                    @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                    {{number_format($vendorProjectAnalysis->others, 2)}},
                    @endforeach
                ],
                stack: 'Stack 0'
            });
        }

        new Chart($("#chartjsBar3"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($vendorProjectsAnalysis as $vendorProjectAnalysis)
                        "{{$vendorProjectAnalysis->vendorName}}",
                    @endforeach
                ],
                datasets: parsedDataSet
            },
            options: {
                legend: { display: true },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 17,
                            max: 10,
                            stacked: true
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
    }

    // recalculateBarChart();
});
</script>
@endsection
