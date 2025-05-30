@extends('layouts.dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Эрүүл мэндийн дэлгэрэнгүй тайлан</h4>
                    <a href="{{ route('health.dashboard') }}" class="btn btn-sm btn-light">Буцах</a>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5>{{ $user->name }} - Эрүүл мэндийн тайлан</h5>
                        <p class="text-muted">Үүсгэсэн: {{ $reportDate }}</p>

                        @if($profile->profile_pic)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $profile->profile_pic) }}" alt="Profile Picture" class="rounded-circle" width="100">
                            </div>
                        @endif
                    </div>

                    <!-- Basic Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Үндсэн мэдээлэл</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Нэр:</strong> {{ $user->name }}</p>
                                    <p><strong>И-мэйл:</strong> {{ $user->email }}</p>
                                    <p><strong>Нас:</strong> {{ $metrics['age'] ?? 'Бөглөөгүй' }} настай</p>
                                    <p><strong>Хүйс:</strong>
                                        @if($profile->gender == 'male')
                                            Эрэгтэй
                                        @elseif($profile->gender == 'female')
                                            Эмэгтэй
                                        @elseif($profile->gender == 'other')
                                            Бусад
                                        @else
                                            Бөглөөгүй
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Өндөр:</strong> {{ $profile->height ?? 'Бөглөөгүй' }} см</p>
                                    <p><strong>Жин:</strong> {{ $profile->weight ?? 'Бөглөөгүй' }} кг</p>
                                    <p><strong>Тамхи татдаг эсэх:</strong> {{ $profile->is_smoker ? 'Тийм' : 'Үгүй' }}</p>
                                    <p><strong>Архаг өвчтэй эсэх:</strong> {{ $profile->has_chronic_conditions ? 'Тийм' : 'Үгүй' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Health Metrics -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Эрүүл мэндийн үзүүлэлтүүд</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(isset($metrics['bmi']))
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="card-title">Биеийн жингийн индекс (BMI)</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="display-4 me-3">{{ $metrics['bmi'] }}</div>
                                                    <div>
                                                        <span class="badge
                                                            @if($metrics['bmi'] < 18.5) bg-warning
                                                            @elseif($metrics['bmi'] >= 18.5 && $metrics['bmi'] < 25) bg-success
                                                            @elseif($metrics['bmi'] >= 25 && $metrics['bmi'] < 30) bg-warning
                                                            @else bg-danger
                                                            @endif">
                                                            {{ $metrics['bmi_category'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="progress mt-2" style="height: 10px;">
                                                    @php
                                                        $bmiPercentage = min(($metrics['bmi'] / 40) * 100, 100);
                                                    @endphp
                                                    <div class="progress-bar
                                                        @if($metrics['bmi'] < 18.5) bg-warning
                                                        @elseif($metrics['bmi'] >= 18.5 && $metrics['bmi'] < 25) bg-success
                                                        @elseif($metrics['bmi'] >= 25 && $metrics['bmi'] < 30) bg-warning
                                                        @else bg-danger
                                                        @endif"
                                                        role="progressbar" style="width: {{ $bmiPercentage }}%">
                                                    </div>
                                                </div>
                                                <small class="text-muted mt-2 d-block">
                                                    <span class="float-start">0</span>
                                                    <span class="float-end">40+</span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(isset($metrics['bmr']))
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="card-title">Суурь Метаболикийн Хурд (BMR)</h6>
                                                <div class="display-4">{{ $metrics['bmr'] }}</div>
                                                <small class="text-muted">ккал/өдөр</small>
                                                <p class="mt-2">Таны бие ямар ч дасгал хөдөлгөөн хийхгүйгээр өдөрт ойролцоогоор {{ $metrics['bmr'] }} ккал хэрэглэдэг.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Risk Factors Analysis -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Эрсдэлийн хүчин зүйлсийн дүн шинжилгээ</h5>
                        </div>
                        <div class="card-body">
                            @if(count($recommendations['risk_factors']) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Хүчин зүйл</th>
                                                <th>Эрсдэлийн түвшин</th>
                                                <th>Тайлбар</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recommendations['risk_factors'] as $risk)
                                                <tr>
                                                    <td>{{ $risk['factor'] }}</td>
                                                    <td>
                                                        <span class="badge
                                                            @if($risk['risk_level'] == 'Өндөр') bg-danger
                                                            @elseif($risk['risk_level'] == 'Дунд зэрэг') bg-warning
                                                            @else bg-info
                                                            @endif">
                                                            {{ $risk['risk_level'] }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $risk['description'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Таны профайлд үндэслэн онцгой эрсдэлийн хүчин зүйлс илрээгүй байна.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Health Insights -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Эрүүл мэндийн мэдээлэл</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach($recommendations['health_insights'] as $insight)
                                    <li class="list-group-item">{{ $insight }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Physical Activity Recommendations -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Биеийн хөдөлгөөний зөвлөмжүүд</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach($recommendations['physical_activity'] as $recommendation)
                                    <li class="list-group-item">{{ $recommendation }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- AI Insights -->
                    @if(isset($recommendations['ai_insights']) && $recommendations['ai_insights']['success'])
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Хиймэл оюун ухаанд суурилсан зөвлөмжүүд</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-robot me-2"></i> Дараах зөвлөмжүүд нь хиймэл оюун ухаанд суурилсан бөгөөд зөвхөн ерөнхий мэдээллийн зорилгоор юм.
                                </div>
                                <div class="mt-3">
                                    {!! nl2br(e($recommendations['ai_insights']['insights'])) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Medical History -->
                    @if($profile->medical_history)
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Өвчний түүх</h5>
                            </div>
                            <div class="card-body">
                                <p>{{ $profile->medical_history }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('health.dashboard') }}" class="btn btn-secondary">Буцах</a>
                        <div>
                            <button class="btn btn-success me-2" onclick="window.print()">
                                <i class="fas fa-print me-1"></i> Хэвлэх
                            </button>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Профайл засах
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .btn, .card-header a, nav, footer {
            display: none !important;
        }
        .container {
            width: 100% !important;
            max-width: 100% !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .card-header {
            background-color: #f8f9fa !important;
            color: #000 !important;
        }
        body {
            color: #000;
        }
    }
</style>
@endpush
