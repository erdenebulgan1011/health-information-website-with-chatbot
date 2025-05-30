@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Миний VR Контент</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Миний оруулсан контент</h2>
            <a href="{{ route('vr-content.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Шинэ контент оруулах
            </a>
        </div>
        
        @if($myContent->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($myContent as $content)
                    <div class="bg-white border rounded-lg overflow-hidden shadow">
                        <a href="{{ route('vr-content.view', $content->id) }}">
                            @if($content->thumbnail)
                                <img src="{{ asset('storage/'.$content->thumbnail) }}" alt="{{ $content->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <div class="flex items-center text-sm mb-2">
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-2">{{ $content->category->name }}</span>
                                <span class="text-gray-500">{{ $content->views_count }} үзсэн</span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">{{ $content->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($content->description, 80) }}</p>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('vr-content.view', $content->id) }}" class="text-blue-500 hover:text-blue-700">Үзэх</a>
                                <span class="text-sm text-gray-500">{{ $content->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $myContent->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 mb-4">Та одоогоор контент оруулаагүй байна.</p>
                <a href="{{ route('vr-content.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Шинэ контент оруулах
                </a>
            </div>
        @endif
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Хадгалсан контент</h2>
        
        @if($savedContent->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($savedContent as $content)
                    <div class="bg-white border rounded-lg overflow-hidden shadow">
                        <a href="{{ route('vr-content.view', $content->id) }}">
                            @if($content->thumbnail)
                                <img src="{{ asset('storage/'.$content->thumbnail) }}" alt="{{ $content->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <div class="flex items-center text-sm mb-2">
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-2">{{ $content->category->name }}</span>
                                <span class="text-gray-500">{{ $content->views_count }} үзсэн</span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">{{ $content->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($content->description, 80) }}</p>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('vr-content.view', $content->id) }}" class="text-blue-500 hover:text-blue-700">Үзэх</a>
                                <form action="{{ route('vr-content.save', $content->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Устгах</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $savedContent->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">Та одоогоор контент хадгалаагүй байна.</p>
                <a href="{{ route('vr-content.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                    Контент харах
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
