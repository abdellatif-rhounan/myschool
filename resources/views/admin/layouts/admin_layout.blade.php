@extends('layouts.app')

@php
	$role = 'admin';
@endphp

@section('sidebar_links')
	<li class="nav-item">
		<a class="nav-link @if (request()->segment(1) === 'admins') active @endif" href="{{ route('admins.index') }}">
			<i class="nav-icon fas fa-user-tie"></i>

			<p>Admins</p>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link @if (request()->segment(1) === 'teachers') active @endif" href="{{ route('teachers.index') }}">
			<i class="nav-icon fas fa-user-tie"></i>

			<p>Teachers</p>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link @if (request()->segment(1) === 'students') active @endif" href="{{ route('students.index') }}">
			<i class="nav-icon fas fa-user-graduate"></i>

			<p>Students</p>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link @if (request()->segment(1) === 'guardians') active @endif" href="{{ route('guardians.index') }}">
			<i class="nav-icon fas fa-users"></i>

			<p>Guardians</p>
		</a>
	</li>
@endsection
