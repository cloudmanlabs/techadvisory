@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

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

@if ($evaluate)
    <div>
        <label for="overallCostScore">Overall Implementation Cost. Score</label>
        <input
            {{$evalDisabled ? 'disabled' : ''}}
            type="number"
            name="asdf"
            id="overallCostScore"
            min="0"
            max="10"
            value="{{$vendorApplication->overallCostScore}}"
            onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
    </div>
@endif
<br>
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
@if ($evaluate)
    <div>
        <label for="staffingCostScore">Staffing Cost. Score</label>
        <input
            {{$evalDisabled ? 'disabled' : ''}}
            type="number"
            name="asdf"
            id="staffingCostScore"
            min="0"
            max="10"
            value="{{$vendorApplication->staffingCostScore}}"
            onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
    </div>
@endif

<br>
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

@if ($evaluate)
    <div>
        <label for="travelCostScore">Travel Cost. Score</label>
        <input
            {{$evalDisabled ? 'disabled' : ''}}
            type="number"
            name="asdf"
            id="travelCostScore"
            min="0"
            max="10"
            value="{{$vendorApplication->travelCostScore}}"
            onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
    </div>
@endif

<br>
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

@if ($evaluate)
    <div>
        <label for="additionalCostScore">Additional Cost. Score</label>
        <input
            {{$evalDisabled ? 'disabled' : ''}}
            type="number"
            name="asdf"
            id="additionalCostScore"
            min="0"
            max="10"
            value="{{$vendorApplication->additionalCostScore}}"
            onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
    </div>
@endif



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
        })
        $('#staffingCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'staffingCostScore',
                value: $(this).val()
            })
            showSavedToast();
        })
        $('#travelCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'travelCostScore',
                value: $(this).val()
            })
            showSavedToast();
        })
        $('#additionalCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'additionalCostScore',
                value: $(this).val()
            })
            showSavedToast();
        })
    });
</script>
@endsection
