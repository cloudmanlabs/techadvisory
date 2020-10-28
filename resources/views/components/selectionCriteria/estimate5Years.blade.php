@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp
<br>
<h5>Billing Plan</h5>
<br>
<div class="form-group">
    <label for="projectName">Estimate first 5 years billing plan</label>

    <div id="estimate5YearsContainer">
        @foreach (($vendorApplication->estimate5Years ?? [0, 0, 0, 0, 0]) as $cost)
        <div>
            <label for="projectName">Year {{$loop->iteration}}</label>
            <input type="number" class="form-control estimate5YearsHoursInput"
                placeholder="Cost"
                {{$disabled ? 'disabled' : ''}}
                min="0"
                value="{{$cost ?? ''}}"
                required>
        </div>
        @endforeach
    </div>
</div>
<p>Total Run Cost: {{$vendorApplication->project->currency ?? ''}} <span id="totalEstimate5YearsCost">0</span></p>
<br>
<p>Average Yearly Cost: {{$vendorApplication->project->currency ?? ''}} <span id="averageEstimate5YearsCost">0</span></p>


@section('scripts')
@parent
<script>
    $(document).ready(function() {
        function updateEstimateTotalCost(){
           var elementsToAdd =
                $('#estimate5YearsContainer').children()
                .map(function(){
                    return $(this).children('.estimate5YearsHoursInput').val()
                })
                .toArray()
                .map(function(el) { return +el})
                .filter(function(el) { return el != 0});
           var totalCost = elementsToAdd
                .reduce(function (a, b) {return a + b}, 0);
            $('#totalEstimate5YearsCost').html(totalCost);
            if(elementsToAdd.length !== 0){
                $('#averageEstimate5YearsCost').html(totalCost / (elementsToAdd.length));
            }
        }

        function setEstimate5YearsEditListener(){
            $('.estimate5YearsHoursInput, #estimate5YearsYear0Cost').change(function(){
                updateEstimate5Years();
            })
        }
        function updateEstimate5Years(){
           var cost = $('#estimate5YearsContainer').children()
                .map(function(){
                    return $(this).children('.estimate5YearsHoursInput').val()
                }).toArray();

            updateEstimateTotalCost();

            $.post('/vendorApplication/updateEstimate5Years', {
                changing: {{$vendorApplication->id}},
                value: cost,
                year0: 0
            })

            showSavedToast();
            if(updateSubmitButton){
                updateSubmitButton();
            }
        }

        setEstimate5YearsEditListener();
        updateEstimateTotalCost();


        $('#estimate5YearsScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'estimate5YearsScore',
                value: $(this).val()
            })
            showSavedToast();
        })
    });
</script>
@endsection
