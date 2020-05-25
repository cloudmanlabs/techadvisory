@extends('clientViews.layouts.benchmark')


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
        <x-client.navbar activeSection="sections" />


        <div class="page-wrapper">
            <div class="page-content">
                <x-client.projectNavbar section="projectBenchmark" subsection="fitgap" :project="$project" />

                <br>
                <x-projectBenchmarkVendorFilter :applications="$applications" />

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendor Ranking by Fit Gap section</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('client_projectBenchmarkFitgap_ranking') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="col-lg-4 col-mg-12 offset-lg-4">
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
                                                    <td>{{$obj->score}}</td>
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
                                    {{nova_get_setting('client_projectBenchmarkFitgap_comparison') ?? ''}}
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
                                                <h4>DETAILED FIT GAP SCORE PER REQUIREMENT TYPE</h4>
                                                <br>
                                                <div class="media-body" style="padding: 20px;">
                                                    <p class="welcome_text">
                                                        Please choose the Requirement Types you'd like to see:
                                                    </p>
                                                    <select id="requirementSelect" class="w-100" multiple="multiple" required>
                                                        <option>Functional</option>
                                                        <option>Technical</option>
                                                        <option>Service</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="table-dark">
                                                                <th>Requirement type</th>
                                                                @foreach ($applications as $application)
                                                                <th class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                                    {{$application->vendor->name}}</th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="filterByRequirement" data-requirement="Functional">
                                                                <th class="table-dark">Functional</th>
                                                                @foreach ($applications as $application)
                                                                <td class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                                    {{number_format($application->fitgapFunctionalScore(), 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr class="filterByRequirement" data-requirement="Technical">
                                                                <th class="table-dark">Technical</th>
                                                                @foreach ($applications as $application)
                                                                <td class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                                    {{number_format($application->fitgapTechnicalScore(), 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr class="filterByRequirement" data-requirement="Service">
                                                                <th class="table-dark">Service</th>
                                                                @foreach ($applications as $application)
                                                                <td class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                                    {{number_format($application->fitgapServiceScore(), 2)}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr class="filterByRequirement" data-requirement="Other">
                                                                <th class="table-dark">Other</th>
                                                                @foreach ($applications as $application)
                                                                <td class="filterByVendor" data-vendor="{{$application->vendor->name}}">
                                                                    {{number_format($application->fitgapOtherScore(), 2)}}</td>
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

            <x-footer />
        </div>
    </div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
    function filterRequirements() {
        // Get all selected practices. If there are none, get all of them
        var selectedRequirements = $('#requirementSelect').select2('data').map((el) => {
            return el.text
        });
        if(selectedRequirements.length == 0){
            selectedRequirements = $('#requirementSelect').children().toArray().map((el) => {
                return el.innerHTML
            });
        }

        // Add a display none to the one which don't have this tags
        $('.filterByRequirement').each(function () {
            const requirement = $(this).data('requirement');

            if ($.inArray(requirement, selectedRequirements) !== -1) {
                $(this).css('display', '')
            } else {
                $(this).css('display', 'none')
            }
        });
    }

    $('#requirementSelect').select2();
    $('#requirementSelect').on('change', function (e) {
        filterRequirements();
    });
    filterRequirements();








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
          {
            label: "Functional",
            backgroundColor: ["#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d"],
            data: [
                @foreach ($applications as $obj)
                {{$obj->fitgapScore()}},
                @endforeach
            ],
            stack: 'Stack 0'
          },
          {
            label: "Technical",
            backgroundColor: ["#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f"],
            data: [
                @foreach ($applications as $obj)
                {{$obj->fitgapScore()}},
                @endforeach
            ],
            stack: 'Stack 0'
          },
          {
            label: "Service",
            backgroundColor: ["#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0"],
            data: [
                @foreach ($applications as $obj)
                {{$obj->fitgapScore()}},
                @endforeach
            ],
            stack: 'Stack 0'
          },
          {
            label: "Other",
            backgroundColor: ["#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff"],
            data: [
                @foreach ($applications as $obj)
                {{$obj->fitgapScore()}},
                @endforeach
            ],
            stack: 'Stack 0'
          }
        ]
      },
      options: {
        legend: { display: true },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              fontSize: 17,
              max: 50,
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
