@extends('layouts.dashboard')

@section('title', 'Миний профайл')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <!-- Ерөнхий профайл -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
        <div class="px-6 py-4 bg-blue-600 text-white">
            <h2 class="text-2xl font-bold">Хувийн мэдээлэл</h2>
        </div>

        <div class="p-6">
            <!-- Профайлын үндсэн хэсэг -->
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Зураг ба үндсэн мэдээлэл -->
                <div class="md:w-1/3">
                    <h4>Two-Factor Authentication</h4>

                    @if(auth()->user()->google2fa_enabled)
                        <div class="alert alert-success">
                            Two-factor authentication is enabled.
                        </div>
                        <a href="{{ route('2fa.disable.form') }}" class="btn btn-danger">Disable 2FA</a>
                    @else
                        <div class="alert alert-warning">
                            Two-factor authentication is not enabled. It adds an extra layer of security to your account.
                        </div>
                        <a href="{{ route('2fa.setup') }}" class="btn btn-success">Enable 2FA</a>
                    @endif
                    <div class="text-center">
                        <img src="{{ $profile->profile_pic ? Storage::url($profile->profile_pic) : asset('images/default-avatar.png') }}"
                             class="w-48 h-48 rounded-full mx-auto mb-4 object-cover"
                             alt="Профайл зураг">
                        <h3 class="text-xl font-bold">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>

                        @if($isDoctor)
                            <div class="mt-4 p-3 bg-blue-100 rounded-lg">
                                <span class="text-blue-600 font-semibold">✓ Баталгаажсан эмч</span>
                            </div>
                        @endif

                        <!-- Эрүүл мэндийн самбар товчлуур -->
                        <a href="{{ route('health.dashboard') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Эрүүл мэндийн самбар
                        </a>

                    </div>
                </div>

                <!-- Хувийн мэдээлэл -->
                <div class="md:w-2/3 space-y-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Хувийн мэдээлэл</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500">Төрсөн огноо</label>
                            <p class="font-medium">
                                {{ $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->format('Y-m-d') : 'Мэдээлэл байхгүй' }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Хүйс</label>
                            <p class="font-medium">
                                @switch($profile->gender)
                                    @case('male') Эрэгтэй @break
                                    @case('female') Эмэгтэй @break
                                    @default Мэдээлэл байхгүй
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Өндөр</label>
                            <p class="font-medium">{{ $profile->height ? $profile->height.' см' : 'Мэдээлэл байхгүй' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Тамхи татдаг</label>
                            <p class="font-medium">{{ $profile->is_smoker ? 'Тийм' : 'Үгүй' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Архаг өвчин</label>
                            <p class="font-medium">{{ $profile->has_chronic_conditions ? 'Тийм' : 'Үгүй' }}</p>
                        </div>
                    </div>

                    @if($isDoctor)
                    <!-- Эмчийн мэдээлэл -->
                    <div class="pt-4 border-t">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Эмчийн Мэдээлэл</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500">Бүтэн нэр</label>
                                <p class="font-medium">{{ $doctorInfo->full_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Утасны дугаар</label>
                                <p class="font-medium">{{ $doctorInfo->phone_number ?? 'Мэдээлэл байхгүй' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Мэргэжил</label>
                                <p class="font-medium">{{ $professional->specialization }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Зэрэг</label>
                                <p class="font-medium">{{ $professional->qualification }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Ажилладаг газар</label>
                                <p class="font-medium">{{ $doctorInfo->workplace ?? 'Мэдээлэл байхгүй' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Хаяг</label>
                                <p class="font-medium">{{ $doctorInfo->address ?? 'Мэдээлэл байхгүй' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Боловсрол</label>
                                <p class="font-medium">{{ $doctorInfo->education ?? 'Мэдээлэл байхгүй' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Туршлага</label>
                                <p class="font-medium">
                                    {{ $doctorInfo->years_experience ? $doctorInfo->years_experience.' жил' : 'Мэдээлэл байхгүй' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Хэлнүүд</label>
                                <p class="font-medium">{{ $doctorInfo->languages ?? 'Мэдээлэл байхгүй' }}</p>
                            </div>
                        </div>

                        @if($professional->certification)
                            <div class="mt-4">
                                <label class="text-sm text-gray-500">Сертификат</label>
                                <div class="flex items-center gap-2 mt-1">
                                    <a href="{{ Storage::url($professional->certification) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Сертификат харах
                                    </a>
                                    <span class="text-xs text-gray-500">(PDF/JPG/PNG)</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Эрүүл мэндийн түүх -->
            @if($profile->medical_history)
            <div class="mt-6 pt-4 border-t">
                <h3 class="text-lg font-semibold mb-2">Эрүүл мэндийн түүх</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 whitespace-pre-line">{{ $profile->medical_history }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Засварлах холбоосууд -->
    <div class="flex justify-end gap-4">
        <a href="{{ route('profile.edit') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
            <i class="fas fa-edit mr-2"></i>Профайл засах
        </a>

        @if($isDoctor)
        <a href="{{ route('doctor.edit') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">
            <i class="fas fa-user-md mr-2"></i>Эмчийн мэдээлэл засах
        </a>
        @endif
    </div>
</div>
@endsection
