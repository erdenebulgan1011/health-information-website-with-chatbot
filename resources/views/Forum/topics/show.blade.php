@extends('layouts.forumApp')

@section('title', $topic->title)

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Topic Header -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $topic->title }}</h1>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        @php
    // Safely access nested relationships (no errors if user/profile is missing)
    $profilePic = optional(optional($topic->user)->profile)->profile_pic;

    if ($profilePic && file_exists(public_path('storage/' . $profilePic))) {
        // Real image path: prepend 'storage/' for correct URL
        $profilePic = 'storage/' . $profilePic;
    } else {
        // Default image path: check if files exist in public/images/
        $randomNum = rand(1, 14);
        $defaultPath = "images/default_{$randomNum}.jpg";

        // Verify the default image exists, otherwise use a guaranteed fallback
        if (file_exists(public_path($defaultPath))) {
            $profilePic = $defaultPath;
        } else {
            // Ultimate fallback - use a known existing image or add path debugging
            $profilePic = "images/default_1.jpg"; // You might want to replace this with a guaranteed image
            // Uncomment for debugging:
            // dd("Default image not found: " . public_path($defaultPath));
        }
    }
@endphp
                                                    <img src="{{ asset($profilePic) }}" alt="{{ $topic->user->name ?? 'Anonymous' }}" class="h-12 w-12 rounded-full object-cover border-2 border-gray-200">

                        <span>{{ $topic->user->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $topic->created_at->diffForHumans() }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $topic->views }} {{ __('views') }}</span>
                    </div>
                </div>

                @auth
                    @can('update', $topic)
                    <div class="flex space-x-2">
                        <a href="{{ route('topics.edit', $topic->slug) }}"
                           class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                            Засах
                        </a>
                        <form action="{{ route('topics.destroy', $topic->slug) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600"
                                    onclick="return confirm('Хэлэлцүүлэг устгахдаа итгэлтэй байна уу?')">
                                Устгах
                            </button>
                        </form>
                    </div>
                    @endcan
                @endauth
            </div>

            <!-- Category and Tags -->
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <a href="{{ route('topics.index', ['category' => $topic->category->id]) }}"
                   class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">
                    {{ $topic->category->name }}
                </a>

                @foreach($topic->tags as $tag)
                    <a href="{{ route('topics.index', ['tag' => $tag->slug]) }}"
                       class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm hover:bg-gray-200">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Topic Content -->
        <div class="p-6 prose max-w-none">
            {!! nl2br(e($topic->content)) !!}
        </div>

        <!-- Best Answer Indicator -->
        @if($topic->replies->where('is_best_answer', true)->count() > 0)
            <div class="p-4 bg-green-50 border-t border-green-100">
                <div class="flex items-center text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Шилдэг хариулт сонгогдсон</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Replies Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-4 bg-blue-50 border-b border-blue-100">
            <h2 class="font-bold">
                Хариултууд ({{ $topic->replies->count() }})
            </h2>
        </div>

        @if($topic->replies->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($topic->replies as $reply)
                    <div id="reply-{{ $reply->id }}" class="p-4 hover:bg-gray-50">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                                        @php
    // Safely access nested relationships (no errors if user/profile is missing)
    $profilePic = optional(optional($topic->user)->profile)->profile_pic;

    if ($profilePic && file_exists(public_path('storage/' . $profilePic))) {
        // Real image path: prepend 'storage/' for correct URL
        $profilePic = 'storage/' . $profilePic;
    } else {
        // Default image path: check if files exist in public/images/
        $randomNum = rand(1, 14);
        $defaultPath = "images/default_{$randomNum}.jpg";

        // Verify the default image exists, otherwise use a guaranteed fallback
        if (file_exists(public_path($defaultPath))) {
            $profilePic = $defaultPath;
        } else {
            // Ultimate fallback - use a known existing image or add path debugging
            $profilePic = "images/default_1.jpg"; // You might want to replace this with a guaranteed image
            // Uncomment for debugging:
            // dd("Default image not found: " . public_path($defaultPath));
        }
    }
@endphp
                                                    <img src="{{ asset($profilePic) }}" alt="{{ $topic->user->name ?? 'Anonymous' }}" class="h-12 w-12 rounded-full object-cover border-2 border-gray-200">

                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="font-medium text-gray-900">{{ $reply->user->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                                        @if($reply->is_best_answer)
                                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs">
                                                Шилдэг хариулт
                                            </span>
                                        @endif
                                    </div>

                                    @auth
                                        <div class="flex space-x-2">
                                            @can('update', $topic)
                                                @if(!$topic->replies->where('is_best_answer', true)->count())
                                                    <form action="{{ route('replies.markAsBest', $reply) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                                            Шилдэг болгох
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan

                                            @can('update', $reply)
                                                <a href="{{ route('replies.edit', $reply) }}"
                                                   class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200">
                                                    Засах
                                                </a>
                                            @endcan
                                        </div>
                                    @endauth
                                </div>

                                <div class="mt-2 text-sm text-gray-700">
                                    {!! nl2br(e($reply->content)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                Хариулт байхгүй байна. Анхны хариултыг үлдээх үү?
            </div>
        @endif
    </div>

    <!-- Reply Form -->
    @auth
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 bg-blue-50 border-b border-blue-100">
                <h2 class="font-bold">Хариулт үлдээх</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('replies.store', $topic) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <textarea name="content" id="content" rows="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Хариултаа энд бичнэ үү..." required></textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Нийтлэх
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden p-6 text-center">
            <p class="mb-4">Хариулт үлдээхийн тулд нэвтэрсэн байх шаардлагатай</p>
            <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Нэвтрэх
            </a>
        </div>
    @endauth
</div>
@endsection
