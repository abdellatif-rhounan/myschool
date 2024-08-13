@extends('layouts.app')

@section('title', "Class's Students")

@section('left_header')
	{{ $class->name }}'s Students (Total : {{ count($class_students) }})
@endsection

@section('page_content')
	<div class="col-lg-12">

		<div class="card card-light">
			<div class="card-header">
				<h3 class="card-title">Search Student</h3>
			</div>

			<form method="get">
				<div class="card-body row align-items-center">

					<div class="col-2">
						<div class="form-group">
							<label for="name">Name</label>

							<input class="form-control" id="name" name="name" type="text" value="{{ Request::get('name') }}"
								placeholder="Name" />
						</div>
					</div>

					<div class="col-2">
						<div class="form-group">
							<label for="email">Email</label>

							<input class="form-control" id="email" name="email" type="text" value="{{ Request::get('email') }}"
								placeholder="Email" />
						</div>
					</div>

					<div class="col-4">
						<button class="btn btn-success px-4" type="submit" style="position: relative; top: 7px;">
							Search
						</button>

						<a class="btn btn-danger px-4" href="{{ route('classes.students', $class->id) }}" style="position: relative; top: 7px;">
							Reset
						</a>
					</div>
				</div>
			</form>
		</div>

		@if ($student_result)
			<div class="card card-light">
				<div class="card-header">
					<h3 class="card-title">Student Result</h3>
				</div>

				<div class="card-body" style="max-height: 300px; overflow-y:auto">
					<table class="table-striped table-hover table">

						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Status</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>

						<tbody>
							@foreach ($student_result as $key => $student)
								<tr>
									<th scope="row">{{ ++$key }}</th>

									<td>{{ $student->name }}</td>

									<td>{{ $student->email }}</td>

									<td>
										@if ($student->status)
											<span class="badge badge-success">Active</span>
										@else
											<span class="badge badge-danger">Stopped</span>
										@endif
									</td>

									<td class="d-flex" style="gap: 7px">
										<form method="post" action="{{ route('classes.assignStudent', [$class->id, $student->id]) }}">
											@csrf

											<button class="btn btn-primary" type="submit">
												<i class="fas fa-plus"></i>
											</button>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>

					</table>
				</div>
			</div>
		@endif

		<div class="card card-light">
			<div class="card-header">
				<h3 class="card-title">Class's Students</h3>
			</div>

			<div class="card-body">
				<table class="table-striped table-hover table">

					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Status</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($class_students as $key => $student)
							<tr>
								<th scope="row">{{ ++$key }}</th>

								<td>{{ $student->name }}</td>

								<td>{{ $student->email }}</td>

								<td>
									@if ($student->status)
										<span class="badge badge-success">Active</span>
									@else
										<span class="badge badge-danger">Stopped</span>
									@endif
								</td>

								<td class="d-flex" style="gap: 7px">
									<form method="post" action="{{ route('classes.removeStudent', $student->id) }}">
										@method('delete')
										@csrf

										<button class="btn btn-danger" type="submit">
											<i class="fas fa-minus"></i>
										</button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>

				</table>
			</div>
		</div>
	</div>
@endsection
