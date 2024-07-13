@extends('layouts.app')

@section('title', 'Show Class')

@section('left_header')
	Class: {{ $class->name }}
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes.index') }}">Class List</a>
@endsection

@section('page_content')
	<div class="mt-2">
		<h4>Name ==> {{ $class->name }}</h4>

		<h4>
			Status ==>
			@if ($class->status)
				<div class="badge bg-success">Active</div>
			@else
				<div class="badge bg-danger">Stopped</div>
			@endif
		</h4>

		<h4>Created By ==> {{ $class->user->name }}</h4>
	</div>
@endsection
