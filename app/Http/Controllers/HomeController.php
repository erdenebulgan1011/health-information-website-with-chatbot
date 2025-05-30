<?php
namespace App\Http\Controllers;

use App\Models\VRContent;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Disease;
use App\Models\Topic;

use Carbon\Carbon;

class HomeController extends Controller
{
    public function index1()
    {
        $featuredContent = VRContent::where('is_featured', true)->take(4)->get();
        $popularContent = VRContent::orderBy('views_count', 'desc')->take(4)->get();
        $categories = Category::all();

        return view('home', compact('featuredContent', 'popularContent', 'categories'));
    }
    public function index()
    {
        // Get upcoming events (limit to 3)
        $events = Event::where('start_time', '>=', Carbon::now())
            ->orderBy('start_time', 'asc')
            ->take(3)
            ->get();

        // Format dates for events
        foreach ($events as $event) {
            $event->formatted_date = Carbon::parse($event->start_time)->format('Y.m.d - H:i');
        }

        // Get diseases (limit to 3)
        $diseases = Disease::take(3)->get();

        // Get active forum topics with reply counts (limit to 2)
    $topics = Topic::with(['user', 'category', 'replies'])
    ->withCount('replies')
    ->orderBy('created_at', 'desc')
    ->take(2)
    ->get();

// Format the time for topics
foreach ($topics as $topic) {
    $topic->time_ago = Carbon::parse($topic->created_at)->diffForHumans();
}
$featuredContent = VRContent::where('featured', true)
            ->where('status', 'published')
            ->with('category')
            ->limit(3)
            ->get();

        $categories = Category::withCount(['vrContents' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderByDesc('vr_contents_count')
            ->limit(4)
            ->get();

        // Pass data to the view
        return view('homeTEST', compact('events', 'diseases', 'topics','featuredContent', 'categories'));
    }
}
