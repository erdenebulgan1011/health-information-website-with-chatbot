@extends('layouts.testapp')

@section('title', 'IPAQ Short Form')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">IPAQ Short Form</h3>
                    </div>
                    <div class="card-body">
                        <p>Энэхүү асуулга нь таны биеийн тамирын идэвхтэй байдлыг үнэлэхэд туслах зорилготой.</p>
                        <form action="{{ route('ipaq.submit') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label>1. Сунгалтын болон хөнгөн дасгалууд (гудамж, дугуй унах зэрэг):</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question1" value="Тийм" required>
                                    <label class="form-check-label">Тийм</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question1" value="Үгүй" required>
                                    <label class="form-check-label">Үгүй</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>2. Дунд зэргийн идэвхтэй дасгалууд (хурдан алхах, усанд сэлэх):</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question2" value="Тийм" required>
                                    <label class="form-check-label">Тийм</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question2" value="Үгүй" required>
                                    <label class="form-check-label">Үгүй</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>3. Хүнд дасгалууд (давхих, хүнд зүйл өргөх):</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question3" value="Тийм" required>
                                    <label class="form-check-label">Тийм</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question3" value="Үгүй" required>
                                    <label class="form-check-label">Үгүй</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>4. Өдөрт таны нийт сууж өнгөрүүлсэн цаг:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question4" value="Тийм" required>
                                    <label class="form-check-label">Тийм</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question4" value="Үгүй" required>
                                    <label class="form-check-label">Үгүй</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>5. Таны амралтын цаг:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question5" value="Тийм" required>
                                    <label class="form-check-label">Тийм</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question5" value="Үгүй" required>
                                    <label class="form-check-label">Үгүй</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>6. Та өдөрт хэдэн цаг хөдөлгөөнгүй сууж байна вэ?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question6" value="Тийм" required>
                                    <label class="form-check-label">Тийм</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question6" value="Үгүй" required>
                                    <label class="form-check-label">Үгүй</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>7. Өдөрт хэдэн цаг өөрийн хүсэлээр хөдөлгөөн хийж байна вэ?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question7" value="Тийм" required>
                                    <label class="form-check-label">Тийм</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question7" value="Үгүй" required>
                                    <label class="form-check-label">Үгүй</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">Илгээх</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
