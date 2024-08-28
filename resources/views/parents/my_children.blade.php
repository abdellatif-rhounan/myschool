@extends('layouts.app')

@section('title', 'My Children')

@section('left_header')
	My Children
@endsection

@section('page_content')
	<div class="col-lg-12">

		<div class="card card-light">
			<div class="card-header">
				<h3 class="card-title">My Children</h3>
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
						@foreach ($children as $key => $child)
							<tr>
								<th scope="row">{{ ++$key }}</th>

								<td>{{ $child->name }}</td>

								<td>{{ $child->email }}</td>

								<td>
									@if ($child->status)
										<span class="badge badge-success">Active</span>
									@else
										<span class="badge badge-danger">Stopped</span>
									@endif
								</td>

								<td class="d-flex" style="gap: 7px">
									<a class="btn btn-primary" href="{{ route('my-child-subjects', $child->id) }}">
										<i class="fas fa-book"></i>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>

				</table>
			</div>
		</div>
	</div>
@endsection
