@extends('layouts.admin')

@section('title', 'VR Контент засварлах')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">{{ $vrContent->title }} засварлах</h1>

        <form action="{{ route('vr.update', $vrContent->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Гарчиг:</label>
                <input type="text" name="title" class="border rounded w-full py-2 px-3"
                       value="{{ old('title', $vrContent->title) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Тайлбар:</label>
                <textarea name="description" class="border rounded w-full py-2 px-3" rows="4" required>
                    {{ old('description', $vrContent->description) }}
                </textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Sketchfab ID:</label>
                <input type="text" name="sketchfab_uid" class="border rounded w-full py-2 px-3"
                       value="{{ old('sketchfab_uid', $vrContent->sketchfab_uid) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ангилал:</label>
                <select name="category_id" class="border rounded w-full py-2 px-3" required>
    @foreach($categories as $category)
        <option value="{{ $category->id }}"
            {{ $vrContent->category_id == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>

            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Төлөв:</label>
                <select name="status" class="border rounded w-full py-2 px-3" required>
                    <option value="draft" {{ $vrContent->status == 'draft' ? 'selected' : '' }}>Ноорог</option>
                    <option value="published" {{ $vrContent->status == 'published' ? 'selected' : '' }}>Нийтлэх</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Шинэчлэх
            </button>
        </form>
    </div>
</div>
@endsection
