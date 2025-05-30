<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vrContent->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Hero Section with Larger 3D View -->
        <div class="mb-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <!-- Fixing the 3D viewer size with fixed height and proper aspect ratio -->
        <div class="relative" style="height: 80vh; width: 100%;">
            <div class="absolute inset-0 w-full h-full">
                <iframe 
                    title="<?php echo $vrContent->title; ?>"
                    frameborder="0" 
                    allowfullscreen 
                    mozallowfullscreen="true"
                    webkitallowfullscreen="true"
                    allow="autoplay; fullscreen; xr-spatial-tracking"
                    xr-spatial-tracking
                    execution-while-out-of-viewport
                    execution-while-not-rendered
                    web-share
                    style="width: 100%; height: 100%;"
                    src="https://sketchfab.com/models/<?php echo $vrContent->sketchfab_uid; ?>/embed?autostart=1&ui_theme=dark">
                </iframe>
            </div>
        </div>
        <!-- Adding controls or title banner below the viewer -->
        <div class="bg-gray-50 p-4 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800"><?php echo $vrContent->title; ?></h2>
                <div class="flex space-x-2">
                    <button id="fullscreenBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Бүтэн дэлгэцээр
                    </button>
                    <button id="shareBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Хуваалцах
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h1 class="text-3xl font-bold mb-2">{{ $vrContent->title }}</h1>
                    
                    <div class="flex items-center mb-6">
                        <a href="{{ route('health.topics', ['category' => $vrContent->category->slug]) }}" 
                            class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            {{ $vrContent->category->name }}
                        </a>
                    </div>
                    
                    <p class="text-gray-700 text-lg leading-relaxed mb-8">{{ $vrContent->description }}</p>
                    
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold mb-4 pb-2 border-b border-gray-200">Гол мэдээлэл:</h2>
                        <div class="prose prose-lg max-w-none">
                            @foreach($vrContent->details as $detail)
                                <div class="mb-6">
                                    <h3 class="text-xl font-medium text-gray-900">{{ $detail->title }}</h3>
                                    <div class="mt-2 text-gray-700">{!! $detail->content !!}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-200">Энэ сэдвээр бусад контент</h2>
                    
                    @if($relatedContent && $relatedContent->count() > 0)
                        <div class="space-y-4">
                            @foreach($relatedContent as $content)
                                <a href="{{ route('vr.show', $content->id) }}" class="block group hover:bg-gray-50 rounded-lg p-3 transition duration-150">
                                    <div class="flex items-start">
                                        <div class="bg-gray-200 rounded-lg overflow-hidden w-24 h-24 flex-shrink-0">
                                            <img src="{{ $content->thumbnail ?? asset('images/default-thumbnail.jpg') }}" 
                                                alt="{{ $content->title }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="font-medium text-gray-900 group-hover:text-blue-600">
                                                {{ $content->title }}
                                            </h3>
                                            <p class="text-sm text-gray-500 line-clamp-2 mt-1">
                                                {{ Str::limit($content->description, 80) }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Холбоотой контент олдсонгүй.</p>
                    @endif
                    
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-3 pb-2 border-b border-gray-200">Санал болгох ангилалууд</h3>
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach($categories as $category)
                                <a href="{{ route('health.topics', ['category' => $category->slug]) }}" 
                                class="inline-block bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-full text-sm transition duration-150">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add necessary JavaScript for Aspect Ratio support -->
    <script>
document.getElementById('fullscreenBtn').addEventListener('click', function() {
        const iframe = document.querySelector('iframe');
        if (iframe.requestFullscreen) {
            iframe.requestFullscreen();
        } else if (iframe.webkitRequestFullscreen) { /* Safari */
            iframe.webkitRequestFullscreen();
        } else if (iframe.msRequestFullscreen) { /* IE11 */
            iframe.msRequestFullscreen();
        }
    });

    // Function to handle share button
    document.getElementById('shareBtn').addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: window.location.href
            }).catch(console.error);
        } else {
            // Fallback for browsers that don't support Web Share API
            prompt("URL-ийг хуулахын тулд доорх холбоосыг хуулж авна уу:", window.location.href);
        }
    });

    </script>
</body>
</html>