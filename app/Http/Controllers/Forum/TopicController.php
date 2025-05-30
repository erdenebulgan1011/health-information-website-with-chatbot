<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class TopicController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }


    public function indexAdmin()
    {
        $topics = Topic::with('user','category')
                       ->latest()
                       ->paginate(20);
        return view('Forum.admin.index', compact('topics'));
    }
    public function editAdmin(Topic $topic)
    {
        // $this->authorize('update', $topic);

        $categories = Category::all();
        $tags = $topic->tags->pluck('name')->implode(', ');

        return view('Forum.admin.edit', compact('topic', 'categories', 'tags'));
    }

    public function updateAdmin(Request $request, Topic $topic)
    {
        // $this->authorize('update', $topic);

        $request->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
        ]);

        $topic->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        // Handle tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => $tagName]
                );

                $tagIds[] = $tag->id;
            }

            $topic->tags()->sync($tagIds);
        } else {
            $topic->tags()->detach();
        }

        return redirect()->route('admin.topics.index', $topic->slug)
            ->with('success', 'Хэлэлцүүлэг амжилттай шинэчлэгдлээ.');
    }






    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = Topic::with(['user', 'category', 'tags', 'replies'])
            ->withCount('replies');

        // Search Functionality
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%$searchTerm%")
                    ->orWhere('content', 'LIKE', "%$searchTerm%")
                    ->orWhereHas('tags', function($tagQuery) use ($searchTerm) {
                        $tagQuery->where('name', 'LIKE', "%$searchTerm%");
                    })
                    ->orWhereHas('replies', function($replyQuery) use ($searchTerm) {
                        $replyQuery->where('content', 'LIKE', "%$searchTerm%");
                    });
            });
        }

        // Existing Filters
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('tag')) {
            $tag = Tag::where('slug', $request->tag)->firstOrFail();
            $query->whereHas('tags', function($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            });
        }

        // Get Results
        $topics = $query->latest()
            ->paginate(15)
            ->appends($request->query());

        // Rest of your existing code...
        $popularTags = Cache::remember('popular_tags', now()->addHours(6), function () {
            return Tag::withCount('topics')
                ->orderBy('topics_count', 'desc')
                ->limit(10)
                ->get();
        });

        $categories = Category::all();
        $counts = Topic::select('category_id', DB::raw('count(*) as count'))
            ->groupBy('category_id')
            ->pluck('count', 'category_id');

        $categories->each(function($cat) use ($counts) {
            $cat->topics_count = $counts->get($cat->id, 0);
        });

        return view('forum.index', compact('topics', 'categories', 'popularTags'));
    }
        /**
     * Scope a query to search topics by title, content, tag names, or user names
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */



    public function create()
    {
        $categories = Category::all();
        return view('Forum.topics.create', compact('categories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:10',
        'category_id' => 'required|exists:categories,id',
        'tags' => 'nullable|string|max:255',
    ]);

    try {
        DB::beginTransaction();

        // Generate unique slug
        do {
            $slug = Str::slug($validated['title']) . '-' . Str::random(5);
        } while (Topic::where('slug', $slug)->exists());

        $topic = Topic::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
        ]);

        if (!$topic) {
            throw new \Exception("Topic creation failed.");
        }

        // Handle tags
        if (!empty($validated['tags'])) {
            $tagNames = array_filter(array_map('trim', explode(',', $validated['tags'])));

            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName]
                    );
                    $topic->tags()->attach($tag->id);
                }
            }
        }

        DB::commit();

        return redirect()->route('topics.show', $topic->slug)
            ->with('success', 'Хэлэлцүүлэг амжилттай үүсгэгдлээ.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error', 'Алдаа гарлаа: ' . $e->getMessage());
    }
}

    public function show($slug)
    {
        $topic = Topic::where('slug', $slug)
            ->with(['user.profile', 'category', 'replies.user.profile', 'tags'])
            ->firstOrFail();

        // Increment view count
        $topic->increment('views');

        $relatedTopics = Topic::where('category_id', $topic->category_id)
            ->where('id', '!=', $topic->id)
            ->take(5)
            ->get();

        return view('Forum.topics.show', compact('topic', 'relatedTopics'));
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);

        $categories = Category::all();
        $tags = $topic->tags->pluck('name')->implode(', ');

        return view('topics.edit', compact('topic', 'categories', 'tags'));
    }

    public function update(Request $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $request->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
        ]);

        $topic->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        // Handle tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => $tagName]
                );

                $tagIds[] = $tag->id;
            }

            $topic->tags()->sync($tagIds);
        } else {
            $topic->tags()->detach();
        }

        return redirect()->route('topics.show', $topic->slug)
            ->with('success', 'Хэлэлцүүлэг амжилттай шинэчлэгдлээ.');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->back()->with('success', 'Topic deleted successfully');
    }





//admin
    public function togglePin(Topic $topic)
    {
        $topic->update(['is_pinned' => !$topic->is_pinned]);
        return redirect()->back()->with('success', 'Pin status updated');
    }

    public function toggleLock(Topic $topic)
    {
        $topic->update(['is_locked' => !$topic->is_locked]);
        return redirect()->back()->with('success', 'Lock status updated');
    }


}
