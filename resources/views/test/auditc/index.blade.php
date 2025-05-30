@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">AUDIT-C Alcohol Use Disorders Identification Test</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('auditc.submit') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label">Please select your gender:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="male" id="gender-male" required>
                                    <label class="form-check-label" for="gender-male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="female" id="gender-female" required>
                                    <label class="form-check-label" for="gender-female">Female</label>
                                </div>
                            </div>
                            
                            @foreach($questions as $index => $questionData)
                                <div class="mb-4">
                                    <h5>{{ $questionData['question'] }}</h5>
                                    <div class="list-group">
                                        @foreach($questionData['options'] as $value => $option)
                                            <label class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <input class="form-check-input me-1" type="radio" name="answers[{{ $index - 1 }}]" value="{{ $value }}" required>
                                                        {{ $option }}
                                                    </div>
                                                    <span class="badge bg-primary">+{{ $value }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection