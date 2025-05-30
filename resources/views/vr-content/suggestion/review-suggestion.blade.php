@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Санал хянах</h2>
            <a href="{{ route('vr.admin.suggestions') }}" class="text-blue-500 hover:underline">
                Бүх саналд буцах
            </a>
        </div>

        <div class="mb-6 p-4 border rounded-lg bg-gray-50">
            <div class="mb-4">
                <span class="block text-sm text-gray-500">Санал оруулсан:</span>
                <span class="font-medium">{{ $suggestion->user->name }}</span>
                <span class="text-gray-500 text-sm ml-2">{{ $suggestion->created_at->format('Y-m-d H:i') }}</span>
            </div>

            <div class="mb-4">
                <span class="block text-sm text-gray-500">Төлөв:</span>
                @if($suggestion->status == 'pending')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Хүлээгдэж буй
                    </span>
                @elseif($suggestion->status == 'approved')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Зөвшөөрсөн
                    </span>
                @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Цуцалсан
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-medium text-lg mb-2">{{ $suggestion->title }}</h3>
                    <p class="text-gray-700 mb-4">{{ $suggestion->description }}</p>

                    <div class="mb-4">
                        <span class="block text-sm text-gray-500">Ангилал:</span>
                        <span class="font-medium">{{ $suggestion->category->name }}</span>
                    </div>

                    <div>
                        <span class="block text-sm text-gray-500">Sketchfab ID:</span>
                        <span class="font-medium">{{ $suggestion->sketchfab_uid }}</span>
                    </div>
                </div>

                <div class="bg-black rounded-lg overflow-hidden h-64">
                    <iframe
                        title="{{ $suggestion->title }}"
                        src="https://sketchfab.com/models/{{ $suggestion->sketchfab_uid }}/embed"
                        width="100%"
                        height="100%"
                        allow="autoplay; fullscreen; vr"
                        frameborder="0">
                    </iframe>
                </div>
            </div>

            @if(!empty($suggestion->admin_notes))
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h4 class="font-medium mb-2">Админы тэмдэглэл:</h4>
                    <p>{{ $suggestion->admin_notes }}</p>
                </div>
            @endif
        </div>

        @if($suggestion->status == 'pending')
            <form action="{{ route('vr.admin.processSuggestion', $suggestion->id) }}" method="POST" class="border-t pt-6">
                @csrf
                <div class="mb-4">
                    <label for="admin_notes" class="block text-gray-700 font-medium mb-2">Тэмдэглэл (шаардлагагүй)</label>
                    <textarea name="admin_notes" id="admin_notes" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit" name="decision" value="reject" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Цуцлах
                    </button>
                    <button type="submit" name="decision" value="approve" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Зөвшөөрөх
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
