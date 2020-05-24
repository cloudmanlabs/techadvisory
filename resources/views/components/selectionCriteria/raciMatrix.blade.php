@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">RACI Matrix</label>

    <div id="raciContainer">
        @foreach ($vendorApplication->raciMatrix ?? [] as $row)
        <div>
            <label for="projectName">Task {{$loop->iteration}}</label>
            <div style="display: flex; flex-direction: row">
                <input type="text" class="form-control raciClientInput" placeholder="Client"
                    value="{{$row['client'] ?? ''}}" required
                    {{$disabled ? 'disabled' : ''}}>
                <input type="text" class="form-control raciVendorInput" placeholder="Vendor" style="margin-left: 1rem"
                    value="{{$row['vendor'] ?? ''}}" required
                    {{$disabled ? 'disabled' : ''}}>
                <input type="text" class="form-control raciAccentureInput" placeholder="Accenture"
                    style="margin-left: 1rem" value="{{$row['accenture'] ?? ''}}" required
                    {{$disabled ? 'disabled' : ''}}>
            </div>
        </div>
        @endforeach
    </div>

    @if (!$disabled)
    <br>
    <div style="display: flex; flex-direction: row;">
        <button class="btn btn-primary" id="addRaciRow">
            Add row
        </button>
        <button class="btn btn-primary" id="removeRaciRow" style="margin-left: 1rem">
            Remove row
        </button>
    </div>
    @endif
</div>

@if ($evaluate)
    <div>
        <label for="raciMatrixScore">RACI Matrix. Score</label>
        <input
            {{$evalDisabled ? 'disabled' : ''}}
            type="number"
            name="asdf"
            id="raciMatrixScore"
            min="0"
            max="10"
            value="{{$vendorApplication->raciMatrixScore}}"
            onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
    </div>
@endif



@section('scripts')
@parent
<script>
    $(document).ready(function() {
        // RACI Matrix section
        $('#addRaciRow').click(function(){
            const childrenCount = $('#raciContainer').children().toArray().length;

            let newDeliverable = `
            <div>
                <label for="projectName">Task ${childrenCount + 1}</label>
                <div style="display: flex; flex-direction: row">
                    <input type="text" class="form-control raciClientInput"
                        placeholder="Client"
                        value="" required>
                    <input type="text" class="form-control raciVendorInput"
                        placeholder="Vendor"
                        style="margin-left: 1rem"
                        value="" required>
                    <input type="text" class="form-control raciAccentureInput"
                        placeholder="Accenture"
                        style="margin-left: 1rem"
                        value="" required>
                </div>
            </div>
            `;

            $('#raciContainer').append(newDeliverable)

            setRaciEditListener();
            updateRaci();
        })

        $('#removeRaciRow').click(function(){
            $('#raciContainer').children().last().remove()
            updateRaci()
        })

        function setRaciEditListener(){
            $('.raciClientInput, .raciVendorInput, .raciAccentureInput').change(function(){
                updateRaci();
            })
        }
        function updateRaci(){
            const raci = $('#raciContainer').children()
            .map(function(){
                return $(this).children().get(1)
            })
            .map(function(){
                return {
                    client: $(this).children('.raciClientInput').val(),
                    vendor: $(this).children('.raciVendorInput').val(),
                    accenture: $(this).children('.raciAccentureInput').val(),
                }
            }).toArray();

            console.log(raci)

            $.post('/vendorApplication/updateRaci', {
                changing: {{$vendorApplication->id}},
                value: raci
            })

            showSavedToast();
        }

        setRaciEditListener();

        $('#raciMatrixScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'raciMatrixScore',
                value: $(this).val()
            })
            showSavedToast();
        })
    });
</script>
@endsection