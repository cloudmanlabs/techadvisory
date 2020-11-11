@props(['vendorApplication', 'disabled', 'evaluate'])

@php
$disabled = $disabled ?? false;
@endphp

<br>
<h5>Pricing model</h5>
<p>
    {{nova_get_setting('pricing_model') ?? ''}}
</p>

<br>

<div class="form-group questionDiv" data-practice="">
    <label>Pricing Model Response</label>
    <textarea
        {{$disabled ? 'disabled' : ''}}
        class="form-control pricingModelInput"
        rows="10"
        data-changing="pricingModelResponse"
        placeholder="Pricing model response">
        {{$vendorApplication->pricingModelResponse}}
    </textarea>
</div>

<div class="form-group">
    <label>Pricing model Upload</label>
    <input id="pricingModelUploadInput" class="file-upload-default" name="img[]" type="file"
        {{$disabled ? 'disabled' : ''}}
    >

    <div class="input-group col-xs-12">
        <input id="pricingModelUploadNameInput" disabled class="form-control file-upload-info"
            value="{{$vendorApplication->pricingModelUpload ? 'File uploaded' : 'No file selected'}}" type="text">

        @if (!$disabled)
            <span class="input-group-append">
                <button id="pricingModelUploadButtonButton" class="file-upload-browse btn btn-primary" type="button">
                    <span class="input-group-append"
                        id="pricingModelUploadButton">{{$vendorApplication->pricingModelUpload ? 'Replace file' : 'Select file'}}</span>
                </button>
            </span>
        @endif
        @if ($vendorApplication->pricingModelUpload)
            <span class="input-group-append">
                <a class="btn btn-primary" href="/storage/{{$vendorApplication->pricingModelUpload}}">
                    <span class="input-group-append">Download</span>
                </a>
            </span>
        @endif
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
        $('.pricingModelInput').change(function(){
            $.post('/vendorApplication/updateNonBindingImplementation', {
                changing: $(this).data('changing'),
                application_id: {{$vendorApplication->id}},
                value: $(this).val()
            })

            showSavedToast();
        });

        $('#pricingModelUploadButtonButton').on('click', function(e) {
            $("#pricingModelUploadInput").trigger('click');
        });

        $("#pricingModelUploadInput").change(function (){
            var fileName = $(this).val().split('\\').pop();;

            $("#pricingModelUploadNameInput").val(fileName);
            $('#pricingModelUploadButton').html('Replace file')

            var formData = new FormData();
            formData.append('image', $(this).get(0).files[0]);
            formData.append('changing', 'pricingModelUpload');
            formData.append('application_id', '{{$vendorApplication->id}}');
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
