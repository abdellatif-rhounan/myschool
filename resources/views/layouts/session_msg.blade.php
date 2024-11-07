@hasSection('alert-type')
	<div class="alert alert-@yield('alert-type') alert-dismissible fade show mb-3" role="alert" style="margin: 0 15px">
		<strong>@yield('alert-title')!</strong> @yield('message')

		<button class="close" data-dismiss="alert" type="button" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif
