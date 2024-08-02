@extends('layouts.app')

@section('title', 'Class Subjects Assignments')

@section('left_header')
	Class Subjects Assignments
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

				<div class="col-2">
					<div class="form-group">
						<label for="status">Assignment Status</label>

						<select class="custom-select" id="status" name="status">
							<option value="">-- select status --</option>
							<option value="1" {{ Request::get('status') == '1' ? 'selected' : '' }}>Active</option>
							<option value="0" {{ Request::get('status') == '0' ? 'selected' : '' }}>Stopped</option>
						</select>
					</div>
				</div>

				<div class="col-2">
					<div class="form-group">
						<label for="created_by">Assignment Created By</label>

						<select class="custom-select" id="created_by" name="created_by">
							<option value="">-- created by --</option>

							@php
								$temp = [];
							@endphp

							@foreach ($classes as $class)
								@foreach ($class->subjects as $subject)
									@unless (in_array($subject->pivot->created_by, $temp))
										<option value="{{ $subject->pivot->created_by }}">{{ $subject->pivot->created_by }}</option>

										@php
											array_push($temp, $subject->pivot->created_by);
										@endphp
									@endunless
								@endforeach
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
					<th scope="col">Status</th>
					<th scope="col">Created By</th>
					<th scope="col">Actions</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($classes as $key => $class)
					<tr>
						<th scope="row">{{ ++$key }}</th>

						<td>{{ $class->name }}</td>

						<td>
							@foreach ($class->subjects as $subject)
								<div class="mb-1">{{ $subject->name }}</div>
							@endforeach
						</td>

						<td>
							@foreach ($class->subjects as $subject)
								@if ($subject->pivot->status)
									<span class="badge badge-success d-block my-2" style="width: fit-content">Active</span>
								@else
									<span class="badge badge-danger d-block my-2" style="width: fit-content">Stopped</span>
								@endif
							@endforeach
						</td>

						<td>
							@foreach ($class->subjects as $subject)
								<div>{{ $subject->pivot->created_by }}</div>
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

	</div>
@endsection
