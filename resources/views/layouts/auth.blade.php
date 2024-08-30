<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>@yield('title') | {{ config('app.name') }}</title>

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet" />

	<link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet" />
	@vite('resources/css/app.css')
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="card card-outline card-primary">

			<div class="card-header text-center">
				<a class="h1" href="{{ route('root') }}">
					<b>{{ config('app.name') }}</b>
				</a>
			</div>

			<div class="card-body">
				@include('includes.session_msg')

				<p class="login-box-msg">@yield('box_msg')</p>

				<form method="post">
					@csrf
					@yield('form_method_hidden_field')

					@yield('input_groups')

					<div class="row">
						@yield('form_submit_area')
					</div>
				</form>

				<p class="mb-1 mt-3">
					@yield('links')
				</p>
			</div>
		</div>
	</div>

	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>

</html>
