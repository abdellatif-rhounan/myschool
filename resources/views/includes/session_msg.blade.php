@if (session('success'))
	<div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="margin: 0 15px">
		<strong>Success!</strong> {{ session('success') }}

		<button class="close" data-dismiss="alert" type="button" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif

@if (session('error'))
	<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="margin: 0 15px">
		<strong>Error!</strong> {{ session('error') }}

		<button class="close" data-dismiss="alert" type="button" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif
