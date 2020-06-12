{{--
    Button that opens a modal to send an email to a vendor
    --}}

@props(['vendor', 'project'])

<a class="btn btn-primary btn-lg btn-icon-text" href="#" data-toggle="modal" data-target="#resend_invite_modal-{{$vendor->id}}">
    Resend invite
    <i class="btn-icon-prepend" data-feather="mail"></i>
</a>

<div
    class="modal fade"
    id="resend_invite_modal-{{$vendor->id}}"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
                    Resend invitation to {{$vendor->name}}
                </h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>

			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="message-text" class="col-form-label" style="align-items: start;display: flex;flex-direction: column;">Message:</label>
                        <textarea class="form-control" id="message-text-{{$vendor->id}}" style="min-height: 400px;"
                        >Dear {{$vendor->name}}, &#10;&#10;We would like to invite dolor sit amet, consectetur adipiscing elit. Etiam in eros libero. &#10;&#10;Curabitur quis ipsum in purus imperdiet dictum. Vivamus at varius sapien. Aenean et bibendum diam, in condimentum erat. Duis sed odio quis nulla venenatis cursus et eu sapien. &#10;&#10;Phasellus hendrerit pharetra turpis. Aliquam lobortis scelerisque dui, at accumsan nunc vehicula laoreet. Proin auctor, nisi emollis ipsum at this link:&#10;&#10;{{route('vendor.home')}}&#10;&#10;Thank you,&#10;Accenture Team</textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" onclick="sendEmail{{$vendor->id}}()" class="btn btn-primary" data-dismiss="modal" id="resendButton-{{$vendor->id}}">Resend invitation</button>
			</div>
		</div>
	</div>
</div>

@section('scripts')
@parent

<script>
    function sendEmail{{$vendor->id}}(){
        const text = document.getElementById("message-text-{{$vendor->id}}").value;
        console.log(text)
        $.post('/accenture/project/resendInvitation/', {
            vendor_id: {{$vendor->id}},
            project_id: {{$project->id}},
            text
        })

        $.toast({
            heading: 'Email sent!',
            showHideTransition: 'slide',
            icon: 'success',
            hideAfter: 1000,
            position: 'bottom-right'
        })
    }
</script>

@endsection
