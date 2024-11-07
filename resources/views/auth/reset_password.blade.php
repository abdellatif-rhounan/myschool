@extends('layouts.auth')

@section('title', 'Reset Password')

@section('box_msg', 'You are only one step a way from your new password, recover your password now.')

@section('input_groups')
	<input name="token" type="hidden" value="{{ $token }}" />

	<div class="input-group mb-3">
		<input class="form-control" name="email" type="email" value="{{ Request::get('email') }}" readonly />

		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-envelope"></span>
			</div>
		</div>
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

	<div class="input-group mb-3">
		<input class="form-control @error('password') is-invalid @enderror" name="password_confirmation" type="password"
			placeholder="Confirm Password" />

		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-lock"></span>
			</div>
		</div>
	</div>
@endsection

@section('form-submit', 'Change password')

@section('links')
	<a href="{{ route('login') }}">Login</a>
@endsection
