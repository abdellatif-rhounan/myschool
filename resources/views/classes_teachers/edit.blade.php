@extends('layouts.app')

@section('title', "Edit Class's Teachers")

@section('left_header')
	Edit Class's Teachers
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-teachers.index') }}">Classes Teacher List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Edit Class's Teachers</h3>
			</div>

			<form method="post" action="{{ route('classes-teachers.update', $class->id) }}">
				@csrf
				@method('PUT')

				<div class="card-body">

					<h2>Class: {{ $class->name }}</h2>

					<div class="form-group" style="max-height: 400px; overflow-y:auto">
						<label>Teachers</label>

						@foreach ($teachers as $teacher)
							<div>
								<label>
									<input name="teachers[]" type="checkbox" value="{{ $teacher->id }}"
										{{ $class->teachers->contains('id', $teacher->id) ? 'checked' : '' }} /> {{ $teacher->name }}
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
