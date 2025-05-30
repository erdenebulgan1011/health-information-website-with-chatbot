<!-- resources/views/adhd-test/index.blade.php -->
@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')    <style>
        body {
            background-color: #f8f9fa;
        }
        .test-container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .question {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .section-header {
            margin-top: 30px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }
        .options {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .form-check {
            margin-right: 10px;
        }
        .submit-btn {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container test-container">
        <h1 class="text-center mb-4">ADHD Үнэлгээний тест</h1>
        <p class="lead text-center mb-5">Доорх асуултуудад хариулж, өөрийн ADHD шинж тэмдгийн түвшинг шалгана уу.</p>
        
        <form action="{{ route('adhd.submit') }}" method="POST">
            @csrf
            
            <h3 class="section-header">А хэсэг</h3>
            <div class="options mb-4">
                <div class="option-label">Хэзээ ч</div>
                <div class="option-label">Ховор</div>
                <div class="option-label">Заримдаа</div>
                <div class="option-label">Заримдаа</div>
                <div class="option-label">Маш олон удаа</div>
            </div>
            
            <div class="question">
                <p>1. Хүнд хэцүү хэсгүүдийг хийж дуусаад төслийн эцсийн нарийн ширийн зүйлийг дуусгахад хэр олон удаа бэрхшээлтэй тулгардаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q1" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>2. Зохион байгуулалт шаардсан ажил хийх үед та аливаа зүйлийг эмх цэгцэнд оруулахад хэр бэрхшээлтэй тулгардаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q2" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>3. Томилгоо эсвэл үүргээ санахад хэр олон удаа асуудал гардаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q3" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>4. Та маш их эргэцүүлэн бодох ажилтай бол эхлэхээс хэр зайлсхийдэг эсвэл хойшлуулдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q4" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>5. Удаан суух шаардлага гарвал хөл, гараараа чимхэх, эргэлдэх нь хэр их байдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q5" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>6. Та моторт жолоодлоготой юм шиг хэт идэвхтэй, ямар нэгэн зүйл хийхээс өөр аргагүйд хүрдэг гэж хэр олон удаа мэдэрдэг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q6" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <h3 class="section-header">Б хэсэг</h3>
            <div class="options mb-4">
                <div class="option-label">Хэзээ ч</div>
                <div class="option-label">Ховор</div>
                <div class="option-label">Заримдаа</div>
                <div class="option-label">Заримдаа</div>
                <div class="option-label">Маш олон удаа</div>
            </div>
            
            <div class="question">
                <p>7. Та уйтгартай эсвэл хэцүү төсөл дээр ажиллахдаа хайхрамжгүй алдаа хэр их гаргадаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q7" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>8. Та уйтгартай эсвэл давтагдах ажил хийж байхдаа анхаарлаа төвлөрүүлэхэд хэр бэрхшээлтэй байдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q8" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>9. Хүмүүс тантай шууд ярилцаж байсан ч танд хэлэх зүйлдээ анхаарлаа төвлөрүүлэхэд хэр бэрхшээлтэй байдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q9" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>10. Та гэртээ эсвэл ажил дээрээ юмаа олоход хэр их бэрхшээлтэй байдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q10" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>11. Та эргэн тойрныхоо үйл ажиллагаа, чимээ шуугианд хэр их сатаардаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q11" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>12. Суудалдаа үлдэхээр хүлээгдэж буй хурал болон бусад нөхцөл байдалд та хэр олон удаа суудлаа орхидог вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q12" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>13. Та хэр олон удаа тайван бус юм шиг санагддаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q13" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>14. Та өөртөө цаг гарвал тайвширч, тайвшрахад хэр бэрхшээлтэй байдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q14" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>15. Та олон нийтийн харилцаанд байхдаа хэт их ярихдаа хэр их тохиолддог вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q15" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>16. Ярилцаж байх үедээ ярилцаж буй хүмүүсийнхээ өгүүлбэрийг өөрсдөө дуусгахаас нь өмнө дуусгах үе хэр олон байдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q16" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>17. Ээлж авах шаардлагатай үед та ээлжээ хүлээхэд хэр бэрхшээлтэй байдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q17" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="question">
                <p>18. Бусдыг завгүй байхад нь хэр олон удаа тасалдаг вэ?</p>
                <div class="options">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q18" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="submit-btn text-center">
                <button type="submit" class="btn btn-primary btn-lg">Үр дүнг харах</button>
            </div>
        </form>
    </div>

    @endsection