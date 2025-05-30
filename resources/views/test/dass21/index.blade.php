
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
        .option-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .option-box:hover {
            background-color: #f8f9fa;
        }
        .option-box.selected {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
        .question-card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">DASS-21 Тест</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">
                            Энэ нь сэтгэлийн хямрал, түгшүүр болон стрессийн сөрөг сэтгэл хөдлөлийн байдлыг хэмжих өөрийн үнэлгээний хэмжүүр юм. Доорх мэдэгдэл бүрийг уншаад өнгөрсөн долоо хоногт танд хэр зэрэг хамааралтай байсныг илэрхийлэх 0, 1, 2 эсвэл 3 гэсэн тоог сонгоно уу.
                        </p>

                        <form action="{{ route('dass21.calculate') }}" method="POST" id="dassForm">
                            @csrf

                            @foreach($questions as $index => $question)
                                <div class="question-card">
                                    <h5 class="mb-3">{{ $index }}. {{ $question }}</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="option-box" data-question="{{ $index }}" data-value="0">
                                                <input type="radio" name="q{{ $index }}" value="0" class="d-none" required>
                                                <strong>0:</strong> Надад огт хамааралгүй
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="option-box" data-question="{{ $index }}" data-value="1">
                                                <input type="radio" name="q{{ $index }}" value="1" class="d-none">
                                                <strong>1:</strong> Надад ямар нэг хэмжээгээр эсвэл зарим үед хэрэглэгдэж байсан
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="option-box" data-question="{{ $index }}" data-value="2">
                                                <input type="radio" name="q{{ $index }}" value="2" class="d-none">
                                                <strong>2:</strong> Надад нэлээд хэмжээгээр эсвэл цаг хугацааны сайн хэсэгт хамааралтай
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="option-box" data-question="{{ $index }}" data-value="3">
                                                <input type="radio" name="q{{ $index }}" value="3" class="d-none">
                                                <strong>3:</strong> Надад маш их эсвэл ихэнх тохиолдолд хамааралтай
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Үр дүнг харах</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle option selection
            const optionBoxes = document.querySelectorAll('.option-box');

            optionBoxes.forEach(box => {
                box.addEventListener('click', function() {
                    const question = this.dataset.question;
                    const value = this.dataset.value;

                    // Remove selection from other options in the same question
                    document.querySelectorAll(`.option-box[data-question="${question}"]`).forEach(option => {
                        option.classList.remove('selected');
                    });

                    // Select this option
                    this.classList.add('selected');

                    // Check the hidden radio button
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                });
            });
        });
    </script>
@endsection
