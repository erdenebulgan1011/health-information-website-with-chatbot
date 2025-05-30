<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Http\Controllers\HealthRecommendationService;
use App\Models\AiRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HealthDashboardController extends Controller
{
    protected $healthService;

    public function __construct(HealthRecommendationService $healthService)
    {
        $this->healthService = $healthService;
        $this->middleware('auth');
    }

    /**
     * Show the user's health dashboard with personalized recommendations
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.create')->with('message', 'Эхлээд эрүүл мэндийн мэдээллээ бөглөнө үү.');
        }

        // Calculate health metrics
        $metrics = $this->healthService->calculateHealthMetrics($profile);

        // Generate recommendations
        $recommendations = $this->healthService->generateRecommendations($profile);
        // 2) If no saved AI insights yet, generate & save them now
    // Only fetch—do NOT create here
        return view('profile.health.dashboard', compact(
            'user', 'profile', 'metrics', 'recommendations',
        ));
    }
    public function regenerateAiInsights()
{
    $profile = Auth::user()->profile;

    $aiResult = $this->healthService->getAIInsights($profile);
    if ($aiResult['success']) {
        // Save new record
        AiRecommendation::create([
            'user_profile_id' => $profile->id,
            'insights'        => $aiResult['insights'],
        ]);
    }

    return redirect()->route('health.dashboard')
                     ->with('success', $aiResult['success']
                         ? 'AI insights updated!'
                         : 'Failed to regenerate insights.');
}
public function generateAiInsights()
{
    $profile  = Auth::user()->profile;

    // 1) If an AI recommendation already exists for this profile, abort
    if ($profile->aiRecommendations()->exists()) {
        session()->flash('info', 'AI insights already generated.');
        return redirect()->route('health.dashboard');
    }

    // 2) Otherwise, generate new insights
    $aiResult = $this->healthService->getAIInsights($profile);

    if ($aiResult['success']) {
        AiRecommendation::create([
            'user_profile_id' => $profile->id,
            'insights'        => $aiResult['insights'],
        ]);
        session()->flash('success', 'AI insights generated!');
    } else {
        session()->flash('error', $aiResult['message']);
    }

    // 3) Redirect (PRG) to avoid duplicate on refresh
    return redirect()->route('health.dashboard');
}



    /**
     * Show form to create or update profile
     */
    public function editProfile()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('profile.health.profile', compact('user', 'profile'));
    }

    /**
     * Save or update profile information
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'birth_date' => 'nullable|date|before_or_equal:today',
            'gender' => 'nullable|string|in:male,female,other',
            'height' => 'nullable|numeric|min:50|max:250', // height in cm
            'weight' => 'nullable|numeric|min:30|max:500', // weight in kg
            'is_smoker' => 'nullable|boolean',
            'has_chronic_conditions' => 'nullable|boolean',
            'medical_history' => 'nullable|string|max:1000',
            'profile_pic' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $validated['profile_pic'] = $path;
        }

        // Create or update profile
        if ($user->profile) {
            $user->profile->update($validated);
        } else {
            $user->profile()->create($validated);
        }

        return redirect()->route('health.dashboard')->with('success', 'Profile updated successfully.');
    }

    /**
     * Generate detailed health report
     */
    public function generateReport()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.create')->with('message', 'Эхлээд эрүүл мэндийн мэдээллээ бөглөнө үү.');
        }

        // Calculate metrics and recommendations
        $metrics = $this->healthService->calculateHealthMetrics($profile);
        $recommendations = $this->healthService->generateRecommendations($profile);

        // Add report generation date
        $reportDate = Carbon::now()->format('F d, Y');

        return view('profile.health.report', compact('user', 'profile', 'metrics', 'recommendations', 'reportDate'));
    }

    /**
     * Show physical activity recommendations
     */
    public function physicalActivity()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.create')->with('message', 'Эхлээд эрүүл мэндийн мэдээллээ бөглөнө үү.');
        }

        $metrics = $this->healthService->calculateHealthMetrics($profile);
        $recommendations = $this->healthService->generateRecommendations($profile);

        return view('profile.health.physical_activity', compact('user', 'profile', 'metrics', 'recommendations'));
    }

    /**
     * Show risk factors analysis
     */
    public function riskFactors()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.create')->with('message', 'Эхлээд эрүүл мэндийн мэдээллээ бөглөнө үү.');
        }

        $metrics = $this->healthService->calculateHealthMetrics($profile);
        $recommendations = $this->healthService->generateRecommendations($profile);

        return view('profile.health.risk_factors', compact('user', 'profile', 'metrics', 'recommendations'));
    }

    /**
     * Show AI-powered health insights
     */
    public function aiInsights()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.create')->with('message', 'Эхлээд эрүүл мэндийн мэдээллээ бөглөнө үү.');
        }

        $metrics = $this->healthService->calculateHealthMetrics($profile);
        $recommendations = $this->healthService->generateRecommendations($profile);

        return view('profile.health.ai_insights', compact('user', 'profile', 'metrics', 'recommendations'));
    }
}
