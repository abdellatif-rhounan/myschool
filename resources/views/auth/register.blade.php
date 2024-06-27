@extends('layouts.auth')

@section('page_title', 'Register')

@section('box_msg', 'Register a new membership')

@section('input1')
    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full name" name="name"
        value="{{ old('name') }}" />
@endsection

@section('input1_icon', 'fas fa-user')

@section('input1_invalid_feedback')
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
@endsection

@section('next_input_group')
    <div class="input-group mb-3">
        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email"
            value="{{ old('email') }}" />

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

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

    <div class="input-group mb-3">
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password"
            name="password_confirmation" />

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
@endsection

@section('form_submit_area')
    <div class="col-8">
        <div class="icheck-primary">
            <input type="checkbox" id="agreeTerms" name="terms" value="agree" class="@error('terms') is-invalid @enderror" />

            <label for="agreeTerms">
                I agree to the
                <a href="javascript:;">terms</a>
            </label>

            @error('terms')
                <div class="invalid-feedback">Please Agree To The Terms</div>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </div>
@endsection

@section('links')
    <p class="mt-4 mb-0">
        <a href="{{ url('login') }}">Login</a>
    </p>
@endsection
