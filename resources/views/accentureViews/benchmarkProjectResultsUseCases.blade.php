@extends('layouts.base')

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
                                    <label for="practices-select">Choose a Practice</label>
                                    <select id="practices-select" multiple>
                                        @foreach ($practices as $practice)
                                            <option value="{{$practice->id}}"
                                            @if($practicesIDsToFilter)
                                                {{ in_array($practice->id,$practicesIDsToFilter)? 'selected="selected"' : '' }}
                                            @endif
                                            >
                                                {{ $practice->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <div id="subpractices-container">
                                        <label for="subpractices-select">Choose a Subpractice</label>
                                        <select id="subpractices-select" multiple>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <label for="years-select">Choose a Year</label>
                                    <select id="years-select" multiple>
                                        @foreach ($years as $year)
                                            <option value="{{$year->year}}"
                                            @if($yearsToFilter)
                                                {{ in_array($year->year,$yearsToFilter)? 'selected="selected"' : '' }}
                                            @endif
                                            >
                                                {{$year->year}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <label for="industries-select">Choose a Industry</label>
                                    <select id="industries-select" multiple>
                                        @foreach($industries as $industry)
                                            <option value="{{$industry}}"
                                            @if($industriesToFilter)
                                                {{ in_array($industry,$industriesToFilter)? 'selected="selected"' : '' }}
                                            @endif
                                            >
                                                {{ $industry }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <label for="regions-select">Choose a Region</label>
                                    <select id="regions-select" multiple>
                                        @foreach ($regions as $region)
                                            <option value="{{$region}}"
                                            @if($regionsToFilter)
                                                {{ in_array($region,$regionsToFilter)? 'selected="selected"' : '' }}
                                            @endif
                                            >
                                                {{ $region }}
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
                                        <h3>Use Cases Overall Results</h3>
                                        <p class="welcome_text extra-top-15px"></p>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row" id="chart1-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Best {{count($vendorScores)}} Vendors By Average Score in All Use Cases</h4>
                                                    <br><br>
                                                    <canvas id="best-use-case-chart"></canvas>
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
                                                            <th scope="col">Use Cases Evaluated</th>
                                                            <th scope="col">Score</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vendorScores as $vendorId => $vendorScore)
                                                            <tr>
                                                                <td>{{ \App\User::find($vendorId)->name }}</td>
                                                                <td>{{ \App\VendorsUseCasesAnalysis::numOfDifferentUSesCasesWithVendorEvaluated($vendorId) }}</td>
                                                                <td>{{ $vendorScore }}</td>
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
            <br>
            <div class="row" id="content-container-2">
                <div class="col-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Use Case Results By Scoring Criteria</h3>
                            <br>
                            <div class="row">

                                <div id="charts-container" class="col-12">

                                    <div class="row" id="chart2-row">
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Best {{count($vendorScoresSolutionFit)}} Vendors Use Cases
                                                        Solution Fit Score</h6>
                                                    <br><br>
                                                    <canvas id="best-use-cases-solution-fit-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Number of projects</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Vendor name</th>
                                                            <th scope="col">Projects applied</th>
                                                            <th scope="col">Score</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vendorScoresSolutionFit as $key=>$vendorScore)
                                                            <tr>
                                                                <td>{{\App\User::find($key)->name}}</td>
                                                                <td>{{\App\VendorsUseCasesAnalysis::numOfDifferentUSesCasesWithVendorEvaluatedByCriteria($key, 'solution_fit')}}</td>
                                                                <td>{{$vendorScore}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="chart3-row">
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Best {{count($vendorScoresUsability)}} Vendors Use Cases
                                                        Usability Score</h6>
                                                    <br><br>
                                                    <canvas id="best-use-cases-usability-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Number of projects</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Vendor name</th>
                                                            <th scope="col">Projects applied</th>
                                                            <th scope="col">Score</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vendorScoresUsability as $key=>$vendorScore)
                                                            <tr>
                                                                <td>{{\App\User::find($key)->name}}</td>
                                                                <td>{{\App\VendorsUseCasesAnalysis::numOfDifferentUSesCasesWithVendorEvaluatedByCriteria($key, 'usability')}}</td>
                                                                <td>{{$vendorScore}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="chart4-row">
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Best {{count($vendorScoresPerformance)}} Vendors Use Cases
                                                        Performance Score</h6>
                                                    <br><br>
                                                    <canvas id="best-use-cases-performance-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Number of projects</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Vendor name</th>
                                                            <th scope="col">Projects applied</th>
                                                            <th scope="col">Scores</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vendorScoresPerformance as $key=>$vendorScore)
                                                            <tr>
                                                                <td>{{\App\User::find($key)->name}}</td>
                                                                <td>{{\App\VendorsUseCasesAnalysis::numOfDifferentUSesCasesWithVendorEvaluatedByCriteria($key, 'performance')}}</td>
                                                                <td>{{$vendorScore}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="chart5-row">
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Best {{count($vendorScoresLookFeel)}} Vendors Use Cases
                                                        Look And Feel Score</h6>
                                                    <br><br>
                                                    <canvas id="best-use-cases-look-feel-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Number of projects</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Vendor name</th>
                                                            <th scope="col">Projects applied</th>
                                                            <th scope="col">Scores</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vendorScoresLookFeel as $key=>$vendorScore)
                                                            <tr>
                                                                <td>{{\App\User::find($key)->name}}</td>
                                                                <td>{{\App\VendorsUseCasesAnalysis::numOfDifferentUSesCasesWithVendorEvaluatedByCriteria($key, 'look_feel')}}</td>
                                                                <td>{{$vendorScore}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="chart5-row">
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Best {{count($vendorScoresOthers)}} Vendors Use Cases
                                                        Others Score</h6>
                                                    <br><br>
                                                    <canvas id="best-use-cases-others-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Number of projects</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Vendor name</th>
                                                            <th scope="col">Projects applied</th>
                                                            <th scope="col">Scores</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vendorScoresOthers as $key=>$vendorScore)
                                                            <tr>
                                                                <td>{{\App\User::find($key)->name}}</td>
                                                                <td>{{\App\VendorsUseCasesAnalysis::numOfDifferentUSesCasesWithVendorEvaluatedByCriteria($key, 'others')}}</td>
                                                                <td>{{$vendorScore}}</td>
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


    @section('scripts')
        @parent
        <script>

            $('#practices-select').select2({
                maximumSelectionLength: 1
            });
            $('#subpractices-select').select2();
            $('#years-select').select2();
            $('#industries-select').select2({
                maximumSelectionLength: 1
            });
            $('#regions-select').select2();

            chargeSubpracticesFromPractice();
            $('#practices-select').change(function () {
                chargeSubpracticesFromPractice();
            });

            function chargeSubpracticesFromPractice() {
                $('#subpractices-container').hide();
                $('#subpractices-select').empty();

                var selectedPractices = $('#practices-select').val();
                if (selectedPractices.length === 1) {
                    $.get("/accenture/benchmark/projectResults/getSubpractices/"
                        + selectedPractices, function (data) {

                        $('#subpractices-container').show();

                        var $dropdown = $("#subpractices-select");
                        var subpractices = data.subpractices;
                        $.each(subpractices, function () {
                            var selectedIds = [
                                @if(is_array($subpracticesIDsToFilter))
                                    @foreach($subpracticesIDsToFilter as $subpractice)
                                    '{{\App\Subpractice::find($subpractice)->id}}',
                                @endforeach
                                @endif
                            ];
                            var option = $("<option />").val(this.id).text(this.name);
                            if (selectedIds.includes(String(this.id))) {
                                option.attr('selected', 'selected');
                            }
                            $dropdown.append(option);
                        });
                    });
                }
            }

            // Submit Filters.
            $('#filter-btn').click(function () {
                var practices = encodeURIComponent($('#practices-select').val());
                var subpractices = encodeURIComponent($('#subpractices-select').val());
                var years = encodeURIComponent($('#years-select').val());
                var industries = encodeURIComponent($('#industries-select').val());
                var regions = encodeURIComponent($('#regions-select').val());

                var currentUrl = '/accenture/benchmark/projectResults/fitgap';
                var url = currentUrl + '?'
                    + 'practices=' + practices
                    + '&subpractices=' + subpractices
                    + '&years=' + years
                    + '&industries=' + industries
                    + '&regions=' + regions;
                // location.replace(url);
            });

            var useCasesChart = new Chart($('#best-use-case-chart'), {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($vendorScores as $key=>$value)
                                "{{\App\User::find($key)->name}}",
                            @endforeach
                        ],
                        datasets: [
                            {
                                backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                                data: [
                                    @foreach($vendorScores as $key => $value)
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
                                    fontSize: 17
                                }
                            }],
                        }
                    }
                }
            );

            var useCasesSolutionFitChart = new Chart($('#best-use-cases-solution-fit-chart'), {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($vendorScoresSolutionFit as $key=>$value)
                                "{{\App\User::find($key)->name}}",
                            @endforeach
                        ],
                        datasets: [
                            {
                                backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                                data: [
                                    @foreach($vendorScoresSolutionFit as $key => $value)
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
                                    fontSize: 17
                                }
                            }],
                        }
                    }
                }
            );

            var useCasesUsabilityChart = new Chart($('#best-use-cases-usability-chart'), {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($vendorScoresUsability as $key=>$value)
                                "{{\App\User::find($key)->name}}",
                            @endforeach
                        ],
                        datasets: [
                            {
                                backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                                data: [
                                    @foreach($vendorScoresUsability as $key => $value)
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
                                    fontSize: 17
                                }
                            }],
                        }
                    }
                }
            );

            var useCasesPerformanceChart = new Chart($('#best-use-cases-performance-chart'), {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($vendorScoresPerformance as $key=>$value)
                                "{{\App\User::find($key)->name}}",
                            @endforeach
                        ],
                        datasets: [
                            {
                                backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                                data: [
                                    @foreach($vendorScoresPerformance as $key => $value)
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
                                    fontSize: 17
                                }
                            }],
                        }
                    }
                }
            );

            var useCasesLookFeelChart = new Chart($('#best-use-cases-look-feel-chart'), {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($vendorScoresLookFeel as $key=>$value)
                                "{{\App\User::find($key)->name}}",
                            @endforeach
                        ],
                        datasets: [
                            {
                                backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                                data: [
                                    @foreach($vendorScoresLookFeel as $key => $value)
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
                                    fontSize: 17
                                }
                            }],
                        }
                    }
                }
            );

            var useCasesOthersChart = new Chart($('#best-use-cases-others-chart'), {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($vendorScoresOthers as $key=>$value)
                                "{{\App\User::find($key)->name}}",
                            @endforeach
                        ],
                        datasets: [
                            {
                                backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                                data: [
                                    @foreach($vendorScoresOthers as $key => $value)
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
                                    fontSize: 17
                                }
                            }],
                        }
                    }
                }
            );

        </script>
@endsection
