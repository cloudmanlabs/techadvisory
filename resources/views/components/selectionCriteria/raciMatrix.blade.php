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
                <input type="text" class="form-control raciTitleInput" placeholder="Client"
                    value="{{$row['title'] ?? ''}}" required
                    {{$disabled ? 'disabled' : ''}}>
                <input type="text" class="form-control raciClientInput" placeholder="Title"
                    style="margin-left: 1rem"
                    value="{{$row['client'] ?? ''}}" required
                    {{$disabled ? 'disabled' : ''}}>
                <input type="text" class="form-control raciVendorInput" placeholder="Vendor"
                    style="margin-left: 1rem"
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
                    <input type="text" class="form-control raciTitleInput"
                        placeholder="Title"
                        value="" required>
                    <input type="text" class="form-control raciClientInput"
                        style="margin-left: 1rem"
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
                    title: $(this).children('.raciTitleInput').val(),
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
            if(updateSubmitButton){
                updateSubmitButton();
            }
        }

        setRaciEditListener();

        $('#raciMatrixScore').change(function(){
            $.post('/vendorApplication/updateImplementationScores', {
                application_id: {{$vendorApplication->id}},
                changing: 'raciMatrixScore',
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
