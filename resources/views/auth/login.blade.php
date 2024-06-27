@extends('layouts.auth')

@section('page_title', 'Login')

@section('box_msg', 'Sign in to start your session')

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

@section('next_input_group')
    <div class="input-group mb-3">
        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"
            name="password" />

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>

        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endsection

@section('form_submit_area')
    <div class="col-8">
        <div class="icheck-primary">
            <input type="checkbox" id="remember" name="remember" />

            <label for="remember">Remember Me</label>
        </div>
    </div>

    <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
    </div>
@endsection

@section('links')
    <p class="mt-3 mb-1">
        <a href="{{ url('forgot-password') }}">I forgot my password</a>
    </p>

    <p class="mb-0">
        <a href="{{ url('register') }}" class="text-center">Sign Up</a>
    </p>
@endsection
