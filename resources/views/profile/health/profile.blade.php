<!-- resources/views/health/profile.blade.php -->
@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Your Health Profile</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('health.profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="text-center mb-3">
                                    @if(isset($profile) && $profile->profile_pic)
                                        <img src="{{ asset('storage/' . $profile->profile_pic) }}" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; margin: 0 auto;">
                                            <span class="h1">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="profile_pic" class="form-label">Profile Picture</label>
                                    <input class="form-control form-control-sm @error('profile_pic') is-invalid @enderror" id="profile_pic" type="file" name="profile_pic">
                                    @error('profile_pic')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="birth_date" class="form-label">Birth Date</label>
                                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', isset($profile) ? $profile->birth_date : '') }}">
                                        @error('birth_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                            <option value="" {{ old('gender', isset($profile) ? $profile->gender : '') == '' ? 'selected' : '' }}>Select Gender</option>
                                            <option value="male" {{ old('gender', isset($profile) ? $profile->gender : '') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', isset($profile) ? $profile->gender : '') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', isset($profile) ? $profile->gender : '') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="height" class="form-label">Height (cm)</label>
                                        <input type="number" class="form-control @error('height') is-invalid @enderror" id="height" name="height" min="50" max="250" value="{{ old('height', isset($profile) ? $profile->height : '') }}">
                                        @error('height')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Weight (kg)</label>
                                        <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" min="30" max="500" value="{{ old('weight', isset($profile) ? $profile->weight : '') }}">
                                        @error('weight')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input @error('is_smoker') is-invalid @enderror" type="checkbox" id="is_smoker" name="is_smoker" value="1" {{ old('is_smoker', isset($profile) && $profile->is_smoker ? 'checked' : '') }}>
                                    <label class="form-check-label" for="is_smoker">
                                        I am a smoker
                                    </label>
                                    @error('is_smoker')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input @error('has_chronic_conditions') is-invalid @enderror" type="checkbox" id="has_chronic_conditions" name="has_chronic_conditions" value="1" {{ old('has_chronic_conditions', isset($profile) && $profile->has_chronic_conditions ? 'checked' : '') }}>
                                    <label class="form-check-label" for="has_chronic_conditions">
                                        I have chronic medical conditions
                                    </label>
                                    @error('has_chronic_conditions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="medical_history" class="form-label">Medical History (Optional)</label>
                            <textarea class="form-control @error('medical_history') is-invalid @enderror" id="medical_history" name="medical_history" rows="3" placeholder="Briefly describe any significant medical history, allergies, or conditions">{{ old('medical_history', isset($profile) ? $profile->medical_history : '') }}</textarea>
                            @error('medical_history')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text">This information is used to provide personalized health recommendations but won't be shared.</div>
                        </div>

                        <div class="mb-3">
                            <p class="text-muted"><i class="fas fa-lock me-1"></i> Your health data is private and secure.</p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('health.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
