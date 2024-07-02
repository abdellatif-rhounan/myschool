@extends('layouts.app')

@section('title', 'Edit Admin')

@section('left_header')
    Edit Admin
@endsection

@section('right_header')
    <a href="{{ route('admins.index') }}" class="btn btn-primary">Admin List</a>
@endsection

@section('page_content')
    <div class="col-lg-4 mx-auto mt-2">
        <div class="card card-success">

            <div class="card-header">
                <h3 class="card-title">Edit Admin</h3>
            </div>

            <form method="post" action="{{ route('admins.update', $user->id) }}">
                @method('PUT')
                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label for="name">Name</label>

                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" name="name" value="{{ old('name', $user->name) }}" />

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>

                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Email" name="email" value="{{ old('email', $user->email) }}" />

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            placeholder="Password" name="password" />

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>

                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password_confirmation" placeholder="Confirm Password" name="password_confirmation" />
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>

                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">-- select status --</option>
                            <option value="1" {{ old('status', $user->status) == '1' ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $user->status) == '0' ? 'selected' : '' }}>Stopped
                            </option>
                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>

        </div>
    </div>
@endsection
