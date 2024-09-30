<aside class="main-sidebar sidebar-dark-primary elevation-4">

	<a class="brand-link" href="{{ route('dashboard') }}" style="text-align: center; font-weight: bold; font-size: 24px">
		<i class="fas fa-book-open" style="position: relative; top: 1px"></i>

		<span class="brand-text">{{ config('app.name') }}</span>
	</a>

	<div class="sidebar" style="margin-top: 4rem">
		<div class="user-panel d-flex mb-3 mt-3 pb-3">
			<div class="image">
				<img class="img-circle elevation-2" src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User Image" />
			</div>

			<div class="info">
				<a class="d-block" href="javascript:;">{{ Auth::user()->name }}</a>
			</div>
		</div>

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false" role="menu">

				<li class="nav-item">
					<a class="nav-link @if (request()->segment(1) == 'dashboard') active @endif" href="{{ route('dashboard') }}">
						<i class="nav-icon fas fa-tachometer-alt"></i>

						<p>Dashboard</p>
					</a>
				</li>

				@php
					$user_type = Auth::user()->user_type;
				@endphp

				@if ($user_type == 1)
					{{-- Admin --}}
					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'admins') active @endif" href="{{ route('admins.index') }}">
							<i class="nav-icon fas fa-user-tie"></i>

							<p>Admins</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'teachers') active @endif" href="{{ route('teachers.index') }}">
							<i class="nav-icon fas fa-user-tie"></i>

							<p>Teachers</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'students') active @endif" href="{{ route('students.index') }}">
							<i class="nav-icon fas fa-user-tie"></i>

							<p>Students</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'parents') active @endif" href="{{ route('parents.index') }}">
							<i class="nav-icon fas fa-user-tie"></i>

							<p>Parents</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'classes') active @endif" href="{{ route('classes.index') }}">
							<i class="nav-icon fas fa-graduation-cap"></i>

							<p>Classes</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'subjects') active @endif" href="{{ route('subjects.index') }}">
							<i class="nav-icon fas fa-graduation-cap"></i>

							<p>Subjects</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'classes-subjects') active @endif" href="{{ route('classes-subjects.index') }}">
							<i class="nav-icon fas fa-graduation-cap"></i>

							<p>Class's Subject</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'classes-teachers') active @endif" href="{{ route('classes-teachers.index') }}">
							<i class="nav-icon fas fa-graduation-cap"></i>

							<p>Class Teacher</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'classes-students') active @endif" href="{{ route('classes-students.index') }}">
							<i class="nav-icon fas fa-graduation-cap"></i>

							<p>Class Students</p>
						</a>
					</li>
				@elseif ($user_type == 2)
					{{-- Teacher --}}
					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'my-classes-subjects') active @endif" href="{{ route('my-classes-subjects') }}">
							<i class="nav-icon fas fa-graduation-cap"></i>

							<p>My Class & Subject</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'my-classes-students') active @endif" href="{{ route('my-classes-students') }}">
							<i class="nav-icon fas fa-graduation-cap"></i>

							<p>My Class & Students</p>
						</a>
					</li>
				@elseif ($user_type == 3)
					{{-- Student --}}
					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'my-subjects') active @endif" href="{{ route('my-subjects') }}">
							<i class="nav-icon fas fa-id-card"></i>

							<p>My Subjects</p>
						</a>
					</li>
				@elseif ($user_type == 4)
					{{-- Parent --}}
					<li class="nav-item">
						<a class="nav-link @if (request()->segment(1) == 'my-children') active @endif" href="{{ route('my-children') }}">
							<i class="nav-icon fas fa-id-card"></i>

							<p>My Children</p>
						</a>
					</li>
				@endif

			</ul>
		</nav>
	</div>

</aside>
