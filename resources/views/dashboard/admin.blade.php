@extends('layouts.app')

@section('sidebar_navlinks')
    <li class="nav-item">
        <a href="{{ url('dashboard') }}" class="nav-link @if (request()->segment(1) == 'dashboard') active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>

            <p>Dashboard</p>
        </a>
    </li>
@endsection

@section('app_page_title', 'Dashboard')

@section('app_page_content')
    <div class="col-lg-12"></div>
@endsection
