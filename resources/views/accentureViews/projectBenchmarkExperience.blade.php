@extends('layouts.base')

@php
    //NOTE This is basically to have the table ordered when the scores are random
    $orderedApps = $applications->map(function($application, $key){
        return (object)[
            'name' => $application->vendor->name,
            'score' => $application->experienceScore()
        ];
    })
    ->sortByDesc('score');
@endphp


@section('content')
<div class="main-wrapper">
    <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectBenchmark" subsection="experience" :project="$project" />

                <br>
                <x-projectBenchmarkVendorFilter :applications="$applications" />

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendor Ranking by Experience section</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectBenchmarkExperience_ranking') ?? ''}}
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
                                    {{nova_get_setting('accenture_projectBenchmarkExperience_comparison') ?? ''}}
                                </p>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xl-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>Vendors sorted by Experience score</h4>
                                                <br>
                                                <canvas id="chartjsBar1"></canvas>
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
    new Chart($("#chartjsBar1"), {
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
});
</script>
@endsection
