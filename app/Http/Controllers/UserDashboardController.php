<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Professional;
use App\Models\Topic;
use App\Models\Reply;
use App\Models\Like;
use App\Models\AiRecommendation;
use App\Models\VrContentSuggestion;

class UserDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user dashboard main page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $isProfessional = $user->professional ? true : false;

        // Get user health stats
        $bmiData = null;
        if ($profile && $profile->height && $profile->weight) {
            $heightInMeters = $profile->height / 100;
            $bmiData = [
                'value' => round($profile->weight / ($heightInMeters * $heightInMeters), 1),
                'category' => $this->getBmiCategory($profile->weight / ($heightInMeters * $heightInMeters))
            ];
        }

        // Get user's topics and replies counts
        $topicsCount = $user->topics()->count();
        $repliesCount = $user->replies()->count();

        // Get AI recommendations if any
        $aiRecommendations = $profile ? $profile->aiRecommendations()->latest()->first() : null;

        // Get forums activity - latest topics with most interactions
        $latestTopics = Topic::with('user', 'category')
                            ->withCount('replies')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Get user's VR content suggestions if any
        $vrSuggestions = $user->vrContentSuggestions()
                              ->orderBy('created_at', 'desc')
                              ->get();

        return view('profile.dashboard.index', compact(
            'user',
            'profile',
            'isProfessional',
            'bmiData',
            'topicsCount',
            'repliesCount',
            'aiRecommendations',
            'latestTopics',
            'vrSuggestions'
        ));
    }

    /**
     * Display the profile edit form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editProfile()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = new UserProfile();
            $profile->user_id = $user->id;
            $profile->save();
        }

        return view('dashboard.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate user data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Update user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Validate profile data
        $request->validate([
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'height' => 'nullable|integer|min:50|max:300',
            'weight' => 'nullable|numeric|min:20|max:500',
            'is_smoker' => 'nullable|boolean',
            'has_chronic_conditions' => 'nullable|boolean',
            'medical_history' => 'nullable|string',
            'profile_pic' => 'nullable|image|max:2048',
        ]);

        // Update or create profile
        $profile = $user->profile ?? new UserProfile();
        $profile->user_id = $user->id;
        $profile->birth_date = $request->birth_date;
        $profile->gender = $request->gender;
        $profile->height = $request->height;
        $profile->weight = $request->weight;
        $profile->is_smoker = $request->boolean('is_smoker');
        $profile->has_chronic_conditions = $request->boolean('has_chronic_conditions');
        $profile->medical_history = $request->medical_history;

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $profile->profile_pic = $path;
        }

        $profile->save();

        // Generate AI recommendations based on new profile data
        if ($profile->height && $profile->weight) {
            $this->generateAiRecommendations($profile);
        }

        return redirect()->route('dashboard.profile.edit')
                         ->with('success', 'Profile updated successfully');
    }

    /**
     * Display the user's topics.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function topics()
    {
        $user = Auth::user();
        $topics = $user->topics()
                     ->with('category')
                     ->withCount('replies')
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);

        return view('profile.dashboard.topics.index', compact('topics'));
    }

    /**
     * Display the user's replies.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function replies()
    {
        $user = Auth::user();
        $replies = $user->replies()
                      ->with('topic')
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('profile.dashboard.replies.index', compact('replies'));
    }

    /**
     * Display professional verification form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function professionalForm()
    {
        $user = Auth::user();
        $professional = $user->professional;

        return view('profile.dashboard.professional.form', compact('professional'));
    }

    /**
     * Save or update professional information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveProfessional(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'specialization' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'certification' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bio' => 'nullable|string',
        ]);

        $professional = $user->professional ?? new Professional();
        $professional->user_id = $user->id;
        $professional->specialization = $request->specialization;
        $professional->qualification = $request->qualification;
        $professional->bio = $request->bio;

        if ($request->hasFile('certification')) {
            $path = $request->file('certification')->store('certifications', 'public');
            $professional->certification = $path;
        }

        $professional->save();

        return redirect()->route('dashboard.professional.form')
                         ->with('success', 'Professional information submitted successfully. Our team will review your application.');
    }

    /**
     * Show the VR content suggestion form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function vrSuggestionForm()
    {
        $categories = \App\Models\Category::all();
        return view('dashboard.vr.create', compact('categories'));
    }

    /**
     * Save a new VR content suggestion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveVrSuggestion(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sketchfab_uid' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $suggestion = new VrContentSuggestion();
        $suggestion->user_id = Auth::id();
        $suggestion->title = $request->title;
        $suggestion->description = $request->description;
        $suggestion->sketchfab_uid = $request->sketchfab_uid;
        $suggestion->category_id = $request->category_id;
        $suggestion->save();

        return redirect()->route('dashboard.vr.index')
                         ->with('success', 'VR content suggestion submitted successfully');
    }

    /**
     * List user's VR content suggestions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function vrSuggestions()
    {
        $suggestions = Auth::user()->vrContentSuggestions()
                               ->with('category')
                               ->orderBy('created_at', 'desc')
                               ->paginate(10);
                            //    dd($suggestions);

        return view('profile.dashboard.vr.index', compact('suggestions'));
        // C:\Users\user\healthinfo\resources\views\profile\dashboard\vr\index.blade.php
    }

    /**
     * Generate AI health recommendations based on user profile.
     *
     * @param  \App\Models\UserProfile  $profile
     * @return void
     */
    private function generateAiRecommendations(UserProfile $profile)
    {
        // Calculate BMI
        $heightInMeters = $profile->height / 100;
        $bmi = $profile->weight / ($heightInMeters * $heightInMeters);
        $bmiCategory = $this->getBmiCategory($bmi);

        // Generate health insights based on profile data
        $insights = "Based on your profile data:\n\n";

        // BMI recommendations
        $insights .= "- Your BMI is " . round($bmi, 1) . " which falls into the '{$bmiCategory}' category.\n";

        if ($bmiCategory === 'Underweight') {
            $insights .= "  Consider consulting a nutritionist about a healthy weight gain plan.\n";
        } elseif ($bmiCategory === 'Overweight' || $bmiCategory === 'Obese') {
            $insights .= "  Consider gradually increasing physical activity and reviewing your diet with a healthcare professional.\n";
        } else {
            $insights .= "  Your weight appears to be in a healthy range. Maintain your healthy habits.\n";
        }

        // Smoking recommendations
        if ($profile->is_smoker) {
            $insights .= "- As a smoker, you could significantly improve your health by quitting. Consider exploring smoking cessation programs.\n";
        }

        // Chronic conditions note
        if ($profile->has_chronic_conditions) {
            $insights .= "- With chronic conditions, regular check-ups with your healthcare provider are important for monitoring your health.\n";
        }

        // Age-based recommendations
        if ($profile->birth_date) {
            $age = date_diff(date_create($profile->birth_date), date_create('now'))->y;

            if ($age < 18) {
                $insights .= "- As a young person, focus on developing healthy habits that will benefit you throughout your life.\n";
            } elseif ($age >= 18 && $age < 40) {
                $insights .= "- At your age, regular exercise and preventive health measures are important for long-term health maintenance.\n";
            } elseif ($age >= 40 && $age < 65) {
                $insights .= "- Consider regular health screenings appropriate for your age group, such as blood pressure, cholesterol, and cancer screenings.\n";
            } else {
                $insights .= "- Regular health check-ups are particularly important at your age. Consider discussing bone density, vision, and hearing tests with your doctor.\n";
            }
        }

        // Save the AI recommendation
        $recommendation = new AiRecommendation();
        $recommendation->user_profile_id = $profile->id;
        $recommendation->insights = $insights;
        $recommendation->save();
    }

    /**
     * Get BMI category based on BMI value.
     *
     * @param  float  $bmi
     * @return string
     */
    private function getBmiCategory($bmi)
    {
        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'Normal weight';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }
}
