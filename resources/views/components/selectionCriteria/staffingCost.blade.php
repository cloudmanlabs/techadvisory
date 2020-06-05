@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Staffing Cost</label>

    <div id="staffingCostContainer">
        @foreach ($vendorApplication->staffingCost ?? [] as $row)
        <div>
            <label for="projectName">Role {{$loop->iteration}}</label>
            <div style="display: flex; flex-direction: row">
                <input type="text" class="form-control staffingCostTitleInput"
                    placeholder="Title"
                    value="{{$row['title'] ?? ''}}" required
                    {{$disabled ? 'disabled' : ''}}>
                <input type="number" class="form-control staffingCostHoursInput"
                    placeholder="Estimated number of hours"
                    value="{{$row['hours'] ?? ''}}" required
                    style="margin-left: 1rem"
                    {{$disabled ? 'disabled' : ''}}>
                <input type="number" class="form-control staffingCostRateInput"
                    placeholder="Hourly rate"
                    style="margin-left: 1rem"
                    value="{{$row['rate'] ?? ''}}" required
                    {{$disabled ? 'disabled' : ''}}>
                <input type="number" class="form-control staffingCostCostInput"
                    placeholder="Staffing cost"
                    style="margin-left: 1rem"
                    value="{{$row['cost'] ?? ''}}" required
                    {{$disabled ? 'disabled' : ''}}>
            </div>
        </div>
        @endforeach
    </div>

    @if (!$disabled)
    <br>
    <div style="display: flex; flex-direction: row;">
        <button class="btn btn-primary" id="addStaffingCostRow">
            Add row
        </button>
        <button class="btn btn-primary" id="removeStaffingCostRow" style="margin-left: 1rem">
            Remove row
        </button>
    </div>
    @endif
</div>
<p>Total Staffing Cost: <span id="totalStaffingCost">0</span>$</p>


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



@section('scripts')
@parent
<script>
    $(document).ready(function() {
        // RACI Matrix section
        $('#addStaffingCostRow').click(function(){
            const childrenCount = $('#staffingCostContainer').children().toArray().length;

            let newDeliverable = `
            <div>
                <label for="projectName">Role ${childrenCount + 1}</label>
                <div style="display: flex; flex-direction: row">
                    <input type="number" class="form-control staffingCostTitleInput"
                        placeholder="Estimated number of hours"
                        value="" required>
                    <input type="number" class="form-control staffingCostHoursInput"
                        placeholder="Estimated number of hours"
                        style="margin-left: 1rem"
                        value="" required>
                    <input type="number" class="form-control staffingCostRateInput"
                        placeholder="Hourly rate"
                        style="margin-left: 1rem"
                        value="" required>
                    <input type="number" class="form-control staffingCostCostInput"
                        placeholder="Staffing cost"
                        style="margin-left: 1rem"
                        value="" required>
                </div>
            </div>
            `;

            $('#staffingCostContainer').append(newDeliverable)

            setStaffingCostEditListener();
            updateStaffingCost();
        })

        $('#removeStaffingCostRow').click(function(){
            $('#staffingCostContainer').children().last().remove()
            updateStaffingCost()
        })

        function updateTotalStaffingCost(){
            const cost = $('#staffingCostContainer').children()
            .map(function(){
                return $(this).children().get(1)
            })
            .map(function(){
                return {
                    title: $(this).children('.staffingCostTitleInput').val(),
                    hours: $(this).children('.staffingCostHoursInput').val(),
                    rate: $(this).children('.staffingCostRateInput').val(),
                    cost: $(this).children('.staffingCostCostInput').val(),
                }
            }).toArray();

            const totalCost = cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)
            $('#totalStaffingCost').html(totalCost);

            updateTotalImplementation()
        }
        function setStaffingCostEditListener(){
            $('.staffingCostHoursInput, .staffingCostRateInput, .staffingCostCostInput, .staffingCostTitleInput').change(function(){
                updateStaffingCost();
            })
        }
        function updateStaffingCost(){
            const cost = $('#staffingCostContainer').children()
            .map(function(){
                return $(this).children().get(1)
            })
            .map(function(){
                return {
                    title: $(this).children('.staffingCostTitleInput').val(),
                    hours: $(this).children('.staffingCostHoursInput').val(),
                    rate: $(this).children('.staffingCostRateInput').val(),
                    cost: $(this).children('.staffingCostCostInput').val(),
                }
            }).toArray();

            updateTotalStaffingCost();

            $.post('/vendorApplication/updateStaffingCost', {
                changing: {{$vendorApplication->id}},
                value: cost
            })

            showSavedToast();
            if(updateSubmitButton){
                updateSubmitButton();
            }
        }

        setStaffingCostEditListener();
        updateTotalStaffingCost();

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
    });
</script>
@endsection
