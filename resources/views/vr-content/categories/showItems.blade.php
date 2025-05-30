<!-- resources/views/categories/showItems.blade.php -->
@extends('layouts.admin')

@section('title', $category->name)

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">{{ $category->name }}</h1>
        <a href="{{ route('categories.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Бүх Ангилал руу буцах
        </a>
    </div>

    @if($category->description)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            Ангилалын тайлбар
        </div>
        <div class="card-body">
            {{ $category->description }}
        </div>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            "{{ $category->name }}" ангилалд байгаа VR контентууд
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Гарчиг</th>
                        <th>Төлөв</th>
                        <th>Үүсгэсэн огноо</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vrContents as $content)
                    <tr>
                        <td>{{ $content->id }}</td>
                        <td>{{ $content->title }}</td>
                        <td>
                            <span class="badge bg-{{ $content->status === 'published' ? 'success' : 'secondary' }}">
                                {{ $content->status }}
                            </span>
                        </td>
                        <td>{{ $content->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('vr.show', $content->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Харуулах
                                </a>
                                <a href="{{ route('vr.edit', $content->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Засах
                                </a>
                                <form action="{{ route('vr.destroy', $content->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Устгахдаа итгэлтэй байна уу?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Энэ ангилалд VR контент олдсонгүй</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="d-flex justify-content-end">
                {{ $vrContents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection