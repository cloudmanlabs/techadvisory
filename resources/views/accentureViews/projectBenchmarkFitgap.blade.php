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
    $colors = ["#27003d", "#410066", "#5a008f", "#7400b8", "#8e00e0", "#9b00f5", "#a50aff", "#c35cff", "#d285ff", "#e9c2ff", "#f0d6ff", "#f8ebff"];
@endphp

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />


        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectBenchmark" subsection="fitgap" :project="$project" />

                <br>
                <x-projectBenchmarkVendorFilter :applications="$applications" />

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendor Ranking by Use Case</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectBenchmarkFitgap_ranking') ?? ''}}
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
                                    {{nova_get_setting('accenture_projectBenchmarkFitgap_comparison') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>Vendors sorted by Fit Gap score</h4>
                                                <br>
                                                <canvas id="fitgapScoreGraph"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>DETAILED FIT GAP SCORE PER LEVEL 1</h4>
                                                <br>
                                                <div class="media-body" style="padding: 20px;">
                                                    <p class="welcome_text">
                                                        Below is the FitGap vendor score breakdown across the level 1.
                                                    </p>
                                                    <select id="levelSelect" class="w-100" multiple="multiple" required>
                                                        @foreach ($level1s as $level1)
                                                        <option>{{$level1}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Level 1</th>
                                                                @foreach ($applications as $application)
                                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">{{$application->vendor->name}}</th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($level1s as $level1)
                                                            <tr class="filterByLevel" data-level="{{$level1}}">
                                                                <th class="table-dark">{{$level1}}</th>
                                                                @foreach ($applications as $application)
                                                                <td class="filterByVendor" data-vendor="{{$application->vendor->name}}">{{number_format($application->fitgapLevelScore($level1), 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            @endforeach
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
    function filterLevels() {
        // Get all selected practices. If there are none, get all of them
        var selectedLevels = $('#levelSelect').select2('data').map(function(el) {
            return el.text
        });
        if(selectedLevels.length == 0){
            selectedLevels = $('#levelSelect').children().toArray().map(function(el) {
                return el.innerHTML
            });
        }

        // Add a display none to the one which don't have this tags
        $('.filterByLevel').each(function () {
            const level = $(this).data('level');

            if ($.inArray(level, selectedLevels) !== -1) {
                $(this).css('display', '')
            } else {
                $(this).css('display', 'none')
            }
        });
    }

    $('#levelSelect').select2();
    $('#levelSelect').on('change', function (e) {
        filterLevels();
    });
    filterLevels();








  // COMPLETE: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
  // SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
    new Chart($("#fitgapScoreGraph"), {
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
            backgroundColor: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
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

    new Chart($("#chartjsBar3"), {
      type: 'bar',
      data: {
        labels: [
            @foreach ($orderedApps as $obj)
            "{{$obj->name}}",
            @endforeach
        ],
        datasets: [
          @foreach ($level1s as $key => $el)
              {
                label: '{{$el}}',
                backgroundColor: ['{{$colors[$key]}}', '{{$colors[$key]}}', '{{$colors[$key]}}', '{{$colors[$key]}}', '{{$colors[$key]}}', '{{$colors[$key]}}', '{{$colors[$key]}}'],
                data: [
                    @foreach ($applications as $obj)
                    {{(($obj->fitgapLevelScore($el)) * ($project->getLevelWeight($el))/100)}},
                    @endforeach
                ],
                stack: 'Stack 0'
              },
          @endforeach
        ]
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
});
</script>
@endsection
