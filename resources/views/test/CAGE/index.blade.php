@extends('layouts.testapp')

@section('title', 'CAGE Архины Асуулга')

@section('content')

    <div class="container py-5">
        <h1 class="text-center mb-5">CAGE-ийн архины асуулга</h1>
        
        <div class="test-container">
            <h2 class="test-title">CAGE Үнэлгээ</h2>
            <p>Дараах асуултуудад хариулна уу:</p>
            
            <form action="{{ route('mental-health.process-cage') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <h5>C: Та архи уухаа болих хэрэгтэй гэж бодож байсан уу?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cage_1" id="cage_1_1" value="1" required>
                        <label class="form-check-label" for="cage_1_1">Тиймээ (+1)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cage_1" id="cage_1_0" value="0">
                        <label class="form-check-label" for="cage_1_0">Үгүй (+0)</label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h5>А: А хүмүүс архи ууж байгааг чинь шүүмжилснээр таныг бухимдуулсан уу?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cage_2" id="cage_2_1" value="1" required>
                        <label class="form-check-label" for="cage_2_1">Тиймээ (+1)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cage_2" id="cage_2_0" value="0">
                        <label class="form-check-label" for="cage_2_0">Үгүй (+0)</label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h5>Г: Та архи уусандаа өөрийгөө буруутай гэж бодож байсан уу?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cage_3" id="cage_3_1" value="1" required>
                        <label class="form-check-label" for="cage_3_1">Тиймээ (+1)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cage_3" id="cage_3_0" value="0">
                        <label class="form-check-label" for="cage_3_0">Үгүй (+0)</label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h5>Э: Та өглөө хамгийн түрүүнд ууж байсан уу (Eye opener)?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cage_4" id="cage_4_1" value="1" required>
                        <label class="form-check-label" for="cage_4_1">Тиймээ (+1)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cage_4" id="cage_4_0" value="0">
                        <label class="form-check-label" for="cage_4_0">Үгүй (+0)</label>
                    </div>
                </div>
                
                <div class="navigation-buttons">
                    <a href="{{ route('mental-health.index') }}" class="btn btn-secondary">Буцах</a>
                    <button type="submit" class="btn btn-success">Үр дүнг харах</button>
                </div>
            </form>
        </div>
    </div>

@endsection