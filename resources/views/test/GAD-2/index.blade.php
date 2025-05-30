@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
        <h1 class="text-center mb-5">Ерөнхий түгшүүрийн эмгэг 2 зүйл (GAD-2)</h1>
        
        <div class="test-container">
            <h2 class="test-title">GAD-2 Үнэлгээ</h2>
            <p>Сүүлийн <strong>2 долоо хоногт</strong> та дараах асуудлуудаас хэр олон удаа санаа зовсон бэ?</p>
            
            <form action="{{ route('mental-health.process-gad2') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <h5>1. Сандарсан, түгшүүртэй эсвэл ирмэг дээр байгаа мэдрэмж</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gad_1" id="gad_1_0" value="0" required>
                        <label class="form-check-label" for="gad_1_0">Огт үгүй (0)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gad_1" id="gad_1_1" value="1">
                        <label class="form-check-label" for="gad_1_1">Хэдэн өдөр (+1)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gad_1" id="gad_1_2" value="2">
                        <label class="form-check-label" for="gad_1_2">Өдрийн талаас илүү нь (+2)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gad_1" id="gad_1_3" value="3">
                        <label class="form-check-label" for="gad_1_3">Бараг өдөр бүр (+3)</label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h5>2. Санаа зоволтыг зогсоож, хянах чадваргүй байх</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gad_2" id="gad_2_0" value="0" required>
                        <label class="form-check-label" for="gad_2_0">Огт үгүй (0)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gad_2" id="gad_2_1" value="1">
                        <label class="form-check-label" for="gad_2_1">Хэдэн өдөр (+1)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gad_2" id="gad_2_2" value="2">
                        <label class="form-check-label" for="gad_2_2">Өдрийн талаас илүү нь (+2)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gad_2" id="gad_2_3" value="3">
                        <label class="form-check-label" for="gad_2_3">Бараг өдөр бүр (+3)</label>
                    </div>
                </div>
                
                <div class="navigation-buttons">
                    <a href="{{ route('mental-health.process-gad2') }}" class="btn btn-secondary">Буцах</a>
                    <button type="submit" class="btn btn-primary">Үр дүнг харах</button>
                </div>
            </form>
        </div>



    @endsection