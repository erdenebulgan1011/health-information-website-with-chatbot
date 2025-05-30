<div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
    <!-- 3D Content Embed -->
    <div class="relative h-48 bg-gray-900">
        @if($content->embed_url)
            <iframe
                src="{{ $content->getEmbedUrlAttribute() }}"
                class="absolute w-full h-full border-0"
                frameborder="0"
                allow="autoplay; fullscreen; vr"
                allowfullscreen
                loading="lazy"
            ></iframe>
        @else
            <div class="absolute inset-0 flex items-center justify-center text-white">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                </svg>
            </div>
        @endif
    </div>

    <!-- Content Details -->
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
