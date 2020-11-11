@props(['vendorApplication', 'disabled', 'evaluate', 'evalDisabled'])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group">
    <label for="projectName">RACI Matrix *</label>

    <div style="display: flex; flex-direction: row; justify-content: space-evenly; width: 100%">
        <div style="width: 25%; padding: 0 0.5rem">
            <p>Title</p>
        </div>
        <div style="width: 25%; padding: 0 0.5rem">
            <p>Client</p>
        </div>
        <div style="width: 25%; padding: 0 0.5rem">
            <p>Vendor</p>
        </div>
        <div style="width: 25%; padding: 0 0.5rem">
            <p>Integrator</p>
        </div>
    </div>
    <div id="raciContainer">
        @foreach ($vendorApplication->raciMatrix ?? [] as $row)
        <div>
            <label for="projectName">Task {{$loop->iteration}}</label>
            <div style="display: flex; flex-direction: row">
                <input type="text" class="form-control raciTitleInput" placeholder="Title"
                    value="{{$row['title'] ?? ''}}"
                    {{$disabled ? 'disabled' : ''}}>
                <select class="form-control raciClientInput" style="margin-left: 1rem" {{$disabled ? 'disabled' : ''}}>
                    <option disabled>Please choose one</option>
                    <option {{$row['client'] == "Responsible" ? 'selected' : ''}} value="Responsible">Responsible</option>
                    <option {{$row['client'] == "Accountable" ? 'selected' : ''}} value="Accountable">Accountable</option>
                    <option {{$row['client'] == "Consulted" ? 'selected' : ''}} value="Consulted">Consulted</option>
                    <option {{$row['client'] == "Informed" ? 'selected' : ''}} value="Informed">Informed</option>
                </select>
                <select class="form-control raciVendorInput" style="margin-left: 1rem" {{$disabled ? 'disabled' : ''}}>
                    <option disabled>Please choose one</option>
                    <option {{$row['vendor'] == "Responsible" ? 'selected' : ''}} value="Responsible">Responsible</option>
                    <option {{$row['vendor'] == "Accountable" ? 'selected' : ''}} value="Accountable">Accountable</option>
                    <option {{$row['vendor'] == "Consulted" ? 'selected' : ''}} value="Consulted">Consulted</option>
                    <option {{$row['vendor'] == "Informed" ? 'selected' : ''}} value="Informed">Informed</option>
                </select>
                <select class="form-control raciAccentureInput" style="margin-left: 1rem" {{$disabled ? 'disabled' : ''}}>
                    <option disabled>Please choose one</option>
                    <option {{$row['accenture'] == "Responsible" ? 'selected' : ''}} value="Responsible">Responsible</option>
                    <option {{$row['accenture'] == "Accountable" ? 'selected' : ''}} value="Accountable">Accountable</option>
                    <option {{$row['accenture'] == "Consulted" ? 'selected' : ''}} value="Consulted">Consulted</option>
                    <option {{$row['accenture'] == "Informed" ? 'selected' : ''}} value="Informed">Informed</option>
                </select>
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
                        value="">
                    <select class="form-control raciClientInput" style="margin-left: 1rem">
                        <option disabled>Please choose one</option>
                        <option value="Responsible">Responsible</option>
                        <option value="Accountable">Accountable</option>
                        <option value="Consulted">Consulted</option>
                        <option value="Informed">Informed</option>
                    </select>
                    <select class="form-control raciVendorInput" style="margin-left: 1rem">
                        <option disabled>Please choose one</option>
                        <option value="Responsible">Responsible</option>
                        <option value="Accountable">Accountable</option>
                        <option value="Consulted">Consulted</option>
                        <option value="Informed">Informed</option>
                    </select>
                    <select class="form-control raciAccentureInput" style="margin-left: 1rem">
                        <option disabled>Please choose one</option>
                        <option value="Responsible">Responsible</option>
                        <option value="Accountable">Accountable</option>
                        <option value="Consulted">Consulted</option>
                        <option value="Informed">Informed</option>
                    </select>
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
            $('.raciTitleInput, .raciClientInput, .raciVendorInput, .raciAccentureInput').change(function(){
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
