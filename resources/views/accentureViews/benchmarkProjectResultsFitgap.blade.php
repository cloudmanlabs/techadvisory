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
                                    <label for="practices-select">Chose a Practice</label>
                                    <select id="practices-select" multiple>
                                        @foreach ($practices as $practice)
                                            <option value="{{$practice->id}}">{{$practice->name}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <div id="subpractices-container">
                                        <label for="subpractices-select">Chose a Subpractice</label>
                                        <select id="subpractices-select" multiple>
                                            @foreach ($subpractices as $subpractice)
                                                <option value="{{$subpractice->id}}">{{$subpractice->name}}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <label for="years-select">Chose a Year</label>
                                    <select id="years-select" multiple>
                                        @foreach ($projectsByYears as $year)
                                            <option value="{{$year->year}}">{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <label for="industries-select">Chose a Industry</label>
                                    <select id="industries-select" multiple>
                                        @foreach ($industries as $industry)
                                            <option value="{{$industry}}">{{$industry}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <label for="regions-select">Chose a Region</label>
                                    <select id="regions-select" multiple>
                                        @foreach ($regions as $region)
                                            <option value="{{$region}}">{{$region}}</option>
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
                                        <h3>Fitgap Results</h3>
                                        <p class="welcome_text extra-top-15px">
                                        </p>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row" id="chart1-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Best {{count($vendorScoresFitgap)}} Vendors By Fitgap Score</h4>
                                                    <br><br>
                                                    <canvas id="best-fitgap-chart"></canvas>
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
                                                        @foreach($vendorScoresFitgap as $key=>$vendorScore)
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

                                    <div class="row" id="chart2-row">
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Best {{count($vendorScoresFitgapFunctional)}} Vendors Fitgap Functional Score</h6>
                                                    <br><br>
                                                    <canvas id="best-fitgap-functional-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Best {{count($vendorScoresFitgapTechnical)}} Vendors Fitgap By Technical Score</h6>
                                                    <br><br>
                                                    <canvas id="best-fitgap-technical-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="chart4-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Best {{count($vendorScoresFitgapService)}} Vendors Fitgap By Services Score</h4>
                                                    <br><br>
                                                    <canvas id="best-fitgap-services-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="chart5-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Best {{count($vendorScoresFitgapOthers)}} Vendors Fitgap By Others Score</h4>
                                                    <br><br>
                                                    <canvas id="best-fitgap-others-chart"></canvas>
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
        $('#practices-select').select2();
        $('#subpractices-select').select2();
        $('#years-select').select2();
        $('#industries-select').select2();
        $('#regions-select').select2();

        $('#subpractices-container').hide();

        // Submit Filters
        $('#filter-btn').click(function () {
            var practices = $('#practices-select').val();
            var subpractices = $('#subpractices-select').val();
            var years = $('#years-select').val();
            var industries = $('#industries-select').val();
            var regions = $('#regions-select').val();

            var currentUrl = '/accenture/benchmark/projectResults/fitgap';
            var url = currentUrl + '?'
                + 'practices=' + practices
                + '&subpractices=' + subpractices
                + '&years=' + years
                + '&industries=' + industries
                + '&regions=' + regions;
            location.replace(url);
        });

        $('#practices-select').change(function () {
            $('#subpractices-container').hide();
            $('#subpractices-select').empty();

            var selectedPractices = $(this).val();
            if (selectedPractices.length === 1) {
                $.get("/accenture/benchmark/projectResults/getSubpractices/"
                    + selectedPractices, function (data) {

                    $('#subpractices-container').show();

                    var $dropdown = $("#subpractices-select");
                    var subpractices = data.subpractices;
                    $.each(subpractices, function () {
                        $dropdown.append($("<option />").val(this.id).text(this.name));
                    });
                });
            }
        });

        var fitgapChart = new Chart($('#best-fitgap-chart'), {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($vendorScoresFitgap as $key=>$value)
                            "{{\App\User::find($key)->name}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                            data: [
                                @foreach($vendorScoresFitgap as $key => $value)
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

        var fitgapFunctionalChart = new Chart($('#best-fitgap-functional-chart'), {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($vendorScoresFitgapFunctional as $key=>$value)
                            "{{\App\User::find($key)->name}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                            data: [
                                @foreach($vendorScoresFitgapFunctional as $key => $value)
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

        var fitgapTechnicalChart = new Chart($('#best-fitgap-technical-chart'), {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($vendorScoresFitgapTechnical as $key=>$value)
                            "{{\App\User::find($key)->name}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                            data: [
                                @foreach($vendorScoresFitgapTechnical as $key => $value)
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

        var fitgapServicesChart = new Chart($('#best-fitgap-services-chart'), {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($vendorScoresFitgapService as $key=>$value)
                            "{{\App\User::find($key)->name}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                            data: [
                                @foreach($vendorScoresFitgapService as $key => $value)
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

        var fitgapOthersChart = new Chart($('#best-fitgap-others-chart'), {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($vendorScoresFitgapOthers as $key=>$value)
                            "{{\App\User::find($key)->name}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                            data: [
                                @foreach($vendorScoresFitgapOthers as $key => $value)
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
