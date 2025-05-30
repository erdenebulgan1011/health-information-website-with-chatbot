@extends('layouts.forumApp')

@section('title', 'Дэлгэрэнгүй Хайлт')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
        <div class="p-5 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200">
            <h2 class="text-2xl font-bold text-gray-800">Дэлгэрэнгүй Хайлт</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('topics.search') }}" method="GET">
                <div class="space-y-5">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Хайх үг</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Ангилал</label>
                            <select name="category" id="category"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Бүгд</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="tag" class="block text-sm font-medium text-gray-700 mb-1">Тэмдэглэгээ</label>
                            <select name="tag" id="tag"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Бүгд</option>
                                @foreach($popularTags as $tag)
                                    <option value="{{ $tag->slug }}" {{ request('tag') == $tag->slug ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Огноо эхлэх</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                   class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Огноо дуусах</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                   class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-md hover:bg-blue-700 transition-colors shadow-sm">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Хайх
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(request()->has('search') || request()->has('category') || request()->has('tag') || request()->has('date_from') || request()->has('date_to'))
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-5 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Хайлтын үр дүн</h2>
                <span class="text-gray-600">{{ $topics->total() }} хэлэлцүүлэг олдлоо</span>
            </div>

            <div class="divide-y divide-gray-200">
                @if($topics->count() > 0)
                    @foreach($topics as $topic)
                        <!-- Same topic display code from index.blade.php -->
                        <div class="p-5 hover:bg-gray-50 transition-colors {{ $topic->is_pinned ? 'bg-blue-50' : '' }}">
                            <!-- Your existing topic display code -->
                        </div>
                    @endforeach
                @else
                    <div class="p-10 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Уучлаарай, хайлтад тохирох үр дүн олдсонгүй</h3>
                        <p class="text-gray-500">Өөр түлхүүр үг ашиглах эсвэл шүүлтүүрээ өөрчилж үзнэ үү</p>
                    </div>
                @endif
            </div>

            <div class="p-5 bg-gray-50 border-t border-gray-200">
                <div class="pagination-container">
                    {{ $topics->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
