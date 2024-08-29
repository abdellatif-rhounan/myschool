@extends('layouts.app')

@section('title', "Class's Students")

@section('left_header')
	Class's Students
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-students.index') }}">Classes Student List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Class's Students</h3>
			</div>

			<h4>{{ $class->name }}</h4>

			@foreach ($class->students as $student)
				<h5>{{ $student->name }}</h5>
			@endforeach

		</div>
	</div>
@endsection
