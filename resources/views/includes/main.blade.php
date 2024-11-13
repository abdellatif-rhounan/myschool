<div class="content-wrapper" style="padding: 0 7px">

	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">

				@hasSection('right_main_header')
					<div class="col-sm-8">
						<h1 class="m-0">@yield('left_main_header')</h1>
					</div>

					<div class="d-flex col-sm-4 justify-content-end">
						<div class="m-0">@yield('right_main_header')</div>
					</div>
				@endif

				@sectionMissing('right_main_header')
					<div class="col-sm-12">
						<h1 class="m-0">@yield('left_main_header')</h1>
					</div>
				@endif

			</div>
		</div>
	</div>

	@include('includes.session_msg')

	<div class="content">
		<div class="container-fluid">
			<div class="row">
				@yield('main_content')
			</div>
		</div>
	</div>

</div>
