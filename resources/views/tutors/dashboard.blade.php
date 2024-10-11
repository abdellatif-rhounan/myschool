@extends('layouts.app')

@section('title', 'Dashboard')

@section('username')
	{{ Auth::guard('tutor')->user()->name }}
@endsection

@section('sidebar_links')
	<li class="nav-item">
		<a class="nav-link @if (request()->segment(1) == 'my-children') active @endif" href="{{ route('my-children') }}">
			<i class="nav-icon fas fa-id-card"></i>

			<p>My Children</p>
		</a>
	</li>
@endsection

@section('left_header', 'Dashboard')

@section('page_content')
	<div class="col-12">Dashboard Content</div>
@endsection
