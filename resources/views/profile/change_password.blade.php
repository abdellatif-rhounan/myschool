@extends('layouts.app')

@section('title', 'Change Password')

@section('left_header')
	Change Password
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Change Password</h3>
			</div>

			<form method="post">
				@csrf

				<div class="card-body">

					<div class="form-group">
						<label for="old-password">Old Password</label>

						<input class="form-control @error('old-password') is-invalid @enderror" id="old-password" name="old-password"
							type="password" placeholder="Old Password" />

						@error('old-password')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="new-password">New Password</label>

						<input class="form-control @error('password') is-invalid @enderror" id="new-password" name="password" type="password"
							placeholder="New Password" />

						@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="confirm-password">Confirm Password</label>

						<input class="form-control @error('password') is-invalid @enderror" id="confirm-password" name="password_confirmation"
							type="password" placeholder="Confirm Password" />
					</div>

				</div>

				<div class="card-footer">
					<button class="btn btn-success" type="submit">Submit</button>
				</div>
			</form>

		</div>
	</div>
@endsection
