@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Форумын Аналитик Хяналтын Самбар</h3>
                </div>
                <div class="card-body">
                    <!-- Summary Stats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light shadow-sm">
                                <div class="card-body text-center">
                                    <h5 class="text-muted">Нийт Сэдвүүд</h5>
                                    <h2 class="mb-0">{{ $totalTopics }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light shadow-sm">
                                <div class="card-body text-center">
                                    <h5 class="text-muted">Нийт Хариултууд</h5>
                                    <h2 class="mb-0">{{ $totalReplies }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light shadow-sm">
                                <div class="card-body text-center">
                                    <h5 class="text-muted">Сэдэв Тус Бүрт Ноогдох Дундаж Хариулт</h5>
                                    <h2 class="mb-0">{{ number_format($avgRepliesPerTopic, 1) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Topics by Category -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Ангилал Дахь Сэдвүүд</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="categoryChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Topics by Month -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Үүсгэсэн Сэдвүүд (Сүүлийн 12 Сар)</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="topicsMonthChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Top Viewed Topics -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Хамгийн Их Үзэлттэй Сэдвүүд</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Сэдэв</th>
                                                    <th>Зохиогч</th>
                                                    <th>Үзэлт</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($topViewedTopics as $topic)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('topics.show', $topic->id) }}">
                                                            {{ Str::limit($topic->title, 50) }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $topic->user->name }}</td>
                                                    <td>{{ number_format($topic->views) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Best Answer Contributors -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Хамгийн Туслахуй Хэрэглэгчид</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Хэрэглэгч</th>
                                                    <th>Шилдэг Хариултууд</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bestAnswerUsers as $user)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('admin.user.detail', $user->id) }}">
                                                            {{ $user->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $user->replies_count }}</td>
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Topics by Category Chart
        const categoryLabels = [
            @foreach($topicsByCategory as $category)
                "{{ $category->category->name ?? 'Ангилалгүй' }}",
            @endforeach
        ];

        const categoryData = [
            @foreach($topicsByCategory as $category)
                {{ $category->count }},
            @endforeach
        ];

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: [
                        '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
                        '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Topics by Month Chart
        const monthNames = [
            'Нэгдүгээр сар', 'Хоёрдугаар сар', 'Гуравдугаар сар', 'Дөрөвдүгээр сар', 'Тавдугаар сар', 'Зургадугаар сар',
            'Долдугаар сар', 'Наймдугаар сар', 'Есдүгээр сар', 'Аравдугаар сар', 'Арван нэгдүгээр сар', 'Арван хоёрдугаар сар'
        ];

        const monthLabels = [
            @foreach($topicsByMonth as $monthData)
"{{ $monthNames[$monthData->month] }} {{ $monthData->year }}",
            @endforeach
        ].reverse();

        const monthData = [
            @foreach($topicsByMonth as $monthData)
                {{ $monthData->count }},
            @endforeach
        ].reverse();

        const monthCtx = document.getElementById('topicsMonthChart').getContext('2d');
        const monthChart = new Chart(monthCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Үүсгэсэн Сэдвүүд',
                    data: monthData,
                    borderColor: '#1f77b4',
                    backgroundColor: 'rgba(31, 119, 180, 0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Сэдвийн Тоо'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
