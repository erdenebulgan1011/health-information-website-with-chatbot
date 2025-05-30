@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">GAD-7 Шинжилгээний үр дүн</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h4>Таны GAD-7 оноо: <span class="badge bg-{{ $interpretation['alert'] }}">{{ $score }}</span></h4>
                        </div>
                        
                        <div class="alert alert-{{ $interpretation['alert'] }}">
                            <h5 class="alert-heading">Түгшүүрийн зэрэг: {{ $interpretation['severity'] }}</h5>
                            <p class="mb-0">{{ $interpretation['description'] }}</p>
                        </div>
                        
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Тайлбар</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Түгшүүрийн эмгэгийг илрүүлэх үед 8 ба түүнээс дээш оноо нь түгшүүрийн ерөнхий эмгэгийн магадлалтай тохиолдлыг тодорхойлох боломжийн хязгаарыг илэрхийлнэ</strong>; Сэтгэл түгших эмгэг байгаа эсэх, төрлийг тодорхойлохын тулд нэмэлт оношлогооны үнэлгээ хийх шаардлагатай.</p>
                                
                                <h6>Дараах хязгаарлалтууд нь сэтгэлийн түгшүүрийн зэрэгтэй хамааралтай байна:</h6>
                                <ul>
                                    <li><strong>0-4 оноо:</strong> Хамгийн бага түгшүүртэй</li>
                                    <li><strong>5-9 оноо:</strong> Бага зэргийн түгшүүр</li>
                                    <li><strong>10-14 оноо:</strong> Дунд зэргийн түгшүүртэй</li>
                                    <li><strong>15-аас дээш оноо:</strong> Хүнд айдас</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">GAD-7-ийн түгшүүрийн эмгэгийг илрүүлэх скринингийн хэрэгсэл</h5>
                            </div>
                            <div class="card-body">
                                <p>Хэдийгээр GAD-7 нь ерөнхий түгшүүрийг илрүүлэх скринингийн хэрэгсэл болгон бүтээгдсэн боловч үймээн самууны эмгэг, нийгмийн түгшүүрийн эмгэг, гэмтлийн дараах стрессийн эмгэг зэрэг бусад гурван нийтлэг түгшүүрийн эмгэгийг шалгах хэрэгсэл болохуйц сайн гүйцэтгэлтэй байдаг.</p>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Туршилт</th>
                                                <th>Мэдрэмж</th>
                                                <th>Онцлог байдал</th>
                                                <th>Эерэг магадлалын харьцаа</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($performanceData as $data)
                                                <tr>
                                                    <td>{{ $data['condition'] }}</td>
                                                    <td>{{ $data['sensitivity'] }}</td>
                                                    <td>{{ $data['specificity'] }}</td>
                                                    <td>{{ $data['ratio'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('gad7.index') }}" class="btn btn-primary">Дахин тест авах</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
