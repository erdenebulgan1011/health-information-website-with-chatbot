{{-- doctor_profile.blade.php: View doctor's profile information --}}
@extends('layouts.ForumApp')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Doctor's Profile</h1>
            @if(Auth::id() == $professional->user_id)
                <a href="{{ route('doctor.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Edit Profile
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <div class="text-center mb-4">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="Profile Photo" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center mx-auto mb-4">
                                <span class="text-3xl text-gray-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h2 class="text-xl font-semibold">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-600">{{ $professional->specialization }}</p>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500">
                            @if($professional->is_verified)
                                <span class="text-green-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Verified Doctor
                                </span>
                            @else
                                <span class="text-yellow-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Verification Pending
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Qualifications</h3>
                    <p class="text-gray-600">{{ $professional->qualification }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Specialization</h3>
                    <p class="text-gray-600">{{ $professional->specialization }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Bio</h3>
                    <p class="text-gray-600">{{ $professional->bio ?? 'No bio information available.' }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Certification</h3>
                    @if($professional->certification)
                        <a href="{{ Storage::url($professional->certification) }}" target="_blank" class="text-blue-500 hover:underline flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            View Certification
                        </a>
                    @else
                        <p class="text-gray-500 italic">No certification uploaded</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
