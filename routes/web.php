<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\VRContentController;
use App\Http\Controllers\VRUserContentController;

use App\Http\Controllers\HealthInfoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\api\SketchfabController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MentalHealthController;
use App\Http\Controllers\Physical;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Forum\ReplyController;
use App\Http\Controllers\Forum\TopicController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\HealthDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProfessionalsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;


Route::get('/', function () {
    return view('welcome');
});

// Guest routes (accessible only when not authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

        Route::get('/password-reset-success', [NewPasswordController::class, 'success'])
        ->name('password.success');
});
// In routes/web.php (temporary, remove after testing)
// Route::get('/test-email', function () {
//     try {
//         Mail::raw('Test email from Laravel Breeze + Mailgun', function ($message) {
//             $message->to('your-test-email@example.com')
//                     ->subject('Test Email');
//         });
//         return 'Email sent successfully!';
//     } catch (Exception $e) {
//         return 'Error: ' . $e->getMessage();
//     }
// });

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('vr-content.user.home');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';
// 2FA Routes
// Route::get('/reset-2fa', function () {
//     if (!Auth::check()) {
//         return redirect()->route('login')->withErrors(['auth' => 'Please login first']);
//     }

//     $user = Auth::user();

//     // Reset 2FA settings
//     DB::table('users')
//         ->where('id', $user->id)
//         ->update([
//             'google2fa_secret' => null,
//             'google2fa_enabled' => false
//         ]);

//     // Clear verification status
//     session()->forget('2fa_verified');

//     return redirect()->route('profile')->with('status', [
//         'type' => 'success',
//         'message' => 'Two-factor authentication has been reset. You can now set it up again.'
//     ]);
// })->middleware('auth')->name('2fa.reset');
Route::group(['middleware' => ['auth'], 'prefix' => '2fa'], function () {
    Route::get('/setup', [App\Http\Controllers\Google2FAController::class, 'setup'])->name('2fa.setup');

    Route::post('/enable', [App\Http\Controllers\Google2FAController::class, 'enable'])->name('2fa.enable');
    Route::get('/disable', function () {
        return view('auth.2fa.disable');
    })->name('2fa.disable.form');
    Route::post('/disable', [App\Http\Controllers\Google2FAController::class, 'disable'])->name('2fa.disable');
    Route::get('/verify', [App\Http\Controllers\Google2FAController::class, 'verify'])->name('2fa.verify');
    Route::post('/verify', [App\Http\Controllers\Google2FAController::class, 'validateCode'])->name('2fa.validate');
});
Route::get('/2fa/diagnose', [App\Http\Controllers\Google2FAController::class, 'diagnose'])
    ->middleware(['auth'])
    ->name('2fa.diagnose');
// Protected routes - add the 2FA middleware to routes that need protection
Route::group(['middleware' => ['auth', '2fa']], function () {

    // Add other routes that need 2FA protection here
Route::get('/dashboard', [UserDashboardController::class, 'index'])
     ->name('dashboard');
// // Dashboard Main Routes
Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    // Health Topics & Replies Routes
    Route::get('/topics', [UserDashboardController::class, 'topics'])->name('topics');
    Route::get('/replies', [UserDashboardController::class, 'replies'])->name('replies');

    // Professional Routes
    Route::get('/professional', [UserDashboardController::class, 'professionalForm'])->name('professional.form');
    Route::post('/professional', [UserDashboardController::class, 'saveProfessional'])->name('professional.save');

    // VR Content Suggestion Routes
    Route::get('/vr-suggestions', [UserDashboardController::class, 'vrSuggestions'])->name('vr.index');
    Route::get('/vr-suggestions/create', [UserDashboardController::class, 'vrSuggestionForm'])->name('vr.create');
    Route::post('/vr-suggestions', [UserDashboardController::class, 'saveVrSuggestion'])->name('vr.save');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/remove-pic', [ProfileController::class, 'removeProfilePic'])->name('profile.remove-pic');
});
Route::middleware(['auth'])->group(function () {
            // View doctor profile - if no ID is provided, shows the current user's profile
            Route::get('/doctor/profile/{id?}', [ProfessionalController::class, 'showProfile'])->name('doctor.profile');
            // Edit doctor profile - only accessible by the doctor themselves
            Route::get('/doctor/edit', [ProfessionalController::class, 'edit'])->name('doctor.edit');
                Route::put('/doctor/update', [ProfessionalController::class, 'updateInfo'])->name('doctor.update');
                // List all verified doctors
                Route::get('/doctors', [ProfessionalController::class, 'listDoctors'])->name('doctor.list');

                Route::get('/doctor-info/create', [ProfessionalController::class, 'createInfo'])->name('doctor-info.create');
                Route::post('/doctor-info', [ProfessionalController::class, 'storeInfo'])->name('doctor-info.store');
});

});







