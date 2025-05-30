@extends('vr-content.user.app')

@section('title', $category->name . ' - Эрүүл Мэндийн VR Контент')

@section('content')
<div class="category-header bg-primary text-white py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-4">{{ $category->name }}</h1>
        <p class="text-lg mb-6">{{ $category->description }}</p>
        <div class="flex items-center">
            <div class="text-5xl mr-4">
                @if($category->icon)
                    <i class="{{ $category->icon }}"></i>
                @else
                    <span class="text-6xl">{{ substr($category->name, 0, 1) }}</span>
                @endif
            </div>
            <div>
                <span class="block text-lg font-medium">Нийт загварууд:</span>
                <span class="text-3xl font-bold">{{ $contents->total() }}</span>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="flex flex-wrap mb-8">
        <div class="w-full md:w-8/12">
            <h2 class="text-2xl font-bold mb-2">{{ $category->name }} загварууд</h2>
            <p class="text-gray-600">{{ $category->name }} ангилалд хамаарах эрүүл мэндийн бүх VR загварууд</p>
        </div>
        <div class="w-full md:w-4/12 flex justify-end items-center">
            <div class="relative">
                <form action="{{ route('vr-content.search') }}" method="GET">
                    <input type="text" name="query" class="pl-10 pr-4 py-2 border rounded-full w-full" placeholder="Хайх...">
                    <button type="submit" class="absolute left-3 top-2.5">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter options -->
    <div class="mb-10 p-4 bg-gray-100 rounded-lg">
        <div class="flex flex-wrap items-center">
            <div class="mr-6 mb-2 sm:mb-0">
                <span class="font-medium">Эрэмбэлэх:</span>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="px-4 py-2 rounded-full {{ request('sort') == 'latest' || !request('sort') ? 'bg-primary text-white' : 'bg-white border' }}">
                    Шинэ нь эхэндээ
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}" class="px-4 py-2 rounded-full {{ request('sort') == 'oldest' ? 'bg-primary text-white' : 'bg-white border' }}">
                    Хуучин нь эхэндээ
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" class="px-4 py-2 rounded-full {{ request('sort') == 'name_asc' ? 'bg-primary text-white' : 'bg-white border' }}">
                    Нэрээр (А-Я)
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}" class="px-4 py-2 rounded-full {{ request('sort') == 'name_desc' ? 'bg-primary text-white' : 'bg-white border' }}">
                    Нэрээр (Я-А)
                </a>
            </div>
        </div>
    </div>

    <!-- Content grid -->
    @if($contents->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($contents as $content)
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="relative h-48">
                        <iframe src="{{ $content->getEmbedUrlAttribute() }}" class="absolute w-full h-full border-0" frameborder="0" allow="autoplay; fullscreen; vr" allowfullscreen></iframe>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1 line-clamp-1">{{ $content->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $content->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="bg-gray-100 text-primary text-xs px-2 py-1 rounded-full">
                                {{ $content->category->name }}
                            </span>
                            <a href="{{ route('category.vr-content.shows', $content->id) }}" class="text-primary hover:underline text-sm font-medium">
                                Дэлгэрэнгүй
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $contents->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-5xl mb-4">😢</div>
            <h3 class="text-xl font-semibold mb-2">Загварууд олдсонгүй</h3>
            <p class="text-gray-600">Энэ ангилалд одоогоор VR контент алга байна.</p>
        </div>
    @endif
</div>

<!-- Related categories -->
<div class="bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8">Бусад ангилалууд</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($otherCategories as $otherCategory)
                <a href="{{ route('vr-content.category', $otherCategory->slug) }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-4xl mb-4">
                        @if($otherCategory->icon)
                            <i class="{{ $otherCategory->icon }}"></i>
                        @else
                            <span class="text-5xl">{{ substr($otherCategory->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <h3 class="font-semibold text-lg mb-1">{{ $otherCategory->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $otherCategory->vr_contents_count }} загвар</p>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
