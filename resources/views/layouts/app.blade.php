<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>@yield('title') | {{ config('app.name') }}</title>

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet" />

	<link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet" />
	@vite('resources/css/app.css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
	<div class="wrapper">
		@include('includes.navbar')

		@include('includes.sidebar')

		<div class="content-wrapper" style="padding: 0 7px">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-8">
							<h1 class="m-0">@yield('left_header')</h1>
						</div>

						<div class="d-flex col-sm-4 justify-content-end">
							<div class="m-0">@yield('right_header')</div>
						</div>
					</div>
				</div>
			</div>

			@include('includes.session_msg')

			<div class="content">
				<div class="container-fluid">
					<div class="row">
						@yield('page_content')
					</div>
				</div>
			</div>

		</div>

		@include('includes.footer')
	</div>

	<script src="{{ asset('plugins/jquery/jquery.min.') }}js"></script>
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('dist/js/adminlte.js') }}"></script>
</body>

</html>
