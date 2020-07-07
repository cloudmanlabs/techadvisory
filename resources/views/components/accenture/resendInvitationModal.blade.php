{{--
    Button that opens a modal to send an email to a vendor
    --}}

@props(['vendor', 'project'])

<a class="btn btn-primary btn-lg btn-icon-text" href="#" data-toggle="modal"
	data-target="#resend_invite_modal-{{$vendor->id}}">
	Resend invite
	<i class="btn-icon-prepend" data-feather="mail"></i>
</a>

<div class="modal fade" id="resend_invite_modal-{{$vendor->id}}" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<label class="col-form-label"
							style="align-items: start;display: flex;flex-direction: column;">Email:</label>
						<select class="form-control" id="message-email-{{$vendor->id}}">
							@foreach ($vendor->credentials as $credential)
							<option value="{{$credential->email}}">{{$credential->name}} - {{$credential->email}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="message-text" class="col-form-label"
							style="align-items: start;display: flex;flex-direction: column;">Message:</label>
						<textarea class="form-control" id="message-text-{{$vendor->id}}"
                            style="min-height: 400px;">Dear {{$vendor->name}}, &#10;&#10;There is a project invitation waiting for your approval in the Tech Advisory Platform.&#10;&#10;Kindly connect to the platform, review the project details and approve or reject the invitation.&#10;&#10;{{route('vendor.home')}}&#10;&#10;Thank you,&#10;&#10;Accenture Team&#10;&#10;</textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" onclick="sendEmail{{$vendor->id}}()" class="btn btn-primary" data-dismiss="modal"
					id="resendButton-{{$vendor->id}}">Resend invitation</button>
			</div>
		</div>
	</div>
</div>

@section('scripts')
@parent

<script>
	function sendEmail{{$vendor->id}}(){
        const text = document.getElementById("message-text-{{$vendor->id}}").value;
        const email = document.getElementById("message-email-{{$vendor->id}}").value;
        $.post('/accenture/project/resendInvitation/', {
            vendor_id: {{$vendor->id}},
            project_id: {{$project->id}},
            text,
            email
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
