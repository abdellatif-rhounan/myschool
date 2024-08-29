@extends('layouts.app')

@section('title', 'Class Students Assignments')

@section('left_header')
	Class Students Assignments (Total: {{ $classesAssignments->total() }})
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-students.create') }}">Assign Students To Class</a>
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

					<a class="btn btn-danger px-4" href="{{ route('classes-students.index') }}" style="position: relative; top: 7px;">
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
					<th scope="col">Actions</th>
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

						<td class="d-flex" style="gap: 7px">
							<a class="btn btn-info" href="{{ route('classes-students.show', $class->id) }}">
								<i class="fas fa-eye"></i>
							</a>

							<a class="btn btn-warning" href="{{ route('classes-students.edit', $class->id) }}">
								<i class="fas fa-edit"></i>
							</a>

							<form method="post" action="{{ route('classes-students.destroy', $class->id) }}">
								@method('delete')
								@csrf

								<button class="btn btn-danger" type="submit">
									<i class="fas fa-trash"></i>
								</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>

		<div class="float-right">{{ $classesAssignments->links() }}</div>

	</div>
@endsection
