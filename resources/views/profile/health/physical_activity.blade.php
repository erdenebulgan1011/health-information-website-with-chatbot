<!-- resources/views/health/physical_activity.blade.php -->
@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Physical Activity Recommendations</h4>
                    <a href="{{ route('health.dashboard') }}" class="btn btn-sm btn-outline-light">Back to Dashboard</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-user-circle fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="mb-3">Your Health Profile</h5>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Age:</span>
                                        <span>{{ isset($metrics['age']) ? $metrics['age'] . ' years' : 'Not provided' }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Gender:</span>
                                        <span>{{ $profile->gender ?? 'Not provided' }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">BMI:</span>
                                        <span>{{ isset($metrics['bmi']) ? $metrics['bmi'] . ' (' . $metrics['bmi_category'] . ')' : 'Not available' }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Smoker:</span>
                                        <span>{{ $profile->is_smoker ? 'Yes' : 'No' }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Chronic Conditions:</span>
                                        <span>{{ $profile->has_chronic_conditions ? 'Yes' : 'No' }}</span>
                                    </div>

                                    <a href="{{ route('health.profile.edit') }}" class="btn btn-sm btn-outline-primary mt-3">Update Profile</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <h5 class="mb-4">Хувь хүний ​​үйл ажиллагааны зөвлөмжүүд</h5>

                            @if(!empty($recommendations['physical_activity']))
                                <div class="list-group mb-4">
                                    @foreach($recommendations['physical_activity'] as $index => $activity)
                                        <div class="list-group-item border-0 shadow-sm mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; min-width: 40px;">
                                                    <span class="h5 mb-0">{{ $index + 1 }}</span>
                                                </div>
                                                <div>
                                                    <p class="mb-0">{{ $activity }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title">Weekly Activity Target</h6>
                                        <div class="progress mb-3" style="height: 20px;">
                                            @if(isset($metrics['age']))
                                                @if($metrics['age'] < 18)
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%;">
                                                        60 minutes daily
                                                    </div>
                                                @elseif($metrics['age'] >= 65)
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;">
                                                        150+ minutes moderate activity weekly
                                                    </div>
                                                @else
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 66%;">
                                                        150 min moderate
                                                    </div>
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 34%;">
                                                        75 min vigorous
                                                    </div>
                                                @endif
                                            @else
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%;">
                                                    Хувийн болгосон зорилтуудын хувьд насаа нэмнэ үү                                                </div>
                                            @endif
                                        </div>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                ДЭМБ-ын удирдамж болон таны эрүүл мэндийн профайл дээр үндэслэсэн үйл ажиллагааны зөвлөмжүүд                                            </small>
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Үйл ажиллагааны зөвлөмж байхгүй байна. Хувийн зөвлөмж авахын тулд эрүүл мэндийн профайлаа шинэчилнэ үү.                                </div>
                            @endif

                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Таны профайл дээр тулгуурлан санал болгож буй зөвлөмж</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if(isset($metrics['bmi']) && $metrics['bmi'] >= 30)
                                            <!-- Activities for higher BMI -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-swimming-pool text-info fa-2x mb-3"></i>
                                                        <h6>Swimming</h6>
                                                        <p class="small text-muted">Low-impact, gentle on joints</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-walking text-success fa-2x mb-3"></i>
                                                        <h6>Walking</h6>
                                                        <p class="small text-muted">Start with 10-15 minutes daily</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-bicycle text-primary fa-2x mb-3"></i>
                                                        <h6>Stationary Cycling</h6>
                                                        <p class="small text-muted">Low-impact cardio workout</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif(isset($metrics['bmi']) && $metrics['bmi'] < 18.5)
                                            <!-- Activities for lower BMI -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-dumbbell text-danger fa-2x mb-3"></i>
                                                        <h6>Strength Training</h6>
                                                        <p class="small text-muted">Focus on building muscle mass</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-apple-alt text-success fa-2x mb-3"></i>
                                                        <h6>Nutrition + Exercise</h6>
                                                        <p class="small text-muted">Combined approach for health</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-running text-primary fa-2x mb-3"></i>
                                                        <h6>Moderate Cardio</h6>
                                                        <p class="small text-muted">Balance with strength training</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($profile->has_chronic_conditions)
                                            <!-- Activities for those with chronic conditions -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-user-md text-danger fa-2x mb-3"></i>
                                                        <h6>Consult Provider</h6>
                                                        <p class="small text-muted">For tailored exercise plan</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-spa text-info fa-2x mb-3"></i>
                                                        <h6>Gentle Yoga</h6>
                                                        <p class="small text-muted">Improves flexibility & strength</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-water text-primary fa-2x mb-3"></i>
                                                        <h6>Water Exercises</h6>
                                                        <p class="small text-muted">Low-impact, joint-friendly</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- General activities for healthy profiles -->
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-running text-success fa-2x mb-3"></i>
                                                        <h6>Interval Training</h6>
                                                        <p class="small text-muted">Efficient for cardio fitness</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-dumbbell text-primary fa-2x mb-3"></i>
                                                        <h6>Strength Training</h6>
                                                        <p class="small text-muted">2-3 times weekly recommended</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-heartbeat text-danger fa-2x mb-3"></i>
                                                        <h6>Cardio Mix</h6>
                                                        <p class="small text-muted">Vary activities for best results</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
