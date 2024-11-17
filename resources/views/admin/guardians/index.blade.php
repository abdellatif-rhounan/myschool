@extends('admin.layouts.admin_layout')

@section('title', 'Guardians List')

@push('css')
	<style>
		table th>a {
			color: inherit;
		}

		.form-btns button,
		.form-btns a {
			position: relative;
			top: 7px;
		}
	</style>
@endpush

@section('left_main_header')
	Guardians List (Total: {{ $guardians->total() }})
@endsection

@section('right_main_header')
	<a class="btn btn-primary" href="{{ route('guardians.create') }}">Add New Guardian</a>
@endsection

@section('main_content')
	<div class="col-lg-12">

		<form class="mb-3" method="get">
			<div class="row align-items-center">

				<div class="col-2">
					<div class="form-group">
						<label for="firstname">Firstname</label>

						<input class="form-control" id="firstname" name="firstname" type="text" value="{{ Request::get('firstname') }}"
							placeholder="Firstname" />
					</div>
				</div>

				<div class="col-2">
					<div class="form-group">
						<label for="lastname">Lastname</label>

						<input class="form-control" id="lastname" name="lastname" type="text" value="{{ Request::get('lastname') }}"
							placeholder="Lastname" />
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
						<label for="gender">Gender</label>

						<select class="custom-select" id="gender" name="gender">
							<option value="">-- select gender --</option>
							@foreach (\App\Enums\Gender::cases() as $gender)
								<option value="{{ $gender->value }}" {{ Request::get('gender') == $gender->value ? 'selected' : '' }}>
									{{ $gender->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-2">
					<div class="form-group">
						<label for="status">Status</label>

						<select class="custom-select" id="status" name="status">
							<option value="">-- select status --</option>
							@foreach (array_filter(\App\Enums\UserStatus::cases(), fn($case) => $case !== \App\Enums\UserStatus::Vacation) as $status)
								<option value="{{ $status->value }}" {{ Request::get('status') == $status->value ? 'selected' : '' }}>
									{{ $status->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-3">
					<div class="form-group">
						<label for="created_by">Created By</label>

						<select class="custom-select" id="created_by" name="created_by">
							<option value="">-- created by --</option>
							@foreach ($creators as $creator)
								<option value="{{ $creator->id }}" {{ Request::get('created_by') == $creator->id ? 'selected' : '' }}>
									{{ $creator->firstname }} {{ $creator->lastname }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-3 form-btns">
					<button class="btn btn-success px-4" type="submit">
						Search
					</button>

					<a class="btn btn-danger px-4" href="{{ route('guardians.index') }}">
						Reset
					</a>

					@if (Request::get('sort'))
						<button class="btn btn-info px-4" type="submit">
							Custom Sort
							<i class="fas fa-times ml-2" style="position: relative; top: 1px;"></i>
						</button>
					@endif
				</div>
			</div>
		</form>

		<table class="table-striped table-hover table">

			<thead>
				<tr>
					<th scope="col">
						<a
							href="{{ route('guardians.index', [
							    'sort' => 'id',
							    'direction' => $sortColumn === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc',
							    'firstname' => Request::get('firstname'),
							    'lastname' => Request::get('lastname'),
							    'email' => Request::get('email'),
							    'gender' => Request::get('gender'),
							    'status' => Request::get('status'),
							    'created_by' => Request::get('created_by'),
							]) }}">
							#
							@if ($sortColumn === 'id')
								<i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
							@else
								<i class="fas fa-sort ml-1"></i>
							@endif
						</a>
					</th>

					<th scope="col">
						<a
							href="{{ route('guardians.index', [
							    'sort' => 'firstname',
							    'direction' => $sortColumn === 'firstname' && $sortDirection === 'asc' ? 'desc' : 'asc',
							    'firstname' => Request::get('firstname'),
							    'lastname' => Request::get('lastname'),
							    'email' => Request::get('email'),
							    'gender' => Request::get('gender'),
							    'status' => Request::get('status'),
							    'created_by' => Request::get('created_by'),
							]) }}">
							Firstname
							@if ($sortColumn === 'firstname')
								<i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
							@else
								<i class="fas fa-sort ml-1"></i>
							@endif
						</a>
					</th>

					<th scope="col">
						<a
							href="{{ route('guardians.index', [
							    'sort' => 'lastname',
							    'direction' => $sortColumn === 'lastname' && $sortDirection === 'asc' ? 'desc' : 'asc',
							    'firstname' => Request::get('firstname'),
							    'lastname' => Request::get('lastname'),
							    'email' => Request::get('email'),
							    'gender' => Request::get('gender'),
							    'status' => Request::get('status'),
							    'created_by' => Request::get('created_by'),
							]) }}">
							Lastname
							@if ($sortColumn === 'lastname')
								<i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
							@else
								<i class="fas fa-sort ml-1"></i>
							@endif
						</a>
					</th>

					<th scope="col">Email</th>
					<th scope="col">Gender</th>
					<th scope="col">Status</th>
					<th scope="col">Actions</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($guardians as $key => $guardian)
					<tr>
						<th scope="row">
							@if ($sortDirection === 'asc')
								{{ $guardians->perPage() * ((Request::get('page') ?? 1) - 1) + ++$key }}
							@else
								{{ $guardians->total() - ((Request::get('page') ?? 1) - 1) * $guardians->perPage() - $key }}
							@endif
						</th>

						<td>{{ $guardian->firstname }}</td>

						<td>{{ $guardian->lastname }}</td>

						<td>{{ $guardian->email }}</td>

						<td>
							@switch($guardian->gender)
								@case(\App\Enums\Gender::Male->value)
									<i class="fas fa-male" style="margin-left: 12px; font-size: 30px; color: #1c71d8;"></i>
								@break

								@case(\App\Enums\Gender::Female->value)
									<i class="fas fa-female" style="margin-left: 10px; font-size: 30px; color: #e72dcf;"></i>
								@break
							@endswitch
						</td>

						<td>
							@switch($guardian->status)
								@case(\App\Enums\UserStatus::Active->value)
									<span class="badge badge-success">Active</span>
								@break

								@case(\App\Enums\UserStatus::Stopped->value)
									<span class="badge badge-danger">Stopped</span>
								@break
							@endswitch
						</td>

						<td class="d-flex" style="gap: 7px">
							<a class="btn btn-info" href="{{ route('guardians.show', $guardian->id) }}">
								<i class="fas fa-eye"></i>
							</a>

							<a class="btn btn-warning" href="{{ route('guardians.edit', $guardian->id) }}">
								<i class="fas fa-edit"></i>
							</a>

							<form method="post" action="{{ route('guardians.destroy', $guardian->id) }}">
								@csrf
								@method('DELETE')

								<button class="btn btn-danger" type="submit">
									<i class="fas fa-trash"></i>
								</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>

		<div class="float-right">{{ $guardians->links() }}</div>

	</div>
@endsection