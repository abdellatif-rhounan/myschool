@extends('layouts.app')

@section('title', 'Dashboard')

@section('username')
	{{ Auth::guard('teacher')->user()->name }}
@endsection

@section('sidebar_links')
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
@endsection

@section('left_header', 'Dashboard')

@section('page_content')
	<div class="col-12">Dashboard Content</div>
@endsection
