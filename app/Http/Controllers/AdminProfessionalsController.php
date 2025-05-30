<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DoctorInfo;
use App\Models\Professional;
use App\Models\Reply;
use App\Models\VrContentSuggestion;
use App\Models\AiRecommendation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


class AdminProfessionalsController extends Controller
{
        /**
     * Display a listing of professionals with statistics
     */
    public function index()
    {
        // General statistics
        $totalProfessionals = Professional::count();
        $verifiedProfessionals = Professional::where('is_verified', true)->count();
        $unverifiedProfessionals = $totalProfessionals - $verifiedProfessionals;
        $professionalUsers = Professional::with('user')->get();
        $doctorCount = DoctorInfo::count();

        // Recent professionals
        $recentProfessionals = Professional::with(['user', 'user.profile', 'doctorInfo'])
                            ->orderBy('created_at', 'desc')
                            ->take(10)
                            ->get();

        // Professionals by date
        $professionalsByDate = Professional::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                             ->groupBy('date')
                             ->orderBy('date', 'desc')
                             ->take(30)
                             ->get();

        // Specialization distribution
        $specializationDistribution = Professional::select('specialization', DB::raw('count(*) as count'))
                                    ->groupBy('specialization')
                                    ->orderBy('count', 'desc')
                                    ->get();

        // Extract labels and counts for JavaScript charts
        $specLabels = $specializationDistribution->pluck('specialization');
        $specCounts = $specializationDistribution->pluck('count');

        // Verification rate by specialization
        $verificationBySpecialization = Professional::select('specialization',
                                        DB::raw('COUNT(*) as total'),
                                        DB::raw('SUM(CASE WHEN is_verified = 1 THEN 1 ELSE 0 END) as verified'),
                                        DB::raw('SUM(CASE WHEN is_verified = 0 THEN 1 ELSE 0 END) as unverified'))
                                      ->groupBy('specialization')
                                      ->get();

        // VR content statistics for professionals
        $vrContentByProfessionals = VrContentSuggestion::whereIn('user_id', Professional::join('users', 'professionals.user_id', '=', 'users.id')
                                                                ->select('users.id'))
                                                    ->select('status', DB::raw('count(*) as count'))
                                                    ->groupBy('status')
                                                    ->get()
                                                    ->pluck('count', 'status')
                                                    ->toArray();

        // Most active professionals
        $mostActiveProfessionals = User::whereIn('id', Professional::select('user_id'))
                                    ->withCount(['topics', 'replies'])
                                    ->orderByRaw('topics_count + replies_count DESC')
                                    ->take(10)
                                    ->with('professional')
                                    ->get();

        // Doctor statistics
        $doctorStats = [
            'total' => $doctorCount,
            'avg_experience' => DoctorInfo::whereNotNull('years_experience')->avg('years_experience'),
            'by_workplace' => DoctorInfo::select('workplace', DB::raw('count(*) as count'))
                                      ->whereNotNull('workplace')
                                      ->groupBy('workplace')
                                      ->orderBy('count', 'desc')
                                      ->take(5)
                                      ->get(),
            'language_distribution' => DoctorInfo::whereNotNull('languages')
                                              ->get()
                                              ->flatMap(function($doctor) {
                                                  return explode(',', $doctor->languages);
                                              })
                                              ->map(function($language) {
                                                  return trim($language);
                                              })
                                              ->countBy()
                                              ->sortDesc()
                                              ->take(5),
        ];

        // Qualification distribution
        $qualificationDistribution = Professional::select('qualification', DB::raw('count(*) as count'))
                                    ->groupBy('qualification')
                                    ->orderBy('count', 'desc')
                                    ->get();

        return view('profile.admin.professionals.professionals', compact(
            'totalProfessionals',
            'verifiedProfessionals',
            'unverifiedProfessionals',
            'recentProfessionals',
            'professionalsByDate',
            'specializationDistribution',
            'specLabels',
            'specCounts',
            'verificationBySpecialization',
            'vrContentByProfessionals',
            'mostActiveProfessionals',
            'doctorStats',
            'qualificationDistribution'
        ));
    }

