<!-- resources/views/events/admin/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Үйл явдал засах')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Үйл явдал засах</h1>
        <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Буцах
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            {{ $event->title }}
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Гарчиг</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Тайлбар</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $event->description) }}</textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_time" class="form-label">Эхлэх хугацаа</label>
                        <input type="datetime-local" class="form-control" id="start_time" name="start_time" 
                               value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="end_time" class="form-label">Дуусах хугацаа</label>
                        <input type="datetime-local" class="form-control" id="end_time" name="end_time" 
                               value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i')) }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="location" class="form-label">Байршил</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $event->location) }}">
                </div>
                
                <div class="mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" class="form-control" id="url" name="url" value="{{ old('url', $event->url) }}">
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Хадгалах
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add validation to make sure end_time is after start_time
    document.getElementById('start_time').addEventListener('change', function() {
        document.getElementById('end_time').min = this.value;
    });
</script>
@endpush