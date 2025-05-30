@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">PHQ-9 Test Results</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h4>Your PHQ-9 Score: <span class="badge bg-{{ $interpretation['alert'] }}">{{ $score }}</span></h4>
                        </div>
                        
                        <div class="alert alert-{{ $interpretation['alert'] }}">
                            <h5 class="alert-heading">Depression Severity: {{ $interpretation['severity'] }}</h5>
                            <p class="mb-0"><strong>Proposed Treatment Actions:</strong> {{ $interpretation['treatment'] }}</p>
                        </div>
                        
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Interpretation Guide</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>PHQ-9 Score</th>
                                            <th>Depression Severity</th>
                                            <th>Proposed Treatment Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0 – 4</td>
                                            <td>None-minimal</td>
                                            <td>None</td>
                                        </tr>
                                        <tr>
                                            <td>5 – 9</td>
                                            <td>Mild</td>
                                            <td>Watchful waiting; repeat PHQ-9 at follow-up</td>
                                        </tr>
                                        <tr>
                                            <td>10 – 14</td>
                                            <td>Moderate</td>
                                            <td>Treatment plan, considering counseling, follow-up and/or pharmacotherapy</td>
                                        </tr>
                                        <tr>
                                            <td>15 – 19</td>
                                            <td>Moderately Severe</td>
                                            <td>Active treatment with pharmacotherapy and/or psychotherapy</td>
                                        </tr>
                                        <tr>
                                            <td>20 – 27</td>
                                            <td>Severe</td>
                                            <td>Immediate initiation of pharmacotherapy and, if severe impairment or poor response to therapy, expedited referral to a mental health specialist for psychotherapy and/or collaborative management</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning mt-4">
                            <p class="mb-0"><strong>Note:</strong> Question 9 is a single screening question on suicide risk. A patient who answers yes to question 9 needs further assessment for suicide risk by an individual who is competent to assess this risk.</p>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('phq9.index') }}" class="btn btn-primary">Take Test Again</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection