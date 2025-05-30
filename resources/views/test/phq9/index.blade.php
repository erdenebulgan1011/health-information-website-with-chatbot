@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">PHQ-9 Depression Screening Test</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">Over the <strong>last 2 weeks</strong>, how often have you been bothered by the following problems?</p>
                        
                        <form action="{{ route('phq9.submit') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="60%">Question</th>
                                            <th class="text-center">Not at all</th>
                                            <th class="text-center">Several days</th>
                                            <th class="text-center">More than half the days</th>
                                            <th class="text-center">Nearly every day</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($questions as $index => $question)
                                            <tr>
                                                <td><strong>{{ $index }}.</strong> {{ $question }}</td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio" name="answers[{{ $index-1 }}]" value="0" required>
                                                        <label class="ms-2"><strong>0</strong></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio" name="answers[{{ $index-1 }}]" value="1" required>
                                                        <label class="ms-2"><strong>+1</strong></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio" name="answers[{{ $index-1 }}]" value="2" required>
                                                        <label class="ms-2"><strong>+2</strong></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="radio" name="answers[{{ $index-1 }}]" value="3" required>
                                                        <label class="ms-2"><strong>+3</strong></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
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