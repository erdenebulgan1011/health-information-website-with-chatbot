@extends('layouts.dashboard')

@section('title', 'Самбар')

@section('content')
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="h3 mb-0">{{ __('Тавтай морилно уу, ') }}{{ $user->name }}!</h1>
            <p class="text-muted">{{ __('Эрүүл мэндийн мэдээлэл, идэвхитэй үйл ажиллагааны товч хураангуй.') }}</p>
        </div>
        @if ($isProfessional && $user->professional->is_verified)
            <div class="col-auto">
                <span class="badge bg-success p-2">
                    <i class="bi bi-patch-check-fill"></i> {{ __('Баталгаажсан мэргэжилтэн') }}
                </span>
            </div>
        @endif
    </div>

    <div class="row">
        <!-- Хэрэглэгчийн профайл карт -->
        <div class="col-lg-4 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-body text-center">
                    @if ($profile && $profile->profile_pic)
                    @php
    // Build URL to the user’s upload, if it exists
    $uploaded = $profile && $profile->profile_pic
        && Storage::disk('public')->exists($profile->profile_pic);

    $src = $uploaded
        ? Storage::disk('public')->url($profile->profile_pic)   // => /storage/user_profiles/...
        : asset('images/default_1.jpg');                       // => /images/default_1.jpg
@endphp

<img
    src="{{ $src }}"
    alt="{{ $user->name }}"
    class="profile-avatar mb-3 d-inline-block mx-auto"
