@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Manage Topics</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Pinned</th>
                <th>Locked</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topics as $topic)
            <tr>
                <td>{{ $topic->title }}</td>
                <td>{{ $topic->user->name }}</td>
                <td>{{ $topic->is_pinned ? 'Yes' : 'No' }}</td>
                <td>{{ $topic->is_locked ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('admin.replies.index', $topic) }}"
       class="btn btn-info btn-sm"
       title="Хариултуудыг харах">
        <i class="fas fa-comments"></i>
    </a>

                    <a href="{{ route('admin.topics.edit', $topic) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('admin.topics.toggle-pin', $topic) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary">
                            {{ $topic->is_pinned ? 'Unpin' : 'Pin' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.topics.toggle-lock', $topic) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning">
                            {{ $topic->is_locked ? 'Unlock' : 'Lock' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.topics.destroy', $topic) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $topics->links() }}
</div>
@endsection
