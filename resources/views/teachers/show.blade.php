@extends('layouts.app')

@section('title', 'Show Teacher')

@section('left_header')
	Teacher: {{ $user->name }}
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('teachers.index') }}">Teachers List</a>
@endsection

@section('page_content')
	<div class="mt-2">
		<h4>Name ==> {{ $user->name }}</h4>

		<h4>Email ==> {{ $user->email }}</h4>

		<h4>
			Status ==>
			@if ($user->status)
				<div class="badge bg-success">Active</div>
			@else
				<div class="badge bg-danger">Stopped</div>
			@endif
		</h4>

		<h4>Created By ==> {{ $user->creator->name }}</h4>
	</div>
@endsection
