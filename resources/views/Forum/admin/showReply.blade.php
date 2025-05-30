@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            "{{ $topic->title }}"-д хавсарсан хариултууд
            <small class="text-muted">(Нийт: {{ $replies->total() }})</small>
        </h1>
        <a href="{{ route('admin.topics.index') }}" class="btn btn-secondary">Буцах</a>
    </div>

    <div class="card">
        <div class="card-body">
            @foreach($replies as $reply)
            <div class="reply-item mb-4 border-bottom pb-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <strong>{{ $reply->user->name }}</strong>
                        <small class="text-muted ms-2">
                            {{ $reply->created_at->format('Y-m-d H:i') }}
                        </small>
                        @if($reply->is_best_answer)
                            <span class="badge bg-success ms-2">Шилдэг хариулт</span>
                        @endif
                    </div>
                    <div class="btn-group">
                        <form action="{{ route('admin.replies.best', $reply) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success">
                                {{ $reply->is_best_answer ? 'Шилдгээс хас' : 'Шилдэг болгох' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.replies.destroy', $reply) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Устгах</button>
                        </form>
                    </div>
                </div>
                <div class="reply-content">
                    {!! nl2br(e($reply->content)) !!}
                </div>
            </div>
            @endforeach

            {{ $replies->links() }}
        </div>
    </div>
</div>
@endsection
