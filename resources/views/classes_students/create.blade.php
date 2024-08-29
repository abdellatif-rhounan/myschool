@extends('layouts.app')

@section('title', 'Assign Students To Class')

@section('left_header')
	Assign Students To Class
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-students.index') }}">Classes Students List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Assign Students To Class</h3>
			</div>

			<form method="post" action="{{ route('classes-students.store') }}">
				@csrf

				<div class="card-body">

					<div class="form-group">
						<label for="class">Class</label>

						<select class="custom-select @error('class') is-invalid @enderror" id="class" name="class">
							<option value="">-- select class --</option>

							@foreach ($classes as $class)
								<option value="{{ $class->id }}" {{ old('class') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
							@endforeach
						</select>

						@error('class')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group" style="max-height: 400px; overflow-y:auto">
						<label>Students</label>

						@foreach ($students as $student)
							<div>
								<label>
									<input name="students[]" type="checkbox" value="{{ $student->id }}" /> {{ $student->name }}
								</label>
							</div>
						@endforeach

						@error('students')
							<div class="invalid-feedback" style="display: block">{{ $message }}</div>
						@enderror
					</div>

				</div>

				<div class="card-footer">
					<button class="btn btn-success" type="submit">Submit</button>
				</div>
			</form>

		</div>
	</div>
@endsection
