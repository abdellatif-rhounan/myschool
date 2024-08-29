@extends('layouts.app')

@section('title', 'My Classes Students Assignments')

@section('left_header')
	My Classes Students Assignments (Total: {{ $classesAssignments->total() }})
@endsection

@section('page_content')
	<div class="col-lg-12">

		<form class="mb-3" method="get">
			<div class="row align-items-center">
				<div class="col-2">
					<div class="form-group">
						<label for="class">Class</label>

						<select class="custom-select" id="class" name="class">
							<option value="">-- select class --</option>

							@foreach ($classes as $class)
								<option value="{{ $class->id }}" {{ Request::get('class') == $class->id ? 'selected' : '' }}>
									{{ $class->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-4">
					<button class="btn btn-success px-4" type="submit" style="position: relative; top: 7px;">
						Search
					</button>

					<a class="btn btn-danger px-4" href="{{ route('my-classes-students') }}" style="position: relative; top: 7px;">
						Reset
					</a>
				</div>
			</div>
		</form>

		<table class="table-striped table-hover table">

			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Class</th>
					<th scope="col">Student</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($classesAssignments as $key => $class)
					<tr>
						<th scope="row">{{ ++$key }}</th>

						<td>{{ $class->name }}</td>

						<td>
							@foreach ($class->students as $student)
								<div class="mb-1">{{ $student->name }}</div>
							@endforeach
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>

		<div class="float-right">{{ $classesAssignments->links() }}</div>

	</div>
@endsection
