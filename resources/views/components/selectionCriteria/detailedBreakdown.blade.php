@props(['vendorApplication', 'disabled', 'evaluate'])

@php
$disabled = $disabled ?? false;
@endphp

<br><br>
<h5>Detailed breakdown</h5>

<br>

<div class="form-group questionDiv">
    <label>Detailed breakdown response</label>
    <input
        {{$disabled ? 'disabled' : ''}}
        class="form-control detailedBreakdownInput"
        type="text"
        data-changing="detailedBreakdownResponse"
        value="{{$vendorApplication->detailedBreakdownResponse}}"
        placeholder="Detailed breakdown response">
</div>

<div class="form-group">
    <label>Detailed breakdown Upload*</label>
    <input id="detailedBreakdownUploadInput" class="file-upload-default" name="img[]" type="file">

    <div class="input-group col-xs-12">
        <input id="detailedBreakdownUploadNameInput" disabled class="form-control file-upload-info"
            value="{{$vendorApplication->detailedBreakdownUpload ? 'File uploaded' : 'No file selected'}}" type="text">
        <span class="input-group-append">
            <button class="file-upload-browse btn btn-primary" type="button">
                <span class="input-group-append"
                    id="detailedBreakdownUploadButton">{{$vendorApplication->detailedBreakdownUpload ? 'Replace file' : 'Select file'}}</span>
            </button>
        </span>
    </div>
</div>
<br>
<p style="font-size: 12px">
    Do not include personal, sensitive data, personal data relating to criminal convictions and offences or financial
    data
    in this free form text field or upload screen shots containing personal data, unless you are consenting and assuming
    responsibility for the processing of this personal data (either your personal data or the personal data of others)
    by
    Accenture.
</p>


@section('scripts')
@parent
<script>
    $(document).ready(function() {
        $('.detailedBreakdownInput').change(function(){
            $.post('/vendorApplication/updateNonBindingImplementation', {
                changing: $(this).data('changing'),
                application_id: {{$vendorApplication->id}},
                value: $(this).val()
            })

            showSavedToast();
        });

        $("#detailedBreakdownUploadInput").change(function (){
            var fileName = $(this).val().split('\\').pop();;

            $("#detailedBreakdownUploadNameInput").val(fileName);
            $('#detailedBreakdownUploadButton').html('Replace file')

            var formData = new FormData();
            formData.append('image', $(this).get(0).files[0]);
            formData.append('changing', 'detailedBreakdownUpload');
            $.ajax({
                url : "/vendorApplication/updateRunFile",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,
            });

            showSavedToast();
        });
    });
</script>
@endsection
