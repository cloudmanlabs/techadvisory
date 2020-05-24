@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Estimate first 5 years billing plan</label>

    <div>
        <label for="projectName">Year 0</label>
        <input type="number" class="form-control"
            id="estimate5YearsYear0Cost"
            placeholder="Total implementation cost"
            {{$disabled ? 'disabled' : ''}}
            value="{{$vendorApplication->estimate5YearsYear0 ?? ''}}"
            required>
    </div>
    <div id="estimate5YearsContainer">
        @foreach (($vendorApplication->estimate5Years ?? [0, 0, 0, 0, 0]) as $cost)
        <div>
            <label for="projectName">Year {{$loop->iteration}}</label>
            <input type="number" class="form-control estimate5YearsHoursInput"
                placeholder="Cost"
                {{$disabled ? 'disabled' : ''}}
                value="{{$cost ?? ''}}"
                required>
        </div>
        @endforeach
    </div>
</div>
<p>Total Cost: <span id="totalEstimate5YearsCost">0</span>$</p>
<br>
<p>Average Yearly Cost: <span id="averageEstimate5YearsCost">0</span>$</p>


@if ($evaluate)
    <div>
        <label for="estimate5YearsScore">Estimate first 5 years billing plan. Score</label>
        <input
            {{$evalDisabled ? 'disabled' : ''}}
            type="number"
            name="asdf"
            id="estimate5YearsScore"
            min="0"
            max="10"
            value="{{$vendorApplication->estimate5YearsScore}}"
            onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
    </div>
@endif


@section('scripts')
@parent
<script>
    $(document).ready(function() {
        function updateEstimateTotalCost(){
            const year0Cost = $('#estimate5YearsYear0Cost').val();
            const cost = $('#estimate5YearsContainer').children()
                .map(function(){
                    return $(this).children('.estimate5YearsHoursInput').val()
                }).toArray();

            const totalCost = cost.map((el) => +el).reduce((a, b) => a + b, 0)
            $('#totalEstimate5YearsCost').html(totalCost + (+year0Cost));
            $('#averageEstimate5YearsCost').html(totalCost / 5);
        }

        function setEstimate5YearsEditListener(){
            $('.estimate5YearsHoursInput, #estimate5YearsYear0Cost').change(function(){
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
