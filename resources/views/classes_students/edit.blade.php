@extends('layouts.app')

@section('title', "Edit Class's Students")

@section('left_header')
	Edit Class's Students
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-students.index') }}">Classes Students List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Edit Class's Students</h3>
			</div>

			<form method="post" action="{{ route('classes-students.update', $class->id) }}">
				@csrf
				@method('PUT')

				<div class="card-body">

					<h2>Class: {{ $class->name }}</h2>

					<div class="form-group" style="max-height: 400px; overflow-y:auto">
						<label>Students</label>

						@foreach ($students as $student)
							<div>
								<label>
									<input name="students[]" type="checkbox" value="{{ $student->id }}"
										{{ $class->students->contains('id', $student->id) ? 'checked' : '' }} /> {{ $student->name }}
								</label>
							</div>
						@endforeach
					</div>

				</div>

				<div class="card-footer">
					<button class="btn btn-success" type="submit">Submit</button>
				</div>
			</form>

		</div>
	</div>
@endsection
