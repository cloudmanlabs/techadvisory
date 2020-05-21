@props(['vendorApplication', 'disabled'])

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
    });
</script>
@endsection