Route::prefix('forum')->name('topics.')->group(function () {
    Route::get('/', [TopicController::class, 'index'])->name('index');
    // Route::get('/search', [TopicController::class, 'search'])->name('search');
    Route::get('/create', [TopicController::class, 'create'])->name('create');
    Route::post('/store', [TopicController::class, 'store'])->name('store');
    Route::get('/{topic}', [TopicController::class, 'show'])->name('show');
    Route::get('/{topic}/edit', [TopicController::class, 'edit'])->name('edit');
    Route::put('/{topic}', [TopicController::class, 'update'])->name('update');
    Route::delete('/{topic}', [TopicController::class, 'destroy'])->name('destroy');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Topics
    Route::get('/topics', [TopicController::class, 'indexAdmin'])->name('topics.index');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'editAdmin'])->name('topics.edit');
    Route::put('/topics/{topic}', [TopicController::class, 'updateAdmin'])->name('topics.update');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');
    Route::post('/topics/{topic}/toggle-pin', [TopicController::class, 'togglePin'])->name('topics.toggle-pin');
    Route::post('/topics/{topic}/toggle-lock', [TopicController::class, 'toggleLock'])->name('topics.toggle-lock');

    // Replies
    Route::get('/topics/{topic}/replies', [ReplyController::class, 'topicReplies'])->name('replies.index');
    Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');
    Route::post('/replies/{reply}/best', [ReplyController::class, 'markAsBest'])->name('replies.best');
});
Route::middleware(['auth', 'admin'])->prefix('replies')->name('replies.')->group(function () {
    Route::post('/{topic}', [ReplyController::class, 'store'])->name('store');
    Route::put('/{reply}', [ReplyController::class, 'update'])->name('update');
    Route::post('/{reply}/best', [ReplyController::class, 'markAsBest'])->name('markAsBest');
});
Route::get('/category', [CategoryController::class, 'indexALL'])->name('category.index');
Route::get('/category/{slug}', [CategoryController::class, 'showALL'])->name('category.shows');





Route::get('/diseases', [DiseaseController::class, 'index'])->name('diseases.index');
Route::get('/diseases/search', [DiseaseController::class, 'search'])->name('diseases.search');

Route::get('/diseases/{id}', [DiseaseController::class, 'show'])->name('diseases.show');


Route::get('/health', [HealthInfoController::class, 'index'])->name('home');
Route::get('/health-topics', [HealthInfoController::class, 'topics'])->name('health.topics');
Route::get('/health-topic/{slug}', [HealthInfoController::class, 'show'])->name('health.show');



use App\Http\Controllers\DiseaseController as AdminDiseaseController;
use App\Http\Controllers\PhysicalTest;

