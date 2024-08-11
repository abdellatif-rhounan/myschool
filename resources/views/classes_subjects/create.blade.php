@extends('layouts.app')

@section('title', 'Assign Subjects To Class')

@section('left_header')
	Assign Subjects To Class
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-subjects.index') }}">Classes Subject List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Assign Subjects To Class</h3>
			</div>

			<form method="post" action="{{ route('classes-subjects.store') }}">
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
						<label>Subjects</label>

						@foreach ($subjects as $subject)
							<div>
								<label>
									<input name="subjects[]" type="checkbox" value="{{ $subject->id }}" /> {{ $subject->name }}
								</label>
							</div>
						@endforeach

						@error('subjects')
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
