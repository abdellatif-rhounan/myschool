<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>@yield('title') - {{ config('app.name') }}</title>

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet" />

	<link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
	@stack('css')
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

					@yield('input_groups')

					<div class="row">
						@hasSection('form-check-submit')
							<div class="col-8">
								<div class="icheck-primary">
									<input id="remember" name="remember" type="checkbox" />

									<label for="remember">Remember Me</label>
								</div>
							</div>

							<div class="col-4">
								<button class="btn btn-primary btn-block" type="submit">@yield('form-check-submit')</button>
							</div>
						@endif

						@sectionMissing('form-check-submit')
							<div class="col-12">
								<button class="btn btn-primary btn-block" type="submit">@yield('form-submit')</button>
							</div>
						@endif
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
