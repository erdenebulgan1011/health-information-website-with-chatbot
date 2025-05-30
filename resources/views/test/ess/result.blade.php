@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
    <style>
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
        .answer-detail {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">Epworth Sleepiness Scale (ESS) - Таны үр дүн</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <p class="mb-0">
                                <strong>Анхааруулга:</strong> Энэхүү үр дүн нь ерөнхий мэдээлэл өгөх зорилготой бөгөөд мэргэжлийн оношилгооны оронд орохгүй. 
                                Хэрэв таны оноо 10 ба түүнээс дээш бол мэргэжлийн эмнэлгийн тусламж авахыг зөвлөж байна.
                            </p>
                        </div>
                        
                        <!-- ESS Result -->
                        <div class="result-card {{ $severity['class'] }} p-3 mb-4">
                            <h4>Таны нойрмог байдлын үр дүн</h4>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-{{ $severity['class'] }}" role="progressbar" 
                                    style="width: {{ min(100, ($totalScore/24)*100) }}%" 
                                    aria-valuenow="{{ $totalScore }}" aria-valuemin="0" aria-valuemax="24">
                                    {{ $totalScore }}/24
                                </div>
                            </div>
                            <p class="mb-1">
                                <strong>Үр дүн:</strong> {{ $severity['level'] }} ({{ $totalScore }} оноо)
                            </p>
                            <p class="mb-0">
                                {{ $severity['description'] }}
                            </p>
                        </div>
                        
                        <!-- Detailed Answers -->
                        <div class="mt-4">
                            <h5>Таны хариултын дэлгэрэнгүй</h5>
                            
                            <?php
                            $questions = [
                                1 => 'Суух, унших',
                                2 => 'ТВ үзэж байна',
                                3 => 'Олон нийтийн газар (жишээ нь, театр, хурал) идэвхгүй суух',
                                4 => 'Нэг цагийн турш завсарлагагүйгээр машинд зорчигчийн хувьд',
                                5 => 'Үдээс хойш амрахаар хэвтэж байна',
                                6 => 'Хэн нэгэнтэй суугаад ярилцаж байна',
                                7 => 'Үдийн хоолны дараа чимээгүй суух (архигүй)',
                                8 => 'Машинд, замын хөдөлгөөнд хэдэн минут зогссон',
                            ];
                            
                            $scoreDescriptions = [
                                0 => 'Хэзээ ч нойрмоглохгүй',
                                1 => 'Нойрмоглох магадлал бага байна',
                                2 => 'Нойрмоглох магадлал дунд зэрэг',
                                3 => 'Нойрмоглох магадлал өндөр',
                            ];
                            ?>
                            
                            @foreach($answers as $key => $value)
                                <?php
                                $questionNum = (int)str_replace('q', '', $key);
                                $questionText = $questions[$questionNum] ?? 'Асуулт';
                                $scoreText = $scoreDescriptions[$value] ?? '';
                                ?>
                                <div class="answer-detail">
                                    <strong>{{ $questionNum }}. {{ $questionText }}</strong>
                                    <div class="d-flex justify-content-between">
                                        <span>Таны хариулт: {{ $value }} оноо</span>
                                        <span class="text-muted">({{ $scoreText }})</span>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="mt-4">
                                <h5>Оноо хэрхэн тооцогдсон бэ?</h5>
                                <p>
                                    ESS нь 8 нөхцөл байдалд таны нойрмоглох эсвэл унтах магадлалыг үнэлдэг өөрийн үнэлгээний хэмжүүр юм. Таны хариултыг дараах байдлаар тооцоолсон:
                                </p>
                                <ul>
                                    <li>Нөхцөл байдал бүрд 0-3 оноогоор үнэлсэн</li>
                                    <li>Бүх 8 нөхцөл байдлын оноог нэгтгэсэн</li>
                                    <li>Нийт оноо 0-24 хооронд байна</li>
                                </ul>
                                <p>
                                    10 ба түүнээс дээш оноо нь эмнэлгийн тусламж авах эсвэл нэмэлт үнэлгээ хийх шаардлагатай байгааг илтгэнэ.
                                </p>
                                
                                <div class="text-center mt-4">
                                    <a href="{{ route('ess.index') }}" class="btn btn-primary">Дахин тест өгөх</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
