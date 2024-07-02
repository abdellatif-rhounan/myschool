@extends('layouts.auth')

@section('title', 'Reset Password')

@section('box_msg', 'You are only one step a way from your new password, recover your password now.')

@section('input1')
    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"
        name="password" />
@endsection

@section('input1_icon', 'fas fa-lock')

@section('input1_invalid_feedback')
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
@endsection

@section('next_input_group')
    <div class="input-group mb-3">
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
            placeholder="Confirm Password" name="password_confirmation" />

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>

    <input type="hidden" name="token" value="{{ $token }}" />
@endsection

@section('form_submit_area')
    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-block">Change password</button>
    </div>
@endsection

@section('links')
    <p class="mt-3 mb-0">
        <a href="{{ route('login') }}">Login</a>
    </p>
@endsection
