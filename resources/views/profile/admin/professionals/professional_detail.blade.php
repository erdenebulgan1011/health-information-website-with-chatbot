@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Reports</h1>
        <a href="{{ route('admin.professionals.print', $professional->id) }}" class="btn btn-secondary">
            <i class="fas fa-print"></i> Print Report
        </a>
</button>
        </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6>Мэргэжилтний мэдээлэл</h6>
                        <div>
                            @if(!$professional->is_verified)
                                <form action="{{ route('admin.professionals.verify', $professional->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Баталгаажуулах</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.professionals.indexs', $professional->id) }}" class="btn btn-sm btn-primary">Засах</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="avatar-xxl position-relative">
                                @if($user->profile && $user->profile->avatar)
                                    <img src="{{ asset($user->profile->avatar) }}" class="w-100 rounded-circle shadow-sm" alt="Profile Image">
                                @else
                                    <div class="avatar-xxl bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <h1 class="text-white">{{ substr($user->name, 0, 1) }}</h1>
                                    </div>
                                @endif
                                @if($professional->is_verified)
                                    <i class="fas fa-check text-success text-lg position-absolute bottom-0 end-0 bg-white rounded-circle p-1"></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <p class="mb-0 text-sm">{{ $user->email }}</p>
                            <p class="mb-2 text-sm">Бүртгүүлсэн: {{ $user->created_at->format('Y-m-d') }}</p>

                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-gradient-primary">{{ $professional->specialization }}</span>
                                </div>
                                <div>
                                    <span class="badge bg-gradient-info">{{ $professional->qualification }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="horizontal dark my-3">

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">Мэргэжилтний дэлгэрэнгүй</h6>
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                    <strong class="text-dark">Мэргэжил:</strong> &nbsp; {{ $professional->specialization }}
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm">
                                    <strong class="text-dark">Мэргэшил:</strong> &nbsp; {{ $professional->qualification }}
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm">
                                    <strong class="text-dark">Баталгаажуулалт:</strong> &nbsp;
                                    @if($professional->is_verified)
                                        <span class="badge bg-gradient-success">Баталгаажсан</span>
                                    @else
                                        <span class="badge bg-gradient-warning">Баталгаажаагүй</span>
                                    @endif
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm">
                                    <strong class="text-dark">Мэргэжлийн гэрчилгээ:</strong> &nbsp;
                                    @if($professional->certification)
                                    <a href="{{ route('admin.professionals.certification.view', $professional->id) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-pdf me-1"></i> Үзэх
                                    </a>
                                        <a href="{{ route('admin.professionals.certification', $professional->id) }}" class="btn btn-sm btn-secondary" download>
                                            <i class="fas fa-download me-1"></i> Татах
                                        </a>
                                    @else
                                        <span class="text-danger">Байхгүй</span>
                                    @endif                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">Хэрэглэгчийн дэлгэрэнгүй</h6>
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                    <strong class="text-dark">Нэр:</strong> &nbsp; {{ $user->name }}
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm">
                                    <strong class="text-dark">Имэйл:</strong> &nbsp; {{ $user->email }}
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm">
                                    <strong class="text-dark">Бүртгүүлсэн:</strong> &nbsp; {{ $user->created_at->format('Y-m-d H:i:s') }}
                                </li>
                                {{-- <li class="list-group-item border-0 ps-0 text-sm">
                                    <strong class="text-dark">И-мэйл баталгаажуулалт:</strong> &nbsp;
                                    @if($user->email_verified_at)
                                        <span class="badge bg-gradient-success">Баталгаажсан</span>
                                    @else
                                        <span class="badge bg-gradient-warning">Баталгаажаагүй</span>
                                    @endif
                                </li> --}}
                            </ul>
                        </div>
                    </div>

                    @if($professional->bio)
                    <hr class="horizontal dark my-3">
                    <h6 class="text-uppercase text-body text-xs font-weight-bolder">Танилцуулга</h6>
                    <p class="text-sm">{{ $professional->bio }}</p>
                    @endif
                </div>
            </div>

            @if($doctorStats)
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Эмч мэргэжилтний дэлгэрэнгүй</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                    <strong class="text-dark">Ажлын байр:</strong> &nbsp; {{ $doctorStats['workplace'] ?? 'Мэдээлэл байхгүй' }}
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm">
                                    <strong class="text-dark">Боловсрол:</strong> &nbsp; {{ $doctorStats['education'] ?? 'Мэдээлэл байхгүй' }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                    <strong class="text-dark">Туршлага (жил):</strong> &nbsp; {{ $doctorStats['experience'] ?? 'Мэдээлэл байхгүй' }}
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm">
                                    <strong class="text-dark">Хэлний мэдлэг:</strong> &nbsp; {{ $doctorStats['languages'] ?? 'Мэдээлэл байхгүй' }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Үйл ажиллагааны түүх</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="timeline timeline-one-side" data-timeline-axis-style="dashed">
                        @forelse($activityTimeline as $activity)
                            <div class="timeline-block mb-3">
                                <span class="timeline-step bg-{{ $activity['type'] == 'topic' ? 'primary' : ($activity['type'] == 'reply' ? 'info' : 'warning') }}">
                                    <i class="ni ni-{{ $activity['type'] == 'topic' ? 'bell-55' : ($activity['type'] == 'reply' ? 'chat-round' : 'bulb-61') }}"></i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">
                                        @if($activity['type'] == 'topic')
                                            Сэдэв үүсгэсэн: {{ $activity['title'] }}
                                        @elseif($activity['type'] == 'reply')
                                            Сэдэвт хариулсан: {{ $activity['title'] }}
                                        @else
                                            VR контент санал: {{ $activity['title'] }}
                                            <span class="badge badge-sm bg-gradient-{{ $activity['status'] == 'approved' ? 'success' : ($activity['status'] == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ $activity['status'] == 'approved' ? 'Зөвшөөрсөн' : ($activity['status'] == 'rejected' ? 'Татгалзсан' : 'Хүлээгдэж буй') }}
                                            </span>
                                        @endif
                                    </h6>
                                    <p class="text-secondary text-xs mt-1 mb-0">{{ $activity['date']->format('Y-m-d H:i:s') }}</p>
                                    <div class="mt-2">
                                        @if($activity['type'] == 'topic')
                                        <i class="fas fa-comments me-1 text-primary"></i>
                                        Created a new topic:
                                        <a href="{{ route('topics.show', $activity['slug']) }}" target="_blank">
                                            {{ $activity['title'] }}
                                        </a>                                        @elseif($activity['type'] == 'reply')
                                        <i class="fas fa-reply me-1 text-success"></i>
                                        Posted a reply in
                                        <a href="{{ route('topics.show', $activity['slug']) }}#reply-{{ $activity['id'] }}" target="_blank">
                                            topic #{{ $activity['topic_id']}} нэртэй #{{ $activity['title']}}
                                        </a>                                        @else
                                            <a href="{{ route('vr.show', $activity['id']) }}" class="btn btn-sm btn-outline-warning">VR контент үзэх</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-sm text-secondary">Үйл ажиллагааны түүх байхгүй байна.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Хэрэглэгчийн үйл ажиллагаа</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="card shadow-none my-2">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Сэдвүүд</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $topicStats['total'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="ni ni-collection text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-none my-2">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Хариултууд</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $replyStats['total'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                                <i class="ni ni-chat-round text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-none my-2">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">VR контентууд</p>
                                        <h5 class="font-weight-bolder mb-0">{{ $vrContentStats['total'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                        <i class="ni ni-app text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="horizontal dark my-3">

                    <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Сэдвийн статистик</h6>
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-primary shadow text-center">
                                    <i class="ni ni-mobile-button text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Нийт үзэлт</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-primary text-gradient text-sm font-weight-bold">
                                {{ $topicStats['views'] }}
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-success shadow text-center">
                                    <i class="ni ni-pin-3 text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Бэхэлсэн сэдвүүд</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                {{ $topicStats['pinned'] }}
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-danger shadow text-center">
                                    <i class="ni ni-lock-circle-open text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Түгжсэн сэдвүүд</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                {{ $topicStats['locked'] }}
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-info shadow text-center">
                                    <i class="ni ni-chart-bar-32 text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Дундаж хариулт</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-info text-gradient text-sm font-weight-bold">
                                {{ number_format($topicStats['avg_replies'], 1) }}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Хариултын статистик</h6>
                </div>
                <div class="card-body pt-0">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-success shadow text-center">
                                    <i class="ni ni-check-bold text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Шилдэг хариултууд</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                {{ $replyStats['best_answers'] }}
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-primary shadow text-center">
                                    <i class="ni ni-user-run text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Үндсэн хариултууд</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-primary text-gradient text-sm font-weight-bold">
                                {{ $replyStats['parent_replies'] }}
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-info shadow text-center">
                                    <i class="ni ni-align-left-2 text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Дэд хариултууд</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-info text-gradient text-sm font-weight-bold">
                                {{ $replyStats['child_replies'] }}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <h6>VR контент статистик</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="chart">
                        <canvas id="vr-status-chart" class="chart-canvas" height="300"></canvas>
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
    // VR content status chart
    var ctx = document.getElementById("vr-status-chart").getContext("2d");

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Хүлээгдэж буй', 'Зөвшөөрсөн', 'Татгалзсан'],
            datasets: [{
                label: 'VR контент',
                data: [
                    {{ $vrContentStats['pending'] }},
                    {{ $vrContentStats['approved'] }},
                    {{ $vrContentStats['rejected'] }}
                ],
                backgroundColor: [
                    '#ffc107',
                    '#2dce89',
                    '#f5365c'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
        }
    });
</script>
@endpush
