@extends('layouts.app')

@section('title', 'My Profile')

@section('left_header')
	My Profile
@endsection

@section('right_header')
	<a class="btn btn-warning" href="{{ route('profile-edit') }}">
		Edit Profile
		<i class="fas fa-pen ml-2"></i>
	</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">My Profile</h3>
			</div>

			<div>
				<div class="card-body">

					<h4>Name: {{ $user->name }}</h4>

					<h4>Email: {{ $user->email }}</h4>

					<h4>
						Status:
						@if ($user->status)
							<span class="badge badge-success">Active</span>
						@else
							<span class="badge badge-danger">Stopped</span>
						@endif
					</h4>

				</div>
			</div>

		</div>
	</div>
@endsection
