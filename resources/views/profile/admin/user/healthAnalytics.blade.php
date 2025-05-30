@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Эрүүл Мэндийн Аналитик Хяналтын Самбар</h3>
                    <small class="text-muted">Сүүлд шинэчилсэн: {{ now()->format('Y оны m сарын d H:i') }}</small>
                </div>
                <div class="card-body p-2">
                    <div class="row">

                        <!-- Эхний мөр: Үндсэн үзүүлэлтүүд -->
                        <div class="col-lg-8">
                            <div class="row">
                                <!-- Тамхи татдаг эсэх -->
                                <div class="col-md-6 mb-3">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">Тамхи татдаг эсэх</h6>
                                        </div>
                                        <div class="card-body p-2">
                                            <canvas id="smokingChart" style="max-height: 250px"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <!-- Архаг өвчлөлүүд -->
                                <div class="col-md-6 mb-3">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">Архаг өвчлөлүүд</h6>
                                        </div>
                                        <div class="card-body p-2">
                                            <canvas id="chronicConditionsChart" style="max-height: 250px"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <!-- БЖИ-ийн тархалт -->
                                <div class="col-12 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">БЖИ-ийн тархалт</h6>
                                        </div>
                                        <div class="card-body p-2">
                                            <canvas id="bmiChart" style="height: 200px"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Хоёр дахь баганад: Хүйсээр харуулсан үзүүлэлтүүд -->
                        <div class="col-lg-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0">Хүйсээр харуулсан дундаж хэмжилтүүд</h6>
                                </div>
                                <div class="card-body p-2">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Хүйс</th>
                                                    <th class="text-end">Өндөр</th>
                                                    <th class="text-end">Жин</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($avgHeightByGender as $heightData)
                                                <tr>
                                                    <td>{{ $heightData->gender === 'Male' ? 'Эрэгтэй' : 'Эмэгтэй' }}</td>
                                                    <td class="text-end">{{ number_format($heightData->avg_height, 1) }} см</td>
                                                    <td class="text-end">
                                                        @php
                                                            $weightData = $avgWeightByGender->where('gender', $heightData->gender)->first();
                                                            echo $weightData ? number_format($weightData->avg_weight, 1) . ' кг' : 'Мэдээлэл байхгүй';
                                                        @endphp
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // График-ын нийтлэг тохиргоо
        const compactPieOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12 } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((context.raw / total) * 100);
                            return `${context.label}: ${context.raw} (${percentage}%)`;
                        }
                    }
                }
            }
        };

        // Тамхины график
        new Chart(document.getElementById('smokingChart'), {
            type: 'doughnut',
            data: {
                labels: ['Тамхичид', 'Тамхи татдаггүй'],
                datasets: [{
                    data: [{{ $smokersCount }}, {{ $nonSmokersCount }}],
                    backgroundColor: ['#dc3545', '#28a745']
                }]
            },
            options: compactPieOptions
        });

        // Архаг өвчлөлийн график
        new Chart(document.getElementById('chronicConditionsChart'), {
            type: 'doughnut',
            data: {
                labels: ['Өвчтэй', 'Өвчингүй'],
                datasets: [{
                    data: [{{ $chronicConditionsCount }}, {{ $noChronicConditionsCount }}],
                    backgroundColor: ['#ffc107', '#17a2b8']
                }]
            },
            options: compactPieOptions
        });

        // БЖИ-ийн график
        new Chart(document.getElementById('bmiChart'), {
            type: 'bar',
            data: {
                labels: ['Туранхай', 'Хэвийн', 'Илүүдэл жинтэй', 'Таргалалттай'],
                datasets: [{
                    label: 'Хэрэглэгчид',
                    data: [
                        {{ $bmiDistribution['Underweight'] ?? 0 }},
                        {{ $bmiDistribution['Normal'] ?? 0 }},
                        {{ $bmiDistribution['Overweight'] ?? 0 }},
                        {{ $bmiDistribution['Obese'] ?? 0 }}
                    ],
                    backgroundColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 } },
                    y: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endpush
