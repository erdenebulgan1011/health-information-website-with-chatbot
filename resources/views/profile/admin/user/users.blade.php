<!-- resources/views/admin/reports/users.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Хэрэглэгчийн Тайлан</h1>

        <div class="d-flex flex-wrap gap-2">
            {{-- New Export Trigger --}}
  <button
  type="button"
  class="btn btn-sm btn-info"
  data-bs-toggle="modal"
  data-bs-target="#exportUserReportModal"
>
  <i class="fas fa-download me-1"></i> Тайлан Татах
</button>


            <a href="{{ route('admin.analytics.health') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-heartbeat fa-sm text-white-50 me-1"></i> Эрүүл Мэндийн Аналитик
            </a>
            <a href="{{ route('admin.analytics.forum') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-comments fa-sm text-white-50 me-1"></i> Форумын Аналитик
            </a>
        </div>
    </div>



    <!-- Overview Cards -->
    <div class="row">

        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Нийт Хэрэглэгч</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verified Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Баталгаажсан Хэрэглэгч</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $verifiedUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unverified Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Баталгаажаагүй Хэрэглэгч</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unverifiedUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users with Profiles Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Профайлтай Хэрэглэгчид
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $usersWithProfiles }}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ ($usersWithProfiles / max(1, $totalUsers)) * 100 }}%" aria-valuenow="{{ $usersWithProfiles }}" aria-valuemin="0"
                                            aria-valuemax="{{ $totalUsers }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Registration Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Хэрэглэгчийн Бүртгэл (Сүүлийн 30 Өдөр)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Age Distribution Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Насны Хуваарилалт</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="userAgeDistribution"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($userAgeDistribution as $range => $count)
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: {{ '#' . substr(md5($range), 0, 6) }}"></i> {{ $range }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gender Distribution -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Хүйсний Хуваарилалт</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="genderDistribution"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($genderDistribution as $entry)
                            <span class="mr-2">
                                <i class="fas fa-circle"
                                   style="color: {{ '#' . substr(md5($entry->gender), 0, 6) }}"></i>
                                {{ $entry->gender }} ({{ $entry->count }})
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- VR Content Stats -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">VR Контент Санал</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <h4 class="small font-weight-bold">Хүлээгдэж буй <span class="float-right">{{ $vrContentStats['pending'] ?? 0 }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($vrContentStats['pending'] ?? 0) / (array_sum($vrContentStats) ?: 1) * 100 }}%"></div>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <h4 class="small font-weight-bold">Зөвшөөрөгдсөн <span class="float-right">{{ $vrContentStats['approved'] ?? 0 }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($vrContentStats['approved'] ?? 0) / (array_sum($vrContentStats) ?: 1) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-center">
                            <h4 class="small font-weight-bold">Татгалзсан <span class="float-right">{{ $vrContentStats['rejected'] ?? 0 }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($vrContentStats['rejected'] ?? 0) / (array_sum($vrContentStats) ?: 1) * 100 }}%"></div>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <h4 class="small font-weight-bold">Нийт <span class="float-right">{{ array_sum($vrContentStats) }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Health Stats -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Эрүүл Мэндийн Статистик</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card bg-primary text-white shadow">
                                <div class="card-body">
                                    Тамхичид
                                    <div class="text-white-50 small">{{ $healthStats['smokers'] }} хэрэглэгч</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card bg-info text-white shadow">
                                <div class="card-body">
                                    Архаг Өвчтэй
                                    <div class="text-white-50 small">{{ $healthStats['with_chronic_conditions'] }} хэрэглэгч</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card bg-success text-white shadow">
                                <div class="card-body">
                                    Дундаж Өндөр
                                    <div class="text-white-50 small">{{ round($healthStats['avg_height']) }} см</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card bg-warning text-white shadow">
                                <div class="card-body">
                                    Дундаж Жин
                                    <div class="text-white-50 small">{{ round($healthStats['avg_weight'], 2) }} кг</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Most Active Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Хамгийн Идэвхтэй Хэрэглэгчид</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Нэр</th>
                            <th>Имэйл</th>
                            <th>Бүртгүүлсэн</th>
                            <th>Сэдвүүд</th>
                            <th>Хариултууд</th>
                            <th>Нийт Идэвх</th>
                            <th>Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mostActiveUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>{{ $user->topics_count }}</td>
                            <td>{{ $user->replies_count }}</td>
                            <td>{{ $user->topics_count + $user->replies_count }}</td>
                            <td>
                                <a href="{{ route('admin.user.detail', $user->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Харах
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Сүүлд Бүртгүүлсэн Хэрэглэгчид</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Нэр</th>
                            <th>Имэйл</th>
                            <th>Бүртгүүлсэн</th>
                            <th>Баталгаажсан</th>
                            <th>Профайл</th>
                            <th>Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($user->email_verified_at)
                                <span class="badge badge-success">Баталгаажсан</span>
                                @else
                                <span class="badge badge-warning">Хүлээгдэж буй</span>
                                @endif
                            </td>
                            <td>
                                @if($user->profile)
                                <span class="badge badge-info">Бүрэн</span>
                                @else
                                <span class="badge badge-secondary">Дутуу</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.user.detail', $user->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Харах
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- Export Modal -->
<div class="modal fade" id="exportUserReportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Хэрэглэгчийн Тайлан Гаргах</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.user.detail.export') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="from_date">Эхлэх Огноо</label>
                        <input type="date" class="form-control" id="from_date" name="from_date">
                    </div>
                    <div class="form-group">
                        <label for="to_date">Дуусах Огноо</label>
                        <input type="date" class="form-control" id="to_date" name="to_date">
                    </div>
                    <div class="form-group">
                        <label for="export_type">Гаралтын Формат</label>
                        <select class="form-control" id="export_type" name="export_type" required>
                            <option value="csv">CSV</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Цуцлах</button>
                    <button type="submit" class="btn btn-primary">Татах</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// User Registration Chart
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document
        .getElementById('genderDistribution')
        .getContext('2d');

    // Load labels & data from PHP
    const labels = @json($labels);   // e.g. ["эм","эр"]
    const data   = @json($counts);   // e.g. [9,13]

    // 1) Define explicit colors for each gender
    const colorMap = {
        'эм': '#E83E8C',  // pink-ish for female
        'эр': '#4E73DF'   // blue-ish for male
    };

    // 2) Build the backgroundColor array in the same order as labels
    const backgroundColors = labels.map(label =>
        colorMap[label] || '#CCCCCC'  // fallback color if label unexpected
    );

    // 3) Create the doughnut chart with explicit colors
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColors,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            cutout: '80%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});



