@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header with action buttons -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Санал хянах: #{{ $suggestion->id }}</h1>
            <p class="text-gray-600 mt-1">Оруулсан: {{ $suggestion->created_at->format('Y-m-d H:i') }}</p>
        </div>
        <a href="{{ route('vr.admin.suggestions') }}"
           class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg shadow-sm flex items-center transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Бүх саналд буцах
        </a>
    </div>

    <!-- Content area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left column: 3D Model and Details -->
        <div class="lg:col-span-8">
            <!-- 3D Model Card -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg overflow-hidden mb-8">
                <!-- Status Badge -->
                <div class="relative">
                    @if($suggestion->status == 'pending')
                        <div class="absolute top-4 right-4 z-10 px-4 py-1.5 rounded-full bg-yellow-500 text-white font-bold shadow-md">
                            Хүлээгдэж буй
                        </div>
                    @elseif($suggestion->status == 'approved')
                        <div class="absolute top-4 right-4 z-10 px-4 py-1.5 rounded-full bg-green-500 text-white font-bold shadow-md">
                            Зөвшөөрсөн
                        </div>
                    @else
                        <div class="absolute top-4 right-4 z-10 px-4 py-1.5 rounded-full bg-red-500 text-white font-bold shadow-md">
                            Цуцалсан
                        </div>
                    @endif

                    <!-- 3D Model Viewer -->
                    <div class="relative aspect-[16/9] w-full bg-black">
                        <iframe
                            title="{{ $suggestion->title }}"
                            frameborder="0"
                            allowfullscreen
                            mozallowfullscreen="true"
                            webkitallowfullscreen="true"
                            allow="autoplay; fullscreen; vr"
                            style="width: 100%; height: 100%;"
                            src="https://sketchfab.com/models/{{ $suggestion->sketchfab_uid }}/embed?autostart=1&ui_theme=dark">
                        </iframe>
                    </div>
                </div>

                <!-- Model Controls -->
                <div class="bg-gray-50 border-t border-gray-200 p-4 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800 truncate">{{ $suggestion->title }}</h2>
                    <div class="flex gap-3">
                        <button id="fullscreenBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5-5-5m5 5v-4m0 4h-4"></path>
                            </svg>
                            Бүтэн дэлгэцээр
                        </button>
                        <a href="https://sketchfab.com/3d-models/{{ $suggestion->sketchfab_uid }}" target="_blank"
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Sketchfab-д харах
                        </a>
                    </div>
                </div>

                <!-- Model Details -->
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Тайлбар</h3>
                    <p class="text-gray-700 leading-relaxed mb-6">{{ $suggestion->description }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-indigo-50 rounded-xl p-5 border border-indigo-100">
                            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Ангилал</span>
                            <p class="mt-1 text-lg font-medium text-gray-900">{{ $suggestion->category->name }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                            <span class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Sketchfab ID</span>
                            <p class="mt-1 text-lg font-medium text-gray-900 break-all">{{ $suggestion->sketchfab_uid }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right column: User Info and Actions -->
        <div class="lg:col-span-4">
            <!-- User Info Card -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gray-800 text-white p-6">
                    <h3 class="text-lg font-semibold">Санал оруулсан хэрэглэгч</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $suggestion->user->name }}</h4>
                            <p class="text-gray-600">ID: {{ $suggestion->user->id }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">Огноо</span>
                            <span class="font-semibold">{{ $suggestion->created_at->format('Y-m-d') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">Цаг</span>
                            <span class="font-semibold">{{ $suggestion->created_at->format('H:i:s') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-600">Төлөв</span>
                            @if($suggestion->status == 'pending')
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-medium text-sm">
                                    Хүлээгдэж буй
                                </span>
                            @elseif($suggestion->status == 'approved')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-medium text-sm">
                                    Зөвшөөрсөн
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 font-medium text-sm">
                                    Цуцалсан
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Notes Card -->
            @if(!empty($suggestion->admin_notes))
                <div class="bg-white border border-gray-200 rounded-2xl shadow-lg overflow-hidden mb-8">
                    <div class="bg-blue-700 text-white p-6">
                        <h3 class="text-lg font-semibold">Админы тэмдэглэл</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 italic">{{ $suggestion->admin_notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Action Card (If pending) -->
            @if($suggestion->status == 'pending')
                <div class="bg-white border border-gray-200 rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gray-800 text-white p-6">
                        <h3 class="text-lg font-semibold">Шийдвэр гаргах</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('vr.admin.processSuggestion', $suggestion->id) }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="admin_notes" class="block text-gray-700 font-medium mb-2">Тэмдэглэл</label>
                                <textarea name="admin_notes" id="admin_notes" rows="4"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                    placeholder="Энд тэмдэглэл оруулна уу..."></textarea>
                                <p class="text-gray-500 text-sm mt-2">Шаардлагагүй бол хоосон үлдээж болно</p>
                            </div>

                            <div class="space-y-3">
                                <button type="submit" name="decision" value="approve"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Зөвшөөрөх
                                </button>
                                <button type="submit" name="decision" value="reject"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Цуцлах
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('fullscreenBtn').addEventListener('click', function() {
        const iframe = document.querySelector('iframe');
        if (iframe.requestFullscreen) {
            iframe.requestFullscreen();
        } else if (iframe.webkitRequestFullscreen) {
            iframe.webkitRequestFullscreen();
        } else if (iframe.msRequestFullscreen) {
            iframe.msRequestFullscreen();
        }
    });
</script>
@endsection
