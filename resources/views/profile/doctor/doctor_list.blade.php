{{-- resources/views/doctor_list.blade.php --}}
@extends('layouts.ForumApp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Баталгаажсан эмч нар</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($professionals as $professional)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <div class="p-6">
                {{-- Profile Photo --}}
                <div class="flex items-center justify-center mb-4">
                    @if($professional->doctorInfo && $professional->doctorInfo->profile_photo)
                        <img src="{{ asset('storage/'.$professional->doctorInfo->profile_photo) }}"
                             class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md"
                             alt="Эмчийн профайл зураг">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Doctor Information --}}
                <div class="text-center">
                    <h2 class="text-xl font-semibold mb-2">
                        {{ $professional->doctorInfo->full_name ?? $professional->user->name }}
                    </h2>
                    <p class="text-blue-600 font-medium mb-2">
                        {{ $professional->specialization }}
                    </p>

                    @if($professional->doctorInfo)
                        <div class="space-y-2 text-sm text-gray-600">
                            @if($professional->doctorInfo->workplace)
                                <p class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ $professional->doctorInfo->workplace }}
                                </p>
                            @endif

                            @if($professional->doctorInfo->years_experience)
                                <p>
                                    <span class="font-medium">Туршлага:</span>
                                    {{ $professional->doctorInfo->years_experience }} жил
                                </p>
                            @endif

                            @if($professional->doctorInfo->languages)
                                <p>
                                    <span class="font-medium">Хэл:</span>
                                    {{ $professional->doctorInfo->languages }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Contact and Details --}}
                <div class="mt-6 flex justify-center space-x-4">
                    @if($professional->doctorInfo && $professional->doctorInfo->phone_number)
                        <a href="tel:{{ $professional->doctorInfo->phone_number }}"
                           class="px-4 py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200">
                            Утасдах
                        </a>
                    @endif

                    <a href="{{ route('doctor.profile', $professional->id) }}"
                       class="px-4 py-2 bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200">
                        Дэлгэрэнгүй
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">Ямар ч эмч бүртгэгдээгүй байна</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}

    @if($professionals->hasPages())
    <div class="mt-8">
        {{ $professionals->links() }}
    </div>
@endif

</div>
@endsection
