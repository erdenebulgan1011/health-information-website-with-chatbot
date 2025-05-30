<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function show(Request $request): View
    // {
    //     $user = Auth::user();
    //     $profile = $user->profile;

    //     return view('profile.show', [
    //         'user' => $user,
    //         'profile' => $profile,
    //     ]);
    // }
public function show(Request $request): View
{
    $user = Auth::user();
    $profile = $user->profile;

    // Эмч мөн эсэхийг шалгах
    if ($user->professional && $user->professional->is_verified) {
        return $this->showDoctorProfile($user);
    }

    return $this->showRegularProfile($user, $profile);
}

private function showDoctorProfile($user)
{
    $professional = $user->professional->load('doctorInfo');
        $isDoctor = true;


    return view('profile.doctor.show', [
        'user' => $user,
        'profile' => $user->profile,
        'professional' => $professional,
        'doctorInfo' => $professional->doctorInfo,
        'isDoctor' => $isDoctor,

    ]);
}

private function showRegularProfile($user, $profile)
{
    return view('profile.show', [
        'user' => $user,
        'profile' => $profile
    ]);
}

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);

        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $profile = Auth::user()->profile ?? UserProfile::create(['user_id' => Auth::id()]);

        $validated = $request->validate([
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'height' => 'nullable|integer|min:50|max:300',
            'weight' => 'nullable|numeric|min:20|max:500',
            'is_smoker' => 'boolean',
            'has_chronic_conditions' => 'boolean',
            'medical_history' => 'nullable|string',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            // Delete old picture if exists
            if ($profile->profile_pic && Storage::disk('public')->exists($profile->profile_pic)) {
                Storage::disk('public')->delete($profile->profile_pic);
            }

            $image = $request->file('profile_pic');
            $fileName = time() . '_' . Auth::id() . '.' . $image->getClientOriginalExtension();

            // Store image using Laravel's file storage
            $path = $image->storeAs('profile_pictures', $fileName, 'public');

            $validated['profile_pic'] = $path;
        }

        $profile->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
