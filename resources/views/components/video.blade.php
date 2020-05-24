@props(['src', 'text'])

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h3>Welcome</h3>
                <br>

                <div class="welcome_text welcome_box">
                    <div class="media d-block d-sm-flex">
                        <div class="media-body" style="padding-top: 16px; padding-left: 20px; padding-right: 20px;">
                            {{$text ?? ''}}
                        </div>
                        <a data-target=".bd-example-modal-lg" data-thevideo="{{$src ?? ''}}"
                            data-toggle="modal" href="#"><img alt="..." class="wd-100p wd-sm-150 mb-3 mb-sm-0 ml-3"
                                src="{{url('/assets/images/video_small.jpg')}}"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog"
    tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <iframe height="450" src="" width="100%"></iframe>
        </div>
    </div>
</div>


@section('scripts')
@parent
<script>
    autoPlayYouTubeModal();

        //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG
        function autoPlayYouTubeModal() {
            var trigger = $("body").find('[data-toggle="modal"]');
            trigger.click(function () {
                var theModal = $(this).data("target"),
                    videoSRC = $(this).attr("data-theVideo"),
                    videoSRCauto = videoSRC + "?autoplay=1";
                $(theModal + ' iframe').attr('src', videoSRCauto);
                $(theModal + ' button.close').click(function () {
                    $(theModal + ' iframe').attr('src', videoSRC);
                });
            });
        }
</script>
@endsection