Route::middleware(['auth', 'admin'])->get('/admindiseases/data', [DiseaseController::class, 'getDiseases'])->name('admin.diseases.data');
Route::middleware(['auth', 'admin'])->get('/admindiseases', [AdminDiseaseController::class, 'Adminindex'])->name('admin.diseases.index');
Route::middleware(['auth', 'admin'])->get('/admindiseases/create', [AdminDiseaseController::class, 'create'])->name('admin.diseases.create');
Route::middleware(['auth', 'admin'])->post('/admindiseases', [AdminDiseaseController::class, 'store'])->name('admin.diseases.store');
Route::middleware(['auth', 'admin'])->get('/admindiseases/{id}/edit', [AdminDiseaseController::class, 'edit'])->name('admin.diseases.edit');
Route::middleware(['auth', 'admin'])->put('/admindiseases/{id}', [AdminDiseaseController::class, 'update'])->name('admin.diseases.update');
Route::middleware(['auth', 'admin'])->delete('/admindiseases/{id}', [AdminDiseaseController::class, 'destroy'])->name('admin.diseases.destroy');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Ангиллын routes
// Админ панел
Route::middleware(['auth', 'admin'])->get('/categories/{slug}/items', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.showItems');
Route::middleware(['auth', 'admin'])->prefix('admincategories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'adminCreate'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'adminStore'])->name('categories.store');
    // Route::get('/{slug}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('vr/{id}', [CategoryController::class, 'showVR'])->name('category.vr-content.shows');
        // Admin Routes for Editing and Deleting
        Route::get('/edit/{id}', [CategoryController::class, 'adminEdit'])->name('categories.edit');
        Route::put('/update/{id}', [CategoryController::class, 'adminUpdate'])->name('categories.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'adminDestroy'])->name('categories.destroy');

});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // User Reports
    Route::get('/userReport', [AdminController::class, 'index'])->name('admin.user');
    Route::get('/userReport/{id}', [AdminController::class, 'show'])->name('admin.user.detail');
    Route::post('/userReports', [AdminController::class, 'export'])->name('admin.user.detail.export');
    // Analytics Routes
    Route::get('/health', [AdminController::class, 'healthAnalytics'])->name('admin.analytics.health');
    Route::get('/forum', [AdminController::class, 'forumAnalytics'])->name('admin.analytics.forum');
// Professional Reports
    Route::get('/professionalsReport', [AdminProfessionalsController::class, 'index'])->name('admin.professionals.indexs');
    Route::get('/professionalsReport/{id}', [AdminProfessionalsController::class, 'show'])->name('admin.professionals.detail');
    Route::get('/professionalsReport/{id}/certification', [AdminProfessionalsController::class, 'downloadCertification'])->name('admin.professionals.certification');
    Route::get('/professionalsReport/{id}/certification/view', [AdminProfessionalsController::class, 'showCertification'])
    ->name('admin.professionals.certification.view');
    Route::get('/professionalsReport/{id}/print', [AdminProfessionalsController::class, 'print'])->name('admin.professionals.print');
    Route::post('/professionalsReport/export', [AdminProfessionalsController::class, 'export'])->name('admin.professionals.export');

    Route::get('/calendar', [EventController::class, 'calendarReport'])->name('events.calendarReport');

});
// Admin suggestion routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/vr/suggestions', [VRContentController::class, 'adminSuggestions'])->name('vr.admin.suggestions');
    Route::get('/vr/suggestions/{id}', [VRContentController::class, 'reviewSuggestion'])->name('vr.admin.reviewSuggestion');
    Route::post('/vr/suggestions/{id}/process', [VRContentController::class, 'processSuggestion'])->name('vr.admin.processSuggestion');
    // New suggestion management routes
    Route::get('/vr/suggestions/{id}/edit', [VRContentController::class, 'editSuggestion'])->name('vr.admin.suggestions.edit');
    Route::put('/vr/suggestions/{id}', [VRContentController::class, 'updateSuggestion'])->name('vr.admin.suggestions.update');
    Route::patch('/vr/suggestions/{id}/status', [VRContentController::class, 'changeStatus'])->name('vr.admin.suggestions.status');
    Route::delete('/vr/suggestions/{id}', [VRContentController::class, 'destroySuggestion'])->name('vr.admin.suggestions.destroy');
    Route::post('/vr/suggestions/bulk', [VRContentController::class, 'bulkAction'])->name('vr.admin.suggestions.bulk');
});

Route::middleware(['auth', 'admin'])->prefix('vr-content')->group(function() {
        Route::get('/', [VRContentController::class, 'index'])->name('vr.index');
        Route::get('/vr-content/{id}', [VRContentController::class, 'show'])->name('vr.show');
        Route::get('/create', [App\Http\Controllers\VRContentController::class, 'create'])->name('vr.create');
                Route::post('/', [VRContentController::class, 'store'])->name('vr.store');
                Route::get('/{id}/edit', [VRContentController::class, 'edit'])->name('vr.edit');
        Route::put('/{id}', [VRContentController::class, 'update'])->name('vr.update');
                Route::delete('/{id}', [VRContentController::class, 'destroy'])->name('vr.destroy');
                Route::get('/{id}', [VRUserContentController::class, 'showVR'])->name('vr.show');
});



Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
    // Edit event
    Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
    // Delete event
    Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

        // Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/professionals', [ProfessionalController::class, 'index'])->name('admin.professionals.index');
    Route::get('/professionals/{professional}', [ProfessionalController::class, 'show'])->name('admin.professionals.show');
    Route::put('/professionals/{professional}', [ProfessionalController::class, 'update'])->name('admin.professionals.update');
    Route::get('/professional/{professional}/download-certification', [ProfessionalController::class, 'downloadCertification'])
    ->name('professional.download-certification');
    Route::delete('/professionals/{professional}', [ProfessionalController::class, 'destroy'])
    ->name('professionals.destroy');
});




