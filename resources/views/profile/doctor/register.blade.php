@extends('vr-content.user.vsapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register as Doctor') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.doctor.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="specialization" class="col-md-4 col-form-label text-md-end">
                                {{ __('Мэргэжил') }}
                            </label>
                            <div class="col-md-6">
                                <input id="specialization" type="text"
                                    class="form-control @error('specialization') is-invalid @enderror"
                                    name="specialization"
                                    value="{{ old('specialization') }}"
                                    required autocomplete="specialization">

                                @error('specialization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="qualification" class="col-md-4 col-form-label text-md-end">
                                {{ __('Мэргэжлийн зэрэг') }}
                            </label>
                            <div class="col-md-6">
                                <input id="qualification" type="text"
                                    class="form-control @error('qualification') is-invalid @enderror"
                                    name="qualification"
                                    value="{{ old('qualification') }}"
                                    required>

                                @error('qualification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="bio" class="col-md-4 col-form-label text-md-end">
                                {{ __('Товч танилцуулга') }}
                            </label>
                            <div class="col-md-6">
                                <textarea id="bio"
                                    class="form-control @error('bio') is-invalid @enderror"
                                    name="bio" rows="3">{{ old('bio') }}</textarea>

                                @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="certification" class="form-label">Certification Document (PDF)</label>
                            <input type="file" class="form-control" id="certification" name="certification" accept=".pdf">
                            @error('certification')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit Registration') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @guest
                <div class="text-center mt-3">
                    <p>You need to be logged in to register as a doctor.
                        <a href="{{ route('login') }}">Login here</a></p>
                </div>
            @endguest
        </div>
    </div>
</div>
@endsection
