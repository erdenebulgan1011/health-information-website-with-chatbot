@extends('layouts.dashboard')

@section('title', 'Миний профайл')

@section('content')
<div class="w-full max-w-7xl mx-auto">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Profile Header -->
        <div class="px-8 py-6 bg-blue-600 text-white">
            <h2 class="text-3xl font-bold">Хувийн мэдээлэл</h2>
        </div>

        <!-- Profile Content -->
        <div class="p-8">
            <div class="flex flex-col lg:flex-row">
                <!-- Left Column - User Info -->
                <div class="lg:w-1/3 flex flex-col items-center mb-8 lg:mb-0">
                    <!-- Profile Picture -->
                    <div class="w-40 h-40 mb-4 rounded-full overflow-hidden border-4 border-gray-200 shadow-md">
                        <img
                            src="{{ optional($profile)->profile_pic_default ?? asset('images/default-avatar.png') }}"
                            alt="{{ Auth::user()->name }}"
                            class="object-cover w-full h-full"
                        >
                    </div>

                    <!-- User Name and Details -->
                    <h3 class="text-2xl font-semibold mt-2">{{ Auth::user()->name }}</h3>
                    <p class="text-lg text-gray-600">{{ Auth::user()->email }}</p>
                    <p class="text-sm text-gray-500 mt-1">Бүртгүүлсэн: {{ Auth::user()->created_at->format('Y-m-d') }}</p>

                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3 w-full px-6 flex flex-col items-center">
                        <a href="{{ route('profile.edit') }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Профайл засах
                        </a>
                        <!-- Эрүүл мэндийн самбар товчлуур -->
                        <a href="{{ route('health.dashboard') }}"
                           class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Эрүүл мэндийн самбар
                        </a>

                        <!-- Doctor Registration Button -->
                        @if(Auth::user()->professional)
                            @if(Auth::user()->professional->is_verified)
                                <a href="{{ route('doctor.profile') }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Эмчийн профайл
                                </a>
                                <a href="{{ route('doctor-info.create') }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Мэдээллээ оруулах
                                </a>
                            @else
                                <button class="w-full inline-flex justify-center items-center px-6 py-3 bg-gray-400 text-white rounded-lg cursor-default shadow-md" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Хүлээгдэж буй...
                                </button>
                            @endif
                        @else
                            <a href="{{ route('register.doctor') }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Эмчээр Бүртгүүлэх
                            </a>
                        @endif
                    </div>


                    <!-- 2FA Section -->
                    <div class="w-full mt-8 bg-gray-50 rounded-lg p-5 shadow-inner">
                        <h4 class="text-lg font-semibold mb-4 text-center">Хоёр-үе шатлалт хамгаалалт</h4>

                        @if(auth()->user()->google2fa_enabled)
                            <div class="alert bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm">Хоёр-үе шатлалт хамгаалалт идэвхтэй байна.</p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('2fa.disable.form') }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                                Идэвхгүй болгох
                            </a>
                        @else
                            <div class="alert bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm">Хоёр-үе шатлалт хамгаалалт идэвхгүй байна. Энэ нь таны бүртгэлийн аюулгүй байдлыг нэмэгдүүлдэг.</p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('2fa.setup') }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Идэвхжүүлэх
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Medical Info -->
                <div class="lg:w-2/3 lg:pl-10 lg:border-l border-gray-200">
                    <h3 class="text-2xl font-semibold mb-6 pb-3 border-b border-gray-200">Үндсэн мэдээлэл</h3>

                    @if(isset($profile) && $profile)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Төрсөн огноо</p>
                                <p class="text-xl text-gray-800 font-medium">{{ $profile->birth_date ?? 'Мэдээлэл оруулаагүй' }}</p>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Хүйс</p>
                                <p class="text-xl text-gray-800 font-medium">
                                    @if($profile->gender === 'male')
                                        Эрэгтэй
                                    @elseif($profile->gender === 'female')
                                        Эмэгтэй
                                    @elseif($profile->gender === 'other')
                                        Бусад
                                    @else
                                        Мэдээлэл оруулаагүй
                                    @endif
                                </p>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Өндөр</p>
                                <p class="text-xl text-gray-800 font-medium">{{ $profile->height ? $profile->height . ' см' : 'Мэдээлэл оруулаагүй' }}</p>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Тамхи татдаг эсэх</p>
                                <p class="text-xl text-gray-800 font-medium">{{ $profile->is_smoker ? 'Тийм' : 'Үгүй' }}</p>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Архаг өвчинтэй эсэх</p>
                                <p class="text-xl text-gray-800 font-medium">{{ $profile->has_chronic_conditions ? 'Тийм' : 'Үгүй' }}</p>
                            </div>
                        </div>

                        @if($profile->medical_history)
                            <div class="mt-6">
                                <h3 class="text-2xl font-semibold mb-4 pb-3 border-b border-gray-200">Эрүүл мэндийн түүх</h3>
                                <div class="p-6 bg-gray-50 rounded-lg shadow-sm">
                                    <p class="text-gray-800 leading-relaxed">{{ $profile->medical_history }}</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="bg-yellow-50 p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <h3 class="text-xl font-medium text-yellow-800">Анхааруулга</h3>
                                    <div class="mt-3 text-lg text-yellow-700">
                                        <p>Таны профайлын мэдээлэл бүртгэгдээгүй байна. Профайлаа засах хэсэгт орж мэдээллээ оруулна уу.</p>
                                    </div>
                                    <div class="mt-6">
                                        <div class="-mx-2 -my-1.5 flex">
                                            <a href="{{ route('profile.edit') }}" class="bg-yellow-100 px-6 py-3 rounded-lg text-lg font-medium text-yellow-800 hover:bg-yellow-200 transition-colors shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                Профайл засах
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
