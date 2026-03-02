
@extends('layouts.app')

@section('title', 'Create Variety')

@section('content')
<div class="container mt-4">
	<h2>Create New Variety</h2>
	<form action="{{ route('varieties.store') }}" method="POST">
		@csrf
		<div class="mb-3">
			<label for="name" class="form-label">Name</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
		</div>
		<div class="mb-3">
			<label for="description" class="form-label">Description</label>
			<textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
		</div>
		<button type="submit" class="btn btn-primary">Create</button>
		<a href="{{ route('varieties.index') }}" class="btn btn-secondary">Cancel</a>
	</form>
</div>
@endsection
