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
                                            <option
                                                value="{{$practice->id}}"
                                            @if($practicesIDsToFilter)
                                                {{ in_array($practice->id,$practicesIDsToFilter)? 'selected="selected"' : ''}}
                                                @endif
                                            >
                                                {{$practice->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <div id="subpractices-container">
                                        <label for="subpractices-select">Chose a Subpractice</label>
                                        <select id="subpractices-select" multiple>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <label for="years-select">Chose a Year</label>
                                    <select id="years-select" multiple>
                                        @foreach ($years as $year)
                                            <option
                                                value="{{$year->year}}"
                                            @if($yearsToFilter)
                                                {{ in_array($year->year,$yearsToFilter)? 'selected="selected"' : ''}}
                                                @endif
                                            >
                                                {{$year->year}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <label for="industries-select">Chose a Industry</label>
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
                                    <label for="regions-select">Chose a Region</label>
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
                                        <h3>Experience Results</h3>
                                        <p class="welcome_text extra-top-15px">
                                        </p>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row" id="chart1-row">
                                        <div class="col-xl-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Best {{count($vendorScoresExperience)}} Vendors By Experience
                                                        Score</h4>
                                                    <br><br>
                                                    <canvas id="best-experience-chart"></canvas>
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
                                                            <th scope="col">Scores</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vendorScoresExperience as $key=>$vendorScore)
                                                            <tr>
                                                                <td>{{\App\User::find($key)->name}}</td>
                                                                <td>{{count(\App\User::find($key)->vendorApplications)}}</td>
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
</div>


@section('scripts')
    @parent
    <script>

        $('#practices-select').select2();
        $('#subpractices-select').select2();
        $('#years-select').select2();
        $('#industries-select').select2();
        $('#regions-select').select2();

        chargeSubpracticesFromPractice();
        //populateSubpracticesSelected();
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
                        $dropdown.append($("<option />").val(this.id).text(this.name));
                    });
                });
            }
        }

        {{--
        function populateSubpracticesSelected() {
            @if(is_array($subpracticesIDsToFilter))
            var selectedIds = [
                @foreach($subpracticesIDsToFilter as $subpractice)
                    '{{\App\Subpractice::find($subpractice)->id}}',
                @endforeach
            ];
            var selectedNames = [
                @foreach($subpracticesIDsToFilter as $subpractice)
                    '{{\App\Subpractice::find($subpractice)->name}}',
                @endforeach
            ];
            var thereIsOnlyOnePracticeSelected = {{count($practicesIDsToFilter)==1}};

            if (selectedIds.length && thereIsOnlyOnePracticeSelected) {
                $('subpractices-container').show();
                for (let i = 0; i < selectedIds.length; i++) {
                   $('#subpractices-select')[0].val(selectedIds[i]);
                    $('#subpractices-select')[0].text(selectedNames[i]);*!/
                    $('#subpractices-select').trigger('change'); // Notify any JS components that the value changed
                    console.log($('#subpractices-select')[0])
                }

            } else {
                $('#subpractices-container').hide();
            }
            @endif
        }
        --}}

        // Submit Filters
        $('#filter-btn').click(function () {
            var practices = encodeURIComponent($('#practices-select').val());
            var subpractices = encodeURIComponent($('#subpractices-select').val());
            var years = encodeURIComponent($('#years-select').val());
            var industries = encodeURIComponent($('#industries-select').val());
            var regions = encodeURIComponent($('#regions-select').val());

            var currentUrl = '/accenture/benchmark/projectResults/experience';
            var url = currentUrl + '?'
                + 'practices=' + practices
                + '&subpractices=' + subpractices
                + '&years=' + years
                + '&industries=' + industries
                + '&regions=' + regions;
            location.replace(url);
        });

        var experienceChart = new Chart($('#best-experience-chart'), {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($vendorScoresExperience as $key=>$value)
                            "{{\App\User::find($key)->name}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                            data: [
                                @foreach($vendorScoresExperience as $key => $value)
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

