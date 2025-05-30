@extends('layouts.ForumApp')

@section('content')
<style>
    .category-section {
            padding: 4rem 0;
        }
</style>
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $category->name }}</h1>
        <p class="text-gray-600 mt-2">{{ $category->description }}</p>
    </div>

    <!-- Forum Topics Section -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Хэлэлцүүлгүүд</h2>
            <a href="{{ route('topics.create') }}?category={{ $category->id }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Шинэ хэлэлцүүлэг
            </a>
        </div>

        @if($topics->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @foreach($topics as $topic)
                    @include('partials.topic-card', ['topic' => $topic])
                @endforeach
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $topics->links('pagination::tailwind') }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">Энэ ангилалд хэлэлцүүлэг байхгүй байна</p>
                <a href="{{ route('topics.create') }}?category={{ $category->id }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Анхны хэлэлцүүлэг үүсгэх
                </a>
            </div>
        @endif
    </section>

    <!-- VR Contents Section -->
    <section>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">VR загварууд</h2>
            @auth
                <a href="{{ route('vr.createSuggest') }}?category={{ $category->id }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Шинэ загвар санал болгох
                </a>
            @endauth
        </div>

        @if($vrContents->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($vrContents as $content)
                    @include('vr-content.partials.card', ['content' => $content])
                @endforeach
            </div>
            <div class="mt-6">
                {{ $vrContents->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">Энэ ангилалд VR загвар байхгүй байна</p>
                @auth
                    <a href="{{ route('vr.create') }}?category={{ $category->id }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Анхны загвар үүсгэх
                    </a>
                @endauth
            </div>
        @endif
    </section>

        <!-- Related Categories -->
        <section class="bg-gray-100 py-12 -mx-4 px-4">
            <div class="container mx-auto">
                <h2 class="text-2xl font-bold mb-8">Бусад ангилалууд</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($otherCategories as $otherCategory)
                        <a href="{{ route('category.shows', $otherCategory->slug) }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col items-center text-center">
                            <div class="text-[80px] mb-4 text-blue-500">
                                @if($otherCategory->icon)
                                    <i class="{{ $otherCategory->icon }}"></i>
                                @else
                                    <span>{{ substr($otherCategory->name, 0, 1) }}</span>
                                @endif
                            </div>


                            <div class="text-4xl mb-4 text-blue-500">
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
        </section>


        {{-- <section class="category-section">
            <div class="container">
                <div class="section-header">
                    <h2>Ангилал</h2>
                    <p>Эрүүл мэндийн VR загварууд төрөл бүрээр</p>
                </div>

                <div class="categories-container">
                @foreach($categories as $category)
        <a href="{{ route('vr-content.category', $category->slug) }}" class="category-card">
            <div class="category-icon">
                {{ $category->icon }}
            </div>
            <h3 class="category-name">{{ $category->name }}</h3>
            <p class="category-count">{{ $category->vr_contents_count }} загвар</p>
        </a>
        @endforeach
                </div>
            </div>
        </section> --}}

</div>
@endsection
