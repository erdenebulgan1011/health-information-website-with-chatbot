<!-- resources/views/adhd-test/about.blade.php -->
@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')    
<style>
        body {
            background-color: #f8f9fa;
        }
        .about-container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .section {
            margin-bottom: 30px;
        }
        .reference {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container about-container">
        <h1 class="text-center mb-4">ADHD Тестийн тухай</h1>
        
        <div class="section">
            <h3>Тестийн эх сурвалж</h3>
            <p>{{ $source }}</p>
            <div class="reference">
                {{ $reference }}
            </div>
        </div>
        
        <div class="section">
            <h3>Тестийн талаар</h3>
            <p>{{ $information }}</p>
            
            <h4 class="mt-4">Тестийн бүтэц:</h4>
            <ul>
                <li><strong>А хэсэг (1-6 асуулт):</strong> Анхаарал төвлөрөлт, зохион байгуулалттай холбоотой шинж тэмдгүүдийг хэмждэг.</li>
                <li><strong>Б хэсэг (7-18 асуулт):</strong> Хэт идэвхтэй байдал, түрэмгий шинж тэмдгүүдийг хэмждэг.</li>
            </ul>
            
            <h4 class="mt-4">Үр дүнгийн тайлбар:</h4>
            <ul>
                <li><strong>0-19 оноо:</strong> ADHD шинж тэмдэг бага байна</li>
                <li><strong>20-39 оноо:</strong> ADHD шинж тэмдэг дунд зэрэг байна</li>
                <li><strong>40-72 оноо:</strong> ADHD шинж тэмдэг өндөр байна</li>
            </ul>
        </div>
        
        <div class="section">
            <h3>Чухал мэдээлэл</h3>
            <div class="alert alert-warning">
                <p>Энэхүү тест нь зөвхөн скрининг зорилготой бөгөөд албан ёсны оношилгоо биш юм. ADHD-г зөвхөн эрүүл мэндийн мэргэжилтэн л үнэн зөв оношлох боломжтой. Хэрэв та өөртөө ADHD-тай байж болзошгүй гэж бодож байгаа бол сэтгэл зүйч, сэтгэцийн эмч эсвэл мэдрэлийн эмч зэрэг мэргэжлийн эмнэлгийн ажилтантай зөвлөлдөхийг зөвлөж байна.</p>
            </div>
            
            <p>ADHD-г оношлохын тулд дараах шалгуурууд байх шаардлагатай:</p>
            <ul>
                <li>Шинж тэмдгүүд хүүхэд насанд эхэлсэн байх (12 нас хүртэл)</li>
                <li>Шинж тэмдгүүд наад зах нь 6 сараас дээш хугацаанд үргэлжилсэн байх</li>
                <li>Шинж тэмдгүүд олон нийтийн газар (сургууль, ажлын байр г.м.) ба гэр орчин гэх мэт хоёр буюу түүнээс дээш нөхцөлд илэрдэг байх</li>
                <li>Шинж тэмдгүүд нь ажил, сургууль, нийгмийн харилцаа зэрэг амьдралын чухал хэсгүүдэд мэдэгдэхүйц саад учруулдаг байх</li>
                <li>Шинж тэмдгүүд нь өөр сэтгэцийн эмгэгээр тайлбарлагдахгүй байх</li>
            </ul>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('adhd.test') }}" class="btn btn-primary">Тест өгөх</a>
        </div>
    </div>

    @endsection