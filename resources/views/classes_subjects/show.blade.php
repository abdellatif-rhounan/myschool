@extends('layouts.app')

@section('title', "Class's Subjects")

@section('left_header')
	Class's Subjects
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-subjects.index') }}">Classes Subject List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Class's Subjects</h3>
			</div>

			<h4>{{ $class->name }}</h4>

			@foreach ($class->subjects as $subject)
				<h5>{{ $subject->name }}</h5>
			@endforeach

		</div>
	</div>
@endsection
