@extends('layouts.forumApp')

@section('title', 'Хэлэлцүүлгүүд')

@section('content')
<div class="flex flex-col md:flex-row gap-8 max-w-7xl mx-auto px-4 py-6">
    <div class="w-full md:w-3/4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6 transition-all">
            <div class="p-5 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-800">Хэлэлцүүлгүүд</h2>
                <a href="{{ route('topics.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-md hover:bg-blue-700 transition-colors shadow-sm w-full sm:w-auto text-center">
                    <div class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Шинэ хэлэлцүүлэг
                    </div>
                </a>
            </div>

            @if(request()->has('search') && request('search'))
            <div class="p-4 bg-blue-50 border-l-4 border-blue-400 mb-4">
                <p class="text-sm text-blue-800">
                    "{{ request('search') }}" гэсэн үгээр хайлт хийж
                    <span class="font-medium">{{ $topics->total() }}</span>
                    илэрц олдлоо
                </p>
            </div>
            @endif
            <div class="p-5 border-b border-gray-200 bg-gray-50">
                <form action="{{ route('topics.index') }}" method="GET" class="flex">
                    <div class="flex-grow relative">
                        <input type="text" name="search" placeholder="Хайх..."
                               value="{{ request('search') }}"
                               class="border border-gray-300 rounded-l-md px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                        @if(request()->has('search'))
                        <a href="{{ route('topics.index') }}"
                           class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                        @endif
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-3 rounded-r-md hover:bg-blue-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($topics as $topic)
                <div class="p-5 hover:bg-gray-50 transition-colors {{ $topic->is_pinned ? 'bg-blue-50' : '' }}">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
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
                            <div class="flex items-center gap-2">
                                @if($topic->is_pinned)
                                <div class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                    Чухал
                                </div>
                                @endif

                                <h3 class="font-medium text-lg">
                                    <a href="{{ route('topics.show', $topic->slug) }}" class="text-blue-700 hover:text-blue-900 hover:underline">
                                        @if(request()->has('search'))
                                            {!! highlightMatches($topic->title, request('search')) !!}
                                        @else
                                            {{ $topic->title }}
                                        @endif
                                    </a>
                                </h3>
                            </div>

                            <div class="flex flex-wrap items-center text-sm text-gray-500 mt-2 gap-2">
                                <span class="font-medium">{{ $topic->user->name }}</span>
                                <span class="text-gray-400">&bull;</span>
                                <span>{{ $topic->created_at->diffForHumans() }}</span>
                                <span class="text-gray-400">&bull;</span>
                                <a href="{{ route('categories.showItems', $topic->category->slug) }}"
                                    class="text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $topic->category->name }}
                                </a>

                                @if($topic->tags->count() > 0)
                                <div class="flex flex-wrap gap-1.5 mt-2">
                                    @foreach($topic->tags as $tag)
                                    <a href="{{ route('topics.index', ['tag' => $tag->slug]) }}"
                                        class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs hover:bg-gray-200 transition-colors">
                                        #{{ $tag->name }}
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-sm text-gray-600">
                            <div class="flex items-center mb-2 bg-gray-100 px-3 py-1.5 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                                {{ $topic->replies_count ?? 0 }}
                            </div>
                            <div class="flex items-center bg-gray-100 px-3 py-1.5 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $topic->views }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="p-5 bg-gray-50 border-t border-gray-200">
                <div class="pagination-container">
                    {{ $topics->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="w-full md:w-1/4 space-y-6">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200">
                <h2 class="font-bold text-gray-800 text-lg">Ангилалууд</h2>
            </div>
            <div class="divide-y divide-gray-200 h-[500px] overflow-y-auto">  <!-- Scrollable Container -->
                @foreach($categories as $category)
                <a href="{{ route('topics.index', ['category' => $category->id]) }}"
                    class="block p-4 hover:bg-gray-50 transition-colors {{ request('category') == $category->id ? 'bg-blue-50' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($category->icon)
                            <span class="text-xl mr-3">{{ $category->icon }}</span>
                            @else
                            <div class="h-6 w-6 bg-blue-100 text-blue-500 rounded-full flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                            @endif
                            <span class="font-medium">{{ $category->name }}</span>
                        </div>
                        <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-medium">{{ $category->topics_count }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-300">
                <h2 class="font-bold text-gray-800 text-lg">Түгээмэл тэмдэглэгээнүүд</h2>
            </div>
            <div class="p-4 flex flex-wrap gap-2">
                @foreach($popularTags as $tag)
                <a href="{{ route('topics.index', ['tag' => $tag->slug]) }}"
                    class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full hover:bg-gray-200 transition-colors text-sm
                    {{ request('tag') == $tag->slug ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                    #{{ $tag->name }}
                </a>
                @endforeach
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-lg p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <h3 class="font-bold text-xl mb-3 text-gray-800">Хэлэлцүүлэг эхлүүлэх үү?</h3>
            <p class="text-gray-600 mb-5">Асуултаа хуваалцаж, мэргэжилтнүүдээс хариулт авах</p>
            <a href="{{ route('topics.create') }}"
                class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors inline-block shadow-md">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Шинэ хэлэлцүүлэг үүсгэх
                </div>
            </a>
        </div>
    </div>
</div>

<style>
/* Custom styles for pagination */
.pagination-container nav {
    @apply flex justify-center;
}

.pagination-container .pagination {
    @apply flex flex-wrap;
}

.pagination-container .page-item {
    @apply mx-1;
}

.pagination-container .page-link {
    @apply px-3 py-1 rounded bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 transition-colors;
}

.pagination-container .page-item.active .page-link {
    @apply bg-blue-500 text-white border-blue-500 hover:bg-blue-600;
}

.pagination-container .page-item.disabled .page-link {
    @apply bg-gray-100 text-gray-400 cursor-not-allowed;
}
</style>
@endsection
