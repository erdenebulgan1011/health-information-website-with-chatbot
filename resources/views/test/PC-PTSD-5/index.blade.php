@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')

<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">PC-PTSD-5 Сэтгэцийн Эрүүл Мэндийн Тест</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ptsd-test.submit') }}">
                        @csrf

                        <div class="alert alert-info">
                            <p class="mb-0">Дараах асуултуудад сүүлийн сард танд тохиолдсон зүйлсэд тулгуурлан хариулна уу.</p>
                        </div>

                        @foreach($questions as $index => $question)
                        <div class="question-card mb-4 p-3 border rounded">
                            <h5 class="question-text">{{ $index }}. {{ $question['question'] }}</h5>
                            
                            <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                <label class="btn btn-outline-primary">
                                    <input type="radio" name="{{ $question['name'] }}" value="1" required> Тийм
                                </label>
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" name="{{ $question['name'] }}" value="0" required> Үгүй
                                </label>
                            </div>
                        </div>
                        @endforeach

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                Үр дүнг харах
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection