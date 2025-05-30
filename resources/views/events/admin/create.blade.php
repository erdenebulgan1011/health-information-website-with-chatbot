@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Үйл явдал нэмэх</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('events.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Гарчиг <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Тайлбар</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Эхлэх огноо <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">Дуусах огноо <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Байршил</label>
                            <input type="text" name="location" id="location" class="form-control">
                        </div>
                        
                        <div class="mb-4">
                            <label for="url" class="form-label">Холбоос (URL)</label>
                            <input type="url" name="url" id="url" class="form-control" placeholder="https://example.com">
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Буцах
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Хадгалах
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Set default time for datetime inputs
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const startTime = document.getElementById('start_time');
        const endTime = document.getElementById('end_time');
        
        // Format to YYYY-MM-DDTHH:MM
        const formattedDateTime = now.toISOString().slice(0, 16);
        
        startTime.value = formattedDateTime;
        
        // Set end time to 1 hour later by default
        now.setHours(now.getHours() + 1);
        endTime.value = now.toISOString().slice(0, 16);
    });
</script>
@endsection