@props(['progressFitgap', 'progressVendor','progressExperience','progressInnovation','progressImplementation', 'progressSubmit', 'title'])

<div style="float: right; width: 35%; margin-right: 5%;">
    {{$title ?? 'Application status'}}: {{
                    $progressFitgap +
                    $progressVendor +
                    $progressExperience +
                    $progressInnovation +
                    $progressImplementation +
                    $progressSubmit
                }}%
    <div class="progress">
        <div style="width: 30%;">
            <div
            title="Fit Gap"
            class="progress-bar"
            role="progressbar"
            style="width: {{($progressFitgap / 30) * 100}}%;
            background-color: #27003d;
            color: {{$progressFitgap == 0 ? 'black' : 'white'}}"
            aria-valuenow="{{$progressFitgap}}"
            aria-valuemin="0"
            aria-valuemax="30"
            >
                {{$progressFitgap}}%
            </div>
        </div>
        <div style="width: 10%; border-left: 1px solid black">
            <div
            title="Vendor"
            class="progress-bar"
            role="progressbar"
            style="width: {{($progressVendor / 10) * 100}}%;
            background-color: #5a008f;
            color: {{$progressVendor == 0 ? 'black' : 'white'}}"
            aria-valuenow="{{$progressVendor}}"
            aria-valuemin="0"
            aria-valuemax="10"
            >
                {{$progressVendor}}%
            </div>
        </div>
        <div style="width: 10%; border-left: 1px solid black">
            <div
                title="Experience"
                class="progress-bar"
                role="progressbar"
                style="width: {{($progressExperience / 10) * 100}}%;
                background-color: #8e00e0;
                color: {{$progressExperience == 0 ? 'black' : 'white'}}"
                aria-valuenow="{{$progressExperience}}"
                aria-valuemin="0"
                aria-valuemax="10"
            >
                {{$progressExperience}}%
            </div>
        </div>
        <div style="width: 10%; border-left: 1px solid black">
            <div
                title="Innovation & Vision"
                class="progress-bar"
                role="progressbar"
                style="width: {{($progressInnovation / 10) * 100}}%;
                background-color: #a50aff;
                color: {{$progressInnovation == 0 ? 'black' : 'white'}}"
                aria-valuenow="{{$progressInnovation}}"
                aria-valuemin="0"
                aria-valuemax="10"
            >
                {{$progressInnovation}}%
            </div>
        </div>
        <div style="width: 30%; border-left: 1px solid black">
            <div
                title="Implementation & Commercial"
                class="progress-bar"
                role="progressbar"
                style="width: {{($progressImplementation / 30) * 100}}%;
                background-color: #d285ff;
                color: {{$progressImplementation == 0 ? 'black' : 'white'}}"
                aria-valuenow="{{$progressImplementation}}"
                aria-valuemin="0"
                aria-valuemax="30"
            >
                {{$progressImplementation}}%
            </div>
        </div>
        <div style="width: 10%; border-left: 1px solid black">
            <div
                title="Submit responses"
                class="progress-bar"
                role="progressbar"
                style="width: {{($progressSubmit / 10) * 100}}%;
                background-color: #d285ff;
                color: {{$progressSubmit == 0 ? 'black' : 'white'}}"
                aria-valuenow="{{$progressSubmit}}"
                aria-valuemin="0"
                aria-valuemax="10"
            >
                {{$progressSubmit}}%
            </div>
        </div>
    </div>
</div>
