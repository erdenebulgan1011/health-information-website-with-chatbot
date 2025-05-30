{{-- doctor_edit.blade.php: Edit doctor's profile information --}}
@extends('layouts.ForumApp')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Doctor Profile</h1>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('doctor.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="full_name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $professional->doctorInfo->full_name ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('full_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone_number" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $professional->doctorInfo->phone_number ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="workplace" class="block text-gray-700 font-medium mb-2">Workplace</label>
                        <input type="text" name="workplace" id="workplace" value="{{ old('workplace', $professional->doctorInfo->workplace ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('workplace')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $professional->doctorInfo->address ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="profile_photo" class="block text-gray-700 font-medium mb-2">Profile Photo</label>
                    @if($professional->doctorInfo && $professional->doctorInfo->profile_photo)
                        <div class="mb-2 flex items-center">
                            <img src="{{ Storage::url($professional->doctorInfo->profile_photo) }}" alt="Current Profile Photo" class="w-16 h-16 rounded-full object-cover mr-2">
                            <span class="text-sm text-gray-500">Current profile photo</span>
                        </div>
                    @endif
                    <input type="file" name="profile_photo" id="profile_photo" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                    <p class="text-gray-500 text-sm mt-1">Accepted file types: JPG, PNG (max 2MB)</p>
                    @error('profile_photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-lg font-medium text-gray-800 mb-4">Professional Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="education" class="block text-gray-700 font-medium mb-2">Education</label>
                        <input type="text" name="education" id="education" value="{{ old('education', $professional->doctorInfo->education ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('education')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="years_experience" class="block text-gray-700 font-medium mb-2">Years of Experience</label>
                        <input type="number" name="years_experience" id="years_experience" value="{{ old('years_experience', $professional->doctorInfo->years_experience ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('years_experience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="languages" class="block text-gray-700 font-medium mb-2">Languages</label>
                        <input type="text" name="languages" id="languages" value="{{ old('languages', $professional->doctorInfo->languages ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <p class="text-gray-500 text-sm mt-1">Separate languages with commas (e.g., English, Spanish)</p>
                        @error('languages')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-lg font-medium text-gray-800 mb-4">Medical Specialization</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="specialization" class="block text-gray-700 font-medium mb-2">Specialization</label>
                        <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $professional->specialization) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('specialization')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="qualification" class="block text-gray-700 font-medium mb-2">Qualification</label>
                        <input type="text" name="qualification" id="qualification" value="{{ old('qualification', $professional->qualification) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('qualification')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="bio" class="block text-gray-700 font-medium mb-2">Bio</label>
                    <textarea name="bio" id="bio" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('bio', $professional->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="certification" class="block text-gray-700 font-medium mb-2">Certification</label>
                    @if($professional->certification)
                        <div class="mb-2 flex items-center">
                            <span class="text-sm text-gray-500 mr-2">Current: </span>
                            <a href="{{ Storage::url($professional->certification) }}" target="_blank" class="text-sm text-blue-500 hover:underline">View current certification</a>
                        </div>
                    @endif
                    <input type="file" name="certification" id="certification" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                    <p class="text-gray-500 text-sm mt-1">Accepted file types: PDF, JPG, PNG (max 2MB)</p>
                    @error('certification')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('doctor.profile') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