    /**
     * Generate detailed report for a specific professional
     */
    public function show($id)
    {
        $professional = Professional::with([
            'user',
            'user.profile',
            'doctorInfo',
            'user.topics',
            'user.replies',
            'user.vrContentSuggestions',
        ])->findOrFail($id);

        $user = $professional->user;

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

        // Professional-specific information
        $profStats = [
            'specialization' => $professional->specialization,
            'qualification' => $professional->qualification,
            'is_verified' => $professional->is_verified,
            'has_certification' => !empty($professional->certification),
            'is_doctor' => $professional->doctorInfo()->exists(),
        ];

        // Doctor-specific information if applicable
        $doctorStats = null;
        if ($professional->doctorInfo) {
            $doctorStats = [
                'workplace' => $professional->doctorInfo->workplace,
                'experience' => $professional->doctorInfo->years_experience,
                'education' => $professional->doctorInfo->education,
                'languages' => $professional->doctorInfo->languages,
            ];
        }

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

        return view('profile.admin.professionals.professional_detail', compact(
            'professional',
            'user',
            'topicStats',
            'replyStats',
            'vrContentStats',
            'profStats',
            'doctorStats',
            'activityTimeline'
        ));
    }
    /**
     * Generate a printer-friendly version of professional report
     */
    public function print($id)
    {
        $professional = Professional::with([
            'user',
            'user.profile',
            'doctorInfo',
            'user.topics',
            'user.replies',
            'user.vrContentSuggestions',
        ])->findOrFail($id);

        $user = $professional->user;

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

        // Professional-specific information
        $profStats = [
            'specialization' => $professional->specialization,
            'qualification' => $professional->qualification,
            'is_verified' => $professional->is_verified,
            'has_certification' => !empty($professional->certification),
            'is_doctor' => $professional->doctorInfo()->exists(),
        ];

        // Doctor-specific information if applicable
        $doctorStats = null;
        if ($professional->doctorInfo) {
            $doctorStats = [
                'workplace' => $professional->doctorInfo->workplace,
                'experience' => $professional->doctorInfo->years_experience,
                'education' => $professional->doctorInfo->education,
                'languages' => $professional->doctorInfo->languages,
            ];
        }

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

        return view('profile.admin.professionals.professional_print', compact(
            'professional',
            'user',
            'topicStats',
            'replyStats',
            'vrContentStats',
            'profStats',
            'doctorStats',
            'activityTimeline'
        ));
    }
    public function downloadCertification($id)
    {
        $professional = Professional::findOrFail($id);

        // Check if the certification exists
        if (!$professional->certification) {
            return back()->with('error', 'No certification file found.');
        }

        // Check if the file exists in storage
        if (!Storage::disk('public')->exists($professional->certification)) {
            return back()->with('error', 'Certification file not found.');
        }

        // Return the file as a download
        return Storage::disk('public')->download($professional->certification);
    }
    /**
 * Display the certification file in browser
 */
public function showCertification($id)
{
    $professional = Professional::findOrFail($id);

    // Check if the certification exists
    if (!$professional->certification) {
        return back()->with('error', 'No certification file found.');
    }

    // Check if the file exists in storage
    if (!Storage::disk('public')->exists($professional->certification)) {
        return back()->with('error', 'Certification file not found.');
    }

    // Get file content
    $fileContent = Storage::disk('public')->get($professional->certification);

    // Get mime type
    $mimeType = Storage::disk('public')->mimeType($professional->certification);

    // Return file content with appropriate headers for viewing in browser
    return response($fileContent)
        ->header('Content-Type', $mimeType)
        ->header('Content-Disposition', 'inline; filename="' . basename($professional->certification) . '"');
}



    /**
     * Export professionals data to CSV/Excel
     */
    public function export(Request $request)
    {
        // Get filter parameters from request
        $specialization = $request->input('specialization');
        $verified = $request->input('verified');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base query
        $query = Professional::with(['user', 'user.profile', 'doctorInfo']);

        // Apply filters
        if ($specialization) {
            $query->where('specialization', $specialization);
        }

        if ($verified !== null) {
            $query->where('is_verified', $verified);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Get professionals data
        $professionals = $query->get();

        // Prepare data for export
        $exportData = [];
        foreach ($professionals as $professional) {
            $user = $professional->user;
            $profile = $user->profile;
            $doctorInfo = $professional->doctorInfo;

            $exportData[] = [
                'ID' => $professional->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Specialization' => $professional->specialization,
                'Qualification' => $professional->qualification,
                'Verified' => $professional->is_verified ? 'Yes' : 'No',
                'Registration Date' => $professional->created_at->format('Y-m-d'),
                'Is Doctor' => $doctorInfo ? 'Yes' : 'No',
                'Workplace' => $doctorInfo ? $doctorInfo->workplace : 'N/A',
                'Experience (Years)' => $doctorInfo ? $doctorInfo->years_experience : 'N/A',
                'Topics Count' => $user->topics ? $user->topics->count() : 0,
                'Replies Count' => $user->replies ? $user->replies->count() : 0,
                'VR Content Count' => $user->vrContentSuggestions ? $user->vrContentSuggestions->count() : 0,
            ];
        }

        // Generate filename
        $filename = 'professionals_report_' . date('Y-m-d_His') . '.csv';

        // Create CSV file
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($exportData) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, array_keys($exportData[0] ?? []));

            // Add data rows
            foreach ($exportData as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
