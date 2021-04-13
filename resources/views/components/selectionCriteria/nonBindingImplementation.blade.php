@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
    $disabled = $disabled ?? false;
@endphp

<div>
    <label for="projectName">Overall Implementation cost</label>
    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Min *</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Max *</p>
        </div>
    </div>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Min"
               data-changing="overallImplementationMin"
               value="{{$vendorApplication->overallImplementationMin}}"
               {{$disabled ? 'disabled' : ''}} min="0" required>
        <input style="margin-left: 1rem;" type="number" class="form-control nonBindingInput" placeholder="Max"
               data-changing="overallImplementationMax"
               value="{{$vendorApplication->overallImplementationMax}}"
               {{$disabled ? 'disabled' : ''}} min="0" required>
    </div>
</div>

<br>
<div>
    <label for="projectName">Total Staffing cost (%)</label>
    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Percentage *</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Comments</p>
        </div>
    </div>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Percentage"
               data-changing="staffingCostNonBinding"
               value="{{$vendorApplication->staffingCostNonBinding}}" required
               {{$disabled ? 'disabled' : ''}} min="0">
        <input style="margin-left: 1rem;" type="text" class="form-control nonBindingInput" placeholder="Comments"
               data-changing="staffingCostNonBindingComments"
               value="{{$vendorApplication->staffingCostNonBindingComments}}"
               {{$disabled ? 'disabled' : ''}} min="0">
    </div>
</div>

<br>
<div>
    <label for="projectName">Total Travel cost (%)</label>
    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Percentage *</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Comments</p>
        </div>
    </div>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Percentage"
               data-changing="travelCostNonBinding"
               value="{{$vendorApplication->travelCostNonBinding}}" required
               {{$disabled ? 'disabled' : ''}} min="0">
        <input style="margin-left: 1rem;" type="text" class="form-control nonBindingInput" placeholder="Comments"
               data-changing="travelCostNonBindingComments"
               value="{{$vendorApplication->travelCostNonBindingComments}}"
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>

<br>
<div>
    <label for="projectName">Total Additional Cost (%)</label>
    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Percentage *</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Comments</p>
        </div>
    </div>
    <div style="display: flex; flex-direction: row">
        <input type="number" class="form-control nonBindingInput" placeholder="Percentage"
               data-changing="additionalCostNonBinding"
               value="{{$vendorApplication->additionalCostNonBinding}}" required
               {{$disabled ? 'disabled' : ''}} min="0">
        <input style="margin-left: 1rem;" type="text" class="form-control nonBindingInput" placeholder="Comments"
               data-changing="additionalCostNonBindingComments"
               value="{{$vendorApplication->additionalCostNonBindingComments}}"
            {{$disabled ? 'disabled' : ''}}>
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            $('.nonBindingInput').change(function () {
                $.post('/vendorApplication/updateNonBindingImplementation', {
                    changing: $(this).data('changing'),
                    application_id: {{$vendorApplication->id}},
                    value: $(this).val()
                }).done(function () {
                    showSavedToast();
                    updateSubmitButton();
                }).fail(handleAjaxError)
            });

            $('#overallCostScore').change(function () {
                $.post('/vendorApplication/updateImplementationScores', {
                    application_id: {{$vendorApplication->id}},
                    changing: 'overallCostScore',
                    value: $(this).val()
                }).done(function () {
                    showSavedToast();
                    if (updateSubmitButton) {
                        updateSubmitButton();
                    }
                }).fail(handleAjaxError)
            })
            $('#staffingCostScore').change(function () {
                $.post('/vendorApplication/updateImplementationScores', {
                    application_id: {{$vendorApplication->id}},
                    changing: 'staffingCostScore',
                    value: $(this).val()
                }).done(function () {
                    showSavedToast();
                    if (updateSubmitButton) {
                        updateSubmitButton();
                    }
                }).fail(handleAjaxError)
            })
            $('#travelCostScore').change(function () {
                $.post('/vendorApplication/updateImplementationScores', {
                    application_id: {{$vendorApplication->id}},
                    changing: 'travelCostScore',
                    value: $(this).val()
                }).done(function () {
                    showSavedToast();
                    if (updateSubmitButton) {
                        updateSubmitButton();
                    }
                }).fail(handleAjaxError)
            })
            $('#additionalCostScore').change(function () {
                $.post('/vendorApplication/updateImplementationScores', {
                    application_id: {{$vendorApplication->id}},
                    changing: 'additionalCostScore',
                    value: $(this).val()
                }).done(function () {
                    showSavedToast();
                    if (updateSubmitButton) {
                        updateSubmitButton();
                    }
                }).fail(handleAjaxError)
            })
        });
    </script>
@endsection
