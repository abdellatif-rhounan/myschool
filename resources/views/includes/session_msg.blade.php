@extends('layouts.session_msg')

@session('success')
	@section('alert-type', 'success')
@section('alert-title', 'Success')

@section('message')
	{{ $value }}
@endsection
@endsession

@error('fail')
@section('alert-type', 'danger')
@section('alert-title', 'Error')

@section('message')
	{{ $message }}
@endsection
@enderror
