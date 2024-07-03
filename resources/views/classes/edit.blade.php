@extends('layouts.app')

@section('title', 'Edit Class')

@section('left_header')
    Edit Class
@endsection

@section('right_header')
    <a href="{{ route('classes.index') }}" class="btn btn-primary">Class List</a>
@endsection

@section('page_content')
    <div class="col-lg-4 mx-auto mt-2">
        <div class="card card-success">

            <div class="card-header">
                <h3 class="card-title">Edit Class</h3>
            </div>

            <form method="post" action="{{ route('classes.update', $class->id) }}">
                @method('PUT')
                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label for="name">Name</label>

                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" name="name" value="{{ old('name', $class->name) }}" />

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>

                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">-- select status --</option>
                            <option value="1" {{ old('status', $class->status) == '1' ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $class->status) == '0' ? 'selected' : '' }}>Stopped
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
