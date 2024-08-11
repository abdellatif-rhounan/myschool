@extends('layouts.app')

@section('title', "Edit Class's Subjects")

@section('left_header')
	Edit Class's Subjects
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-subjects.index') }}">Classes Subject List</a>
@endsection

@section('page_content')
	<div class="col-lg-4 mx-auto mt-2">
		<div class="card card-success">

			<div class="card-header">
				<h3 class="card-title">Edit Class's Subjects</h3>
			</div>

			<form method="post" action="{{ route('classes-subjects.update', $class->id) }}">
				@csrf
				@method('PUT')

				<div class="card-body">

					<h2>Class: {{ $class->name }}</h2>

					<div class="form-group" style="max-height: 400px; overflow-y:auto">
						<label>Subjects</label>

						@foreach ($subjects as $subject)
							<div>
								<label>
									<input name="subjects[]" type="checkbox" value="{{ $subject->id }}"
										{{ $class->subjects->contains('id', $subject->id) ? 'checked' : '' }} /> {{ $subject->name }}
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