// Set default to_date to today
const today = new Date();
        const todayFormatted = today.toISOString().split('T')[0];
        document.getElementById('to_date').value = todayFormatted;

        // Set default from_date to 30 days ago
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30);
        const thirtyDaysAgoFormatted = thirtyDaysAgo.toISOString().split('T')[0];
        document.getElementById('from_date').value = thirtyDaysAgoFormatted;




var ctx = document.getElementById("userRegistrationChart");
var dates = {!! json_encode($usersByDate->pluck('date')) !!};
var counts = {!! json_encode($usersByDate->pluck('count')) !!};

var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: dates,
        datasets: [{
            label: "Бүртгэлүүд",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: counts,
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    precision: 0
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: false
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
        }
    }
});

// Age Distribution Chart
var ctx2 = document.getElementById("userAgeDistribution");
var ageLabels = {!! json_encode($userAgeDistribution->keys()) !!};
var ageCounts = {!! json_encode($userAgeDistribution->values()) !!};
var backgroundColors = ageLabels.map(label => '#' + label.split('').reduce((a,b) => {
    a = ((a << 5) - a) + b.charCodeAt(0);
    return Math.abs(a & 0xFFFFFF);
}, 0).toString(16).padStart(6, '0'));

var myPieChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ageLabels,
        datasets: [{
            data: ageCounts,
            backgroundColor: backgroundColors,
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});

// Gender Distribution Chart
// var ctx3 = document.getElementById("genderDistribution");
// var genderLabels = {!! json_encode($genderDistribution->pluck('gender')) !!};
// var genderCounts = {!! json_encode($genderDistribution->pluck('count')) !!};
// var genderColors = genderLabels.map(label => '#' + label.split('').reduce((a,b) => {
//     a = ((a << 5) - a) + b.charCodeAt(0);
//     return Math.abs(a & 0xFFFFFF);
// }, 0).toString(16).padStart(6, '0'));

// var genderPieChart = new Chart(ctx3, {
//     type: 'doughnut',
//     data: {
//         labels: genderLabels,
//         datasets: [{
//             data: genderCounts,
//             backgroundColor: genderColors,
//             hoverBorderColor: "rgba(234, 236, 244, 1)",
//         }],
//     },
//     options: {
//         maintainAspectRatio: false,
//         tooltips: {
//             backgroundColor: "rgb(255,255,255)",
//             bodyFontColor: "#858796",
//             borderColor: '#dddfeb',
//             borderWidth: 1,
//             xPadding: 15,
//             yPadding: 15,
//             displayColors: false,
//             caretPadding: 10,
//         },
//         legend: {
//             display: false
//         },
//         cutoutPercentage: 80,
//     },
// });
</script>
@endpush
