@extends('layouts.app')

@section('title', 'Parents List')

@section('left_header')
	Parents List (Total: {{ $parents->total() }})
@endsection

@section('right_header')
	<a class="btn btn-primary" href="{{ route('parents.create') }}">Add New Parent</a>
@endsection

@section('page_content')
	<div class="col-lg-12">

		<form class="mb-3" method="get">
			<div class="row align-items-center">

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

							@foreach ($parents_creators as $creator)
								<option value="{{ $creator->id }}" {{ Request::get('created_by') == $creator->id ? 'selected' : '' }}>
									{{ $creator->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-4">
					<button class="btn btn-success px-4" type="submit" style="position: relative; top: 7px;">
						Search
					</button>

					<a class="btn btn-danger px-4" href="{{ route('parents.index') }}" style="position: relative; top: 7px;">
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
					<th scope="col">Email</th>
					<th scope="col">Status</th>
					<th scope="col">Actions</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($parents as $key => $parent)
					<tr>
						<th scope="row">{{ ++$key }}</th>

						<td>{{ $parent->name }}</td>

						<td>{{ $parent->email }}</td>

						<td>
							@if ($parent->status)
								<span class="badge badge-success">Active</span>
							@else
								<span class="badge badge-danger">Stopped</span>
							@endif
						</td>

						<td class="d-flex" style="gap: 7px">
							<a class="btn btn-info" href="{{ route('parents.show', $parent->id) }}">
								<i class="fas fa-eye"></i>
							</a>

							<a class="btn btn-warning" href="{{ route('parents.edit', $parent->id) }}">
								<i class="fas fa-edit"></i>
							</a>

							<form method="post" action="{{ route('parents.destroy', $parent->id) }}">
								@method('delete')
								@csrf

								<button class="btn btn-danger" type="submit">
									<i class="fas fa-trash"></i>
								</button>
							</form>

							<a class="btn btn-info" href="{{ route('parents.students', $parent->id) }}">
								<i class="fas fa-child"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>

		<div class="float-right">{{ $parents->links() }}</div>

	</div>
@endsection
