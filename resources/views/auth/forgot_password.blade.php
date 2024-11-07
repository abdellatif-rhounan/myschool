@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('box_msg', 'You forgot your password? Here you can easily retrieve a new password.')

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
@endsection

@section('form-submit', 'Request new password')

@section('links')
	<a href="{{ route('login') }}">Login</a>
@endsection
