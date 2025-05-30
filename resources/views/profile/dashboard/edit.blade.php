@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">{{ __('Edit Profile') }}</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-dashboard">
                <div class="card-header bg-white">
                    <h5 class="mb-0">{{ __('Personal Information') }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- User Information -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3">{{ __('Health Information') }}</h5>
                        <p class="text-muted small mb-4">{{ __('This information helps us provide you with personalized health recommendations.') }}</p>

                        <!-- Basic Health Information -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">{{ __('Birth Date') }}</label>
                                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date', $profile->birth_date ? $profile->birth_date->format('Y-m-d') : '') }}">
                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">{{ __('Gender') }}</label>
                                <select id="gender" class="form-select @error('gender') is-invalid @enderror" name="gender">
                                    <option value="">{{ __('Select Gender') }}</option>
                                    <option value="Male" {{ old('gender', $profile->gender) == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="Female" {{ old('gender', $profile->gender) == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    <option value="Other" {{ old('gender', $profile->gender) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Physical Measurements -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="height" class="form-label">{{ __('Height (cm)') }}</label>
                                <input id="height" type="number" step="1" min="50" max="300" class="form-control @error('height') is-invalid @enderror" name="height" value="{{ old('height', $profile->height) }}">
                                @error('height')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="weight" class="form-label">{{ __('Weight (kg)') }}</label>
                                <input id="weight" type="number" step="0.1" min="20" max="500" class="form-control @error('weight') is-invalid @enderror" name="weight" value="{{ old('weight', $profile->weight) }}">
                                @error('weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Health Factors -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('is_smoker') is-invalid @enderror" type="checkbox" id="is_smoker" name="is_smoker" {{ old('is_smoker', $profile->is_smoker) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_smoker">
                                        {{ __('I am a smoker') }}
                                    </label>
                                    @error('is_smoker')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('has_chronic_conditions') is-invalid @enderror" type="checkbox" id="has_chronic_conditions" name="has_chronic_conditions" {{ old('has_chronic_conditions', $profile->has_chronic_conditions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_chronic_conditions">
                                        {{ __('I have chronic health conditions') }}
                                    </label>
                                    @error('has_chronic_conditions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
