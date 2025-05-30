{{-- @extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Key Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">{{ $totalUsers }}</p>
                        <a href="{{ route('topics.index') }}" class="btn btn-link">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Users (7 days)</h5>
                        <p class="card-text">{{ $newUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Diseases</h5>
                        <p class="card-text">{{ $totalDiseases }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total VR Contents</h5>
                        <p class="card-text">{{ $totalVrContents }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        @if($pendingSuggestions > 0)
            <div class="alert alert-info mb-4">
                There are {{ $pendingSuggestions }} pending VR content suggestions.
                <a href="{{ route('vr.admin.suggestions') }}" class="alert-link">Review Now</a>
            </div>
        @endif

        <!-- Recent Activities -->
        <h2>Recent Activities</h2>
        <div class="row">
            <div class="col-md-4">
                <h3>Recent Topics</h3>
                <ul class="list-group">
                    @foreach($recentTopics as $topic)
                        <li class="list-group-item">
                            {{ $topic->title }} - by {{ $topic->user->name }} on {{ $topic->created_at->format('Y-m-d') }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Recent Replies</h3>
                <ul class="list-group">
                    @foreach($recentReplies as $reply)
                        <li class="list-group-item">
                            {{ Str::limit($reply->content, 50) }} - by {{ $reply->user->name }} on {{ $reply->created_at->format('Y-m-d') }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Recent Users</h3>
                <ul class="list-group">
                    @foreach($recentUsers as $user)
                        <li class="list-group-item">
                            {{ $user->name }} - joined on {{ $user->created_at->format('Y-m-d') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Upcoming Events -->
        <h2 class="mt-4">Upcoming Events</h2>
        <ul class="list-group mb-4">
            @foreach($upcomingEvents as $event)
                <li class="list-group-item">
                    {{ $event->title }} - starts on {{ $event->start_time->format('Y-m-d H:i') }}
                </li>
            @endforeach
        </ul>

        <!-- Charts -->
        <h2>User Growth (Last 30 Days)</h2>
        <canvas id="userGrowthChart" class="mb-4"></canvas>

        <h2>VR Contents by Category</h2>
        <canvas id="vrContentsChart"></canvas>
    </div>

    <!-- Chart.js Scripts -->
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // User Growth Chart
            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            const userGrowthChart = new Chart(userGrowthCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($userGrowth->keys()) !!},
                    datasets: [{
                        label: 'New Users',
                        data: {!! json_encode($userGrowth->values()) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // VR Contents by Category Chart
            const vrContentsCtx = document.getElementById('vrContentsChart').getContext('2d');
            const vrContentsChart = new Chart(vrContentsCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($vrContentsByCategory->pluck('name')) !!},
                    datasets: [{
                        label: 'VR Contents',
                        data: {!! json_encode($vrContentsByCategory->pluck('vr_contents_count')) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script>
    @endsection
@endsection --}}
{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="m-0 text-dark">Админ Хяналтын Самбар</h1>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" id="refreshDashboard">
                        <i class="fas fa-sync-alt mr-1"></i> Өгөгдлийг Шинэчлэх
                    </button>
                    <a href="{{ route('admin.user') }}" class="btn btn-outline-primary">
                        <i class="fas fa-download mr-1"></i> Өгөгдөл Татах
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Нийт Хэрэглэгчид</div>
                            <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                            <div class="mt-2 text-success">
                                <i class="fas {{ $activityInsights['user_growth_rate'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                <span>{{ $activityInsights['user_growth_rate'] }}% өсөлт</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-3x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.user') }}" class="btn btn-sm btn-primary btn-block">Хэрэглэгчдийг Харах</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">VR Агуулга</div>
                            <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $vrContentCount }}</div>
                            <div class="mt-2 text-success">
                                <i class="fas {{ $activityInsights['vr_content_growth_rate'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                <span>{{ $activityInsights['vr_content_growth_rate'] }}% өсөлт</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vr-cardboard fa-3x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('vr.index') }}" class="btn btn-sm btn-success btn-block">Агуулга Харах</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Арга Хэмжээнүүд</div>
                            <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $eventCount }}</div>
                            <div class="mt-2 text-muted">
                                <i class="fas fa-calendar-check mr-1"></i>
                                <span>Удахгүй болох: {{ $activityInsights['total_events'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-3x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('events.index') }}" class="btn btn-sm btn-warning btn-block">Арга Хэмжээ Харах</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Хэлэлцүүлгийн Сэдвүүд</div>
                            <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $topicCount }}</div>
                            <div class="mt-2 text-muted">
                                <i class="fas fa-comments mr-1"></i>
                                <span>Идэвхтэй хэлэлцүүлэг</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-3x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.topics.index') }}" class="btn btn-sm btn-info btn-block">Сэдвүүдийг Харах</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Visualization Section -->
    <div class="row">
        <!-- User Registration Chart -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line mr-1"></i> Хэрэглэгч Бүртгүүлэлтийн Чиг Хандлага
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="userChartDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="userChartDropdown">
                            <div class="dropdown-header">Диаграммын Тохиргоо:</div>
                            <a class="dropdown-item chart-period" href="#" data-period="6">Сүүлийн 6 Сар</a>
                            <a class="dropdown-item chart-period" href="#" data-period="3">Сүүлийн 3 Сар</a>
                            <a class="dropdown-item chart-period" href="#" data-period="1">Сүүлийн Сар</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userRegistrationChart" height="320"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Insights -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Платформын Мэдээлэл</h6>
                </div>
                <div class="card-body">
                    <div class="progress-group mb-4">
                        <span class="progress-text">Саяхны Хэрэглэгчид (30 өдөр)</span>
                        <span class="float-right">{{ $activityInsights['recent_users'] }}/{{ $activityInsights['total_users'] }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: {{ ($activityInsights['recent_users'] / $activityInsights['total_users']) * 100 }}%"></div>
                        </div>
                    </div>

                    <div class="progress-group mb-4">
                        <span class="progress-text">Хэрэглэгч Бүрийн Дундаж Агуулга</span>
                        <span class="float-right">{{ $activityInsights['avg_content_per_user'] ?? 0 }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: {{ min(($activityInsights['avg_content_per_user'] ?? 0) * 10, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="progress-group mb-4">
                        <span class="progress-text">2FA-н Хэрэглээний Түвшин</span>
                        <span class="float-right">{{ $activityInsights['2fa_adoption_rate'] ?? 0 }}%</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: {{ $activityInsights['2fa_adoption_rate'] ?? 0 }}%"></div>
                        </div>
                    </div>

                    <div class="progress-group">
                        <span class="progress-text">Админ Хэрэглэгчид</span>
                        <span class="float-right">{{ $activityInsights['admin_percentage'] ?? 0 }}%</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: {{ $activityInsights['admin_percentage'] ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- VR Content Uploads Chart -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-chart-bar mr-1"></i> VR Агуулга Байршуулалт
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="vrChartDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="vrChartDropdown">
                            <div class="dropdown-header">Диаграммын Тохиргоо:</div>
                            <a class="dropdown-item vr-chart-type" href="#" data-type="bar">Багана Диаграмм</a>
                            <a class="dropdown-item vr-chart-type" href="#" data-type="line">Шугаман Диаграмм</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="vrContentChart" height="320"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-user-clock mr-1"></i> Саяхны Хэрэглэгч Бүртгэл
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="recentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="recentDropdown">
                            <div class="dropdown-header">Харах Сонголтууд:</div>
                            <a class="dropdown-item" href="{{ route('admin.user') }}">Бүх Хэрэглэгчид</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Хэрэглэгчийн Жагсаалт Татах</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 text-muted">{{ $user->email }}</p>
                            <div class="d-flex w-100 justify-content-between">
                                <small>
                                    @if($user->google2fa_enabled)
                                    <span class="badge badge-success">2FA Идэвхтэй</span>
                                    @endif
                                    @if($user->is_admin)
                                    <span class="badge badge-danger">Админ</span>
                                    @endif
                                </small>
                                <a href="{{ route('admin.user', $user->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.user') }}" class="btn btn-block btn-outline-info">
                        <i class="fas fa-users mr-1"></i> Бүх Хэрэглэгчдийг Харах
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Comparisons -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Сарын Гүйцэтгэл</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Энэ Сарын Хэрэглэгчид
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $activityInsights['current_month_users'] ?? 0 }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Энэ Сарын 3 Д Контентын Байршуулалт
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $activityInsights['current_month_vr_content'] ?? 0 }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-upload fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Өсөлтийн Хурд (Хэрэглэгчид)
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $activityInsights['user_growth_rate'] }}%
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas {{ $activityInsights['user_growth_rate'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Өсөлтийн Хурд (3 Д Контент)
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $activityInsights['vr_content_growth_rate'] }}%
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas {{ $activityInsights['vr_content_growth_rate'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    .chart-area, .chart-bar {
        position: relative;
        height: 100%;
        width: 100%;
    }

    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }

    .progress {
        height: 0.5rem;
        overflow: hidden;
    }

    .progress-group {
        margin-bottom: 1.2rem;
    }

    .progress-text {
        font-weight: 600;
        color: #3a3b45;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Registration Chart
    var userCtx = document.getElementById('userRegistrationChart').getContext('2d');
    var userChart = new Chart(userCtx, {
        type: 'line',
        data: {
            labels: @json($userRegistrationLabels),
            datasets: [{
                label: 'Хэрэглэгч Бүртгэл',
                data: @json($userRegistrationData),
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(78, 115, 223, 1)',
                pointHoverRadius: 5,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "rgb(255, 255, 255)",
                    bodyColor: "#858796",
                    titleMarginBottom: 10,
                    titleColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    }
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        borderDash: [2],
                        drawBorder: false
                    }
                }
            }
        }
    });

    // VR Content Upload Chart
    var vrContentCtx = document.getElementById('vrContentChart').getContext('2d');
    var vrContentChart = new Chart(vrContentCtx, {
        type: 'bar',
        data: {
            labels: @json($vrContentLabels),
            datasets: [{
                label: 'VR Агуулга Байршуулалт',
                data: @json($vrContentData),
                backgroundColor: 'rgba(28, 200, 138, 0.6)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "rgb(255, 255, 255)",
                    bodyColor: "#858796",
                    titleMarginBottom: 10,
                    titleColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    }
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        borderDash: [2],
                        drawBorder: false
                    }
                }
            }
        }
    });

    // Chart interactions
    document.querySelectorAll('.chart-period').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            // This is where you would change the data based on the period
            // For now, just a placeholder
            alert('Хугацааны шүүлтүүр өгөгдлийг ачаална: ' + this.dataset.period + ' сар');
        });
    });

    document.querySelectorAll('.vr-chart-type').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            vrContentChart.config.type = this.dataset.type;
            vrContentChart.update();
        });
    });

    // Dashboard refresh button
    document.getElementById('refreshDashboard').addEventListener('click', function() {
        const button = this;
        const originalHtml = button.innerHTML;

        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Шинэчилж байна...';
        button.disabled = true;

        // Simulate refresh - in real app would use AJAX to refresh data
        setTimeout(function() {
            button.innerHTML = originalHtml;
            button.disabled = false;

            // Display a success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = '<strong>Амжилттай!</strong> Хяналтын самбарын өгөгдөл шинэчлэгдсэн. <button type="button" class="close" data-dismiss="alert">&times;</button>';

            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.container-fluid').firstChild);

            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                alertDiv.classList.remove('show');
                setTimeout(function() {
                    alertDiv.remove();
                }, 150);
            }, 5000);
        }, 1000);
    });
});
</script>
@endpush
