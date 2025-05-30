{{-- resources/views/admin/topics/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Хэлэлцүүлэг засварлах</h1>

    <form action="{{ route('admin.topics.update', $topic) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Гарчиг</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="{{ old('title', $topic->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Ангилал</label>
            <select class="form-select" id="category_id" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $topic->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Контент</label>
            <textarea class="form-control" id="content" name="content"
                      rows="6" required>{{ old('content', $topic->content) }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Шошгууд (таслалаар тусгаарсан)</label>
            <input type="text" class="form-control" id="tags" name="tags"
                   value="{{ old('tags', $tags) }}">
            @error('tags')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Хадгалах</button>
            <a href="{{ route('admin.topics.index') }}" class="btn btn-secondary">Буцах</a>
        </div>
    </form>
</div>
@endsection
