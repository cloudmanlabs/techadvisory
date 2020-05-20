@props(['vendorApplication'])

<div class="form-group">
    <label for="projectName">Staffing Cost</label>

    <div id="staffingCostContainer">
        @foreach ($vendorApplication->staffingCost ?? [] as $row)
        <div>
            <label for="projectName">Role {{$loop->iteration}}</label>
            <div style="display: flex; flex-direction: row">
                <input type="number" class="form-control staffingCostHoursInput"
                    placeholder="Estimated number of hours"
                    value="{{$row['hours'] ?? ''}}" required>
                <input type="number" class="form-control staffingCostRateInput"
                    placeholder="Hourly rate"
                    style="margin-left: 1rem"
                    value="{{$row['rate'] ?? ''}}" required>
                <input type="number" class="form-control staffingCostCostInput"
                    placeholder="Staffing cost"
                    style="margin-left: 1rem"
                    value="{{$row['cost'] ?? ''}}" required>
            </div>
        </div>
        @endforeach
    </div>

    <br>
    <div style="display: flex; flex-direction: row;">
        <button class="btn btn-primary" id="addStaffingCostRow">
            Add row
        </button>
        <button class="btn btn-primary" id="removeStaffingCostRow" style="margin-left: 1rem">
            Remove row
        </button>
    </div>
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
            <div>
                <label for="projectName">Role ${childrenCount + 1}</label>
                <div style="display: flex; flex-direction: row">
                    <input type="number" class="form-control staffingCostHoursInput"
                        placeholder="Estimated number of hours"
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
            $('.staffingCostHoursInput, .staffingCostRateInput, .staffingCostCostInput').change(function(){
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
        }

        setStaffingCostEditListener();
        updateTotalStaffingCost();
    });
</script>
@endsection
