@extends('layouts.app')

@section('title', 'Add New Student')

@section('left_header')
	Add New Student
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('students.index') }}">Students List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Create Student</h3>
			</div>

			<form method="post" action="{{ route('students.store') }}">
				@csrf

				<div class="card-body">

					<div class="form-group">
						<label for="name">Name</label>

						<input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text"
							value="{{ old('name') }}" placeholder="Name" />

						@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="email">Email</label>

						<input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email"
							value="{{ old('email') }}" placeholder="Email" />

						@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="password">Password</label>

						<input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password"
							placeholder="Password" />

						@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="password_confirmation">Confirm Password</label>

						<input class="form-control @error('password') is-invalid @enderror" id="password_confirmation"
							name="password_confirmation" type="password" placeholder="Confirm Password" />
					</div>

					<div class="form-group">
						<label for="status">Status</label>

						<select class="custom-select @error('status') is-invalid @enderror" id="status" name="status">
							<option value="">-- select status --</option>
							<option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
							<option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Stopped</option>
						</select>

						@error('status')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

				</div>

				<div class="card-footer">
					<button class="btn btn-success" type="submit">Submit</button>
				</div>
			</form>

		</div>
	</div>
@endsection
