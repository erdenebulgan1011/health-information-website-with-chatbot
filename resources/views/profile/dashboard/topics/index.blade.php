@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Миний сэдвүүд</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('topics.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Шинэ сэдэв үүсгэх
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($topics->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Гарчиг</th>
<th>Ангилал</th>
<th>Хариулт</th>
<th>Үүсгэсэн</th>
<th>Үйлдэл</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topics as $topic)
                                <tr>
                                    <td>
                                        <a href="{{ route('topics.show', $topic) }}" class="fw-bold text-decoration-none">
                                            {{ $topic->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $topic->category->name }}</span>
                                    </td>
                                    <td>
                                        {{ $topic->replies_count }}
                                    </td>
                                    <td>
                                        {{ $topic->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('topics.show', $topic) }}" class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('topics.edit', $topic) }}" class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteTopicModal{{ $topic->id }}"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteTopicModal{{ $topic->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">сэдвийг устгахдаа</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Та энэ сэдвийг устгахдаа итгэлтэй байна уу: <strong>{{ $topic->title }}</strong>?
                                                        <p class="text-danger mt-2">Энэ үйлдлийг буцаах боломжгүй бөгөөд бүх хариу мөн устах болно.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('topics.destroy', $topic) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">устгах</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $topics->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-comment-slash fa-3x text-muted"></i>
                    </div>
                    <h3 class="h5 text-muted">Та ямар ч сэдэв үүсгээгүй байна</h3>
                    <p>Анхны сэдвээ үүсгэснээр форум дээр яриа эхлүүлээрэй..</p>
                    <a href="{{ route('topics.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Create New Topic
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
