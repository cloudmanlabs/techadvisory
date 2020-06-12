{{--
    Simple list of fields to edit the Project weights
    --}}

@props(['project', 'disabled'])

@php
    $disabled = $disabled ?? false;

    $fields = [
        'fitgapWeightMust' => 'Fitgap Client Weight: Must',
        'fitgapWeightRequired' => 'Fitgap Client Weight: Required',
        'fitgapWeightNiceToHave' => 'Fitgap Client Weight: Nice to have',

        'fitgapWeightFullySupports' => 'Fitgap Vendor Weight: Fully supports',
        'fitgapWeightPartiallySupports' => 'Fitgap Vendor Weight: Partially supports',
        'fitgapWeightPlanned' => 'Fitgap Vendor Weight: Planned',
        'fitgapWeightNotSupported' => 'Fitgap Vendor Weight: Not supported',

        'fitgapFunctionalWeight' => 'Fitgap Detailed Weight: Functional',
        'fitgapTechnicalWeight' => 'Fitgap Detailed Weight: Technical',
        'fitgapServiceWeight' => 'Fitgap Detailed Weight: Service',
        'fitgapOthersWeight' => 'Fitgap Detailed Weight: Others',

        'implementationImplementationWeight' => 'Implementation Detailed Weight: Implementation',
        'implementationRunWeight' => 'Implementation Detailed Weight: Run',
    ];
@endphp

<div>
    <h3>Weights</h3>
    <br>

    @foreach ($fields as $field => $label)
        <div class="form-group">
            <label>{{$label}}*</label>
            <input type="number" class="form-control scoringCriteriaWeightField"
                data-changing="{{$field}}"
                value="{{ $project->{$field} }}"
                {{$disabled ? 'disabled' : ''}}
                required>
        </div>
    @endforeach
</div>

@section('scripts')
@parent
<script>
    $(document).ready(function(){
        // Timeout cause otherwise the steps thingy messes it up
        setTimeout(weightSetup, 3000);
    })

    function weightSetup() {
        $('.scoringCriteriaWeightField').change(function(){
            const value = $(this).val();
            const changing = $(this).data('changing');
            console.log($(this))
            console.log(value)
            console.log(changing)
            $.post('/accenture/newProjectSetUp/changeWeights', {
                project_id: '{{$project->id}}',
                changing,
                value
            })

            showSavedToast();
        })
    }
</script>
@endsection
