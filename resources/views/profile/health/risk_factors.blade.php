@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Эрсдэлийн хүчин зүйлсийн дүн шинжилгээ</h2>
                <a href="{{ route('health.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Хянах самбар руу буцах
                </a>
            </div>

            <!-- User Profile Summary Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        @if($profile->profile_pic)
                            <div class="col-auto">
                                <img src="{{ asset('storage/' . $profile->profile_pic) }}" alt="Profile Picture" class="rounded-circle" width="70">
                            </div>
                        @endif
                        <div class="col">
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <div class="d-flex flex-wrap gap-3 text-muted">
                                @if(isset($metrics['age']))
                                    <span><i class="fas fa-birthday-cake me-1"></i> {{ $metrics['age'] }} настай</span>
                                @endif

                                @if($profile->gender)
                                    <span>
                                        <i class="fas fa-venus-mars me-1"></i>
                                        @if($profile->gender == 'male')
                                            Эрэгтэй
                                        @elseif($profile->gender == 'female')
                                            Эмэгтэй
                                        @else
                                            Бусад
                                        @endif
                                    </span>
                                @endif

                                @if($profile->height && $profile->weight)
                                    <span><i class="fas fa-weight me-1"></i> {{ $profile->weight }} кг</span>
                                    <span><i class="fas fa-ruler-vertical me-1"></i> {{ $profile->height }} см</span>
                                @endif

                                @if(isset($metrics['bmi']))
                                    <span><i class="fas fa-calculator me-1"></i> BMI: {{ $metrics['bmi'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Risk Level Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Эрсдэлийн түвшний хураангуй</h5>
                </div>
                <div class="card-body">
                    @php
                        $highRisks = 0;
                        $mediumRisks = 0;
                        $lowRisks = 0;

                        foreach($recommendations['risk_factors'] as $risk) {
                            if($risk['risk_level'] == 'Өндөр') {
                                $highRisks++;
                            } elseif($risk['risk_level'] == 'Дунд зэрэг') {
                                $mediumRisks++;
                            } else {
                                $lowRisks++;
                            }
                        }

                        $totalRisks = count($recommendations['risk_factors']);
                        $riskScore = ($highRisks * 3 + $mediumRisks * 2 + $lowRisks * 1);
                        $maxScore = $totalRisks * 3;
                        $riskPercentage = $maxScore > 0 ? ($riskScore / $maxScore) * 100 : 0;
                    @endphp

                    <div class="row mb-3">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="border rounded p-3 h-100">
                                <h6 class="text-danger">Өндөр эрсдэл</h6>
                                <div class="display-4">{{ $highRisks }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="border rounded p-3 h-100">
                                <h6 class="text-warning">Дунд зэргийн эрсдэл</h6>
                                <div class="display-4">{{ $mediumRisks }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="border rounded p-3 h-100">
                                <h6 class="text-info">Бага эрсдэл</h6>
                                <div class="display-4">{{ $lowRisks }}</div>
                            </div>
                        </div>
                    </div>

                    @if($totalRisks > 0)
                        <div class="mt-4">
                            <h6>Ерөнхий эрсдэлийн түвшин</h6>
                            <div class="progress" style="height: 1.5rem;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ min($highRisks * 25, 100) }}%" aria-valuenow="{{ $highRisks * 25 }}" aria-valuemin="0" aria-valuemax="100">
                                    @if($highRisks > 0) Өндөр @endif
                                </div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ min($mediumRisks * 15, 100 - min($highRisks * 25, 100)) }}%" aria-valuenow="{{ $mediumRisks * 15 }}" aria-valuemin="0" aria-valuemax="100">
                                    @if($mediumRisks > 0) Дунд @endif
                                </div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ min($lowRisks * 10, 100 - min($highRisks * 25 + $mediumRisks * 15, 100)) }}%" aria-valuenow="{{ $lowRisks * 10 }}" aria-valuemin="0" aria-valuemax="100">
                                    @if($lowRisks > 0) Бага @endif
                                </div>
                            </div>

                            <div class="mt-3">
                                @if($riskPercentage >= 70)
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Анхаар:</strong> Таны профайлд өндөр эрсдэлийн хүчин зүйлс илэрч байна. Эрүүл мэндийн мэргэжилтэнтэй яаралтай зөвлөлдөхийг зөвлөж байна.
                                    </div>
                                @elseif($riskPercentage >= 40)
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <strong>Анхаар:</strong> Таны профайлд дунд зэргийн эрсдэлийн хүчин зүйлс илэрч байна. Эрүүл мэндээ сайжруулахын тулд доорх зөвлөмжүүдийг анхаарна уу.
                                    </div>
                                @else
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>Сайн байна!</strong> Таны профайлд харьцангуй бага эрсдэлийн хүчин зүйлс илэрч байна. Эрүүл мэндээ хадгалахын тулд доорх зөвлөмжүүдийг үргэлжлүүлэн дагана уу.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Баяр хүргэе!</strong> Таны профайлд онцгой эрсдэлийн хүчин зүйлс илрээгүй байна.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detailed Risk Factors Analysis -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Дэлгэрэнгүй эрсдэлийн хүчин зүйлсийн дүн шинжилгээ</h5>
                </div>
                <div class="card-body">
                    @if(count($recommendations['risk_factors']) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Хүчин зүйл</th>
                                        <th>Эрсдэлийн түвшин</th>
                                        <th>Тайлбар</th>
                                        <th>Зөвлөмжүүд</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recommendations['risk_factors'] as $risk)
                                        <tr>
                                            <td>
                                                <strong>{{ $risk['factor'] }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge
                                                    @if($risk['risk_level'] == 'Өндөр') bg-danger
                                                    @elseif($risk['risk_level'] == 'Дунд зэрэг') bg-warning text-dark
                                                    @else bg-info text-dark
                                                    @endif px-3 py-2">
                                                    {{ $risk['risk_level'] }}
                                                </span>
                                            </td>
                                            <td>{{ $risk['description'] }}</td>
                                            <td>
                                                @if($risk['factor'] === 'Таргалалт' || $risk['factor'] === 'Илүүдэл жин')
                                                    <ul class="mb-0 ps-3">
                                                        <li>Эрүүл хооллолт дадал хэвшүүлэх</li>
                                                        <li>Долоо хоногт 150 минутаас багагүй дасгал хөдөлгөөн</li>
                                                        <li>Хоолны порцын хэмжээг багасгах</li>
                                                    </ul>
                                                @elseif($risk['factor'] === 'Тамхидалт')
                                                    <ul class="mb-0 ps-3">
                                                        <li>Тамхи татахаа бүрэн зогсоох</li>
                                                        <li>Тамхи татахаа зогсооход туслах мэргэжлийн тусламж авах</li>
                                                        <li>Тамхи орлуулах эмчилгээ хэрэглэх</li>
                                                    </ul>
                                                @elseif(strpos($risk['factor'], 'нас') !== false)
                                                    <ul class="mb-0 ps-3">
                                                        <li>Жилд нэг удаа эрүүл мэндийн үзлэгт хамрагдах</li>
                                                        <li>Зүрх судасны эрүүл мэндийн шинжилгээ өгөх</li>
                                                        <li>Биеийн хөдөлгөөн тогтмол хийх</li>
                                                    </ul>
                                                @else
                                                    <ul class="mb-0 ps-3">
                                                        <li>Эрүүл мэндийн мэргэжилтэнтэй тогтмол уулзах</li>
                                                        <li>Эрүүл амьдралын хэв маягийг дэмжих</li>
                                                        <li>Стрессийг менежмент хийх</li>
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Одоогоор таны профайлд тодорхой эрсдэлийн хүчин зүйлс илрээгүй байна. Энэ нь сайн хэрэг!
                            Гэсэн хэдий ч эрүүл мэндээ хадгалахын тулд тогтмол дасгал хөдөлгөөн хийж, эрүүл хооллолтын дэглэм баримтлахыг зөвлөж байна.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Age-Related Risk Factors -->
            @if(isset($metrics['age']))
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Насны бүлгийн эрсдэлийн хүчин зүйлс</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="text-center">
                                    <div class="display-4 text-primary mb-2">{{ $metrics['age'] }}</div>
                                    <p class="lead">Таны одоогийн нас</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                @if($metrics['age'] < 30)
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">Залуу насны эрсдэлийн хүчин зүйлс</h6>
                                        <ul class="mb-0">
                                            <li>Аюултай зан үйл ба эрсдэлт дадал</li>
                                            <li>Хортой бодис хэрэглэх (тамхи, архи, бусад бодис)</li>
                                            <li>Хөдөлгөөний дутагдал ба архаг стресс</li>
                                        </ul>
                                    </div>
                                @elseif($metrics['age'] >= 30 && $metrics['age'] < 50)
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">Дунд насны эрсдэлийн хүчин зүйлс</h6>
                                        <ul class="mb-0">
                                            <li>Илүүдэл жин ба таргалалт</li>
                                            <li>Цусны даралт ихсэх эрсдэл</li>
                                            <li>Ажлын стресс ба сэтгэцийн дарамт</li>
                                            <li>2-р төрлийн чихрийн шижингийн эрсдэл</li>
                                        </ul>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">Ахмад насны эрсдэлийн хүчин зүйлс</h6>
                                        <ul class="mb-0">
                                            <li>Зүрх судасны өвчин</li>
                                            <li>Яс сийрэгжилт</li>
                                            <li>Үений өвчин</li>
                                            <li>Мэдрэл, мэдрэхүйн доройтол</li>
                                            <li>Архаг өвчнүүд хүндрэх эрсдэл</li>
                                        </ul>
                                    </div>
                                @endif

                                <h6 class="mt-3">Таны насны бүлэгт зориулсан зөвлөмжүүд:</h6>
                                @if($metrics['age'] < 30)
                                    <ul>
                                        <li>Эрүүл зан үйл, дадал хэвшүүлэх</li>
                                        <li>Долоо хоногт дор хаяж 150 минут дунд зэргийн эрчимтэй дасгал хийх</li>
                                        <li>Стрессийг зохицуулах арга техникийг эзэмших</li>
                                        <li>Тамхи татахаас зайлсхийх, архи хэрэглэхээс татгалзах</li>
                                    </ul>
                                @elseif($metrics['age'] >= 30 && $metrics['age'] < 50)
                                    <ul>
                                        <li>Тогтмол эрүүл мэндийн үзлэгт хамрагдах</li>
                                        <li>Цусны даралт, холестерин, чихрийн шижинг шалгуулах</li>
                                        <li>Тогтмол дасгал хөдөлгөөн хийх</li>
                                        <li>Дээд зэргийн үйл явдал, стрессийн шалтгааныг менежмент хийх</li>
                                    </ul>
                                @else
                                    <ul>
                                        <li>Жилд нэг удаа дэлгэрэнгүй эрүүл мэндийн үзлэгт хамрагдах</li>
                                        <li>Унахаас сэргийлэх тэнцвэрийн дасгалууд хийх</li>
                                        <li>Ясны нягтшилыг хянах</li>
                                        <li>Оюун санааны идэвхтэй байдлаа хадгалах</li>
                                        <li>Нийгмийн харилцаа холбоогоо хадгалах</li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Preventive Recommendations -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Урьдчилан сэргийлэх зөвлөмжүүд</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-primary text-white p-3 me-3" style="height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-heartbeat fa-2x"></i>
                                        </div>
                                        <h5 class="mb-0">Зүрх судасны эрүүл мэнд</h5>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Долоо хоногт 150 минут дасгал хөдөлгөөн хийх</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Давс, ханасан тос багатай хооллох</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Жимс, ногоо, шим тэжээл ихтэй хүнс хэрэглэх</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Тогтмол цусны даралт шалгуулах</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Тамхи татахгүй байх</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-success text-white p-3 me-3" style="height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-apple-alt fa-2x"></i>
                                        </div>
                                        <h5 class="mb-0">Хооллолт ба шим тэжээл</h5>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Өдөрт 5 төрлийн жимс, ногоо хэрэглэх</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Шим тэжээл ихтэй үр тариа хэрэглэх</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Чихэртэй ундаа, боловсруулсан хүнс хязгаарлах</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Өдөрт 6-8 аяга ус уух</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Порцын хэмжээг хянах</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-warning text-white p-3 me-3" style="height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-brain fa-2x"></i>
                                        </div>
                                        <h5 class="mb-0">Сэтгэцийн эрүүл мэнд</h5>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Стрессийг бууруулах аргуудыг эзэмших</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Хангалттай амрах, унтах</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Нийгмийн холбоо, харилцаагаа хадгалах</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Бясалгал, амьсгалын дасгал туршиж үзэх</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Шаардлагатай үед мэргэжлийн тусламж авах</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-info text-white p-3 me-3" style="height: 50px; width: 50px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-shield-alt fa-2x"></i>
                                        </div>
                                        <h5 class="mb-0">Урьдчилан сэргийлэх шалгалт</h5>
                                    </div>
                                    <ul class="list-unstyled">
                                        @if(isset($metrics['age']))
                                            @if($metrics['age'] < 40)
                                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 2-3 жил тутамд ерөнхий эрүүл мэндийн үзлэг</li>
                                            @elseif($metrics['age'] >= 40 && $metrics['age'] < 50)
                                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Жил бүр цусны даралт шалгуулах</li>
                                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 3 жил тутамд холестерин шалгуулах</li>
                                            @else
                                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Жил бүр иж бүрэн эрүүл мэндийн үзлэг</li>
                                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Колоноскопи шинжилгээ</li>
                                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Ясны нягтшил шалгах</li>
                                            @endif
                                        @endif
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Шүдээ 6 сар тутамд шалгуулах</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Нүдээ жил тутамд шалгуулах</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('health.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Хянах самбар руу буцах
                </a>
                <div>
                    <a href="{{ route('health.report') }}" class="btn btn-info me-2">
                        <i class="fas fa-file-alt me-1"></i> Бүрэн тайлан харах
                    </a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Профайл засах
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endpush
