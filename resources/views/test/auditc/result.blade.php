@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">AUDIT-C Test Results</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h4>Your AUDIT-C Score: <span class="badge bg-{{ $interpretation['alert'] }}">{{ $score }}</span></h4>
                        </div>
                        
                        <div class="alert alert-{{ $interpretation['alert'] }}">
                            <h5 class="alert-heading">Result: {{ $interpretation['status'] }}</h5>
                            <p class="mb-0">{{ $interpretation['message'] }}</p>
                        </div>
                        
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Interpretation Guide</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>Men:</strong> A score of 4 or more is considered positive, optimal for identifying hazardous drinking or active alcohol use disorders.
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Women:</strong> A score of 3 or more is considered positive, optimal for identifying hazardous drinking or active alcohol use disorders.
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Note:</strong> If all points are from Question 1, assume the patient is drinking below recommended limits and the medical provider should review the patient's alcohol intake during the past few months.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('auditc.index') }}" class="btn btn-primary">Take Test Again</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection