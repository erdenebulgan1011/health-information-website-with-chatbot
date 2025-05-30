@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-5">CAGE-ийн архины асуулгын үр дүн</h1>
        
        <div class="result-container">
            <h2 class="result-title">CAGE Үр дүн</h2>
            <p class="result-score">Нийт оноо: {{ $cageScore }} / 4</p>
            
            <div class="result-interpretation {{ $cageScore >= 2 ? 'result-critical' : 'result-normal' }}">
                <p><strong>Дүгнэлт: {{ $cageResult }}</strong></p>
                @if($cageScore >= 2)
                    <p>Оноо өндөр байх тусам архины асуудал ихэсдэг. Нийт 2 ба түүнээс дээш оноог эмнэлзүйн хувьд чухал гэж үзнэ. 2 ба түүнээс дээш оноо авсан тохиолдолд хэт их уухыг тодорхойлох мэдрэмж 93%, өвөрмөц байдал 76% байна.</p>
                    
                    <p>Эх сурвалжууд:</p>
                    <ul>
                        <li>Бернад МВ, Мумфорд Ж, С Тейлор С, Смит Б, Мюррей Р.М. Архидан согтуурах, хэтрүүлэн хэрэглэхийг илрүүлэх анкет, лабораторийн шинжилгээний харьцуулалт. Лансет. 1982;1(8267):325-8.</li>
                        <li>Архидан согтуурах, архидан согтуурахтай тэмцэх үндэсний хүрээлэн.</li>
                    </ul>
                @else
                    <p>Таны оноо эмнэлзүйн хувьд чухал ач холбогдолгүй байна.</p>
                @endif
            </div>
            
            <div class="navigation-buttons">
                <a href="{{ route('mental-health.cage') }}" class="btn btn-secondary">Дахин тест авах</a>
                <a href="{{ route('mental-health.index') }}" class="btn btn-success">Үндсэн хуудас руу буцах</a>
            </div>
        </div>
    </div>

    @endsection