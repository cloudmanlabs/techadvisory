@props(['vendorApplication', 'disabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div>
    <label for="projectName">Overall Implementation cost</label>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Min" data-changing="overallImplementationMin"
            value="{{$vendorApplication->overallImplementationMin}}" required
            {{$disabled ? 'disabled' : ''}}>
        <input style="margin-left: 1rem;" type="number" class="form-control nonBindingInput" placeholder="Max" data-changing="overallImplementationMax"
            value="{{$vendorApplication->overallImplementationMax}}" required
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>

<div>
    <label for="projectName">Total Staffing cost</label>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Percentage" data-changing="staffingCostNonBinding"
            value="{{$vendorApplication->staffingCostNonBinding}}" required
            {{$disabled ? 'disabled' : ''}}>
        <input style="margin-left: 1rem;" type="text" class="form-control nonBindingInput" placeholder="Comments" data-changing="staffingCostNonBindingComments"
            value="{{$vendorApplication->staffingCostNonBindingComments}}" required
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>

<div>
    <label for="projectName">Total Travel cost</label>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Percentage" data-changing="travelCostNonBinding"
            value="{{$vendorApplication->travelCostNonBinding}}" required
            {{$disabled ? 'disabled' : ''}}>
        <input style="margin-left: 1rem;" type="text" class="form-control nonBindingInput" placeholder="Comments" data-changing="travelCostNonBindingComments"
            value="{{$vendorApplication->travelCostNonBindingComments}}" required
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>

<div>
    <label for="projectName">Total Additional Cost</label>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Percentage" data-changing="additionalCostNonBinding"
            value="{{$vendorApplication->additionalCostNonBinding}}" required
            {{$disabled ? 'disabled' : ''}}>
        <input style="margin-left: 1rem;" type="text" class="form-control nonBindingInput" placeholder="Comments" data-changing="additionalCostNonBindingComments"
            value="{{$vendorApplication->additionalCostNonBindingComments}}" required
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>



@section('scripts')
@parent
<script>
    $(document).ready(function() {
        $('.nonBindingInput').change(function(){
            $.post('/vendorApplication/updateNonBindingImplementation', {
                changing: $(this).data('changing'),
                application_id: {{$vendorApplication->id}},
                value: $(this).val()
            })

            showSavedToast();
        });
    });
</script>
@endsection
