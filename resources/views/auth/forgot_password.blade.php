@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('box_msg', 'You forgot your password? Here you can easily retrieve a new password.')

@section('input1')
    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email"
        value="{{ old('email') }}" />
@endsection

@section('input1_icon', 'fas fa-envelope')

@section('input1_invalid_feedback')
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
@endsection

@section('form_submit_area')
    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-block">Request new password</button>
    </div>
@endsection

@section('links')
    <p class="mt-3 mb-0">
        <a href="{{ route('login') }}">Login</a>
    </p>
@endsection
