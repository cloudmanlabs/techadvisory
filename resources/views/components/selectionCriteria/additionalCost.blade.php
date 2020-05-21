@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
    $disabled = $disabled ?? false;
    $evaluate = $evaluate ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Additional Cost</label>

    <div id="additionalCostContainer">
        @foreach ($vendorApplication->additionalCost ?? [] as $cost)
        <div>
            <label for="projectName">Item {{$loop->iteration}}</label>
            <input type="number" class="form-control additionalCostHoursInput"
                placeholder="Cost"
                {{$disabled ? 'disabled' : ''}}
                value="{{$cost ?? ''}}" required>
        </div>
        @endforeach
    </div>

    @if (!$disabled)
        <br>
        <div style="display: flex; flex-direction: row;">
            <button class="btn btn-primary" id="addAdditionalCostRow">
                Add row
            </button>
            <button class="btn btn-primary" id="removeAdditionalCostRow" style="margin-left: 1rem">
                Remove row
            </button>
        </div>
    @endif

    @if ($evaluate)
        <div>
            <label for="additionalCostScore">Additional Cost. Score</label>
            <input
                {{$evalDisabled ? 'disabled' : ''}}
                type="number"
                name="asdf"
                id="additionalCostScore"
                min="0"
                max="10"
                value="{{$vendorApplication->additionalCostScore}}"
                onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
        </div>
    @endif
</div>
<p>Total Additional Cost: <span id="totalAdditionalCost">0</span>$</p>


@section('scripts')
@parent
<script>
    $(document).ready(function() {
        // RACI Matrix section
        $('#addAdditionalCostRow').click(function(){
            const childrenCount = $('#additionalCostContainer').children().toArray().length;

            let newDeliverable = `
            <div>
                <label for="projectName">Item ${childrenCount + 1}</label>
                <input type="number" class="form-control additionalCostHoursInput"
                    placeholder="Cost"
                    value="" required>
            </div>
            `;

            $('#additionalCostContainer').append(newDeliverable)

            setAdditionalCostEditListener();
            updateAdditionalCost();
        })

        $('#removeAdditionalCostRow').click(function(){
            $('#additionalCostContainer').children().last().remove()
            updateAdditionalCost()
        })

        function updateTotalAdditionalCost(){
            const cost = $('#additionalCostContainer').children()
                .map(function(){
                    return $(this).children('.additionalCostHoursInput').val()
                }).toArray();

            const totalCost = cost.map((el) => +el).reduce((a, b) => a + b, 0)
            $('#totalAdditionalCost').html(totalCost);

            updateTotalImplementation()
        }
        function setAdditionalCostEditListener(){
            $('.additionalCostHoursInput').change(function(){
                updateAdditionalCost();
            })
        }
        function updateAdditionalCost(){
            const cost = $('#additionalCostContainer').children()
                .map(function(){
                    return $(this).children('.additionalCostHoursInput').val()
                }).toArray();

            updateTotalAdditionalCost();

            $.post('/vendorApplication/updateAdditionalCost', {
                changing: {{$vendorApplication->id}},
                value: cost
            })

            showSavedToast();
        }

        setAdditionalCostEditListener();
        updateTotalAdditionalCost();




        $('#additionalCostScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'additionalCostScore',
                value: $(this).val()
            })
            showSavedToast();
        })
    });
</script>
@endsection
