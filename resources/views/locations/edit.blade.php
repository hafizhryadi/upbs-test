@extends('layouts.app')

@section('title', 'Edit Location')

@section('content')
    <div class="container mt-4">
        <h2>Edit Location</h2>
        <form action="{{ route('locations.update', $location->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $location->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="{{ old('address', $location->address) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('locations.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
