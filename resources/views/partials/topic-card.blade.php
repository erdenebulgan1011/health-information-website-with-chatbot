<div class="p-4 border-b border-gray-200 hover:bg-gray-50">
    <div class="flex items-start">
        <div class="flex-shrink-0 mr-4">
            <img src="{{ $topic->user->avatar ?? asset('images/default-avatar.png') }}"
                 alt="{{ $topic->user->name }}"
                 class="h-10 w-10 rounded-full">
        </div>
        <div class="flex-grow">
            <div class="flex items-center">
                @if($topic->is_pinned)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                @endif

                <h3 class="font-medium">
                    <a href="{{ route('topics.show', $topic->slug) }}" class="text-blue-600 hover:text-blue-800">{{ $topic->title }}</a>
                </h3>
            </div>

            <div class="flex flex-wrap items-center text-sm text-gray-500 mt-1">
                <span>{{ $topic->user->name }}</span>
                <span class="mx-2">&bull;</span>
                <span>{{ $topic->created_at->diffForHumans() }}</span>
                <span class="mx-2">&bull;</span>
                <span>{{ $topic->replies_count }} хариулт</span>

                @if($topic->tags->count() > 0)
                <div class="ml-2 flex flex-wrap gap-1 mt-1">
                    @foreach($topic->tags as $tag)
                    <a href="{{ route('topics.index', ['tag' => $tag->slug]) }}" class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs hover:bg-gray-200">
                        {{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <div class="flex-shrink-0 ml-4 text-sm text-gray-500">
            <div class="flex items-center mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ $topic->views }}
            </div>
        </div>
    </div>
</div>