>
           @else
                        <div class="profile-avatar mb-3 bg-primary d-flex align-items-center justify-content-center text-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>

                    @if ($profile)
                        <div class="d-flex justify-content-center mb-3">
                            @if ($profile->birth_date)
                                <span class="badge bg-light text-dark me-2">
                                    <i class="bi bi-calendar"></i> {{ $profile->birth_date->age }} {{ __('нас') }}
                                </span>
                            @endif

                            @if ($profile->gender)
                                <span class="badge bg-light text-dark me-2">
                                    @if ($profile->gender == 'Male')
                                        <i class="bi bi-gender-male"></i>
                                    @elseif ($profile->gender == 'Female')
                                        <i class="bi bi-gender-female"></i>
                                    @else
                                        <i class="bi bi-person"></i>
                                    @endif
                                    {{ $profile->gender }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> {{ __('Профайл засах') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Эрүүл мэндийн үзүүлэлтүүд -->
        <div class="col-lg-8 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">{{ __('Таны эрүүл мэндийн үзүүлэлтүүд') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if ($bmiData)
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded stat-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-1">{{ __('БМӨ') }}</h6>
                                            <div class="health-stat">{{ $bmiData['value'] }}</div>
                                            <span class="badge
                                                @if ($bmiData['category'] == 'Normal weight') bg-success
                                                @elseif ($bmiData['category'] == 'Underweight') bg-warning
                                                @else bg-danger
                                                @endif
                                            ">{{ $bmiData['category'] }}</span>
                                        </div>
                                        <div class="display-4 text-primary opacity-25">
                                            <i class="bi bi-rulers"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Өндөр, Жин -->
                        @if ($profile && ($profile->height || $profile->weight))
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded stat-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-1">{{ __('Өммөрөлтүүд') }}</h6>
                                            @if ($profile->height)
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-arrows-vertical me-2"></i>
                                                    <span>{{ $profile->height }} см</span>
                                                </div>
                                            @endif
                                            @if ($profile->weight)
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-speedometer me-2"></i>
                                                    <span>{{ $profile->weight }} кг</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="display-4 text-primary opacity-25">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Эрүүл мэндийн хүчин зүйлүүд -->
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded stat-card">
                                <h6 class="text-muted mb-3">{{ __('Эрүүл мэндийн хүчин зүйлүүд') }}</h6>
                                <div class="d-flex flex-column">
                                    <div class="mb-2 d-flex align-items-center">
                                        <div class="me-2">
                                            @if ($profile && $profile->is_smoker)
                                                <span class="badge bg-danger"><i class="bi bi-check-circle-fill"></i></span>
                                            @else
                                                <span class="badge bg-success"><i class="bi bi-x-circle-fill"></i></span>
                                            @endif
                                        </div>
                                        <span>{{ __('Тамхичин') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            @if ($profile && $profile->has_chronic_conditions)
                                                <span class="badge bg-warning"><i class="bi bi-check-circle-fill"></i></span>
                                            @else
                                                <span class="badge bg-success"><i class="bi bi-x-circle-fill"></i></span>
                                            @endif
                                        </div>
                                        <span>{{ __('Тасралтгүй өвчин') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Оролцогчийн идэвхи -->
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded stat-card">
                                <h6 class="text-muted mb-1">{{ __('Нийгмийн идэвхи') }}</h6>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="text-center">
                                        <div class="h4 mb-0">{{ $topicsCount }}</div>
                                        <small class="text-muted">{{ __('Сэдвүүд') }}</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="h4 mb-0">{{ $repliesCount }}</div>
                                        <small class="text-muted">{{ __('Хариултууд') }}</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="h4 mb-0">{{ $vrSuggestions->count() }}</div>
                                        <small class="text-muted">{{ __('VR санал') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (!$profile || (!$profile->height && !$profile->weight))
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> {{ __('Профайлаа бүрэн бөглөж эрүүл мэндийн үзүүлэлтээ харж, зөвлөмж авах.') }}
                            <a href="{{ route('profile.edit') }}" class="alert-link">{{ __('Профайл шинэчлэх') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- AI зөвлөмжүүд -->
        @if ($aiRecommendations)
            <div class="col-lg-8 mb-4">
                <div class="card card-dashboard h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-robot"></i> {{ __('AI Эрүүл мэндийн зөвлөмжүүд') }}</h5>
                        <small class="text-muted">{{ $aiRecommendations->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="card-body">
                        <div class="ai-recommendation">
                            <div class="mb-2 small text-muted">{{ __('Таны мэдээллийн үндсэн дээр:') }}</div>
                            {!! nl2br(e($aiRecommendations->insights)) !!}
                        </div>
                        <div class="small text-muted mt-3">
                            <i class="bi bi-exclamation-circle"></i> {{ __('Эдгээр зөвлөмж нь автомат бөгөөд мэргэжлийн зөвлөгөөг орлож болохгүй.') }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-8 mb-4">
                <div class="card card-dashboard h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-robot"></i> {{ __('AI Эрүүл мэндийн зөвлөмжүүд') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-4">
                            <div class="display-1 text-muted opacity-25 mb-3"><i class="bi bi-robot"></i></div>
                            <h5>{{ __('Зөвлөмж хараахан бэлэнгүй') }}</h5>
                            <p class="text-muted">{{ __('Профайлаа шинэчилж хувийн зөвлөмж авна уу.') }}</p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                {{ __('Профайл шинэчлэх') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Сүүлийн Форумын идэвхи -->
        <div class="col-lg-4 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-chat-dots"></i> {{ __('Сүүлийн Форумын идэвхи') }}</h5>
                </div>
                <div class="card-body p-0">
                    @if ($latestTopics->count())
                        <div class="list-group list-group-flush">
                            @foreach ($latestTopics as $topic)
                                <a href="{{ url('/forum/topics/' . $topic->slug) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1 text-truncate">{{ $topic->title }}</h6>
                                        <small class="text-muted">{{ $topic->replies_count }} {{ __('хариулт') }}</small>
                                    </div>
                                    <small class="d-block text-muted">{{ $topic->category->title ?? 'Ангилаагүй' }}</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <small class="text-muted"><i class="bi bi-person-circle"></i> {{ $topic->user->name }}</small>
                                        <small class="ms-auto text-muted">{{ $topic->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">{{ __('Сүүлийн идэвхи байхгүй') }}</p>
                            <a href="{{ url('/forum') }}" class="btn btn-sm btn-outline-primary">
                                {{ __('Форум руу очих') }}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ url('/forum') }}" class="btn btn-sm btn-primary">{{ __('Бүх сэдвүүд') }}</a>
                    <a href="{{ url('/forum/create') }}" class="btn btn-sm btn-outline-primary">{{ __('Шинэ сэдэв үүсгэх') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- VR Контент санал -->
    @if ($vrSuggestions->count())
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card card-dashboard">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-badge-vr"></i> {{ __('Таны VR контент санал') }}</h5>
                        <a href="{{ route('dashboard.vr.create') }}" class="btn btn-sm btn-primary">{{ __('Шинэ санал') }}</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Гарчиг') }}</th>
                                        <th>{{ __('Ангилал') }}</th>
                                        <th>{{ __('Төлөв') }}</th>
                                        <th>{{ __('Илгээсэн огноо') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vrSuggestions->take(3) as $suggestion)
                                        <tr>
                                            <td>{{ $suggestion->title }}</td>
                                            <td>{{ $suggestion->category->name ?? 'Ангилаагүй' }}</td>
                                            <td>
                                                @if ($suggestion->status == 'pending')
                                                    <span class="badge bg-warning">{{ __('Хүлээгдэж буй') }}</span>
                                                @elseif ($suggestion->status == 'approved')
                                                    <span class="badge bg-success">{{ __('Батлагдсан') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ __('Татгалзсан') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $suggestion->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($vrSuggestions->count() > 3)
                        <div class="card-footer bg-white text-center">
                            <a href="{{ route('dashboard.vr.index') }}" class="btn btn-sm btn-outline-primary">{{ __('Бүх санал харах') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Самбарын нэмэлт JavaScript тохиргоо
</script>
@endpush
