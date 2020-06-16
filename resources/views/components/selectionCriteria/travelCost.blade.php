@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Travel Cost</label>

    <div id="travelCostContainer">
        @foreach ($vendorApplication->travelCost ?? [] as $cost)
        <div>
            <label for="projectName">Month {{$loop->iteration}}</label>
            <div style="display: flex; flex-direction: row">
                <input type="text" class="form-control travelTitleInput"
                    placeholder="Title"
                    value="{{$cost['title'] ?? ''}}"
                    required
                    {{$disabled ? 'disabled' : ''}}>
                <input type="number" class="form-control travelCostInput"
                    style="margin-left: 1rem"
                    placeholder="Monthly travel cost"
                    value="{{$cost['cost'] ?? ''}}"
                    required
                    {{$disabled ? 'disabled' : ''}}>
            </div>
        </div>
        @endforeach
    </div>

    @if (!$disabled)
    <br>
    <div style="display: flex; flex-direction: row;">
        <button class="btn btn-primary" id="addTravelCostRow">
            Add row
        </button>
        <button class="btn btn-primary" id="removeTravelCostRow" style="margin-left: 1rem">
            Remove row
        </button>
    </div>
    @endif
</div>
<p>Total Travel Cost: <span id="totalTravelCost">0</span>$</p>


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
                <div style="display: flex; flex-direction: row">
                    <input type="text" class="form-control travelTitleInput"
                        placeholder="Title"
                        value=""
                        required>
                    <input type="number" class="form-control travelCostInput"
                        style="margin-left: 1rem"
                        placeholder="Monthly travel cost"
                        value=""
                        required>
                </div>
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
                    return $(this).children().get(1)
                })
                .map(function(){
                    return {
                        title: $(this).children('.travelTitleInput').val(),
                        cost: $(this).children('.travelCostInput').val(),
                    }
                }).toArray();

            const totalCost = cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)
            $('#totalTravelCost').html(totalCost);

            updateTotalImplementation()
        }

        function setTravelCostEditListener(){
            $('.travelTitleInput, .travelCostInput').change(function(){
                updateTravelCost();
            })
        }
        function updateTravelCost(){
            const cost = $('#travelCostContainer').children()
                .map(function(){
                    return $(this).children().get(1)
                })
                .map(function(){
                    return {
                        title: $(this).children('.travelTitleInput').val(),
                        cost: $(this).children('.travelCostInput').val(),
                    }
                }).toArray();

            updateTotalTravelCost();

            $.post('/vendorApplication/updateTravelCost', {
                changing: {{$vendorApplication->id}},
                value: cost
            })

            showSavedToast();
            if(updateSubmitButton){
                updateSubmitButton();
            }
        }

        setTravelCostEditListener();
        updateTotalTravelCost();

        $('#travelCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'travelCostScore',
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
