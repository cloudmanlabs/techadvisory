@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div>
    <label for="projectName">Overall Implementation cost</label>
    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Min</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Max</p>
        </div>
    </div>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Min" data-changing="overallImplementationMin"
            value="{{$vendorApplication->overallImplementationMin}}" required
            {{$disabled ? 'disabled' : ''}}>
        <input style="margin-left: 1rem;" type="number" class="form-control nonBindingInput" placeholder="Max" data-changing="overallImplementationMax"
            value="{{$vendorApplication->overallImplementationMax}}" required
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>

<br>
<div>
    <label for="projectName">Total Staffing cost (%)</label>
    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Percentage</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Comments</p>
        </div>
    </div>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Percentage" data-changing="staffingCostNonBinding"
            value="{{$vendorApplication->staffingCostNonBinding}}" required
            {{$disabled ? 'disabled' : ''}}>
        <input style="margin-left: 1rem;" type="text" class="form-control nonBindingInput" placeholder="Comments" data-changing="staffingCostNonBindingComments"
            value="{{$vendorApplication->staffingCostNonBindingComments}}" required
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>

<br>
<div>
    <label for="projectName">Total Travel cost (%)</label>
    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Percentage</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Comments</p>
        </div>
    </div>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Percentage" data-changing="travelCostNonBinding"
            value="{{$vendorApplication->travelCostNonBinding}}" required
            {{$disabled ? 'disabled' : ''}}>
        <input style="margin-left: 1rem;" type="text" class="form-control nonBindingInput" placeholder="Comments" data-changing="travelCostNonBindingComments"
            value="{{$vendorApplication->travelCostNonBindingComments}}" required
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>

<br>
<div>
    <label for="projectName">Total Additional Cost (%)</label>
    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Percentage</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Comments</p>
        </div>
    </div>
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


        $('#overallCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'overallCostScore',
                value: $(this).val()
            })
            showSavedToast();
            if(updateSubmitButton){
                updateSubmitButton();
            }
        })
        $('#staffingCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'staffingCostScore',
                value: $(this).val()
            })
            showSavedToast();
            if(updateSubmitButton){
                updateSubmitButton();
            }
        })
        $('#travelCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'travelCostScore',
                value: $(this).val()
            })
            showSavedToast();
            if(updateSubmitButton){
                updateSubmitButton();
            }
        })
        $('#additionalCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'additionalCostScore',
                value: $(this).val()
            })
            showSavedToast();
            if(updateSubmitButton){
                updateSubmitButton();
            }
        })
    });
</script>
@endsection
