<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\DoctorInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse; // Make sure this is imported


class ProfessionalController extends Controller
{
    public function doctorRegister()
    {
        return view('profile.doctor.register');
    }


/**
     * Store a newly created professional profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doctorRegisterStore(Request $request)
    {
        \Log::debug('Starting file upload process');

        // Validate the request data
        $validated = $request->validate([
            'specialization' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'certification' => 'nullable|file|mimes:pdf|max:2048', // Allow PDF files up to 2MB
            'bio' => 'nullable|string',
        ]);

        // Handle file upload
        $certificationPath = null;
        if ($request->hasFile('certification')) {
            // Get the file from the request
            $file = $request->file('certification');

            // Create a unique filename
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store the file in the public disk under the certifications folder
            // This will save to: storage/app/public/certifications/
            $certificationPath = $file->storeAs('certifications', $fileName, 'public');
        }

        // Create new professional record
        $professional = Professional::create([
            'user_id' => Auth::id(),
            'specialization' => $validated['specialization'],
            'qualification' => $validated['qualification'],
            'certification' => $certificationPath, // Save the file path in the database
            'bio' => $validated['bio'] ?? null,
            'is_verified' => false, // Default to unverified
        ]);

        return redirect()->route('doctor-info.create', $professional->id)
            ->with('success', 'Professional profile created successfully.');
    }

    /**
     * Download the certification file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    public function createInfo()
    {
        return view('profile.doctor.doctor-info.create');
    }

    public function storeInfo(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'workplace' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'languages' => 'nullable|string|max:255',
        ]);

        $professional = Professional::where('user_id', Auth::id())->firstOrFail();

        $professional->doctorInfo()->create($validated);

        return redirect()->route('profile.show')->with('success', 'Эмчний мэдээлэл амжилттай бүртгэгдлээ!');
    }

     // Show doctor profile
    public function showProfile($id = null)
    {
        // If no ID provided, show current user's profile (if they are a doctor)
        if ($id === null) {
            $professional = Professional::where('user_id', Auth::id())
                ->with(['doctorInfo', 'user'])
                ->firstOrFail();
        } else {
            $professional = Professional::findOrFail($id)
                ->load(['doctorInfo', 'user']);
        }

        return view('profile.doctor.doctor_profile', compact('professional'));
    }


     // Show edit profile form
         // Show edit profile form
    public function edit()
    {
        $professional = Professional::where('user_id', Auth::id())
            ->with('doctorInfo')
            ->firstOrFail();

        return view('profile.doctor.doctor-info.doctor_edit', compact('professional'));
    }


    // Update doctor profile
    public function updateInfo(Request $request)
    {
        $professional = Professional::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'workplace' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'languages' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'specialization' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'certification' => 'nullable|file|mimes:pdf,jpg,png|max:2048'
        ]);

        // Update professional info
        $professional->specialization = $request->specialization;
        $professional->qualification = $request->qualification;
        $professional->bio = $request->bio;

        // Handle certification update if a new file is uploaded
        if ($request->hasFile('certification')) {
            // Delete the old certification file if it exists
            if ($professional->certification) {
                Storage::disk('public')->delete($professional->certification);
            }

            // Store the new certification file
            $certificationPath = $request->file('certification')->store('certifications', 'public');
            $professional->certification = $certificationPath;
        }

        $professional->save();

        // Get or create doctor info
        $doctorInfo = $professional->doctorInfo ?? new DoctorInfo(['professional_id' => $professional->id]);

        // Update doctor info
        $doctorInfo->full_name = $request->full_name;
        $doctorInfo->phone_number = $request->phone_number;
        $doctorInfo->workplace = $request->workplace;
        $doctorInfo->address = $request->address;
        $doctorInfo->education = $request->education;
        $doctorInfo->years_experience = $request->years_experience;
        $doctorInfo->languages = $request->languages;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($doctorInfo->profile_photo) {
                Storage::disk('public')->delete($doctorInfo->profile_photo);
            }

            // Store new photo
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            $doctorInfo->profile_photo = $photoPath;
        }

        $doctorInfo->save();

        return redirect()->route('doctor.profile')->with('success', 'Profile updated successfully!');
    }

    // List all verified doctors
    public function listDoctors()
{
    $professionals = Professional::where('is_verified', true)
        ->with(['user', 'doctorInfo'])
        ->paginate(10); // Changed get() to paginate()



    return view('profile.doctor.doctor_list', compact('professionals'));
}



     //admin


    public function index()
{
    $professionals = Professional::with('user')->latest()->get();
    return view('profile.doctor.admin.index', compact('professionals'));
}

public function show(Professional $professional)
{
    return view('profile.doctor.admin.show', compact('professional'));
}

public function update(Request $request, Professional $professional)
{
    $professional->update([
        'is_verified' => !$professional->is_verified
    ]);

    return back()->with('success', 'Статус амжилттай шинэчлэгдлээ');
}
public function destroy(Professional $professional)
{
    try {
        if ($professional->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        if ($professional->certification) {
            Storage::disk('public')->delete($professional->certification);
        }

        $professional->delete();

        return redirect()->route('admin.professionals.index')
            ->with('success', 'Professional profile deleted successfully.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error deleting profile: ' . $e->getMessage());
    }
}
}
