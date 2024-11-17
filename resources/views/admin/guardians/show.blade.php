@extends('admin.layouts.admin_layout')

@section('title')
	{{ $guardian->firstname }} {{ $guardian->lastname }} Profile
@endsection

@section('left_main_header')
	{{ $guardian->firstname }} {{ $guardian->lastname }} Profile
@endsection

@section('right_main_header')
	<a class="btn btn-primary" href="{{ route('guardians.index') }}">Guardians List</a>
@endsection

@section('main_content')
	<div class="col-lg-6 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">{{ $guardian->firstname }} {{ $guardian->lastname }} Profile</h3>
			</div>

			<div class="card-body">
				<div>
					<label for="firstname">Firstname :</label>
					<span class="ml-2">{{ $guardian->firstname }}</span>
				</div>

				<div>
					<label for="lastname">Lastname :</label>
					<span class="ml-2">{{ $guardian->lastname }}</span>
				</div>

				<div>
					<label for="email">Email :</label>
					<span class="ml-2">{{ $guardian->email }}</span>
				</div>

				<div>
					<label for="gender">Gender :</label>
					<span class="text-capitalize ml-2">{{ $guardian->gender }}</span>
				</div>

				<div>
					<label for="status">Status :</label>

					<span class="ml-2">
						@switch($guardian->status)
							@case(\App\Enums\UserStatus::Active->value)
								<span class="badge badge-success">{{ \App\Enums\UserStatus::Active->name }}</span>
							@break

							@case(\App\Enums\UserStatus::Stopped->value)
								<span class="badge badge-danger">{{ \App\Enums\UserStatus::Stopped->name }}</span>
							@break
						@endswitch
					</span>
				</div>

				<div>
					<label for="created_by">Created By :</label>
					<span class="ml-2">{{ $guardian->creator->firstname }} {{ $guardian->creator->lastname }}</span>
				</div>
			</div>

		</div>
	</div>
@endsection