@extends('admin.layouts.admin_layout')

@section('title')
	{{ $admin->firstname }} {{ $admin->lastname }} Profile
@endsection

@section('left_main_header')
	{{ $admin->firstname }} {{ $admin->lastname }} Profile
@endsection

@section('right_main_header')
	<a class="btn btn-primary" href="{{ route('admins.index') }}">Admins List</a>
@endsection

@section('main_content')
	<div class="col-lg-6 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">{{ $admin->firstname }} {{ $admin->lastname }} Profile</h3>
			</div>

			<div class="card-body">
				<div>
					<label for="firstname">Firstname :</label>
					<span class="ml-2">{{ $admin->firstname }}</span>
				</div>

				<div>
					<label for="lastname">Lastname :</label>
					<span class="ml-2">{{ $admin->lastname }}</span>
				</div>

				<div>
					<label for="email">Email :</label>
					<span class="ml-2">{{ $admin->email }}</span>
				</div>

				<div>
					<label for="gender">Gender :</label>
					<span class="text-capitalize ml-2">{{ $admin->gender }}</span>
				</div>

				<div>
					<label for="status">Status :</label>

					<span class="ml-2">
						@switch($admin->status)
							@case(\App\Enums\UserStatus::ACTIVE->value)
								<span class="badge badge-success">{{ \App\Enums\UserStatus::ACTIVE->name }}</span>
							@break

							@case(\App\Enums\UserStatus::VACATION->value)
								<span class="badge badge-primary">{{ \App\Enums\UserStatus::VACATION->name }}</span>
							@break

							@case(\App\Enums\UserStatus::STOPPED->value)
								<span class="badge badge-danger">{{ \App\Enums\UserStatus::STOPPED->name }}</span>
							@break
						@endswitch
					</span>
				</div>

				<div>
					<label for="created_by">Created By :</label>
					<span class="ml-2">{{ $admin->creator->firstname }} {{ $admin->creator->lastname }}</span>
				</div>
			</div>

		</div>
	</div>
@endsection
