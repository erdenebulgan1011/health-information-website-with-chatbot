<?php

namespace App\Http\Controllers;

use App\Models\Event as EventModel; // Event model-ийг өөр нэртэй импортлох
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Yajra\DataTables\DataTables;


class EventController extends Controller
{
    public function calendarReport()
    {
        // Today's events count
        $todayEventsCount = EventModel::whereDate('start_time', Carbon::today())->count();

        // This month's events count
        $monthEventsCount = EventModel::whereYear('start_time', Carbon::now()->year)
            ->whereMonth('start_time', Carbon::now()->month)
            ->count();

        // Most popular event (by views)
        $popularEvent = EventModel::orderBy('max_attendees', 'desc')->first();
        $popularEventViews = $popularEvent ? $popularEvent->views : 0;

        // Total attendees across all events
        try {
            $totalAttendees = DB::table('users')->count();
        } catch (\Exception $e) {
            // Fallback if users table doesn't exist
            $totalAttendees = 0;
        }

        // Upcoming events (next 7 days)
        $upcomingEvents = EventModel::where('start_time', '>=', Carbon::now())
            ->where('start_time', '<=', Carbon::now()->addDays(7))
            ->where('status', 'active')
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        // Featured events
        $featuredEvents = EventModel::where('is_featured', true)
            ->where('status', 'active')
            ->where('start_time', '>=', Carbon::now())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        // Get all event locations for filter dropdown
        $locations = EventModel::whereNotNull('location')
            ->distinct()
            ->pluck('location')
            ->toArray();

        // Get all categories for filter dropdown
        $categories = Category::orderBy('name', 'asc')->get();

        return view('events.admin.calendarReport', compact(
            'todayEventsCount',
            'monthEventsCount',
            'popularEventViews',
            'totalAttendees',
            'upcomingEvents',
            'featuredEvents',
            'locations',
            'categories'
        ));
    }
    public function index(Request $request)
{
    if ($request->ajax()) {
        $events = EventModel::select([
            'id',
            'title',
            'description',
            'start_time',
            'end_time',
            'location',
            'url'
        ]);

        return DataTables::of($events)
            ->addColumn('show_url', function($event) {
                return route('events.show', $event->id);
            })
            ->addColumn('edit_url', function($event) {
                return route('events.edit', $event->id);
            })
            ->addColumn('delete_url', function($event) {
                return route('events.destroy', $event->id);
            })
            ->toJson();
    }


    return view('events.index');
}
public function calendar()
{
    // Upcoming events (next 7 days)
    $upcomingEvents = EventModel::where('start_time', '>=', Carbon::now())
    ->where('start_time', '<=', Carbon::now()->addDays(7))
    ->where('status', 'active')
    ->orderBy('start_time', 'asc')
    ->take(5)
    ->get();

// Featured events
$featuredEvents = EventModel::where('is_featured', true)
    ->where('status', 'active')
    ->where('start_time', '>=', Carbon::now())
    ->orderBy('start_time', 'asc')
    ->take(5)
    ->get();

    return view('events.calendar', compact(
    'upcomingEvents',
    'featuredEvents',
));
}
public function getEvents()
{
    $events = EventModel::all();

    $formattedEvents = $events->map(function($event) {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start_time,
            'end' => $event->end_time,
            'description' => $event->description,
            'location' => $event->location,
            'url' => $event->url
        ];
    });

    Log::info('Events API returned: ' . count($formattedEvents) . ' events');
    Log::info(json_encode($formattedEvents));

    return response()->json($formattedEvents);
}


    public function create()
    {
        return view('events.admin.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'location' => 'nullable|string|max:255',
        'url' => 'nullable|url',
    ]);

    EventModel::create($request->all());

    return redirect()->route('events.index')
        ->with('success', 'Үйл явдал амжилттай нэмэгдлээ!');
}

public function show(EventModel $event)
{
    return view('events.admin.show', compact('event'));
}

public function edit(EventModel $event)
{
    return view('events.admin.edit', compact('event'));
}

public function update(Request $request, EventModel $event)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'location' => 'nullable|string|max:255',
        'url' => 'nullable|url',
    ]);

    $event->update($request->all());

    return redirect()->route('events.index')
        ->with('success', 'Үйл явдал амжилттай шинэчлэгдлээ!');
}

public function destroy(EventModel $event)
{
    $event->delete();
    return redirect()->route('events.index')->with('success', 'Үйл явдал устгагдлаа!');
}

}
