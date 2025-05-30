@extends('layouts.admin')

@section('title', 'Add Disease')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Disease</h2>

    <form action="{{ route('admin.diseases.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Disease Name</label>
            <input type="text" name="disease_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Common Symptoms</label>
            <textarea name="common_symptom" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Treatment</label>
            <textarea name="treatment" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.diseases.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
