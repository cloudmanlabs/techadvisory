@props(['vendorApplication', 'disabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Estimate first 5 years billing plan</label>

    <div>
        <label for="projectName">Average yearly cost</label>
        <div style="display: flex; flex-direction: row">
            <input type="number" class="form-control nonBindingInput" placeholder="Min" data-changing="averageYearlyCostMin"
                value="{{$vendorApplication->averageYearlyCostMin}}" required
                {{$disabled ? 'disabled' : ''}}>
            <input style="margin-left: 1rem;" type="number" class="form-control nonBindingInput" placeholder="Max" data-changing="averageYearlyCostMax"
                value="{{$vendorApplication->averageYearlyCostMax}}" required
                {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>
    <div>
        <label for="projectName">Total run cost</label>
        <div style="display: flex; flex-direction: row">
            <input type="number" class="form-control nonBindingInput" placeholder="Min" data-changing="totalRunCostMin"
                value="{{$vendorApplication->totalRunCostMin}}" required
                {{$disabled ? 'disabled' : ''}}>
            <input style="margin-left: 1rem;" type="number" class="form-control nonBindingInput" placeholder="Max" data-changing="totalRunCostMax"
                value="{{$vendorApplication->totalRunCostMax}}" required
                {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>


    <div id="estimate5YearsContainer">
        @foreach (($vendorApplication->estimate5Years ?? [0, 0, 0, 0, 0]) as $cost)
        <div>
            <label for="projectName">Year {{$loop->iteration}}</label>
            <input type="number" class="form-control estimate5YearsHoursInput"
                placeholder="Percentage out of total run"
                value="{{$cost ?? ''}}"
                required
                {{$disabled ? 'disabled' : ''}}>
        </div>
        @endforeach
    </div>
</div>
<p>Total Cost: <span id="totalEstimate5YearsCost">0</span>$</p>
<br>
<p>Average Yearly Cost: <span id="averageEstimate5YearsCost">0</span>$</p>



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
        });
    });
</script>
@endsection
