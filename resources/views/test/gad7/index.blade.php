@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Ерөнхий түгшүүрийн эмгэг 7 зүйл (GAD-7)</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">Ерөнхий түгшүүрийн эмгэгийн 7-р зүйл (GAD-7) нь түгшүүрийн ерөнхий эмгэг 1-ийг илрүүлэхэд хялбар анхан шатны үзлэг хийх хэрэгсэл юм.</p>
                        <p class="fw-bold">Сүүлийн <strong>2 долоо хоногт</strong> та дараах асуудлуудаас хэр олон удаа санаа зовсон бэ?</p>
                        
                        <form action="{{ route('gad7.submit') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="60%">Асуулт</th>
                                            <th class="text-center">Огт үгүй</th>
                                            <th class="text-center">Хэдэн өдөр</th>
                                            <th class="text-center">Өдрийн талаас илүү нь</th>
                                            <th class="text-center">Бараг өдөр бүр</th>
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
                                <button type="submit" class="btn btn-primary btn-lg">Илгээх</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    