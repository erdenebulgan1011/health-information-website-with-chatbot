@extends('layouts.dashboard')

@section('title', 'Эрүүл Мэндийн Хувийн Мэдээлэл')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Эрүүл Мэндийн Хувийн Мэдээлэл</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Хэрэглэгчийн мэдээлэл -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Хэрэглэгчийн мэдээлэл</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm mb-0">Нэр:</p>
                                            <h6>{{ $user->name }}</h6>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-0">Нас:</p>
                                            <h6>{{ $metrics['age'] ?? 'Тодорхойгүй' }} нас</h6>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <p class="text-sm mb-0">Өндөр:</p>
                                            <h6>{{ $profile->height ?? 'Тодорхойгүй' }} см</h6>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-0">Жин:</p>
                                            <h6>{{ $profile->weight ?? 'Тодорхойгүй' }} кг</h6>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <p class="text-sm mb-0">Хүйс:</p>
                                            <h6>{{ $profile->gender == 'male' ? 'Эрэгтэй' : 'Эмэгтэй' }}</h6>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-0">БЖИ:</p>
                                            <h6>{{ $metrics['bmi'] ?? 'Тодорхойгүй' }} ({{ $metrics['bmi_category'] ?? 'Тодорхойгүй' }})</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Эрүүл мэндийн үзүүлэлт</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm mb-0">Тамхи татдаг эсэх:</p>
                                            <h6>{{ $profile->is_smoker ? 'Тийм' : 'Үгүй' }}</h6>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-0">Архаг өвчтэй эсэх:</p>
                                            <h6>{{ $profile->has_chronic_conditions ? 'Тийм' : 'Үгүй' }}</h6>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <p class="text-sm mb-0">Суурь метаболизмын хурд (BMR):</p>
                                            <h6>{{ $metrics['bmr'] ?? 'Тодорхойгүй' }} ккал/өдөр</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AI Зөвлөмж -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0 text-white">AI Зөвлөмж</h6>
                                </div>
                                <div class="card-body">
                                    @if(isset($recommendations['ai_insights']) && $recommendations['ai_insights']['success'])
                                        {!! nl2br($recommendations['ai_insights']['insights']) !!}
                                    @else
                                        <div class="alert alert-warning">
                                            <p>{{ $recommendations['ai_insights']['message'] ?? 'AI зөвлөмж хараахан боловсруулагдаагүй байна. Та дараа дахин оролдоно уу.' }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Биеийн хөдөлгөөний зөвлөмж -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0 text-white">Биеийн хөдөлгөөний зөвлөмж</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach($recommendations['physical_activity'] as $activity)
                                            <li class="list-group-item">{{ $activity }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Эрүүл мэндийн ерөнхий мэдээлэл -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0 text-white">Эрүүл мэндийн ерөнхий мэдээлэл</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach($recommendations['health_insights'] as $insight)
                                            <li class="list-group-item">{{ $insight }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Эрсдлийн хүчин зүйлсийн дүн шинжилгээ -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h6 class="mb-0">Эрсдлийн хүчин зүйлсийн дүн шинжилгээ</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Хүчин зүйл</th>
                                                    <th>Эрсдлийн түвшин</th>
                                                    <th>Тайлбар</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recommendations['risk_factors'] as $risk)
                                                    <tr>
                                                        <td>{{ $risk['factor'] }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $risk['risk_level'] == 'Өндөр' ? 'danger' : ($risk['risk_level'] == 'Дунд зэрэг' ? 'warning' : 'info') }}">
                                                                {{ $risk['risk_level'] }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $risk['description'] }}</td>
                                                    </tr>
                                                @endforeach
                                                @if(count($recommendations['risk_factors']) == 0)
                                                    <tr>
                                                        <td colspan="3" class="text-center">Эрсдэлийн хүчин зүйлс илэрээгүй байна</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Холбоос товчууд -->
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                                Профайл засах
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                Хянах самбар руу буцах
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Онцлох эрсдлүүдийг тод харуулах
    document.addEventListener('DOMContentLoaded', function() {
        const highRiskItems = document.querySelectorAll('.badge.bg-danger');
        highRiskItems.forEach(item => {
            const row = item.closest('tr');
            if (row) {
                row.classList.add('table-danger');
            }
        });
    });
</script>
@endsection