// Route::get('/userReports', [AdminController::class, 'export'])->name('admin.user.detail.export');
Route::prefix('sketchfab')->group(function () {
    Route::get('/search', [\App\Http\Controllers\Api\SketchfabController::class, 'search']);
    Route::get('/models/{uid}', [\App\Http\Controllers\Api\SketchfabController::class, 'getModel']);
});
    Route::get('/map', [App\Http\Controllers\VRContentController::class, 'Map'])->name('vr.map')->middleware(['auth']);
    // Chatbot API route

    Route::post('/chatbot/message', [ChatbotController::class, 'processMessage'])->name('chatbot.message');
Route::get('/chatbot/test-mock', function() {
    return response()->json([
        'error' => 'Please use POST method for this endpoint',
        'example' => [
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant'],
                ['role' => 'user', 'content' => 'Hello!']
            ]
        ]
    ]);
});


    // VR content suggestion routes
    Route::get('/vr/suggest', [VRContentController::class, 'createSuggest'])->name('vr.createSuggest');
    Route::post('/vr/suggest', [VRContentController::class, 'storeSuggest'])->name('vr.storeSuggest');


Route::middleware(['auth'])->group(function () {
    Route::get('/register/doctor', [ProfessionalController::class, 'doctorRegister'])->name('register.doctor');
    Route::post('/register/doctor', [ProfessionalController::class, 'doctorRegisterStore'])->name('register.doctor.store');
});

    Route::resource('health-info', App\Http\Controllers\Admin\HealthInfoController::class);


// Эрүүл мэндийн VR контентын нүүр хуудас
Route::get('/vr-contents', [VRUserContentController::class, 'index'])->name('home');

// VR контентын маршрутууд
Route::prefix('vr-contents')->group(function () {
    Route::get('/featured', [VRUserContentController::class, 'featured'])->name('vr-content.featured');
        Route::get('/new', [VRUserContentController::class, 'newModels'])->name('vr-content.new');
        Route::get('/category/{category}', [VRUserContentController::class, 'category'])->name('vr-content.category');

        // routes/web.php
Route::get('/combined', [VRUserContentController::class, 'combined'])->name('vr-content.combined');
        // Route::get('/featured/{id}', [VRUserContentController::class, 'show'])->name('vr-content.show');
        Route::get('featured/{id}', [VRUserContentController::class, 'showVR'])->name('vr-content.show');

    Route::get('/search', [VRUserContentController::class, 'search'])->name('vr-content.search');
});
Route::get('/vr-contents/new', [VRUserContentController::class, 'newModels'])->name('vr-content.new');


// Холбоо барих хуудас
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Тухай хуудас
Route::get('/about', function () {
    return view('about');
})->name('about');

//user
Route::get('/calendar', [EventController::class, 'calendar'])->name('events.calendar');
// Эрүүл мэндийн самбар бүлгийн route-ууд
Route::prefix('health')->middleware(['auth'])->group(function () {
    // Үндсэн самбар
    Route::get('/dashboard', [HealthDashboardController::class, 'index'])
         ->name('health.dashboard');
    // Профайл менежмент
    Route::get('/profile', [HealthDashboardController::class, 'editProfile'])
         ->name('health.profile.edit');
    Route::post('/profile', [HealthDashboardController::class, 'updateProfile'])
         ->name('health.profile.update');

    // Тайлан ба шинжилгээ
    Route::get('/report', [HealthDashboardController::class, 'generateReport'])
         ->name('health.report');

    // Зөвлөмжүүд
    Route::get('/physical-activity', [HealthDashboardController::class, 'physicalActivity'])
         ->name('health.physical-activity');
    Route::get('/risk-factors', [HealthDashboardController::class, 'riskFactors'])
         ->name('health.risk-factors');

    // AI шинжилгээ
    Route::get('/ai-insights', [HealthDashboardController::class, 'aiInsights'])
         ->name('health.ai-insights');

         // Regenerate AI insights on demand
    Route::post('/ai-insights/regenerate', [HealthDashboardController::class, 'regenerateAiInsights'])
    ->name('health.ai-insights.regenerate');

    Route::post('/ai-insights/generate', [HealthDashboardController::class,'generateAiInsights'
    ])->name('health.ai-insights.generate');
});







    //phq9
    Route::get('/phq9', [MentalHealthController::class, 'index'])->name('phq9.index');
    Route::post('/phq9/submit', [MentalHealthController::class, 'submit'])->name('phq9.submit');
    Route::get('/phq9/result/{score}', [MentalHealthController::class, 'result'])->name('phq9.result');
    //alcoholHealth
    Route::get('/auditc', [App\Http\Controllers\MentalHealthController::class, 'indexAudit'])->name('auditc.index');
