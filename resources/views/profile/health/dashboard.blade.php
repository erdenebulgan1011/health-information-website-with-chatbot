@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Dashboard Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
            <h1 class="text-2xl font-bold">Эрүүл мэндийн хяналтын самбар</h1>
        </div>

        <!-- Dashboard Content -->
        <div class="p-6">
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column - User Profile -->
                <div class="lg:w-1/4">
                    <div class="bg-gray-50 rounded-xl shadow-sm p-6 text-center">
                        <div class="mb-4 flex justify-center">
                            @if($profile->profile_pic)
                                <img src="{{ asset('storage/' . $profile->profile_pic) }}" alt="Профайлын зураг" class="h-28 w-28 rounded-full object-cover border-4 border-white shadow">
                            @else
                                <div class="h-28 w-28 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-3xl font-bold shadow-md border-4 border-white">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-500 mt-1">
                            {{ isset($metrics['age']) ? $metrics['age'] . ' нас' : 'Нас оруулаагүй' }}<br>
                            {{ $profile->gender ?? 'Хүйс оруулаагүй' }}
                        </p>

                        <div class="mt-6">
                            <a href="{{ route('health.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Профайл засах
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Health Data -->
                <div class="lg:w-3/4">
                    <!-- Metrics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- BMI Card -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition duration-200">
                            <div class="p-5">
                                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">БМӨ</h3>
                                <div class="flex items-end justify-between">
                                    <div>
                                        @if(isset($metrics['bmi']))
                                            <div class="text-3xl font-bold text-gray-800">{{ $metrics['bmi'] }}</div>
                                            <div class="text-sm
                                                @if($metrics['bmi_category'] == 'Хэвийн') text-green-600
                                                @elseif($metrics['bmi_category'] == 'Илүүдэл жинтэй' || $metrics['bmi_category'] == 'Жин багатай') text-yellow-600
                                                @else text-red-600
                                                @endif font-medium">
                                                {{ $metrics['bmi_category'] }}
                                            </div>
                                        @else
                                            <div class="text-gray-500">Мэдээлэлгүй</div>
                                            <div class="text-xs text-gray-400">Өндөр, жинг оруулж тооцно уу</div>
                                        @endif
                                    </div>
                                    <div class="bg-blue-100 rounded-lg p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Height Card -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition duration-200">
                            <div class="p-5">
                                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">Өндөр</h3>
                                <div class="flex items-end justify-between">
                                    <div>
                                        @if($profile->height)
                                            <div class="text-3xl font-bold text-gray-800">{{ $profile->height }} <span class="text-lg font-normal text-gray-500">см</span></div>
                                        @else
                                            <div class="text-gray-500">Оруулаагүй</div>
                                        @endif
                                    </div>
                                    <div class="bg-green-100 rounded-lg p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Weight Card -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition duration-200">
                            <div class="p-5">
                                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">Жин</h3>
                                <div class="flex items-end justify-between">
                                    <div>
                                        @if(isset($profile->weight))
                                            <div class="text-3xl font-bold text-gray-800">{{ $profile->weight }} <span class="text-lg font-normal text-gray-500">кг</span></div>
                                        @else
                                            <div class="text-gray-500">Оруулаагүй</div>
                                        @endif
                                    </div>
                                    <div class="bg-purple-100 rounded-lg p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Factors and Activity Recommendations -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Risk Factors -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Эрсдэл хүчин зүйлүүд
                                </h3>

                                @if(!empty($recommendations['risk_factors']))
                                    <ul class="space-y-3">
                                        @foreach($recommendations['risk_factors'] as $risk)
                                            <li class="flex items-center">
                                                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold rounded
                                                    {{ $risk['risk_level']=='High' ? 'bg-red-100 text-red-800' :
                                                      ($risk['risk_level']=='Moderate' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                                    {{ $risk['risk_level'] }}
                                                </span>
                                                <span class="text-gray-700">{{ $risk['factor'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="mt-4">
                                        <a href="{{ route('health.risk-factors') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                            Дэлгэрэнгүй үзэх
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-gray-50 rounded-lg p-4 text-gray-500">
                                        Тодорхой эрсдэл хүчин зүйл тодорхойлогдоогүй
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Activity Recommendations -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Идэвхийн зөвлөмжүүд
                                </h3>

                                @if(!empty($recommendations['physical_activity']))
                                    <ul class="space-y-3">
                                        @foreach(array_slice($recommendations['physical_activity'],0,2) as $activity)
                                            <li class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span class="text-gray-700">{{ $activity }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="mt-4">
                                        <a href="{{ route('health.physical-activity') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                            Бүх зөвлөмж үзэх
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-gray-50 rounded-lg p-4 text-gray-500">
                                        Идэвхийн зөвлөмж байхгүй
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI Insights Section -->
            <div class="mt-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white flex justify-between items-center">
                        <h2 class="text-xl font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            AI Эрүүл мэндийн зөвлөмжүүд
                        </h2>
                    </div>

                    <div class="p-6">
                        @if($recommendations['ai_insights']['success'])
                            <div class="prose max-w-none mb-6 bg-gray-50 p-5 rounded-lg">
                                {!! nl2br(e($recommendations['ai_insights']['insights'])) !!}
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <form action="{{ route('health.ai-insights.regenerate') }}" method="POST">
                                    @csrf
                                    <button class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 bg-white hover:bg-blue-50 rounded-md text-sm font-medium transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        AI Дахин үүсгэх
                                    </button>
                                </form>
                                <a href="{{ route('health.ai-insights') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Дэлгэрэнгүй AI шинжилгээ
                                </a>
                                <a href="{{ route('health.report') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 rounded-md text-sm font-medium transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Эрүүл мэндийн тайлан үүсгэх
                                </a>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">{{ $recommendations['ai_insights']['message'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <form action="{{ route('health.ai-insights.generate') }}" method="POST">
                                    @csrf
                                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        AI Үүсгэх
                                    </button>
                                </form>
                                <a href="{{ route('health.ai-insights') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Дэлгэрэнгүй AI шинжилгээ
                                </a>
                                <a href="{{ route('health.report') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 rounded-md text-sm font-medium transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Эрүүл мэндийн тайлан үүсгэх
                                </a>
                                {{-- <div class="card-body">
                                    @if(isset($recommendations['ai_insights']) && $recommendations['ai_insights']['success'])
                                        <div class="mb-3">
                                            {!! nl2br(e($recommendations['ai_insights']['insights'])) !!}
                                        </div>
                                    @else
                                        <p class="text-muted">AI insights not available. Please ensure your profile is complete and try again.</p>
                                    @endif
                                    <a href="{{ route('health.ai-insights') }}" class="btn btn-primary">Get Detailed AI Analysis</a>
                                    <a href="{{ route('health.report') }}" class="btn btn-outline-secondary ms-2">Generate Health Report</a>
                                </div> --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
