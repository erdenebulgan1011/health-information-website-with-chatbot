@extends('layouts.admin')

@section('title', 'Edit Disease')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Disease</h2>

    <form action="{{ route('admin.diseases.update', $disease->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Disease Name</label>
            <input type="text" name="disease_name" class="form-control" value="{{ $disease->disease_name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Common Symptoms</label>
            <textarea name="common_symptom" class="form-control">{{ $disease->common_symptom }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Treatment</label>
            <textarea name="treatment" class="form-control">{{ $disease->treatment }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.diseases.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
