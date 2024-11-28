@extends('admin.layouts.admin_layout')

@php
	use App\Enums\UserStatus;
@endphp

@section('title')
	{{ $user->firstname }} {{ $user->lastname }} Profile
@endsection

@section('left_main_header')
	{{ $user->firstname }} {{ $user->lastname }} Profile
@endsection

@section('right_main_header')
	<a class="btn btn-primary" href="{{ route('admins.index') }}">Admins List</a>
@endsection

@section('main_content')
	<div class="col-lg-6 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">{{ $user->firstname }} {{ $user->lastname }} Profile</h3>
			</div>

			<div class="card-body">
				<div>
					<label for="firstname">Firstname :</label>
					<span class="ml-2">{{ $user->firstname }}</span>
				</div>

				<div>
					<label for="lastname">Lastname :</label>
					<span class="ml-2">{{ $user->lastname }}</span>
				</div>

				<div>
					<label for="email">Email :</label>
					<span class="ml-2">{{ $user->email }}</span>
				</div>

				<div>
					<label for="gender">Gender :</label>
					<span class="text-capitalize ml-2">{{ $user->gender }}</span>
				</div>

				<div>
					<label for="status">Status :</label>

					<span class="ml-2">
						@switch($user->status)
							@case(UserStatus::ACTIVE->value)
								<span class="badge badge-success">Active</span>
							@break

							@case(UserStatus::VACATION->value)
								<span class="badge badge-primary">Vacation</span>
							@break

							@case(UserStatus::STOPPED->value)
								<span class="badge badge-danger">Stopped</span>
							@break
						@endswitch
					</span>
				</div>

				<div>
					<label for="created_by">Created By :</label>
					<span class="ml-2">{{ $user->creator->firstname }} {{ $user->creator->lastname }}</span>
				</div>
			</div>

		</div>
	</div>
@endsection
