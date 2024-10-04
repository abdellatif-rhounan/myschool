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

	<div class="form-group mb-4">
		<label style="font-size: 17px">User Type:</label>

		<div class="row px-3" style="width: 100%; margin: 0 auto;">
			<div class="col-6 custom-control custom-radio">
				<input class="custom-control-input" id="user-student" name="user-type" type="radio" value="student" checked />
				<label class="custom-control-label" for="user-student">Student</label>
			</div>

			<div class="col-6 custom-control custom-radio">
				<input class="custom-control-input" id="user-tutor" name="user-type" type="radio" value="tutor" />
				<label class="custom-control-label" for="user-tutor">Tutor</label>
			</div>

			<div class="col-6 custom-control custom-radio">
				<input class="custom-control-input" id="user-teacher" name="user-type" type="radio" value="teacher" />
				<label class="custom-control-label" for="user-teacher">Teacher</label>
			</div>

			<div class="col-6 custom-control custom-radio">
				<input class="custom-control-input" id="user-frame" name="user-type" type="radio" value="frame" />
				<label class="custom-control-label" for="user-frame">Frame</label>
			</div>
		</div>
	</div>
@endsection

@section('form_submit_area')
	<div class="col-12">
		<button class="btn btn-primary btn-block" type="submit">Request new password</button>
	</div>
@endsection

@section('links')
	<a href="{{ route('login') }}">Login</a>
@endsection
