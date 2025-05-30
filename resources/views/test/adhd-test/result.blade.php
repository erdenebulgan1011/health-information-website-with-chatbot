<!-- resources/views/adhd-test/results.blade.php (fixed version) -->
@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')    <style>
        body {
            background-color: #f8f9fa;
        }
        .result-container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .score-box {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .score-low {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .score-medium {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
        }
        .score-high {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        .section-scores {
            margin-top: 30px;
        }
        .explanation {
            margin-top: 30px;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 8px;
        }
        .progress {
            height: 25px;
        }
    </style>
</head>
<body>
    <div class="container result-container">
        <h1 class="text-center mb-4">ADHD Үнэлгээний үр дүн</h1>
        
        <div class="score-box {{ $scoreClass }}">
            <h2>Таны нийт оноо: {{ $totalScore }}/72</h2>
            <h3>{{ $interpretation }}</h3>
        </div>
        
        <div class="section-scores">
            <h3 class="mb-3">Дэд хэсгүүдийн оноо:</h3>
            
            <div class="mb-3">
                <label><strong>А хэсэг (Анхаарал төвлөрөлт/Зохион байгуулалт):</strong> {{ $sectionAScore }}/24</label>
                <div class="level-indicator {{ ($sectionAScore <= 8) ? 'low' : (($sectionAScore <= 16) ? 'medium' : 'high') }}">
                    {{ $sectionAScore }}%
                </div>
            </div>
            
            <div class="mb-3">
                <label><strong>Б хэсэг (Хэт идэвхтэй/Түрэмгий):</strong> {{ $sectionBScore }}/48</label>
                <div class="level-indicator {{ ($sectionBScore <= 16) ? 'low' : (($sectionBScore <= 32) ? 'medium' : 'high') }}">
                    {{ $sectionBScore }}%
                </div>
            </div>
        </div>
        
        <div class="explanation">
            <h4>Үр дүнгийн тайлбар:</h4>
            <p>{{ $explanation }}</p>
            <div class="alert alert-info mt-3">
                <strong>Санамж:</strong> Энэ тест нь албан ёсны оношилгоо биш бөгөөд зөвхөн скрининг зорилготой юм. 
                Хэрэв та ADHD-тай байж болзошгүй гэж бодож байгаа бол мэргэжлийн эмнэлгийн ажилтантай зөвлөлдөхийг зөвлөлдөж байна.
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('adhd.test') }}" class="btn btn-primary">Дахин тест өгөх</a>
        </div>
    </div>

    @endsection