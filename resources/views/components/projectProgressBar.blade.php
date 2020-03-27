@props(['progressSetUp', 'progressValue','progressResponse','progressAnalytics','progressConclusions', 'title'])

<div style="float: right; width: 35%; margin-right: 10%;">
    {{$title ?? 'Current status'}}: {{
                    $progressSetUp +
                    $progressValue +
                    $progressResponse +
                    $progressAnalytics +
                    $progressConclusions
                }}%
    <div class="progress">
        <div style="width: 40%;">
            <div
            title="Set Up"
            class="progress-bar"
            role="progressbar"
            style="width: {{($progressSetUp / 40) * 100}}%;
            background-color: #27003d;
            color: {{$progressSetUp == 0 ? 'black' : 'white'}}"
            aria-valuenow="{{$progressSetUp}}"
            aria-valuemin="0"
            aria-valuemax="40"
            >
                {{$progressSetUp}}%
            </div>
        </div>
        <div style="width: 20%; border-left: 1px solid black">
            <div
            title="Value Targeting"
            class="progress-bar"
            role="progressbar"
            style="width: {{($progressValue / 20) * 100}}%;
            background-color: #5a008f;
            color: {{$progressValue == 0 ? 'black' : 'white'}}"
            aria-valuenow="{{$progressValue}}"
            aria-valuemin="0"
            aria-valuemax="20"
            >
                {{$progressValue}}%
            </div>
        </div>
        <div style="width: 25%; border-left: 1px solid black">
            <div
                title="Vendor Response"
                class="progress-bar"
                role="progressbar"
                style="width: {{($progressResponse / 25) * 100}}%;
                background-color: #8e00e0;
                color: {{$progressResponse == 0 ? 'black' : 'white'}}"
                aria-valuenow="{{$progressResponse}}"
                aria-valuemin="0"
                aria-valuemax="25"
            >
                {{$progressResponse}}%
            </div>
        </div>
        <div style="width: 10%; border-left: 1px solid black">
            <div
                title="Analytics"
                class="progress-bar"
                role="progressbar"
                style="width: {{($progressAnalytics / 10) * 100}}%;
                background-color: #a50aff;
                color: {{$progressAnalytics == 0 ? 'black' : 'white'}}"
                aria-valuenow="{{$progressAnalytics}}"
                aria-valuemin="0"
                aria-valuemax="10"
            >
                {{$progressAnalytics}}%
            </div>
        </div>
        <div style="width: 5%; border-left: 1px solid black">
            <div
                title="Conclusions"
                class="progress-bar"
                role="progressbar"
                style="width: {{($progressConclusions / 5) * 100}}%;
                background-color: #d285ff;
                color: {{$progressConclusions == 0 ? 'black' : 'white'}}"
                aria-valuenow="{{$progressConclusions}}"
                aria-valuemin="0"
                aria-valuemax="5"
            >
                {{$progressConclusions}}%
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
