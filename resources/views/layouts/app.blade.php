<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>@yield('title') - {{ config('app.name') }}</title>

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet" />

	<link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet" />
	@vite('resources/css/app.css')
	@stack('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
	<div class="wrapper">
		@include('includes.navbar')

		@include('includes.sidebar')

		@include('includes.main')

		@include('includes.footer')
	</div>

	<script src="{{ asset('plugins/jquery/jquery.min.') }}js"></script>
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('dist/js/adminlte.js') }}"></script>
</body>

</html>
