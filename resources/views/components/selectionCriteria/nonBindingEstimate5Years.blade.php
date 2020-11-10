@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp
<br>
<h5>Billing Plan</h5>
<br>
<div class="form-group">
    <label for="projectName">Estimate first 5 years billing plan</label>

    <div>
        <label for="projectName">Average yearly cost</label>
        <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
            <div style="width: 50%; padding: 0 0.5rem">
                <p>Min</p>
            </div>
            <div style="width: 50%; padding: 0 0.5rem">
                <p>Max</p>
            </div>
        </div>
        <div style="display: flex; flex-direction: row">
            <input type="number" id="averageYearlyCostMin" class="form-control nonBindingInput" placeholder="Min" data-changing="averageYearlyCostMin"
                value="{{$vendorApplication->averageYearlyCostMin}}"
                {{$disabled ? 'disabled' : ''}} min="0">
            <input style="margin-left: 1rem;" id="averageYearlyCostMax" type="number" class="form-control nonBindingInput" placeholder="Max" data-changing="averageYearlyCostMax"
                value="{{$vendorApplication->averageYearlyCostMax}}"
                {{$disabled ? 'disabled' : ''}} min="0">
        </div>
    </div>
    <div>
        <label for="projectName">Total run cost</label>
        <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
            <div style="width: 50%; padding: 0 0.5rem">
                <p>Min</p>
            </div>
            <div style="width: 50%; padding: 0 0.5rem">
                <p>Max</p>
            </div>
        </div>
        <div style="display: flex; flex-direction: row">
            <input type="number" class="form-control nonBindingInput" placeholder="Min" data-changing="totalRunCostMin"
                value="{{$vendorApplication->totalRunCostMin}}"
                {{$disabled ? 'disabled' : ''}} min="0">
            <input style="margin-left: 1rem;" type="number" class="form-control nonBindingInput" placeholder="Max" data-changing="totalRunCostMax"
                value="{{$vendorApplication->totalRunCostMax}}"
                {{$disabled ? 'disabled' : ''}} min="0">
        </div>
    </div>


    <div id="estimate5YearsContainer">
        @foreach (($vendorApplication->estimate5Years ?? [0, 0, 0, 0, 0]) as $cost)
        <div>
            <label for="projectName">Year {{$loop->iteration}} (% out of total run cost)</label>
            <input type="number" class="form-control estimate5YearsHoursInput"
                placeholder="Percentage out of total run"
                value="{{$cost ?? ''}}"
                min="0"
                {{$disabled ? 'disabled' : ''}}>
        </div>
        @endforeach
    </div>
</div>
<br>
<p>Average Yearly Cost: {{$vendorApplication->project->currency ?? ''}} <span id="averageEstimate5YearsCost">0</span></p>


@section('scripts')
@parent
<script>
    $(document).ready(function() {
        function updateEstimateTotalCost(){
            const averageYearlyCostMin = +$('#averageYearlyCostMin').val();
            const averageYearlyCostMax = +$('#averageYearlyCostMax').val();

            $('#averageEstimate5YearsCost').html((averageYearlyCostMin + averageYearlyCostMax) / 2);
        }

        function setEstimate5YearsEditListener(){
            $('.estimate5YearsHoursInput, #estimate5YearsYear0Cost, #averageYearlyCostMin, #averageYearlyCostMax').change(function(){
                updateEstimate5Years();
            })
        }
        function updateEstimate5Years(){
            const cost = $('#estimate5YearsContainer').children()
                .map(function(){
                    return $(this).children('.estimate5YearsHoursInput').val()
                }).toArray();

            updateEstimateTotalCost();

            $.post('/vendorApplication/updateEstimate5Years', {
                changing: {{$vendorApplication->id}},
                value: cost,
                year0: $('#estimate5YearsYear0Cost').val()
            })

            showSavedToast();
        }

        setEstimate5YearsEditListener();
        updateEstimateTotalCost();


        $('.nonBindingInput').change(function(){
            $.post('/vendorApplication/updateNonBindingImplementation', {
                changing: $(this).data('changing'),
                application_id: {{$vendorApplication->id}},
                value: $(this).val()
            })

            showSavedToast();
            if(updateSubmitButton){
            updateSubmitButton();
            }
        });


        $('#nonBindingEstimate5YearsScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'nonBindingEstimate5YearsScore',
                value: $(this).val()
            })
            showSavedToast();
        })
    });
</script>
@endsection
