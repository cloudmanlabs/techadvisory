{{--
    Contains the filter and the filtering functions for Vendors for the Benchmark views
    --}}

@props(['applications'])

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
                            Please choose the Vendors you'd like to add in the comparison tables:
                            <br><br>
                            <select id="vendorSelect" class="w-100" multiple="multiple" required>
                                @foreach ($applications as $application)
                                <option>{{optional($application->vendor)->name}}</option>
                                @endforeach
                            </select>
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

    function filter() {
        // Get all selected practices. If there are none, get all of them
        var selectedVendors = $('#vendorSelect').select2('data').map((el) => {
            return el.text
        });
        if(selectedVendors.length == 0){
            selectedVendors = $('#vendorSelect').children().toArray().map((el) => {
                return el.innerHTML
            });
        }

        // Add a display none to the one which don't have this tags
        $('.filterByVendor').each(function () {
            const vendor = $(this).data('vendor');

            if ($.inArray(vendor, selectedVendors) !== -1) {
                $(this).css('display', '')
            } else {
                $(this).css('display', 'none')
            }
        });
    }

    $('#vendorSelect').select2();
    $('#vendorSelect').on('change', function (e) {
        filter();
    });
    filter();
})
</script>

@endsection
