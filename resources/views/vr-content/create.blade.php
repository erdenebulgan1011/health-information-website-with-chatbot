<!-- resources/views/vr/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Шинэ VR Контент')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Шинэ VR Контент Нэмэх</h1>

        <form action="{{ route('vr.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Гарчиг:</label>
                <input type="text" name="title" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Тайлбар:</label>
                <textarea name="description" class="border rounded w-full py-2 px-3" rows="4" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Sketchfab ID:</label>
                <input type="text" name="sketchfab_uid" class="border rounded w-full py-2 px-3" required>
                <small class="text-gray-500">Жишээ: https://sketchfab.com/models/<b>abcdef12345</b></small>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ангилал:</label>
                <select name="category_id" class="border rounded w-full py-2 px-3" required>
    @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</select>

            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Төлөв:</label>
                <select name="status" class="border rounded w-full py-2 px-3" required>
                    <option value="draft">Ноорог</option>
                    <option value="published">Нийтлэх</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Хадгалах
            </button>
        </form>
    </div>
</div>
@endsection
