@props(['project', 'title'])

@php
    $progressSetUp = $project->progressSetUp;
    $progressValue = $project->progressValue;
    $progressResponse = $project->progressResponse;
    $progressAnalytics = $project->progressAnalytics;
    $progressConclusions = $project->progressConclusions;

    $totalProgress = $progressSetUp +
                        $progressValue +
                        $progressResponse +
                        $progressAnalytics +
                        $progressConclusions;
@endphp

<div style="float: right; width: 35%; margin-right: 10%;">
    {{$title ?? 'Current status'}}: {{ $totalProgress }}%
    <div class="progress">
        <div style="width: 100%; border-left: 1px solid black">
            <div
            class="progress-bar"
            role="progressbar"
            style="width: {{($totalProgress / 100) * 100}}%;
            background-color: #5a008f;
            color: {{$totalProgress == 0 ? 'black' : 'white'}}"
            aria-valuenow="{{$totalProgress}}"
            aria-valuemin="0"
            aria-valuemax="100"
            >
                {{$totalProgress}}%
            </div>
        </div>
    </div>

    @php
        $finishedPhases = [];

        if($progressSetUp == 40 ){
            $finishedPhases[] = 'Set Up';
        }
        if($progressValue == 20 ){
            $finishedPhases[] = 'Value';
        }
        if($progressResponse == 25 ){
            $finishedPhases[] = 'Response';
        }
        if($progressAnalytics == 10 ){
            $finishedPhases[] = 'Analytics';
        }
        if($progressConclusions == 5){
            $finishedPhases[] = 'Conclusions';
        }

        if(count($finishedPhases)  > 0){
            echo 'Finished phases: ' . implode(', ', $finishedPhases);
        }
    @endphp
</div>
