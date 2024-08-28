@extends('layouts.app')

@section('title', "Class's Teachers")

@section('left_header')
	Class's Teachers
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-teachers.index') }}">Classes Teacher List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Class's Teachers</h3>
			</div>

			<h4>{{ $class->name }}</h4>

			@foreach ($class->teachers as $teacher)
				<h5>{{ $teacher->name }}</h5>
			@endforeach

		</div>
	</div>
@endsection
