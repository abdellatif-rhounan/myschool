@extends('layouts.app')

@section('title', 'Show Subject')

@section('left_header')
    Subject: {{ $subject->name }}
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('subjects.index') }}">Subject List</a>
@endsection

@section('page_content')
	<div class="mt-2">
		<h4>Name ==> {{ $subject->name }}</h4>

        <h4>Name ==> {{ $subject->type }}</h4>

		<h4>
			Status ==>
			@if ($subject->status)
				<div class="badge bg-success">Active</div>
			@else
				<div class="badge bg-danger">Stopped</div>
			@endif
		</h4>

		<h4>Created By ==> {{ $subject->user->name }}</h4>
	</div>
@endsection
