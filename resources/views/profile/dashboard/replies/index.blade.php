@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3">Миний Хариултууд</h1>
            <p class="text-muted">Форумын бүх сэдвүүд дээрх таны хариултуудыг үзнэ үү</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($replies->count() > 0)
                <div class="list-group">
                    @foreach($replies as $reply)
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between mb-2">
                                <h5 class="mb-1">
                                    <a href="{{ route('topics.show', $reply->topic_id) }}#reply-{{ $reply->id }}" class="text-decoration-none">
                                        Хариулт: {{ $reply->topic->title }}
                                    </a>
                                </h5>
                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>

                            <div class="reply-content mb-2">
                                {!! Str::limit(strip_tags($reply->content), 200) !!}
                                @if(strlen(strip_tags($reply->content)) > 200)
                                    <a href="{{ route('topics.show', $reply->topic_id) }}#reply-{{ $reply->id }}" class="text-decoration-none">
                                        (үргэлжлүүлэн унших)
                                    </a>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <span class="badge bg-primary me-1">
                                        <i class="fas fa-thumbs-up"></i> {{ $reply->likes()->count() }}
                                    </span>
                                    <a href="{{ route('topics.show', $reply->topic->slug) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-external-link-alt"></i> Сэдвийг үзэх
                                    </a>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('topics.edit', $reply->id) }}" class="btn btn-outline-secondary" title="Хариултыг засах">
                                        <i class="fas fa-edit"></i> Засах
                                    </a>
                                    <button type="button" class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteReplyModal{{ $reply->id }}"
                                            title="Хариултыг устгах">
                                        <i class="fas fa-trash"></i> Устгах
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Устгах диалог -->
                        <div class="modal fade" id="deleteReplyModal{{ $reply->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Хариултыг устгах</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Хаах"></button>
                                    </div>
                                    <div class="modal-body">
                                        Та энэ хариултыг устгахыг хүсч байна уу?
                                        <p class="text-danger mt-2">Энэ үйлдэл буцаагдахгүй.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Цуцлах</button>
                                        <form action="{{ route('topics.destroy', $reply->id) }}" method="POST">
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
                    {{ $replies->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-comments fa-3x text-muted"></i>
                    </div>
                    <h3 class="h5 text-muted">Та одоогоор ямар ч хариулт бичээгүй байна</h3>
                    <p>Форумын сэдвүүдэд нэгдэж хариулт бичээрэй.</p>
                    <a href="{{ route('topics.index') }}" class="btn btn-primary">
                        <i class="fas fa-comments"></i> Форумыг үзэх
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
