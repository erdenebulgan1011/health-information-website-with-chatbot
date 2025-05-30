@extends('layouts.admin')
@section('title', 'Санал засах')
@section('content')
<div class="container-fluid px-4">
    <div class="mb-4">
        <a href="{{ route('vr.admin.suggestions') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Бүх саналд буцах
        </a>
        <h1>Санал засах</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> {{ $suggestion->title }}
        </div>
        <div class="card-body">
            <form action="{{ route('vr.admin.suggestions.update', $suggestion->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Гарчиг</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $suggestion->title) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Ангилал</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Сонгох --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $suggestion->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sketchfab_uid" class="form-label">Sketchfab ID</label>
                        <input type="text" class="form-control" id="sketchfab_uid" name="sketchfab_uid" value="{{ old('sketchfab_uid', $suggestion->sketchfab_uid) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Төлөв</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ old('status', $suggestion->status) == 'pending' ? 'selected' : '' }}>Хүлээгдэж буй</option>
                            <option value="approved" {{ old('status', $suggestion->status) == 'approved' ? 'selected' : '' }}>Зөвшөөрсөн</option>
                            <option value="rejected" {{ old('status', $suggestion->status) == 'rejected' ? 'selected' : '' }}>Цуцалсан</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Тайлбар</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $suggestion->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="admin_notes" class="form-label">Админы тэмдэглэл</label>
                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ old('admin_notes', $suggestion->admin_notes) }}</textarea>
                </div>

                <div class="mb-4">
                    <h4>3D загвар харах</h4>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe
                            title="{{ $suggestion->title }}"
                            class="embed-responsive-item"
                            width="100%"
                            height="400"
                            src="https://sketchfab.com/models/{{ $suggestion->sketchfab_uid }}/embed"
                            frameborder="0"
                            allow="autoplay; fullscreen; vr"
                            mozallowfullscreen="true"
                            webkitallowfullscreen="true">
                        </iframe>
                    </div>
                    <div class="form-text text-muted">
                        Sketchfab ID өөрчлөгдсөн бол дээрх загвар шинэчлэгдэхгүй. Хадгалсны дараа шинэ загвар харагдана.
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('vr.admin.suggestions') }}" class="btn btn-secondary">Буцах</a>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Хадгалах
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Live preview Sketchfab model when ID changes
    document.getElementById('sketchfab_uid').addEventListener('change', function() {
        const iframe = document.querySelector('iframe');
        const newUid = this.value.trim();
        if (newUid) {
            iframe.src = `https://sketchfab.com/models/${newUid}/embed`;
        }
    });
</script>
@endpush
