@extends('layouts.app')

@section('title', 'My Classes Subjects Assignments')

@section('left_header')
	My Classes Subjects Assignments (Total: {{ $classesAssignments->total() }})
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

					<a class="btn btn-danger px-4" href="{{ route('my-classes-subjects') }}" style="position: relative; top: 7px;">
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
					</tr>
				@endforeach
			</tbody>

		</table>

		<div class="float-right">{{ $classesAssignments->links() }}</div>

	</div>
@endsection
