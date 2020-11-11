@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
    $disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Travel Cost</label>

    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Title</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Monthly travel cost</p>
        </div>
    </div>
    <div id="travelCostContainer">
        @foreach ($vendorApplication->travelCost ?? [] as $cost)
            <div style="margin-top: 0.5rem">
                <div style="display: flex; flex-direction: row">
                    <input type="text" class="form-control travelTitleInput"
                           placeholder="Title"
                           value="{{$cost['title'] ?? ''}}"
                           {{$disabled ? 'disabled' : ''}} min="0">
                    <input type="number" class="form-control travelCostInput"
                           style="margin-left: 1rem"
                           placeholder="Monthly travel cost"
                           value="{{$cost['cost'] ?? ''}}"
                           {{$disabled ? 'disabled' : ''}} min="0">
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
<p>Total Travel Cost: {{$vendorApplication->project->currency ?? ''}} <span id="totalTravelCost">0</span></p>



@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            // RACI Matrix section
            $('#addTravelCostRow').click(function () {
                const childrenCount = $('#travelCostContainer').children().toArray().length;

                let newDeliverable = `
            <div style="margin-top: 0.5rem">
                <div style="display: flex; flex-direction: row">
                    <input type="text" class="form-control travelTitleInput"
                        placeholder="Title"
                        value=""
                        min="0">
                    <input type="number" class="form-control travelCostInput"
                        style="margin-left: 1rem"
                        placeholder="Monthly travel cost"
                        value=""
                        min="0">
                </div>
            </div>
            `;

                $('#travelCostContainer').append(newDeliverable)

                setTravelCostEditListener();
                updateTravelCost();
            })

            $('#removeTravelCostRow').click(function () {
                $('#travelCostContainer').children().last().remove()
                updateTravelCost()
            })

            function updateTotalTravelCost() {
                const cost = $('#travelCostContainer').children()
                    .map(function () {
                        return $(this).children().get(0)
                    })
                    .map(function () {
                        return {
                            title: $(this).children('.travelTitleInput').val(),
                            cost: $(this).children('.travelCostInput').val(),
                        }
                    }).toArray();

                const totalCost = cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)
                $('#totalTravelCost').html(totalCost);

                updateTotalImplementation()
            }

            function setTravelCostEditListener() {
                $('.travelTitleInput, .travelCostInput').change(function () {
                    updateTravelCost();
                })
            }

            function updateTravelCost() {
                const cost = $('#travelCostContainer').children()
                    .map(function () {
                        return $(this).children().get(0)
                    })
                    .map(function () {
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
                if (updateSubmitButton) {
                    updateSubmitButton();
                }
            }

            setTravelCostEditListener();
            updateTotalTravelCost();

            $('#travelCostScore').change(function () {
                $.post('/vendorApplication/updateImplementationScores', {
                    application_id: {{$vendorApplication->id}},
                    changing: 'travelCostScore',
                    value: $(this).val()
                })
                showSavedToast();
                if (updateSubmitButton) {
                    updateSubmitButton();
                }
            })
        });
    </script>
@endsection
