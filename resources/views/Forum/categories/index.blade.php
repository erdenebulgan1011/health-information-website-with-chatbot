@extends('layouts.ForumApp')

@section('content')
<section class="category-section py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="section-header text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Ангилал</h2>
            <p class="text-gray-600 mt-2">Форум хэлэлцүүлэг болон VR загварууд төрөл бүрээр</p>
        </div>

        <div class="categories-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('category.shows', $category->slug) }}" class="category-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="category-icon text-4xl text-center text-blue-500 mb-4">
                        {!! $category->icon ?? '📁' !!}
                    </div>
                    <h3 class="category-name text-xl font-semibold text-center text-gray-800">{{ $category->name }}</h3>
                    <div class="flex justify-center gap-8 mt-4">
                        <p class="category-count text-sm text-gray-600">
                            <span class="font-medium">{{ $category->topics_count }}</span> хэлэлцүүлэг
                        </p>
                        <p class="category-count text-sm text-gray-600">
                            <span class="font-medium">{{ $category->vr_contents_count }}</span> загвар
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
