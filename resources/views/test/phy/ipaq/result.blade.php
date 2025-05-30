@extends('layouts.testapp')

@section('title', 'IPAQ Test Results')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">IPAQ Test Results</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h4>Your IPAQ Score: <span class="badge bg-{{ $activityLevel['alert'] }}">{{ $score }}</span></h4>
                        </div>
                        
                        <div class="alert alert-{{ $activityLevel['alert'] }}">
                            <h5 class="alert-heading">Activity Level: {{ $activityLevel['level'] }}</h5>
                            <p class="mb-0"><strong>Suggested Actions:</strong> {{ $activityLevel['description'] }}</p>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('ipaq.index') }}" class="btn btn-primary">Take Test Again</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
