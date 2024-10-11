@extends('layouts.app')

@section('title', 'Dashboard')

@section('username')
	{{ Auth::guard('frame')->user()->name }}
@endsection

@section('sidebar_links')
	<li class="nav-item">
		<a class="nav-link @if (request()->segment(1) == 'frames') active @endif" href="{{ route('frames.index') }}">
			<i class="nav-icon fas fa-user-tie"></i>

			<p>Frames</p>
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
		<a class="nav-link @if (request()->segment(1) == 'tutors') active @endif" href="{{ route('tutors.index') }}">
			<i class="nav-icon fas fa-user-tie"></i>

			<p>Tutors</p>
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
@endsection

@section('left_header', 'Dashboard')

@section('page_content')
	<div class="col-12">Dashboard Content</div>
@endsection
