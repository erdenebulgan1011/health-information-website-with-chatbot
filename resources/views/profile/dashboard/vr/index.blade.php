@extends('layouts.dashboard')

@section('content')

<div class="container py-4"> <div class="row mb-4"> <div class="col-md-8"> <h1 class="h3">Миний VR Контентын Саналууд</h1> <p class="text-muted">Таны илгээсэн VR контентын саналуудыг удирдах</p> </div> <div class="col-md-4 text-md-end"> <a href="{{ route('dashboard.vr.create') }}" class="btn btn-primary"> <i class="fas fa-plus-circle"></i> Шинэ VR Контент Илгээх </a> </div> </div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($suggestions->count() > 0)
            <div class="row g-4">
                @foreach($suggestions as $suggestion)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <span class="badge bg-{{ match($suggestion->status) {
    'approved' => 'success',
    'rejected' => 'danger',
    default => 'warning'
} }}">
    {{ match($suggestion->status) {
        'approved' => 'Зөвшөөрсөн (Approved)',
        'rejected' => 'Татгалзсан (Rejected)',
        default => 'Хяналт хүлээж буй (Pending)'
    } }}
</span>
                                <span class="badge bg-secondary">{{ $suggestion->category->name }}</span>
                            </div>

                            <div class="card-body">
                                <div class="sketchfab-embed-wrapper mb-3">
                                    <div class="ratio ratio-16x9">
                                        <iframe
                                            title="{{ $suggestion->title }}"
                                            frameborder="0"
                                            allowfullscreen
                                            mozallowfullscreen="true"
                                            webkitallowfullscreen="true"
                                            allow="autoplay; fullscreen; xr-spatial-tracking"
                                            xr-spatial-tracking
                                            execution-while-out-of-viewport
                                            execution-while-not-rendered
                                            web-share
                                            src="https://sketchfab.com/models/{{ $suggestion->sketchfab_uid }}/embed">
                                        </iframe>
                                    </div>
                                </div>

                                <h5 class="card-title">{{ $suggestion->title }}</h5>
                                <p class="card-text text-muted small">
                                    Илгээсэн огноо: {{ $suggestion->created_at->format('M d, Y') }}
                                </p>
                                <p class="card-text">{{ Str::limit($suggestion->description, 100) }}</p>
                            </div>

                            <div class="card-footer bg-white border-top-0">
                                <div class="btn-group w-100">
                                    @if($suggestion->status !== 'approved')
                                    <a href="{{ route('vr.edit', $suggestion->id) }}" class="btn btn-sm btn-outline-secondary {{ $suggestion->is_approved ? 'disabled' : '' }}" {{ $suggestion->is_approved ? 'aria-disabled="true"' : '' }}>
                                        <i class="fas fa-edit"></i> Засах
                                    </a>
                                    @endif
                                    <a href="{{ route('vr.show', $suggestion->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Үзэх
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger {{ $suggestion->is_approved ? 'disabled' : '' }}"
                                            {{ $suggestion->is_approved ? 'disabled' : '' }}
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteVrModal{{ $suggestion->id }}">
                                        <i class="fas fa-trash"></i> Устгах
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Устгах Modal -->
                    <div class="modal fade" id="deleteVrModal{{ $suggestion->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">VR Контентын Санал Устгах</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Хаах"></button>
                                </div>
                                <div class="modal-body">
                                    Та "<strong>{{ $suggestion->title }}</strong>"-г устгахдаа итгэлтэй байна уу?
                                    <p class="text-danger mt-2">Энэ үйлдлийг буцаах боломжгүй.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Цуцлах</button>
                                    <form action="{{ route('vr.admin.suggestions.destroy', $suggestion->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Устгах</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $suggestions->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-vr-cardboard fa-3x text-muted"></i>
                </div>
                <h3 class="h5 text-muted">Та одоогоор VR контентын санал илгээгүй байна</h3>
                <p>VR контентын саналаа нийтлэгчдэд хуваалцаарай</p>
                <a href="{{ route('vr.createSuggest') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Шинэ VR Контент Илгээх
                </a>
            </div>
        @endif
    </div>
</div>
</div> @endsection
