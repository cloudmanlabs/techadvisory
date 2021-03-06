@extends('layouts.base')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-accenture.projectNavbar section="projectValueTargeting" :project="$project" />

                <x-video :src="nova_get_setting('video_valueTargeting_file')" :text="nova_get_setting('video_valueTargeting_text')" />

                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Discovery week configuration</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            {{nova_get_setting('accenture_projectValueTargeting_title2') ?? ''}}
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
                                <h3>Selected Value Levers</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectValueTargeting_selected') ?? ''}}
                                </p>
                                <br>

                                <x-folderFilePreview :folder="$project->selectedValueLeversFolder" />
                                <x-folderFileUploader :folder="$project->selectedValueLeversFolder" :disabled="$project->currentPhase == 'old'"/>

                                <br><br><br>

                                <h3>Business Opportunity Details</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectValueTargeting_business') ?? ''}}
                                </p>
                                <br>
                                <x-folderFileUploader :folder="$project->businessOpportunityFolder" :disabled="$project->currentPhase == 'old'"/>

                                <br><br><br>

                                <h3>Conclusions</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectValueTargeting_conclusions') ?? ''}}
                                </p>
                                <br>
                                <x-folderFilePreview :folder="$project->vtConclusionsFolder" />
                                <x-folderFileUploader :folder="$project->vtConclusionsFolder" :disabled="$project->currentPhase == 'old'"/>

                                @if ($project->currentPhase != 'preparation')
                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('accenture.projectHome', ['project' => $project])}}">
                                        <i data-feather="arrow-left"></i>
                                        Go back to project
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
