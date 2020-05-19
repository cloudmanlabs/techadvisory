@props(['application', 'title'])

@php
    $progressSetUp = $application->progressFitgap();
    $progressValue = $application->progressVendor();
    $progressResponse = $application->progressExperience();
    $progressAnalytics = $application->progressInnovation();
    $progressConclusions = $application->progressImplementation();
    $progressConclusions = $application->progressSubmit();

    $totalProgress = $progressSetUp +
                        $progressValue +
                        $progressResponse +
                        $progressAnalytics +
                        $progressConclusions +
                        $progressConclusions;
@endphp

<div style="float: right; width: 35%; margin-right: 5%;">
    {{$title ?? 'Application status'}}: {{ $totalProgress }}%
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

        if($progressSetUp == 30){
            $finishedPhases[] = 'Fitgap';
        }
        if($progressValue == 10){
            $finishedPhases[] = 'Vendor';
        }
        if($progressResponse == 10){
            $finishedPhases[] = 'Experience';
        }
        if($progressAnalytics == 10){
            $finishedPhases[] = 'Innovation & Vision';
        }
        if($progressConclusions == 30){
            $finishedPhases[] = 'Implementation & Commercial';
        }
        if($progressConclusions == 10){
            $finishedPhases[] = 'Submit';
        }

        if(count($finishedPhases)  > 0){
            echo 'Finished phases: ' . implode(', ', $finishedPhases);
        }
    @endphp
</div>
