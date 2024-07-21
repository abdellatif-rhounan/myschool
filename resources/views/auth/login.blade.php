@extends('layouts.auth')

@section('title', 'Login')

@section('box_msg', 'Sign in to start your session')

@section('input_groups')
	<div class="input-group mb-3">
		<input class="form-control @error('email') is-invalid @enderror" name="email" type="email" value="{{ old('email') }}"
			placeholder="Email" />

		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-envelope"></span>
			</div>
		</div>

		@error('email')
			<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>

	<div class="input-group mb-3">
		<input class="form-control @error('password') is-invalid @enderror" name="password" type="password"
			placeholder="Password" />

		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-lock"></span>
			</div>
		</div>

		@error('password')
			<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
@endsection

@section('form_submit_area')
	<div class="col-8">
		<div class="icheck-primary">
			<input id="remember" name="remember" type="checkbox" />

			<label for="remember">Remember Me</label>
		</div>
	</div>

	<div class="col-4">
		<button class="btn btn-primary btn-block" type="submit">Sign In</button>
	</div>
@endsection

@section('links')
	<a href="{{ route('forgotPassword') }}">I forgot my password</a>
@endsection
