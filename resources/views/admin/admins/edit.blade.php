@extends('admin.layouts.admin_layout')

@section('title', 'Edit Admin')

@section('left_main_header', 'Edit Admin')

@section('right_main_header')
	<a class="btn btn-primary" href="{{ route('admins.index') }}">Admins List</a>
@endsection

@section('main_content')
	<div class="col-lg-8 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Edit Admin</h3>
			</div>

			<form method="post" action="{{ route('admins.update', $admin->id) }}">
				@csrf
				@method('PUT')

				<div class="card-body">

					<div class="row">
						<div class="form-group col">
							<label for="firstname">Firstname</label>

							<input class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" type="text"
								value="{{ old('firstname', $admin->firstname) }}" placeholder="Firstname" />

							@error('firstname')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group col">
							<label for="lastname">Lastname</label>

							<input class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" type="text"
								value="{{ old('lastname', $admin->lastname) }}" placeholder="Lastname" />

							@error('lastname')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="form-group">
						<label for="email">Email</label>

						<input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email"
							value="{{ old('email', $admin->email) }}" placeholder="Email" />

						@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="row">
						<div class="form-group col">
							<label for="password">Password</label>

							<input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password"
								placeholder="Password" />

							@error('password')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group col">
							<label for="password_confirmation">Confirm Password</label>

							<input class="form-control @error('password') is-invalid @enderror" id="password_confirmation"
								name="password_confirmation" type="password" placeholder="Confirm Password" />
						</div>
					</div>

					<div class="row">
						<div class="form-group col">
							<label for="gender">Gender</label>

							<select class="custom-select @error('gender') is-invalid @enderror" id="gender" name="gender">
								<option value="">-- select gender --</option>
								@foreach (\App\Enums\Gender::cases() as $gender)
									<option value="{{ $gender->value }}" {{ old('gender', $admin->gender) == $gender->value ? 'selected' : '' }}>
										{{ ucfirst($gender->value) }}
									</option>
								@endforeach
							</select>

							@error('gender')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group col">
							<label for="status">Status</label>

							<select class="custom-select @error('status') is-invalid @enderror" id="status" name="status">
								<option value="">-- select status --</option>
								@foreach (\App\Enums\UserStatus::cases() as $status)
									<option value="{{ $status->value }}" {{ old('status', $admin->status) == $status->value ? 'selected' : '' }}>
										{{ ucfirst(strtolower($status->name)) }}
									</option>
								@endforeach
							</select>

							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

				</div>

				<div class="card-footer">
					<button class="btn btn-success" type="submit">Submit</button>
				</div>
			</form>

		</div>
	</div>
@endsection
