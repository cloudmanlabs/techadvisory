@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">Deliverables per phase</label>

    <div id="deliverableContainer">
        @foreach ($vendorApplication->deliverables ?? [] as $deliverable)
        <div>
            <label for="projectName">Phase {{$loop->iteration}}</label>
            <input type="text" class="form-control deliverableInput" data-changing="name"
                placeholder="Deliverable"
                {{$disabled ? 'disabled' : ''}}
                value="{{$deliverable}}" required>
        </div>
        @endforeach
    </div>

    @if (!$disabled)
    <br>
    <div style="display: flex; flex-direction: row;">
        <button class="btn btn-primary" id="addDeliverable">
            Add deliverable
        </button>
        <button class="btn btn-primary" id="removeDeliverable" style="margin-left: 1rem">
            Remove deliverable
        </button>
    </div>
    @endif

    @if ($evaluate)
        <div>
            <label for="deliverablesScore">Deliverables. Score</label>
            <input {{$evalDisabled ? 'disabled' : ''}} type="number" name="asdf" id="deliverablesScore" min="0" max="10"
                value="{{$vendorApplication->deliverablesScore}}"
                onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
        </div>
    @endif
</div>

@section('scripts')
@parent
<script>
    $(document).ready(function() {
        $('#addDeliverable').click(function(){
            const childrenCount = $('#deliverableContainer').children().toArray().length;

            let newDeliverable = `
            <div>
                <label for="projectName">Phase ${childrenCount + 1}</label>
                <input type="text" class="form-control deliverableInput" data-changing="name" placeholder="Deliverable"
                    value="" required>
            </div>
            `;

            $('#deliverableContainer').append(newDeliverable)

            setDeliverableEditListener();
            updateDeliverables();
        })

        $('#removeDeliverable').click(function(){
            $('#deliverableContainer').children().last().remove()
            updateDeliverables()
        })

        function setDeliverableEditListener(){
            $('.deliverableInput').change(function(){
                updateDeliverables();
            })
        }
        function updateDeliverables(){
            const deliverables = $('#deliverableContainer').children().map(function(){
                return $(this).children('input').val()
            }).toArray();

            $.post('/vendorApplication/updateDeliverables', {
                changing: {{$vendorApplication->id}},
                value: deliverables
            })

            showSavedToast();
        }

        setDeliverableEditListener();

        $('#deliverablesScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'deliverablesScore',
                value: $(this).val()
            })
            showSavedToast();
        })
    });
</script>
@endsection