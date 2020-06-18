{{--
    Shows preview images for files in a folder that can be previewed
    --}}

@props(['folder'])

@php
    $files = Storage::disk('public')->files('previewImages/' . $folder->name);
@endphp

<div class="form-group">
    <div style="display: flex; flex-wrap: wrap">
        <div class="row" style="margin: 1rem">
            <div class="card" style="width: 300px;">
                <img src="/images/conclusions.jpg" class="card-img-top card-shadow" />
                <div class="card-body">
                    <div style="text-align: center; margin-top: 5px;">
                        <a href="#" target="_blank" class="btn btn-primary">View / Download</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin: 1rem">
            <div class="card" style="width: 300px;">
                <img src="/images/outcomes.jpg" class="card-img-top card-shadow" />
                <div class="card-body">
                    <div style="text-align: center; margin-top: 5px;">
                        <a href="#" target="_blank" class="btn btn-primary">View / Download</a>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($files as $file)
        @php
            $actualFile = preg_replace('/previewImages/', 'folders', $file);
            $actualFile = preg_replace('/\.jpg/', '', $actualFile);
        @endphp
        <div class="row" style="margin: 1rem">
            <div class="card" style="width: 300px;">
                <img src="/storage/{{$file}}" class="card-img-top card-shadow" />
                <div class="card-body">
                    <div style="text-align: center; margin-top: 5px;">
                        <a href="/storage/{{$actualFile}}" target="_blank" class="btn btn-primary">View / Download</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
