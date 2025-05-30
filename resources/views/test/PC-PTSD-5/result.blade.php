@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-{{ $interpretation['alert'] }} text-white">
                    <h4 class="mb-0">Тестийн Үр дүн</h4>
                </div>

                <div class="card-body">
                    <div class="result-summary text-center mb-4">
                        <h3 class="text-{{ $interpretation['alert'] }}">
                            {{ $interpretation['status'] }} үр дүн
                        </h3>
                        <div class="score-display my-4">
                            <span class="badge badge-{{ $interpretation['alert'] }} py-3 px-4" style="font-size: 1.5rem;">
                                Оноо: {{ $interpretation['score'] }}/5
                            </span>
                        </div>
                        <p class="lead">{{ $interpretation['message'] }}</p>
                    </div>

                    <div class="detailed-results mb-5">
                        <h5 class="mb-3">Дэлгэрэнгүй хариултууд:</h5>
                        <ul class="list-group">
                            @foreach($interpretation['answers'] as $key => $answer)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $questions[array_search($key, array_column($questions, 'name'))]['question'] }}
                                <span class="badge badge-{{ $answer ? 'danger' : 'success' }}">
                                    {{ $answer ? 'Тийм' : 'Үгүй' }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @if($interpretation['isPositive'])
                    <div class="recommendation alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle"></i> Зөвлөмж:</h5>
                        <p class="mb-2">{{ $interpretation['recommendation'] }}</p>
                        <ul class="mb-0">
                            <li>Мэргэжлийн сэтгэл зүйч эсвэл эмчтэй холбогдох</li>
                            <li>Ойр дотны хүмүүстэйгээ ярилцах</li>
                            <li>Стресс бууруулах арга техник ашиглах</li>
                        </ul>
                    </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('ptsd-test.index') }}" class="btn btn-outline-primary">
                            Дахин тест хийх
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection