<!-- resources/views/home.blade.php -->
@extends('layouts.forumApp')

@section('title', 'Нүүр хуудас')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
    <div class="bg-blue-500 text-white p-8 text-center">
        <h1 class="text-4xl font-bold mb-4">Эрүүл Мэнд Форум</h1>
        <p class="text-xl mb-6">Эрүүл мэндийн асуудлаар мэдээлэл авч, хэлэлцүүлэг өрнүүлэх газар</p>
        <div class="flex justify-center">
            <a href="{{ route('topics.create') }}" class="bg-white text-blue-500 px-6 py-3 rounded-lg font-bold mr-4 hover:bg-blue-100">Хэлэлцүүлэг үүсгэх</a>
            <a href="{{ route('topics.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">Хэлэлцүүлгүүд үзэх</a>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-6 rounded-lg text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                </svg>
                <h2 class="text-xl font-bold mb-2">Хэлэлцүүлэг өрнүүлэх</h2>
                <p class="text-gray-600">Эрүүл мэндийн асуудлаар асуулт тавьж, бусдаас зөвлөгөө авах</p>
            </div>
            <div class="bg-blue-50 p-6 rounded-lg text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h2 class="text-xl font-bold mb-2">Мэдээлэл авах</h2>
                <p class="text-gray-600">Эрүүл мэндийн чиглэлээр найдвартай мэдээлэл, зөвлөгөө авах</p>
            </div>
            <div class="bg-blue-50 p-6 rounded-lg text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <h2 class="text-xl font-bold mb-2">Мэргэжилтнүүдтэй холбогдох</h2>
                <p class="text-gray-600">Баталгаажсан эрүүл мэндийн мэргэжилтнүүдээс зөвлөгөө авах</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                <h2 class="text-xl font-bold">Шинэ хэлэлцүүлгүүд</h2>
                <a href="{{ route('topics.index') }}" class="text-blue-500 hover:text-blue-700">Бүгдийг үзэх</a>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($latestTopics as $topic)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-4">
                            <img src="{{ $topic->user->profile->avatar ?? asset('images/default-avatar.png') }}" alt="{{ $topic->user->name }}" class="h-10 w-10 rounded-full">
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-medium">
                                <a href="{{ route('topics.show', $topic->slug) }}" class="text-blue-600 hover:text-blue-800">{{ $topic->title }}</a>
                            </h3>
                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                <span>{{ $topic->user->name }}</span>
                                <span class="mx-2">&bull;</span>
                                <span>{{ $topic->created_at->diffForHumans() }}</span>
                                <span class="mx-2">&bull;</span>
                                <a href="{{ route('categories.show', $topic->category->slug) }}" class="text-blue-500 hover:text-blue-700">{{ $topic->category->name }}</a>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ml-4 text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                                {{ $topic->replies_count }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4 bg-blue-50 border-b border-blue-100">
                <h2 class="text-xl font-bold">Ангилалууд</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="block p-4 hover:bg-gray-50">
                    <div class="flex items-center">
                        @if($category->icon)
                        <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}" class="h-8 w-8 mr-3">
                        @else
                        <div class="h-8 w-8 bg-blue-100 text-blue-500 rounded-full flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        @endif
                        <div>
                            <h3 class="font-medium">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->topics_count }} хэлэлцүүлэг</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                <h2 class="text-xl font-bold">Мэргэжилтнүүд</h2>
                <a href="{{ route('professionals.index') }}" class="text-blue-500 hover:text-blue-700">Бүгдийг үзэх</a>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($professionals as $professional)
                <a href="{{ route('professionals.show', $professional->id) }}" class="block p-4 hover:bg-gray-50">
                    <div class="flex items-center">
                        <img src="{{ $professional->user->profile->avatar ?? asset('images/default-avatar.png') }}" alt="{{ $professional->user->name }}" class="h-10 w-10 rounded-full mr-3">
                        <div>
                            <h3 class="font-medium">{{ $professional->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $professional->specialization }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
