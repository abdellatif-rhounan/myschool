@extends('layouts.app')

@section('title', 'My Subject List')

@section('left_header')
	My Subject List @if ($classe)
		({{ $classe->name }}) (Total: {{ $subjects->total() }})
	@endif
@endsection

@section('page_content')
	<div class="col-lg-12">

		@if ($msg)
			<div>{{ $msg }}</div>
		@else
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

					<div class="col-4">
						<button class="btn btn-success px-4" type="submit" style="position: relative; top: 7px;">
							Search
						</button>

						<a class="btn btn-danger px-4" href="{{ route('my-subjects') }}" style="position: relative; top: 7px;">
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
						</tr>
					@endforeach
				</tbody>

			</table>

			<div class="float-right">{{ $subjects->links() }}</div>
		@endif

	</div>
@endsection
