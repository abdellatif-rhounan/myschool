@extends('layouts.auth')

@section('title', 'Login')

@push('css')
	<link href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet" />
@endpush

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

@section('form-check-submit', 'Sign In')

@section('links')
	<a href="{{ route('password.request') }}">I forgot my password</a>
@endsection
