@props(['vendorApplication'])

<div class="form-group">
    <label for="projectName">Travel Cost</label>

    <div id="travelCostContainer">
        @foreach ($vendorApplication->travelCost ?? [] as $cost)
        <div>
            <label for="projectName">Month {{$loop->iteration}}</label>
            <input type="number" class="form-control travelCostHoursInput"
                placeholder="Monthly travel cost"
                value="{{$cost ?? ''}}"
                required>
        </div>
        @endforeach
    </div>

    <br>
    <div style="display: flex; flex-direction: row;">
        <button class="btn btn-primary" id="addTravelCostRow">
            Add row
        </button>
        <button class="btn btn-primary" id="removeTravelCostRow" style="margin-left: 1rem">
            Remove row
        </button>
    </div>
</div>
<p>Total Travel Cost: <span id="totalTravelCost">0</span>$</p>



@section('scripts')
@parent
<script>
    $(document).ready(function() {
        // RACI Matrix section
        $('#addTravelCostRow').click(function(){
            const childrenCount = $('#travelCostContainer').children().toArray().length;

            let newDeliverable = `
            <div>
                <label for="projectName">Month ${childrenCount + 1}</label>
                <input type="number" class="form-control travelCostHoursInput"
                    placeholder="Monthly travel cost"
                    value=""
                    required>
            </div>
            `;

            $('#travelCostContainer').append(newDeliverable)

            setTravelCostEditListener();
            updateTravelCost();
        })

        $('#removeTravelCostRow').click(function(){
            $('#travelCostContainer').children().last().remove()
            updateTravelCost()
        })

        function updateTotalTravelCost(){
            const cost = $('#travelCostContainer').children()
                .map(function(){
                    return $(this).children('.travelCostHoursInput').val()
                }).toArray();

            const totalCost = cost.map((el) => +el).reduce((a, b) => a + b, 0)
            $('#totalTravelCost').html(totalCost);

            updateTotalImplementation()
        }

        function setTravelCostEditListener(){
            $('.travelCostHoursInput').change(function(){
                updateTravelCost();
            })
        }
        function updateTravelCost(){
            const cost = $('#travelCostContainer').children()
                .map(function(){
                    return $(this).children('.travelCostHoursInput').val()
                }).toArray();

            updateTotalTravelCost();

            $.post('/vendorApplication/updateTravelCost', {
                changing: {{$vendorApplication->id}},
                value: cost
            })

            showSavedToast();
        }

        setTravelCostEditListener();
        updateTotalTravelCost();
    });
</script>
@endsection
