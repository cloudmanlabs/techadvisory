@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
    $disabled = $disabled ?? false;
    $evaluate = $evaluate ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Additional Cost *</label>

    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Title *</p>
        </div>
        <div style="width: 50%; padding: 0 0.5rem">
            <p>Cost *</p>
        </div>
    </div>
    <div id="additionalCostContainer">
        @foreach ($vendorApplication->additionalCost ?? [] as $cost)
            <div style="margin-top: 0.5rem">
                <div style="display: flex; flex-direction: row">
                    <input type="text" class="form-control additionalTitleInput"
                           placeholder="Title"
                           {{$disabled ? 'disabled' : ''}}
                           value="{{$cost['title'] ?? ''}}" required>
                    <input type="number" class="form-control additionalCostInput"
                           style="margin-left: 1rem"
                           placeholder="Cost"
                           min="0"
                           {{$disabled ? 'disabled' : ''}}
                           value="{{$cost['cost'] ?? ''}}" required>
                </div>
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
</div>
<p>Total Additional Cost: {{$vendorApplication->project->currency ?? ''}} <span id="totalAdditionalCost">0</span></p>


@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            // RACI Matrix section
            $('#addAdditionalCostRow').click(function () {
                const childrenCount = $('#additionalCostContainer').children().toArray().length;
                let newDeliverable = `
            <div style="margin-top: 0.5rem">
                <div style="display: flex; flex-direction: row">
                    <input type="text" class="form-control additionalTitleInput"
                        placeholder="Title"
                        value="" required>
                    <input type="number" class="form-control additionalCostInput"
                        style="margin-left: 1rem"
                        placeholder="Cost"
                        min="0"
                        value="" required>
                </div>
            </div>
            `;
                $('#additionalCostContainer').append(newDeliverable)
                setAdditionalCostEditListener();
                updateAdditionalCost();
            })
            $('#removeAdditionalCostRow').click(function () {
                $('#additionalCostContainer').children().last().remove()
                updateAdditionalCost()
            })

            function updateTotalAdditionalCost() {
                const cost = $('#additionalCostContainer').children()
                    .map(function () {
                        return $(this).children().get(0)
                    })
                    .map(function () {
                        return {
                            title: $(this).children('.additionalTitleInput').val(),
                            cost: $(this).children('.additionalCostInput').val(),
                        }
                    }).toArray();
                const totalCost = cost.map((el) => +el.cost).reduce((a, b) => a + b, 0)
                $('#totalAdditionalCost').html(totalCost);
                updateTotalImplementation()
            }

            function setAdditionalCostEditListener() {
                $('.additionalTitleInput, .additionalCostInput').change(function () {
                    updateAdditionalCost();
                })
            }

            function updateAdditionalCost() {
                const cost = $('#additionalCostContainer')
                    .children()
                    .map(function () {
                        return $(this).children().get(0)
                    })
                    .map(function () {
                        return {
                            title: $(this).children('.additionalTitleInput').val(),
                            cost: $(this).children('.additionalCostInput').val(),
                        }
                    })
                    .toArray();

                updateTotalAdditionalCost();

                $.post('/vendorApplication/updateAdditionalCost', {
                    changing: {{$vendorApplication->id}},
                    value: cost
                }).done(function () {
                    showSavedToast();
                    if (updateSubmitButton) {
                        updateSubmitButton();
                    }
                }).fail(handleAjaxError)
            }

            setAdditionalCostEditListener();
            updateTotalAdditionalCost();
            $('#additionalCostScore').change(function () {
                $.post('/vendorApplication/updateImplementationScores', {
                    application_id: {{$vendorApplication->id}},
                    changing: 'additionalCostScore',
                    value: $(this).val()
                }).done(showSavedToast).fail(handleAjaxError)
            })
        });
    </script>
@endsection
