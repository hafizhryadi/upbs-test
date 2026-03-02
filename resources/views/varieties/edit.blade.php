@extends('layouts.app')

@section('title', 'Edit Variety')

@section('content')
    <div class="container mt-4">
        <h2>Edit Variety</h2>
        <form action="{{ route('varieties.update', $variety->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $variety->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $variety->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('varieties.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
