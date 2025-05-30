@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-5">Ерөнхий түгшүүрийн эмгэг (GAD-2) үнэлгээний үр дүн</h1>
        
        <div class="result-container">
            <h2 class="result-title">GAD-2 Үр дүн</h2>
            <p class="result-score">Нийт оноо: {{ $gadScore }} / 6</p>
            
            <div class="result-interpretation {{ $gadScore >= 3 ? 'result-critical' : 'result-normal' }}">
                <p><strong>Дүгнэлт: {{ $gadResult }}</strong></p>
                @if($gadScore >= 3)
                    <p>3 оноо нь боломжит тохиолдлуудыг тодорхойлох, ерөнхий түгшүүрийн эмгэгийн цаашдын оношилгооны үнэлгээг хийх хамгийн тохиромжтой хязгаар юм. 3-ын хязгаарыг ашиглан GAD-2 нь ерөнхий түгшүүрийн эмгэгийг оношлоход 86% -ийн мэдрэмжтэй, 83% -ийн өвөрмөц онцлогтой байдаг.</p>
                    
                    <p>GAD-2-ийн түгшүүрийн эмгэгийг илрүүлэх скринингийн хэрэгсэл болох гүйцэтгэл:</p>
                    <ul>
                        <li>Ерөнхий түгшүүрийн эмгэг: Мэдрэмж 86%, Онцлог байдал 83%</li>
                        <li>Паник эмгэг: Мэдрэмж 76%, Онцлог байдал 81%</li>
                        <li>Нийгмийн түгшүүрийн эмгэг: Мэдрэмж 70%, Онцлог байдал 81%</li>
                        <li>Гэмтлийн дараах стрессийн эмгэг: Мэдрэмж 59%, Онцлог байдал 81%</li>
                    </ul>
                @else
                    <p>Таны оноо эмнэлзүйн хувьд чухал ач холбогдолгүй байна.</p>
                @endif
            </div>
            
            <div class="navigation-buttons">
                <a href="{{ route('mental-health.gad2') }}" class="btn btn-secondary">Дахин тест авах</a>
            </div>
        </div>
    </div>
    @endsection