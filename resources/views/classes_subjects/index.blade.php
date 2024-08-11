@extends('layouts.app')

@section('title', 'Class Subjects Assignments')

@section('left_header')
	Class Subjects Assignments (Total: {{ $classesAssignments->total() }})
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('classes-subjects.create') }}">Assign Subjects To Class</a>
@endsection

@section('page_content')
	<div class="col-lg-12">

		<form class="mb-3" method="get">
			<div class="row align-items-center">
				<div class="col-2">
					<div class="form-group">
						<label for="subject">Subject</label>

						<select class="custom-select" id="subject" name="subject">
							<option value="">-- select subject --</option>

							@foreach ($subjects as $subject)
								<option value="{{ $subject->id }}" {{ Request::get('subject') == $subject->id ? 'selected' : '' }}>
									{{ $subject->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-4">
					<button class="btn btn-success px-4" type="submit" style="position: relative; top: 7px;">
						Search
					</button>

					<a class="btn btn-danger px-4" href="{{ route('classes-subjects.index') }}" style="position: relative; top: 7px;">
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
					<th scope="col">Subject</th>
					<th scope="col">Actions</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($classesAssignments as $key => $class)
					<tr>
						<th scope="row">{{ ++$key }}</th>

						<td>{{ $class->name }}</td>

						<td>
							@foreach ($class->subjects as $subject)
								<div class="mb-1">{{ $subject->name }}</div>
							@endforeach
						</td>

						<td class="d-flex" style="gap: 7px">
							<a class="btn btn-info" href="{{ route('classes-subjects.show', $class->id) }}">
								<i class="fas fa-eye"></i>
							</a>

							<a class="btn btn-warning" href="{{ route('classes-subjects.edit', $class->id) }}">
								<i class="fas fa-edit"></i>
							</a>

							<form method="post" action="{{ route('classes-subjects.destroy', $class->id) }}">
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
