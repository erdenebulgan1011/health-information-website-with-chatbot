// resources/views/dass21/result.blade.php
@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')    <style>
        body {
            background-color: #f5f5f5;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .result-card {
            transition: all 0.3s;
            border-left: 5px solid;
        }
        .result-card.primary {
            border-left-color: #0d6efd;
        }
        .result-card.success {
            border-left-color: #198754;
        }
        .result-card.info {
            border-left-color: #0dcaf0;
        }
        .result-card.warning {
            border-left-color: #ffc107;
        }
        .result-card.danger {
            border-left-color: #dc3545;
        }
        .progress {
            height: 25px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">DASS-21 Таны үр дүн</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <p class="mb-0">
                                <strong>Анхааруулга:</strong> Энэхүү үр дүн нь ерөнхий мэдээлэл өгөх зорилготой бөгөөд мэргэжлийн оношилгооны оронд орохгүй. 
                                Хэрэв та сэтгэл санааны хүндрэлтэй тулгарч байгаа бол мэргэжлийн сэтгэл зүйч эсвэл эмчид хандахыг зөвлөж байна.
                            </p>
                        </div>
                        
                        <!-- Depression Result -->
                        <div class="result-card {{ $depressionSeverity['class'] }} p-3 mb-4">
                            <h4>Сэтгэлийн хямрал</h4>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-{{ $depressionSeverity['class'] }}" role="progressbar" 
                                    style="width: {{ min(100, ($depressionScore/42)*100) }}%" 
                                    aria-valuenow="{{ $depressionScore }}" aria-valuemin="0" aria-valuemax="42">
                                    {{ $depressionScore }}/42
                                </div>
                            </div>
                            <p class="mb-0">
                                <strong>Үр дүн:</strong> {{ $depressionSeverity['level'] }} ({{ $depressionScore }} оноо)
                            </p>
                        </div>
                        
                        <!-- Anxiety Result -->
                        <div class="result-card {{ $anxietySeverity['class'] }} p-3 mb-4">
                            <h4>Сэтгэл түгших</h4>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-{{ $anxietySeverity['class'] }}" role="progressbar" 
                                    style="width: {{ min(100, ($anxietyScore/42)*100) }}%" 
                                    aria-valuenow="{{ $anxietyScore }}" aria-valuemin="0" aria-valuemax="42">
                                    {{ $anxietyScore }}/42
                                </div>
                            </div>
                            <p class="mb-0">
                                <strong>Үр дүн:</strong> {{ $anxietySeverity['level'] }} ({{ $anxietyScore }} оноо)
                            </p>
                        </div>
                        
                        <!-- Stress Result -->
                        <div class="result-card {{ $stressSeverity['class'] }} p-3">
                            <h4>Стресс</h4>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-{{ $stressSeverity['class'] }}" role="progressbar" 
                                    style="width: {{ min(100, ($stressScore/42)*100) }}%" 
                                    aria-valuenow="{{ $stressScore }}" aria-valuemin="0" aria-valuemax="42">
                                    {{ $stressScore }}/42
                                </div>
                            </div>
                            <p class="mb-0">
                                <strong>Үр дүн:</strong> {{ $stressSeverity['level'] }} ({{ $stressScore }} оноо)
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <h5>Оноо хэрхэн тооцогдсон бэ?</h5>
                            <p>
                                DASS-21 нь 21 асуулт бүхий өөрийн үнэлгээний хэмжүүр бөгөөд сэтгэлийн хямрал, түгшүүр, стрессийн шинж тэмдгүүдийг хэмждэг. Таны хариултыг дараах байдлаар тооцоолсон:
                            </p>
                            <ul>
                                <li>Асуулт бүрийг 0-3 оноогоор үнэлсэн</li>
                                <li>Сэтгэлийн хямрал, түгшүүр, стресс гэсэн гурван дэд хэсэгт хуваасан</li>
                                <li>Дэд хэсэг бүрийн оноог 2-оор үржүүлсэн (DASS-42 хувилбартай харьцуулахын тулд)</li>
                            </ul>
                            
                            <div class="text-center mt-4">
                                <a href="{{ route('dass21.index') }}" class="btn btn-primary">Дахин тест өгөх</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection