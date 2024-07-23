@extends('layouts.app')

@section('title', 'Subject List')

@section('left_header')
	Subject List (Total: {{ $subjects->total() }})
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('subjects.create') }}">Add New Subject</a>
@endsection

@section('page_content')
	<div class="col-lg-12">

		<form class="mb-3" method="get">
			<div class="row align-items-center">

				<div class="col-2">
					<div class="form-group">
						<label for="name">Name</label>

						<input class="form-control" id="name" name="name" type="text" value="{{ Request::get('name') }}"
							placeholder="Subject Name" />
					</div>
				</div>

				<div class="col-2">
					<div class="form-group">
						<label for="type">Type</label>

						<select class="custom-select" id="type" name="type">
							<option value="">-- select type --</option>
							<option value="Theory" {{ Request::get('type') == 'Theory' ? 'selected' : '' }}>Theory</option>
							<option value="Practical" {{ Request::get('type') == 'Practical' ? 'selected' : '' }}>Practical</option>
						</select>
					</div>
				</div>

				<div class="col-2">
					<div class="form-group">
						<label for="status">Status</label>

						<select class="custom-select" id="status" name="status">
							<option value="">-- select status --</option>
							<option value="1" {{ Request::get('status') == '1' ? 'selected' : '' }}>Active</option>
							<option value="0" {{ Request::get('status') == '0' ? 'selected' : '' }}>Stopped</option>
						</select>
					</div>
				</div>

				<div class="col-2">
					<div class="form-group">
						<label for="created_by">Created By</label>

						<select class="custom-select" id="created_by" name="created_by">
							<option value="">-- created by --</option>

							@foreach ($admins as $admin)
								<option value="{{ $admin->id }}" {{ Request::get('created_by') == $admin->id ? 'selected' : '' }}>
									{{ $admin->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-4">
					<button class="btn btn-success px-4" type="submit" style="position: relative; top: 7px;">
						Search
					</button>

					<a class="btn btn-danger px-4" href="{{ route('subjects.index') }}" style="position: relative; top: 7px;">
						Reset
					</a>
				</div>
			</div>
		</form>

		<table class="table-striped table-hover table">

			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Name</th>
					<th scope="col">Type</th>
					<th scope="col">Status</th>
					<th scope="col">Created_by</th>
					<th scope="col">Actions</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($subjects as $key => $subject)
					<tr>
						<th scope="row">{{ ++$key }}</th>

						<td>{{ $subject->name }}</td>

						<td>{{ $subject->type }}</td>

						<td>
							@if ($subject->status)
								<span class="badge badge-success">Active</span>
							@else
								<span class="badge badge-danger">Stopped</span>
							@endif
						</td>

						<td>{{ $subject->created_by_user }}</td>

						<td class="d-flex" style="gap: 7px">
							<a class="btn btn-info" href="{{ route('subjects.show', $subject->id) }}">
								<i class="fas fa-eye"></i>
							</a>

							<a class="btn btn-warning" href="{{ route('subjects.edit', $subject->id) }}">
								<i class="fas fa-edit"></i>
							</a>

							<form method="post" action="{{ route('subjects.destroy', $subject->id) }}">
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

		<div class="float-right">{{ $subjects->links() }}</div>

	</div>
@endsection
