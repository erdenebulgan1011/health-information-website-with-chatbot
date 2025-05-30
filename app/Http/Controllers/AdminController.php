<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Topic;
use App\Models\Disease;
use App\Models\Reply;
use App\Models\VrContent;
use App\Models\Event;
use App\Models\Category;
use App\Models\VrContentSuggestion;
use App\Models\AiRecommendation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // public function dashboard()
    // {
    //     // Key statistics
    //     $totalUsers = User::count();
    //     $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
    //     $totalDiseases = Disease::count();
    //     $totalVrContents = VrContent::count();
    //     $upcomingEvents = Event::where('start_time', '>', now())->orderBy('start_time')->take(5)->get();
    //     $pendingSuggestions = VrContentSuggestion::where('status', 'pending')->count();

    //     // Recent activities
    //     $recentTopics = Topic::with('user')->latest()->take(5)->get();
    //     $recentReplies = Reply::with('user')->latest()->take(5)->get();
    //     $recentUsers = User::latest()->take(5)->get();

    //     // Chart data
    //     $userGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
    //         ->where('created_at', '>=', now()->subDays(30))
    //         ->groupBy('date')
    //         ->orderBy('date')
    //         ->pluck('count', 'date');

    //     $vrContentsByCategory = Category::withCount('vrContents')->get();

    //     return view('adminDashboard', compact(
    //         'totalUsers', 'newUsers', 'totalDiseases', 'totalVrContents',
    //         'upcomingEvents', 'pendingSuggestions', 'recentTopics',
    //         'recentReplies', 'recentUsers', 'userGrowth', 'vrContentsByCategory'
    //     ));
    // }
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
        public function dashboard()
    {
        // Key Statistics
        $userCount = User::count();
        $vrContentCount = VrContent::count();
        $eventCount = Event::count();
        $topicCount = Topic::count();

        // Recent Activities
        $recentUsers = User::latest()->take(5)->get();
        $recentEvents = Event::latest()->take(5)->get();

        // User Registration Chart Data (Last 6 Months)
        $userRegistrationData = $this->getUserRegistrationData();
        $userRegistrationLabels = array_keys($userRegistrationData);
        $userRegistrationData = array_values($userRegistrationData);

        // VR Content Uploads Chart Data (Last 6 Months)
        $vrContentData = $this->getVrContentUploadData();
        $vrContentLabels = array_keys($vrContentData);
        $vrContentData = array_values($vrContentData);

        // Activity Insights
        $activityInsights = $this->getActivityInsights();

        return view('adminDashboard', [
            // Statistics
            'userCount' => $userCount,
            'vrContentCount' => $vrContentCount,
            'eventCount' => $eventCount,
            'topicCount' => $topicCount,

            // Recent Activities
            'recentUsers' => $recentUsers,
            'recentEvents' => $recentEvents,

            // Chart Data
            'userRegistrationLabels' => $userRegistrationLabels,
            'userRegistrationData' => $userRegistrationData,
            'vrContentLabels' => $vrContentLabels,
            'vrContentData' => $vrContentData,

            // Additional Insights
            'activityInsights' => $activityInsights
        ]);
    }

    /**
     * Get user registration data for the last 6 months
     * @return array
     */
    private function getUserRegistrationData()
    {
        // Get user registrations for the last 6 months
        $registrations = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

        // Fill in missing months with 0
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $months[$month] = $registrations[$month] ?? 0;
        }

        return $months;
    }

    /**
     * Get VR content upload data for the last 6 months
     * @return array
     */
    private function getVrContentUploadData()
    {
        // Get VR content uploads for the last 6 months
        $uploads = VrContent::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

        // Fill in missing months with 0
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $months[$month] = $uploads[$month] ?? 0;
        }

        return $months;
    }

    /**
     * Get comprehensive activity insights
     * @return array
     */
    private function getActivityInsights()
    {
        // Get recent users (created in the last 30 days) instead of using last_login
        $recentUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Current month's data
        $currentMonthUsers = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $currentMonthVrContent = VrContent::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        // Previous month's data
        $previousMonthUsers = User::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->where('created_at', '<', Carbon::now()->startOfMonth())
            ->count();
        $previousMonthVrContent = VrContent::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->where('created_at', '<', Carbon::now()->startOfMonth())
            ->count();

        return [
            'total_users' => User::count(),
            'recent_users' => $recentUsers, // Changed from active_users with last_login
            'total_vr_contents' => VrContent::count(),
            'total_events' => Event::count(),
            'total_topics' => Topic::count(),
            'total_categories' => Category::count(),

            // Current month statistics
            'current_month_users' => $currentMonthUsers,
            'current_month_vr_content' => $currentMonthVrContent,

            // User Growth Rate
            'user_growth_rate' => $this->calculateGrowthRate($previousMonthUsers, $currentMonthUsers),

            // VR Content Upload Growth Rate
            'vr_content_growth_rate' => $this->calculateGrowthRate($previousMonthVrContent, $currentMonthVrContent),

            // Average uploads per user
            'avg_content_per_user' => User::count() > 0 ? round(VrContent::count() / User::count(), 2) : 0,

            // Admin user percentage
            'admin_percentage' => $this->calculatePercentage(User::where('is_admin', 1)->count(), User::count()),

            // 2FA adoption rate
            '2fa_adoption_rate' => $this->calculatePercentage(User::where('google2fa_enabled', 1)->count(), User::count())
        ];
    }

    /**
     * Calculate percentage growth rate
     * @param int $oldValue
     * @param int $newValue
     * @return float
     */
    private function calculateGrowthRate($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }

        return round((($newValue - $oldValue) / $oldValue) * 100, 2);
    }

    /**
     * Calculate percentage
     * @param int $part
     * @param int $total
     * @return float
     */
    private function calculatePercentage($part, $total)
    {
        if ($total == 0) {
            return 0;
        }

        return round(($part / $total) * 100, 2);
    }

    /**
     * Export dashboard data for reporting
     */
    public function exportDashboardData()
    {
        $data = [
            'users' => $this->getUserRegistrationData(),
            'vr_contents' => $this->getVrContentUploadData(),
            'insights' => $this->getActivityInsights()
        ];

        // You can implement various export formats (CSV, Excel, PDF)
        // For now, we'll return JSON
        return response()->json($data);
    }

    public function index()
    {
        $totalUsers = User::count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;
        $usersWithProfiles = UserProfile::distinct('user_id')->count();
        $recentUsers = User::with('profile')
                          ->orderBy('created_at', 'desc')
                          ->take(10)
                          ->get();

        $usersByDate = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                           ->groupBy('date')
                           ->orderBy('date', 'desc')
                           ->take(30)
                           ->get();

        $userAgeDistribution = UserProfile::select(DB::raw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) as age'), DB::raw('count(*) as count'))
                                         ->whereNotNull('birth_date')
                                         ->groupBy('age')
                                         ->get()
                                         ->groupBy(function($item) {
                                             // Group ages into ranges
                                             if ($item->age < 18) return 'Under 18';
                                             else if ($item->age >= 18 && $item->age <= 24) return '18-24';
                                             else if ($item->age >= 25 && $item->age <= 34) return '25-34';
                                             else if ($item->age >= 35 && $item->age <= 44) return '35-44';
                                             else if ($item->age >= 45 && $item->age <= 54) return '45-54';
                                             else return '55+';
                                         })
                                         ->map(function($group) {
                                             return $group->sum('count');
                                         });

        $genderDistribution = UserProfile::whereNotNull('gender')
                                        ->select('gender', DB::raw('count(*) as count'))
                                        ->groupBy('gender')
                                        ->get();
                                            // Extract labels and counts for JavaScript
                                            $labels = $genderDistribution->pluck('gender');      // e.g. ['эр', 'эм']
                                            $counts = $genderDistribution->pluck('count');       // e.g. [13, 9]
                                            \Log::info('Original search query: ' . $genderDistribution. 'Original search query: ' . $labels.'Original search query: ' . $counts);



        $mostActiveUsers = User::withCount(['topics', 'replies'])
                              ->orderByRaw('topics_count + replies_count DESC')
                              ->take(10)
                              ->get();

        $vrContentStats = VrContentSuggestion::select('status', DB::raw('count(*) as count'))
                                           ->groupBy('status')
                                           ->get()
                                           ->pluck('count', 'status')
                                           ->toArray();

        $healthStats = [
            'smokers' => UserProfile::where('is_smoker', true)->count(),
            'with_chronic_conditions' => UserProfile::where('has_chronic_conditions', true)->count(),
            'avg_height' => UserProfile::whereNotNull('height')->avg('height'),
            'avg_weight' => UserProfile::whereNotNull('weight')->avg('weight'),
        ];

        return view('profile.admin.user.users', compact(
            'totalUsers',
            'verifiedUsers',
            'unverifiedUsers',
            'usersWithProfiles',
            'recentUsers',
            'usersByDate',
            'userAgeDistribution',
            'genderDistribution',
            'labels', 'counts',
            'mostActiveUsers',
            'vrContentStats',
            'healthStats'
        ));
    }

    /**
     * Generate detailed report for a specific user
     */
    public function show($id)
    {
        $user = User::with([
            'profile',
            'topics',
            'replies',
            'vrContentSuggestions',
        ])->findOrFail($id);

        $aiRecommendations = AiRecommendation::where('user_profile_id', $user->profile->id ?? 0)
                                           ->orderBy('created_at', 'desc')
                                           ->get();

        $topicStats = [
            'total' => $user->topics->count(),
            'views' => $user->topics->sum('views'),
            'pinned' => $user->topics->where('is_pinned', true)->count(),
            'locked' => $user->topics->where('is_locked', true)->count(),
            'avg_replies' => $user->topics->map(function($topic) {
                                return $topic->replies->count();
                            })->avg() ?? 0,
        ];

        $replyStats = [
            'total' => $user->replies->count(),
            'best_answers' => $user->replies->where('is_best_answer', true)->count(),
            'parent_replies' => $user->replies->whereNull('parent_id')->count(),
            'child_replies' => $user->replies->whereNotNull('parent_id')->count(),
        ];

        $vrContentStats = [
            'total' => $user->vrContentSuggestions ? $user->vrContentSuggestions->count() : 0,
            'pending' => $user->vrContentSuggestions ? $user->vrContentSuggestions->where('status', 'pending')->count() : 0,
            'approved' => $user->vrContentSuggestions ? $user->vrContentSuggestions->where('status', 'approved')->count() : 0,
            'rejected' => $user->vrContentSuggestions ? $user->vrContentSuggestions->where('status', 'rejected')->count() : 0,
        ];


        $activityTimeline = collect()
        ->merge(($user->topics ?? collect())->map(function($item) {
            return [
                    'type' => 'topic',
                    'slug'=> $item->slug,
                    'id' => $item->id,
                    'title' => $item->title,
                    'date' => $item->created_at,
                ];
            }))
            ->merge(($user->replies ?? collect())->map(function($item) {
                return [
                    'type' => 'reply',
                    'id' => $item->id,
                    'topic_id' => $item->topic_id,
                    'title' => $item->topic->title,
                    'slug' => $item->topic->slug ?? null,
                    'date' => $item->created_at,
                ];
            }))
            ->merge(($user->vrContentSuggestions ?? collect())->map(function($item) {
                return [
                    'type' => 'vr_suggestion',
                    'id' => $item->id,
                    'title' => $item->title,
                    'status' => $item->status,
                    'date' => $item->created_at,
                ];
            }))
            ->sortByDesc('date');

        return view('profile.admin.user.user_detail', compact(
            'user',
            'aiRecommendations',
            'topicStats',
            'replyStats',
            'vrContentStats',
            'activityTimeline'
        ));
    }

    /**
     * Generate exportable user report
     */
    public function export(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'export_type' => 'required|in:csv,pdf,excel'
        ]);

        $query = User::with('profile');

        if ($request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->where('created_at', '<=', Carbon::parse($request->to_date)->endOfDay());
        }

        // For preview
    if (!$request->has('export_type')) {
        $users = $query->paginate(15);
        return view('profile.admin.user.export-preview', [
            'users' => $users,
            'fromDate' => $request->from_date,
            'toDate' => $request->to_date
        ]);
    }
        $users = $query->get();

        // Format data for export
        $exportData = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'registered_at' => $user->created_at->format('Y-m-d H:i:s'),
                'verified' => $user->email_verified_at ? 'Yes' : 'No',
                'topics_count' => $user->topics->count(),
                'replies_count' => $user->replies->count(),
                'birth_date' => $user->profile->birth_date ?? null,
                'gender' => $user->profile->gender ?? null,
                'height' => $user->profile->height ?? null,
                'weight' => $user->profile->weight ?? null,
                'is_smoker' => $user->profile && $user->profile->is_smoker ? 'Yes' : 'No',
                'has_chronic_conditions' => $user->profile && $user->profile->has_chronic_conditions ? 'Yes' : 'No',
            ];
        });

        // Generate appropriate export based on requested type
        switch ($request->export_type) {
            case 'csv':
                return $this->exportCsv($exportData);
            case 'pdf':
                return $this->exportPdf($exportData);
            case 'excel':
                return $this->exportExcel($exportData);
        }
    }

    /**
     * Generate CSV export
     */
    protected function exportCsv($data)
    {
        $filename = 'user_report_' . date('Y-m-d') . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Add header row
            if (count($data) > 0) {
                fputcsv($file, array_keys($data[0]));
            }

            // Add data rows
            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate PDF export (requires laravel-dompdf)
     */
    // protected function exportPdf($data)
    // {
    //     // This assumes you have installed laravel-dompdf package
    //     // $pdf = \PDF::loadView('admin.reports.pdf.users', compact('data'));
    //     $pdf = PDF::loadView('profile.admin.user.usersPDF', compact('data'));
    //     return $pdf->download('user_report_' . date('Y-m-d') . '.pdf');
    // }
    protected function exportPdf($data)
{
    $pdf = PDF::loadView('profile.admin.user.users-pdf', ['data' => $data])
              ->setPaper('a4', 'landscape')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isRemoteEnabled' => true,
                  'defaultFont' => 'sans-serif',
                  'dpi' => 96,
                  'fontHeightRatio' => 1
              ]);

    return $pdf->stream('user_report_'.date('Y-m-d').'.pdf');
}

    /**
     * Generate Excel export (requires laravel-excel)
     */
    protected function exportExcel($data)
    {
        // This assumes you have installed maatwebsite/excel package
        return (new \App\Exports\UsersExport($data))->download('user_report_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Display analytics dashboard for user health data
     */
    public function healthAnalytics()
    {
        $smokersCount = UserProfile::where('is_smoker', true)->count();
        $nonSmokersCount = UserProfile::where('is_smoker', false)->whereNotNull('is_smoker')->count();

        $chronicConditionsCount = UserProfile::where('has_chronic_conditions', true)->count();
        $noChronicConditionsCount = UserProfile::where('has_chronic_conditions', false)->whereNotNull('has_chronic_conditions')->count();

        $avgHeightByGender = UserProfile::select('gender', DB::raw('AVG(height) as avg_height'))
                                       ->whereNotNull('gender')
                                       ->whereNotNull('height')
                                       ->groupBy('gender')
                                       ->get();

        $avgWeightByGender = UserProfile::select('gender', DB::raw('AVG(weight) as avg_weight'))
                                       ->whereNotNull('gender')
                                       ->whereNotNull('weight')
                                       ->groupBy('gender')
                                       ->get();

        $bmiDistribution = UserProfile::whereNotNull('height')
                                     ->whereNotNull('weight')
                                     ->select(
                                         DB::raw('user_id'),
                                         DB::raw('weight / ((height/100) * (height/100)) as bmi')
                                     )
                                     ->get()
                                     ->groupBy(function($item) {
                                         if ($item->bmi < 18.5) return 'Underweight';
                                         else if ($item->bmi >= 18.5 && $item->bmi < 25) return 'Normal';
                                         else if ($item->bmi >= 25 && $item->bmi < 30) return 'Overweight';
                                         else return 'Obese';
                                     })
                                     ->map(function($group) {
                                         return count($group);
                                     });

        return view('profile.admin.user.healthAnalytics', compact(
            'smokersCount',
            'nonSmokersCount',
            'chronicConditionsCount',
            'noChronicConditionsCount',
            'avgHeightByGender',
            'avgWeightByGender',
            'bmiDistribution'
        ));
    }

    /**
     * Display analytics dashboard for forum activity
     */
    public function forumAnalytics()
    {
        $totalTopics = Topic::count();
        $totalReplies = Reply::count();
        $avgRepliesPerTopic = $totalTopics > 0 ? $totalReplies / $totalTopics : 0;

        $topicsByCategory = Topic::select('category_id', DB::raw('count(*) as count'))
                                ->groupBy('category_id')
                                ->with('category:id,name')
                                ->get();

        $topicsByMonth = Topic::select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                             ->groupBy('year', 'month')
                             ->orderBy('year', 'desc')
                             ->orderBy('month', 'desc')
                             ->take(12)
                             ->get();

        $topViewedTopics = Topic::orderBy('views', 'desc')
                               ->take(10)
                               ->with('user:id,name')
                               ->get();

        $bestAnswerUsers = User::withCount(['replies' => function($query) {
                                   $query->where('is_best_answer', true);
                               }])
                               ->orderBy('replies_count', 'desc')
                               ->take(10)
                               ->get();
                               $monthNames = [
                                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                            ];

        return view('profile.admin.user.forum_Analytics', compact(
            'totalTopics',
            'totalReplies',
            'avgRepliesPerTopic',
            'topicsByCategory',
            'topicsByMonth',
            'topViewedTopics',
            'bestAnswerUsers',
            'monthNames'
        ));
    }

    /**
     * Display VR content suggestions analytics
     */
    public function vrContentAnalytics()
    {
        $statusCounts = VrContentSuggestion::select('status', DB::raw('count(*) as count'))
                                          ->groupBy('status')
                                          ->get();

        $categoryDistribution = VrContentSuggestion::select('category_id', DB::raw('count(*) as count'))
                                                  ->groupBy('category_id')
                                                  ->with('category:id,title')
                                                  ->get();

        $topContributors = User::withCount('vrContentSuggestions')
                              ->orderBy('vr_content_suggestions_count', 'desc')
                              ->take(10)
                              ->get();

        $monthlySubmissions = VrContentSuggestion::select(
                                                DB::raw('YEAR(created_at) as year'),
                                                DB::raw('MONTH(created_at) as month'),
                                                DB::raw('count(*) as count')
                                             )
                                             ->groupBy('year', 'month')
                                             ->orderBy('year', 'desc')
                                             ->orderBy('month', 'desc')
                                             ->take(12)
                                             ->get();

        $approvalRateByMonth = VrContentSuggestion::select(
                                                 DB::raw('YEAR(created_at) as year'),
                                                 DB::raw('MONTH(created_at) as month'),
                                                 DB::raw('count(*) as total'),
                                                 DB::raw('SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved')
                                              )
                                              ->where('status', '!=', 'pending')
                                              ->groupBy('year', 'month')
                                              ->orderBy('year', 'desc')
                                              ->orderBy('month', 'desc')
                                              ->take(12)
                                              ->get()
                                              ->map(function($item) {
                                                  $item->rate = $item->total > 0 ? round(($item->approved / $item->total) * 100, 2) : 0;
                                                  return $item;
                                              });

        return view('admin.reports.user.vr_content_analytics', compact(
            'statusCounts',
            'categoryDistribution',
            'topContributors',
            'monthlySubmissions',
            'approvalRateByMonth'
        ));
    }

    /**
     * AI recommendations analytics
     */
    public function aiRecommendationsAnalytics()
    {
        $totalRecommendations = AiRecommendation::count();

        $recommendationsPerUser = UserProfile::withCount('aiRecommendations')
                                           ->orderBy('ai_recommendations_count', 'desc')
                                           ->take(10)
                                           ->with('user:id,name')
                                           ->get();

        $recommendationsByMonth = AiRecommendation::select(
                                                  DB::raw('YEAR(created_at) as year'),
                                                  DB::raw('MONTH(created_at) as month'),
                                                  DB::raw('count(*) as count')
                                               )
                                               ->groupBy('year', 'month')
                                               ->orderBy('year', 'desc')
                                               ->orderBy('month', 'desc')
                                               ->take(12)
                                               ->get();

        return view('admin.reports.ai_recommendations_analytics', compact(
            'totalRecommendations',
            'recommendationsPerUser',
            'recommendationsByMonth'
        ));
    }

}