Route::post('/auditc/submit', [App\Http\Controllers\MentalHealthController::class, 'submitAudit'])->name('auditc.submit');
Route::get('/auditc/result/{score}', [App\Http\Controllers\MentalHealthController::class, 'resultAudit'])->name('auditc.result');

//test.PC-PDSD-5
Route::get('/ptsd-test', [MentalHealthController::class, 'indexPTSD'])->name('ptsd-test.index');
Route::post('/ptsd-test', [MentalHealthController::class, 'submitPTSD'])->name('ptsd-test.submit');
// GAD7
Route::get('/gad7', [MentalHealthController::class, 'indexGAD7'])->name('gad7.index');
Route::post('/gad7/submit', [MentalHealthController::class, 'submitGAD7'])->name('gad7.submit');
Route::get('/gad7/result/{score}', [MentalHealthController::class, 'resultGAD7'])->name('gad7.result');
//gad2
Route::get('/mental-health', [MentalHealthController::class, 'index'])->name('mental-health.index');

Route::get('/mental-health/gad2', [MentalHealthController::class, 'showGad2Test'])->name('mental-health.gad2');
Route::post('/mental-health/gad2/process', [MentalHealthController::class, 'processGad2Test'])->name('mental-health.process-gad2');

// CAGE тестийн маршрутууд
Route::get('/mental-health/cage', [MentalHealthController::class, 'showCageTest'])->name('mental-health.cage');
Route::post('/mental-health/cage/process', [MentalHealthController::class, 'processCageTest'])->name('mental-health.process-cage');
//adhd
Route::get('/adhd-test', [MentalHealthController::class, 'indexadhd'])->name('adhd.test');
Route::post('/adhd-test/submit', [MentalHealthController::class, 'submitadhd'])->name('adhd.submit');
Route::get('/adhd-test/about', [MentalHealthController::class, 'aboutadhd'])->name('adhd.about');
//DASS-21
Route::get('DASS/', [MentalHealthController::class, 'indexDASS'])->name('dass21.index');
Route::post('DASS/calculate', [MentalHealthController::class, 'calculateDASS'])->name('dass21.calculate');
//ess
Route::get('/ess', [MentalHealthController::class, 'indexESS'])->name('ess.index');
Route::post('/ess/calculate', [MentalHealthController::class, 'calculateESS'])->name('ess.calculate');
//1. PAR-Q+ (Physical Activity Readiness Questionnaire)
Route::get('PAR-Q/', [PhysicalTest::class, 'indexPAR'])->name('parq.index');

Route::post('PAR-Q/submit', [PhysicalTest::class, 'submitPAR'])->name('parq.submit');

Route::get('PAR-Q/result', [PhysicalTest::class, 'resultPAR'])->name('parq.result');
//2. International Physical Activity Questionnaire (IPAQ) – Short Form

Route::get('/ipa-q', [PhysicalTest::class, 'index'])->name('ipaq.index');
Route::post('/ipa-q/submit', [PhysicalTest::class, 'submit'])->name('ipaq.submit');




    // Route::get('/mental-health', [MentalHealthController::class, 'index'])->name('mental-health.index');
    //         Route::get('/mental-health/tests/{category}', [MentalHealthController::class, 'showTest'])->name('show-test');
    //         // Route::post('/mental-health/process-test/submit/{category}', [MentalHealthController::class, 'processTest'])->name('process-test');
    //         Route::post('/mental-health/process-test/submit/{slug}', [MentalHealthController::class, 'processTest']);
    //         // View test history
    //         Route::get('/history', [MentalHealthController::class, 'testHistory'])->name('history');
    //         Route::get('/results/{session}', [MentalHealthController::class, 'viewResults'])->name('view-results');
    Route::get('testhome112233/', [HomeController::class, 'index'])->name('test.home');
