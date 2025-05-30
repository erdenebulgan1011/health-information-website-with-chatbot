@extends('layouts.admin')

@section('title', 'Хэрэглэгчийн дэлгэрэнгүй: ' . $user->name)

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Хэрэглэгчийн Дэлгэрэнгүй</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">Хяналтын Самбар</a></li>
        <li class="breadcrumb-item active">Хэрэглэгчийн Дэлгэрэнгүй</li>
    </ol>


    <div class="row">

        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Үндсэн Мэдээлэл
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-lg me-3">
                            @if($user->profile && $user->profile->avatar)
                                <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="Хэрэглэгчийн Зураг" class="img-thumbnail rounded-circle">
                            @else
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <span class="text-white fs-1">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $user->name }}</h3>
                            <p class="text-muted">Бүртгүүлсэн огноо: {{ $user->created_at->format('M d, Y') }}</p>
                            <p class="mb-0">
                                <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                    {{ $user->email_verified_at ? 'Баталгаажсан' : 'Баталгаажаагүй' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5>Холбоо Барих Мэдээлэл</h5>
                        <p><i class="fas fa-envelope me-2"></i> {{ $user->email }}</p>
                    </div>

                    @if($user->profile)
                    <div class="mb-3">
                        <h5>Хувийн Мэдээлэл</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Хүйс:</strong> {{ $user->profile->gender ?? 'Тодорхойгүй' }}</p>
                                <p><strong>Төрсөн огноо:</strong> {{ $user->profile->birth_date ? date('M d, Y', strtotime($user->profile->birth_date)) : 'Тодорхойгүй' }}</p>
                                <p><strong>Нас:</strong> {{ $user->profile->birth_date ? \Carbon\Carbon::parse($user->profile->birth_date)->age : 'Тодорхойгүй' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Өндөр:</strong> {{ $user->profile->height ? $user->profile->height . ' см' : 'Тодорхойгүй' }}</p>
                                <p><strong>Жин:</strong> {{ $user->profile->weight ? $user->profile->weight . ' кг' : 'Тодорхойгүй' }}</p>
                                <p><strong>БЖИ:</strong>
                                    @if($user->profile->height && $user->profile->weight)
                                        {{ round($user->profile->weight / (($user->profile->height/100) * ($user->profile->height/100)), 2) }}
                                    @else
                                        Байхгүй
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <p><strong>Тамхи татдаг:</strong> <span class="badge bg-{{ $user->profile->is_smoker ? 'danger' : 'success' }}">{{ $user->profile->is_smoker ? 'Тийм' : 'Үгүй' }}</span></p>
                                <p><strong>Архаг өвчтэй:</strong> <span class="badge bg-{{ $user->profile->has_chronic_conditions ? 'warning' : 'success' }}">{{ $user->profile->has_chronic_conditions ? 'Тийм' : 'Үгүй' }}</span></p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info">
                        Энэ хэрэглэгч профайлаа бүрэн бөглөөгүй байна.
                    </div>
                    @endif

                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('admin.user', $user->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Хэрэглэгч Засах
                        </a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                            <i class="fas fa-trash me-1"></i> Хэрэглэгч Устгах
                        </button>


                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="userDetailsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="true">
                                <i class="fas fa-chart-bar me-1"></i> Статистик
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false">
                                <i class="fas fa-history me-1"></i> Идэвхийн Түүх
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="recommendations-tab" data-bs-toggle="tab" data-bs-target="#recommendations" type="button" role="tab" aria-controls="recommendations" aria-selected="false">
                                <i class="fas fa-robot me-1"></i> ХИ Зөвлөмжүүд
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userDetailsTabsContent">
                        <!-- Stats Tab -->
                        <div class="tab-pane fade show active" id="stats" role="tabpanel" aria-labelledby="stats-tab">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card border-left-primary mb-3">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Үүсгэсэн Сэдвүүд</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $topicStats['total'] }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card border-left-success mb-3">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Бичсэн Хариултууд</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $replyStats['total'] }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-reply fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card border-left-info mb-3">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        VR Контент Санал</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vrContentStats['total'] }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-vr-cardboard fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-comments me-1"></i>
                                            Сэдвийн Статистик
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Нийт Үзэлт
                                                    <span class="badge bg-primary rounded-pill">{{ $topicStats['views'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Тогтоосон Сэдвүүд
                                                    <span class="badge bg-warning rounded-pill">{{ $topicStats['pinned'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Түгжсэн Сэдвүүд
                                                    <span class="badge bg-danger rounded-pill">{{ $topicStats['locked'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Сэдэв Тус Бүрт Ноогдох Дундаж Хариулт
                                                    <span class="badge bg-info rounded-pill">{{ number_format($topicStats['avg_replies'], 1) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-reply me-1"></i>
                                            Хариултын Статистик
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Шилдэг Хариултууд
                                                    <span class="badge bg-success rounded-pill">{{ $replyStats['best_answers'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Шууд Хариултууд
                                                    <span class="badge bg-primary rounded-pill">{{ $replyStats['parent_replies'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Сэтгэгдлийн Хариултууд
                                                    <span class="badge bg-secondary rounded-pill">{{ $replyStats['child_replies'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Шилдэг Хариултын Хувь
                                                    <span class="badge bg-info rounded-pill">
                                                        {{ $replyStats['total'] > 0 ? number_format(($replyStats['best_answers'] / $replyStats['total']) * !00, 1) : 0 }}%
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-vr-cardboard me-1"></i>
                                    VR Контент Саналын Төлөв
                                </div>
                                <div class="card-body">
                                    <div class="progress" style="height: 25px;">
                                        @php
                                            $pendingPercent = $vrContentStats['total'] > 0 ? ($vrContentStats['pending'] / $vrContentStats['total']) * 100 : 0;
                                            $approvedPercent = $vrContentStats['total'] > 0 ? ($vrContentStats['approved'] / $vrContentStats['total']) * 100 : 0;
                                            $rejectedPercent = $vrContentStats['total'] > 0 ? ($vrContentStats['rejected'] / $vrContentStats['total']) * 100 : 0;
                                        @endphp

                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $pendingPercent }}%"
                                            aria-valuenow="{{ $pendingPercent }}" aria-valuemin="0" aria-valuemax="100">
                                            {{ $vrContentStats['pending'] }} Хүлээгдэж буй
                                        </div>
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $approvedPercent }}%"
                                            aria-valuenow="{{ $approvedPercent }}" aria-valuemin="0" aria-valuemax="100">
                                            {{ $vrContentStats['approved'] }} Батлагдсан
                                        </div>
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $rejectedPercent }}%"
                                            aria-valuenow="{{ $rejectedPercent }}" aria-valuemin="0" aria-valuemax="100">
                                            {{ $vrContentStats['rejected'] }} Татгалзсан
                                        </div>
                                    </div>
                                    <div class="mt-3 d-flex justify-content-between">
                                        <span class="text-warning">Хүлээгдэж буй: {{ $vrContentStats['pending'] }}</span>
                                        <span class="text-success">Батлагдсан: {{ $vrContentStats['approved'] }}</span>
                                        <span class="text-danger">Татгалзсан: {{ $vrContentStats['rejected'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Timeline Tab -->
                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                            <div class="timeline">
                                @foreach($activityTimeline as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-marker
                                        {{ $activity['type'] == 'topic' ? 'bg-primary' : '' }}
                                        {{ $activity['type'] == 'reply' ? 'bg-success' : '' }}
                                        {{ $activity['type'] == 'vr_suggestion' ? 'bg-info' : '' }}
                                    "></div>
                                    <div class="timeline-content">
                                        <h5 class="timeline-date">{{ \Carbon\Carbon::parse($activity['date'])->format('M d, Y - H:i') }}</h5>
                                        <div class="timeline-body">
                                            @if($activity['type'] == 'topic')
                                                <i class="fas fa-comments me-1 text-primary"></i>
                                                Шинэ сэдэв үүсгэсэн:
                                                <a href="{{ route('topics.show', $activity['slug']) }}" target="_blank">
                                                    {{ $activity['title'] }}
                                                </a>
                                            @elseif($activity['type'] == 'reply')
                                                <i class="fas fa-reply me-1 text-success"></i>
                                                Хариулт бичсэн:
                                                <a href="{{ route('topics.show', $activity['slug']) }}#reply-{{ $activity['id'] }}" target="_blank">
                                                    #{{ $activity['topic_id']}} дугаартай #{{ $activity['title']}} сэдэвт
                                                </a>

                                            @elseif($activity['type'] == 'vr_suggestion')
                                                <i class="fas fa-vr-cardboard me-1 text-info"></i>
                                                VR контент санал болгосон:
                                                <a href="{{ route('admin.user', $activity['id']) }}">
                                                    {{ $activity['title'] }}
                                                </a>
                                                <span class="badge bg-{{
                                                    $activity['status'] == 'pending' ? 'warning' :
                                                    ($activity['status'] == 'approved' ? 'success' : 'danger')
                                                }}">
                                                    {{ $activity['status'] == 'pending' ? 'Хүлээгдэж буй' :
                                                       ($activity['status'] == 'approved' ? 'Батлагдсан' : 'Татгалзсан') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @if(count($activityTimeline) == 0)
                                <div class="alert alert-info">
                                    Энэ хэрэглэгч одоогоор ямар нэг үйл ажиллагаа хийгээгүй байна.
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- AI Recommendations Tab -->
                        <div class="tab-pane fade" id="recommendations" role="tabpanel" aria-labelledby="recommendations-tab">
                            @if(count($aiRecommendations) > 0)
                                <div class="list-group">
                                @foreach($aiRecommendations as $recommendation)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $recommendation->title }}</h5>
                                            <small>{{ $recommendation->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <p class="mb-1">{{ $recommendation->description }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <small class="text-muted">
                                                <strong>Ангилал:</strong> {{ $recommendation->category }}
                                            </small>
                                            <a href="{{ $recommendation->resource_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-external-link-alt me-1"></i> Материал Харах
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Энэ хэрэглэгчид зориулсан ХИ зөвлөмж одоогоор үүсгэгдээгүй байна.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Устгахыг Баталгаажуулах</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Та <strong>{{ $user->name }}</strong> хэрэглэгчийг устгахдаа итгэлтэй байна уу? Энэ үйлдлийг буцаах боломжгүй.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Цуцлах</button>
                <form action="{{ route('topics.show', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Хэрэглэгч Устгах</button>
                </form>
            </div>
        </div>
    </div>
</div>





@endsection

@section('styles')
<style>
    .avatar-lg {
        width: 80px;
        height: 80px;
        overflow: hidden;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 25px;
    }

    .timeline-marker {
        position: absolute;
        left: -30px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 3px #f8f9fa;
    }

    .timeline-content {
        border-left: 2px solid #dee2e6;
        padding-left: 15px;
    }

    .timeline-date {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .border-left-primary {
        border-left: 4px solid #4e73df;
    }

    .border-left-success {
        border-left: 4px solid #1cc88a;
    }

    .border-left-info {
        border-left: 4px solid #36b9cc;
    }
</style>
@endsection

@push('scripts')
<script>
    // Enable all Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Ensure the correct tab is shown when clicking tab links
    document.addEventListener('DOMContentLoaded', function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('#userDetailsTabs a'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })






    });
</script>
@endpush

