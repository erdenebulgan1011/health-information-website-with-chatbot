@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    </div>

    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Нийт мэргэжилтнүүд</p>
                                <h5 class="font-weight-bolder">{{ $totalProfessionals }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-single-02 text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Баталгаажсан</p>
                                <h5 class="font-weight-bolder">{{ $verifiedProfessionals }}</h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">{{ $totalProfessionals > 0 ? round(($verifiedProfessionals / $totalProfessionals) * 100) : 0 }}%</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-check-bold text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Баталгаажаагүй</p>
                                <h5 class="font-weight-bolder">{{ $unverifiedProfessionals }}</h5>
                                <p class="mb-0">
                                    <span class="text-danger text-sm font-weight-bolder">{{ $totalProfessionals > 0 ? round(($unverifiedProfessionals / $totalProfessionals) * 100) : 0 }}%</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-fat-remove text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Эмч мэргэжилтэн</p>
                                <h5 class="font-weight-bolder">{{ $doctorStats['total'] }}</h5>
                                <p class="mb-0">
                                    <span class="text-info text-sm font-weight-bolder">{{ $totalProfessionals > 0 ? round(($doctorStats['total'] / $totalProfessionals) * 100) : 0 }}%</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                <i class="ni ni-favourite-28 text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Мэргэжилтэн бүртгэлийн өсөлт</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="professionals-chart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Мэргэжлийн чиглэлүүд</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="specialization-chart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Баталгаажуулалт (мэргэжлийн чиглэлээр)</h6>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Мэргэжил</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Нийт</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Баталгаажсан</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($verificationBySpecialization as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->specialization }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $item->total }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $item->verified }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-sm font-weight-bold">{{ round(($item->verified / $item->total) * 100) }}%</span>
                                            <div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-info" role="progressbar"
                                                         aria-valuenow="{{ round(($item->verified / $item->total) * 100) }}"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         style="width: {{ round(($item->verified / $item->total) * 100) }}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">VR контент санал</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="vr-content-chart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($doctorStats['by_workplace']) > 0)
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Эмч нарын ажлын байр</h6>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ажлын байр</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Тоо</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctorStats['by_workplace'] as $workplace)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $workplace->workplace }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $workplace->count }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Эмч нарын хэлний мэдлэг</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="languages-chart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-4">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Идэвхтэй мэргэжилтнүүд</h6>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Мэргэжилтэн</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Мэргэжил</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Сэдвүүд</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Хариултууд</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Нийт</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Үйлдэл</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mostActiveProfessionals as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if($user->profile && $user->profile->avatar)
                                                    <img src="{{ asset($user->profile->avatar) }}" class="avatar avatar-sm me-3" alt="user avatar">
                                                @else
                                                    <div class="avatar avatar-sm me-3 bg-gradient-primary">{{ substr($user->name, 0, 1) }}</div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->professional->specialization }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->topics_count }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->replies_count }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->topics_count + $user->replies_count }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.professionals.detail', $user->professional->id) }}" class="btn btn-sm btn-info">Дэлгэрэнгүй</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Сүүлийн мэргэжилтнүүд</h6>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Мэргэжилтэн</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Мэргэжил</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Мэргэшил</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Статус</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Бүртгүүлсэн</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Үйлдэл</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProfessionals as $professional)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if($professional->user->profile && $professional->user->profile->avatar)
                                                    <img src="{{ asset($professional->user->profile->avatar) }}" class="avatar avatar-sm me-3" alt="user avatar">
                                                @else
                                                    <div class="avatar avatar-sm me-3 bg-gradient-primary">{{ substr($professional->user->name, 0, 1) }}</div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $professional->user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $professional->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $professional->specialization }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $professional->qualification }}</p>
                                    </td>
                                    <td>
                                        @if($professional->is_verified)
                                            <span class="badge badge-sm bg-gradient-success">Баталгаажсан</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-warning">Баталгаажаагүй</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $professional->created_at->format('Y-m-d') }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.professionals.show', $professional->id) }}" class="btn btn-sm btn-info">Дэлгэрэнгүй</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gradient for charts
    var ctx1 = document.getElementById("professionals-chart").getContext("2d");
    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');

    // Professional registration over time chart
    var ctx1 = document.getElementById("professionals-chart").getContext("2d");
    var dates = {!! json_encode($professionalsByDate->pluck('date')) !!};
    var counts = {!! json_encode($professionalsByDate->pluck('count')) !!};

    new Chart(ctx1, {
        type: "line",
        data: {
            labels: dates,
            datasets: [{
                label: "Мэргэжилтнүүд",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#5e72e4",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: counts,
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        },
    });

    // VR content by status chart
    var ctx3 = document.getElementById("vr-content-chart").getContext("2d");
    var vrStatuses = ['pending', 'approved', 'rejected'];
    var vrCounts = [
        {{ $vrContentByProfessionals['pending'] ?? 0 }},
        {{ $vrContentByProfessionals['approved'] ?? 0 }},
        {{ $vrContentByProfessionals['rejected'] ?? 0 }}
    ];

    new Chart(ctx3, {
        type: "bar",
        data: {
            labels: ['Хүлээгдэж буй', 'Зөвшөөрсөн', 'Татгалзсан'],
            datasets: [{
                label: "VR контент",
                weight: 5,
                borderWidth: 0,
                borderRadius: 4,
                backgroundColor: ['#ffc107', '#2dce89', '#f5365c'],
                data: vrCounts,
                fill: false,
                maxBarThickness: 35
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Languages chart (if available)
    if (document.getElementById("languages-chart")) {
        var ctx4 = document.getElementById("languages-chart").getContext("2d");
        var languageLabels = {!! json_encode($doctorStats['language_distribution']->keys()) !!};
        var languageCounts = {!! json_encode($doctorStats['language_distribution']->values()) !!};

        new Chart(ctx4, {
            type: "doughnut",
            data: {
                labels: languageLabels,
                datasets: [{
                    label: "Хэлний мэдлэг",
                    weight: 9,
                    cutout: 50,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 2,
                    backgroundColor: ['#17c1e8', '#cb0c9f', '#3A416F', '#a8b8d8', '#82d616'],
                    data: languageCounts,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                },
                cutoutPercentage: 70,
            },
        });
    }

    // Specialization distribution chart
    var ctx2 = document.getElementById("specialization-chart").getContext("2d");
    var specLabels = {!! json_encode($specLabels) !!};
    var specCounts = {!! json_encode($specCounts) !!};

    new Chart(ctx2, {
        type: "pie",
        data: {
            labels: specLabels,
            datasets: [{
                label: "Мэргэжлийн чиглэлүүд",
                weight: 9,
                borderWidth: 2,
                backgroundColor: [
                    '#17c1e8', '#cb0c9f', '#3A416F', '#a8b8d8', '#82d616',
                    '#ea0606', '#f53939', '#f5b759', '#5e72e4', '#2dce89'
                ],
                data: specCounts,
                cutout: '30%'
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        },
    });
</script>
@endpush
