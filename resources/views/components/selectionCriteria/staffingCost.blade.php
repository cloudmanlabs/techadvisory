@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Staffing Cost</label>

    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 25%; padding: 0 0.5rem">
            <p>Title</p>
        </div>
        <div style="width: 25%; padding: 0 0.5rem">
            <p>Estimated number of hours</p>
        </div>
        <div style="width: 25%; padding: 0 0.5rem">
            <p>Hourly rate</p>
        </div>
        <div style="width: 25%; padding: 0 0.5rem">
            <p>Staffing cost</p>
        </div>
    </div>
    <div id="staffingCostContainer">
        @foreach ($vendorApplication->staffingCost ?? [] as $row)
        <div style="margin-top: 0.5rem">
            {{-- <label for="projectName">Role {{$loop->iteration}}</label> --}}
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
                    value="{{$row['cost'] ?? ''}}"
                    disabled
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



@section('scripts')
@parent
<script>
    $(document).ready(function() {
        // RACI Matrix section
        $('#addStaffingCostRow').click(function(){
            const childrenCount = $('#staffingCostContainer').children().toArray().length;

            let newDeliverable = `
            <div style="margin-top: 0.5rem">
                <div style="display: flex; flex-direction: row">
                    <input type="text" class="form-control staffingCostTitleInput"
                        placeholder="Title"
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
                        disabled
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
                return $(this).children().get(0)
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
            $('.staffingCostHoursInput, .staffingCostRateInput, .staffingCostTitleInput').change(function(){
                updateStaffingCost();
            })
        }
        function updateStaffingCost(){
            const cost = $('#staffingCostContainer').children()
                .map(function(){
                    return $(this).children().get(0)
                })
                .map(function(){
                    const hours = $(this).children('.staffingCostHoursInput').val();
                    const rate = $(this).children('.staffingCostRateInput').val();

                    const cost = hours * rate;
                    $(this).children('.staffingCostCostInput').val(cost)
                    return {
                        title: $(this).children('.staffingCostTitleInput').val(),
                        hours,
                        rate,
                        cost,
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
