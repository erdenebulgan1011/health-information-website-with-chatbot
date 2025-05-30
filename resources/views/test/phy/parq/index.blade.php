@extends('layouts.testapp')

@section('title', 'PAR-Q+ Биеийн Тамирын Бэлэн Байдлын Асуулга')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Биеийн Тамирын Бэлэн Байдлын Асуулга (PAR-Q+)</h3>
                </div>
                <div class="card-body fs-5">
                    <p>Энэхүү асуулга нь таны биеийн тамирын дасгалд бэлэн эсэхийг үнэлэхэд зориулагдсан. Асуулт бүрт үнэн зөв, чин сэтгэлээсээ хариулна уу.</p>
                    <!-- <div class="alert alert-danger">
                        <strong>Анхаар!</strong> Аль нэг асуултад <strong>"Тийм"</strong> гэж хариулсан бол эмчтэй зөвлөлдөх шаардлагатай.
                    </div> -->
                </div>
            </div>

            <form action="{{ route('parq.submit') }}" method="POST">
                @csrf

                @php
                    $questions = [
                        '1. Таны эмч таныг зүрхний өвчтэй, зөвхөн эмчийн зөвлөсөн биеийн тамирын дасгал хийх хэрэгтэй гэж хэлж байсан уу?',
                        '2. Та биеийн тамирын дасгал хийхдээ цээжиндээ өвдөж байна уу?',
                        '3. Сүүлийн нэг сарын хугацаанд биеийн тамирын дасгал хийхгүй байхдаа цээж өвдөж байсан уу?',
                        '4. Толгой эргэхээс болж тэнцвэрээ алддаг уу эсвэл ухаан алддаг уу?',
                        '5. Таны биеийн хөдөлгөөний өөрчлөлтөөс болж муудаж болох яс, үе мөчний асуудал байна уу? (жишээлбэл: нуруу, өвдөг, ташаа)',
                        '6. Таны эмч таны цусны даралт, зүрхний өвчнийг эмчлэх эм (жишээлбэл, усны эм) бичиж байна уу?',
                        '7. Биеийн тамирын дасгал хийхгүй байх өөр ямар нэг шалтгааныг та мэдэх үү?'
                    ];
                @endphp

                @foreach($questions as $index => $question)
                    @php $number = $index + 1; @endphp
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3">{{ $question }}</h5>
                            <div class="form-check form-check-inline fs-5">
                                <input class="form-check-input" type="radio" name="question{{ $number }}" value="Тийм" id="q{{ $number }}_yes" required>
                                <label class="form-check-label" for="q{{ $number }}_yes">Тийм</label>
                            </div>
                            <div class="form-check form-check-inline fs-5">
                                <input class="form-check-input" type="radio" name="question{{ $number }}" value="Үгүй" id="q{{ $number }}_no" required>
                                <label class="form-check-label" for="q{{ $number }}_no">Үгүй</label>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg px-5">Илгээх</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
