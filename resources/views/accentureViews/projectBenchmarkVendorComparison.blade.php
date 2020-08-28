@extends('accentureViews.layouts.benchmark')

@php

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

        var bestPossibleDatasets = [51, 17, 7, 25];
        var bestVendorDatasets = [49, 15, 7, 21];
        var averageDatasets = [43, 14, 7, 20];
        var SAPDatasets = [38, 15, 6, 20];

        var ctx = document.getElementById('bestVendorGraph');
        var stackedBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Best Possible', 'Best of vendors', 'Average', 'SAP'],
                datasets: [
                    {
                        label: 'Functionality',
                        data: [bestPossibleDatasets[0], bestVendorDatasets[0],
                            averageDatasets[0], SAPDatasets[0]],
                        backgroundColor: '#608FD1'
                    },
                    {
                        label: 'Services',
                        data: [bestPossibleDatasets[1], bestVendorDatasets[1],
                            averageDatasets[1], SAPDatasets[1]],
                        backgroundColor: '#E08733'
                    },
                    {
                        label: 'Viability',
                        data: [bestPossibleDatasets[2], bestVendorDatasets[2],
                            averageDatasets[2], SAPDatasets[2]],
                        backgroundColor: '#4A922A'
                    },
                    {
                        label: 'SAP',
                        data: [bestPossibleDatasets[3], bestVendorDatasets[3],
                            averageDatasets[3], SAPDatasets[3]],
                        backgroundColor: '#C645D5'
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
