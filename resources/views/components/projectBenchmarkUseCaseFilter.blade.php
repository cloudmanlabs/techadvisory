{{--
    Contains the filter and the filtering functions for Vendors for the Benchmark views
    --}}

@props(['useCases', 'selectedUseCases'])

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="float: left;">
                    <h3>Benchmark and Analytics</h3>
                </div>
                <br><br>
                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                    <div class="media d-block d-sm-flex">
                        <div class="media-body" style="padding: 20px;">
                            Please choose Use Cases you'd like to add in the comparison tables:
                            <br><br>
                            <select id="useCaseSelect" class="w-100" multiple="multiple" required>
                                @foreach ($useCases as $useCase)
                                <option value="{{$useCase->id}}">{{optional($useCase)->name}}</option>
                                @endforeach
                            </select>
                            <div style="text-align: center;margin-top: 30px;">
                                <button id="filter-btn" class="btn btn-primary btn-lg btn-icon-text">
                                    Click to Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
@parent

<script>
$(document).ready(function (){

    // function filter() {
    //     // Get all selected practices. If there are none, get all of them
    //     var selectedVendors = $('#useCaseSelect').select2('data').map(function(el) {
    //         return el.text
    //     });
    //     if(selectedVendors.length == 0){
    //         selectedVendors = $('#useCaseSelect').children().toArray().map(function(el) {
    //             return el.innerHTML
    //         });
    //     }
    //
    //     // Add a display none to the one which don't have this tags
    //     $('.filterByVendor').each(function () {
    //         const vendor = $(this).data('vendor');
    //
    //         if ($.inArray(vendor, selectedVendors) !== -1) {
    //             $(this).css('display', '')
    //         } else {
    //             $(this).css('display', 'none')
    //         }
    //     });
    // }

    $('#useCaseSelect').select2();
    // $('#useCaseSelect').on('change', function (e) {
    //     filter();
    // });
    // filter();
    $('#filter-btn').click(function () {
        //Get all selected Use Cases.
        var selectedUseCases = $('#useCaseSelect').val();
        // $('#useCaseSelect').select2('data').map(function(el) {
        //     return parseInt(el.id, 10);
        // });

        var useCases = encodeURIComponent($('#useCaseSelect').val());

        var currentUrl = location.pathname;
        if(selectedUseCases.length > 0) {
            currentUrl += '?' + 'useCases=' + useCases;
        }
        location.replace(currentUrl);
    });

    $('#useCaseSelect').val(decodeURIComponent("{{$selectedUseCases}}").split(","))
    $('#useCaseSelect').select2().trigger('change')
})
</script>

@endsection
