@extends('layouts.forumApp')

@section('title', 'Нүүр хуудас')

@section('content')
    <title>Медик - Эрүүл мэндийн асуулт хариултын платформ</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    @push('style')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .hero-pattern {
            background-color: #f0f9ff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23a5f3fc' fill-opacity='0.4'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

    </style>
    @endpush

<body>
    <!-- Навигаци -->
    {{-- <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="#" class="flex items-center">
                        <i class="fas fa-heartbeat text-cyan-600 text-3xl mr-2"></i>
                        <span class="text-xl font-bold text-gray-800">Медик</span>
                    </a>
                    <div class="hidden md:flex items-center ml-10 space-x-6">
                        <a href="#" class="text-gray-800 hover:text-cyan-600 font-medium">Нүүр</a>
                        <a href="#forum" class="text-gray-600 hover:text-cyan-600">Форум</a>
                        <a href="#diseases" class="text-gray-600 hover:text-cyan-600">Өвчнүүд</a>
                        <a href="#vr" class="text-gray-600 hover:text-cyan-600">VR Контент</a>
                        <a href="#events" class="text-gray-600 hover:text-cyan-600">Үйл явдал</a>
                        <a href="#map" class="text-gray-600 hover:text-cyan-600">Газрын зураг</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="relative mr-4 hidden md:block">
                        <input type="text" placeholder="Хайх..." class="bg-gray-100 rounded-full px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <button class="absolute right-0 top-0 mt-2 mr-3 text-gray-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <a href="#" class="bg-cyan-600 text-white px-4 py-2 rounded-md hover:bg-cyan-700 transition">Нэвтрэх</a>
                    <button class="ml-4 text-gray-600 md:hidden">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav> --}}

    <!-- Үндсэн зураг хэсэг -->
<section class="hero-pattern py-16 md:py-24 bg-gradient-to-r from-blue-50 to-blue-100">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Эрүүл мэндийн асуулт хариултын цогц платформ</h1>
                <p class="text-lg text-gray-600 mb-8">Өөрийн эрүүл мэндээ хянах, мэргэжлийн зөвлөгөө авах, бусадтай туршлагаа хуваалцах боломжийг нэг дор.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300 transform hover:scale-105 text-center shadow-lg">Асуулт асуух</a>
                    <a href="javascript:void(0)" id="open-chatbot" class="bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition duration-300 text-center shadow-md">Чатботтой ярилцах</a>
                </div>
            </div>
            <div class="md:w-1/2">
                <div class="relative">
                    <div class="absolute -inset-4 bg-blue-600 rounded-lg opacity-10 blur-xl"></div>
                    <img src="{{ asset('/storage/img/test.jpg') }}" alt="Эрүүл мэндийн зураг" class="relative w-full max-w-lg h-auto rounded-lg shadow-xl mx-auto transform hover:scale-105 transition duration-500">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Үндсэн функциональ хэсэг -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Бидний үйлчилгээнүүд</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Асуулт хариулт -->
            <div class="bg-white rounded-xl shadow-lg p-6 feature-card hover:shadow-xl transition duration-300 border-t-4 border-blue-600 transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-question-circle text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Календарь</h3>
                <p class="text-gray-600 mb-4">Эрүүл мэндийн Үйлчилгээтэй холбоотой үйл явдлуудын календарь.</p>
                <a href="{{ route('events.calendar') }}" class="text-blue-600 font-medium hover:text-blue-700 inline-flex items-center">
                    Дэлгэрэнгүй <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Чатбот -->
            <div class="bg-white rounded-xl shadow-lg p-6 feature-card hover:shadow-xl transition duration-300 border-t-4 border-blue-600 transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-robot text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">AI Чатбот</h3>
                <p class="text-gray-600 mb-4">24/7 ажиллах AI чатбот танд шуурхай хариулт, зөвлөгөө өгнө.</p>
                <a href="javascript:void(0)" id="open-chatbot-forMAIN" class="text-blue-600 font-medium hover:text-blue-700 inline-flex items-center">
                    Дэлгэрэнгүй <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Эрүүл мэндийн бүртгэл -->
            <div class="bg-white rounded-xl shadow-lg p-6 feature-card hover:shadow-xl transition duration-300 border-t-4 border-blue-600 transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-notes-medical text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Эрүүл мэндийн бүртгэл</h3>
                <p class="text-gray-600 mb-4">Өөрийн эрүүл мэндийн бүртгэлийг хөтлөх, хянах.</p>
                <a href="{{ route('profile.show') }}" class="text-blue-600 font-medium hover:text-blue-700 inline-flex items-center">
                    Дэлгэрэнгүй <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- VR контент -->
            <div class="bg-white rounded-xl shadow-lg p-6 feature-card hover:shadow-xl transition duration-300 border-t-4 border-blue-600 transform hover:-translate-y-2" id="vr">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-vr-cardboard text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">VR Контент</h3>
                <p class="text-gray-600 mb-4">Эрүүл мэндийн 3D VR контентыг шууд үзэх боломж.</p>
                <a href="{{ route('home') }}" class="text-blue-600 font-medium hover:text-blue-700 inline-flex items-center">
                    Дэлгэрэнгүй <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Форум -->
            <div class="bg-white rounded-xl shadow-lg p-6 feature-card hover:shadow-xl transition duration-300 border-t-4 border-blue-600 transform hover:-translate-y-2" id="forum">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-comments text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Хэлэлцүүлгийн форум</h3>
                <p class="text-gray-600 mb-4">Олон нийтийн хэлэлцүүлэг, туршлага солилцох форум.</p>
                <a href="{{ route('topics.index') }}" class="text-blue-600 font-medium hover:text-blue-700 inline-flex items-center">
                    Дэлгэрэнгүй <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- MAP -->
            <div class="bg-white rounded-xl shadow-lg p-6 feature-card hover:shadow-xl transition duration-300 border-t-4 border-blue-600 transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-shield-alt text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Газрын зураг</h3>
                <p class="text-gray-600 mb-4">Таньд ойр байрлах эмнэлэг эмийн сангийн байршил .</p>
                <a href="{{ route('vr.map') }}" class="text-blue-600 font-medium hover:text-blue-700 inline-flex items-center">
                    Дэлгэрэнгүй <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Өвчнүүд хэсэг -->
<section class="py-16 bg-gray-50" id="diseases">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div class="mb-6 md:mb-0">
                <h2 class="text-3xl font-bold text-gray-800">Өвчний мэдээлэл</h2>
                <div class="w-20 h-1 bg-blue-600 mt-2"></div>
            </div>
            <div class="mt-4 md:mt-0">
                <form action="{{ route('diseases.search') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Өвчин хайх..." class="bg-white border border-gray-300 rounded-full px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-500 hover:text-blue-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($diseases as $disease)
                <!-- Өвчин -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">{{ $disease->disease_name }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($disease->common_symptom, 120) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            @if(Str::contains(strtolower($disease->common_symptom), ['сахар', 'шээх', 'ундаасах']))
                                Дотор
                            @elseif(Str::contains(strtolower($disease->common_symptom), ['даралт', 'зүрх', 'судас']))
                                Зүрх судас
                            @elseif(Str::contains(strtolower($disease->common_symptom), ['ханиах', 'амьсгал', 'уушги']))
                                Амьсгал
                            @else
                                Ерөнхий
                            @endif
                        </span>
                        <a href="{{ route('diseases.show', $disease->id) }}" class="text-blue-600 hover:text-blue-700 font-medium">Дэлгэрэнгүй</a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">Одоогоор өвчний мэдээлэл байхгүй байна.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('diseases.index') }}" class="inline-block bg-white border border-blue-600 text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition duration-300 shadow-md">Бүх өвчнүүдийг харах</a>
        </div>
    </div>
</section>

<!-- Эрүүл мэндийн тест -->
<section class="py-16 bg-blue-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Эрүүл мэндийн тест авах</h2>
                <div class="w-20 h-1 bg-blue-600 mb-6"></div>
                <p class="text-gray-600 mb-8">Өөрийн эрүүл мэндийн байдлаа үнэлж, эрсдэлийг урьдчилан тодорхойлоход туслах төрөл бүрийн тестүүд.</p>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white mr-3">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="text-gray-700">Зүрх судасны эрсдэлийн үнэлгээ</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white mr-3">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="text-gray-700">Стрессийн түвшин тодорхойлох тест</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white mr-3">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="text-gray-700">Биеийн жингийн индекс (BMI) тооцоолох</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white mr-3">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="text-gray-700">Чихрийн шижингийн эрсдэлийн үнэлгээ</span>
                    </div>
                </div>
                <a href="{{ route('phq9.index') }}" class="inline-block mt-8 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105">Тест өгөх</a>
            </div>
            <div class="md:w-1/2">
                <div class="relative">
                    <div class="absolute -inset-4 bg-blue-600 rounded-lg opacity-10 blur-lg"></div>
                    <img src="{{ asset('/storage/img/healthTEST.png') }}" alt="Эрүүл мэндийн тест" class="relative w-full max-w-lg h-auto rounded-lg shadow-xl mx-auto transform hover:scale-105 transition duration-500">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Календарь ба Үйл явдал -->
<section class="py-16 bg-white" id="events">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Үйл явдлын календарь</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                <!-- Үйл явдал -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition transform hover:-translate-y-1">
                    <div class="bg-blue-600 text-white p-4">
                        <h3 class="font-bold text-xl">{{ $event->title }}</h3>
                        <div class="flex items-center mt-2">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <span>{{ $event->formatted_date }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4">{{ Str::limit($event->description, 100) }}</p>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                        <a href="{{ route('events.show', $event->id) }}" class="block text-center mt-4 bg-gray-100 text-gray-800 px-4 py-2 rounded hover:bg-blue-100 hover:text-blue-800 transition">Дэлгэрэнгүй</a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">Одоогоор үйл явдал байхгүй байна.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="#" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105">Бүх үйл явдлыг харах</a>
        </div>
    </div>
</section>

<!-- Чатбот хэсэг -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h2 class="text-3xl font-bold mb-6">AI Чатботтой ярилцах</h2>
                <div class="w-20 h-1 bg-white opacity-80 mb-6"></div>
                <p class="mb-8">Эрүүл мэндийн асуултаа шууд чатботоос асууж, хариулт авах боломжтой. Бидний AI чатбот 24/7 ажиллаж, танд туслахад бэлэн.</p>
                <a href="#" class="inline-block bg-white text-blue-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition duration-300 shadow-lg transform hover:scale-105">Чатботтой ярилцах</a>
            </div>
            <div class="md:w-1/2">
                <div class="bg-white rounded-xl shadow-xl overflow-hidden max-w-md mx-auto transform hover:scale-105 transition duration-500">
                    <div class="bg-blue-700 text-white p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-robot"></i>
                            </div>
                            <h3 class="ml-3 font-semibold">Медик Чатбот</h3>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 h-64 overflow-y-auto">
                        <div class="flex items-start mb-4">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white mr-2">
                                <i class="fas fa-robot text-sm"></i>
                            </div>
                            <div class="bg-blue-100 rounded-lg p-3 max-w-xs">
                                <p class="text-gray-800 text-sm">Сайн байна уу! Танд чим туслах уу? Эрүүл мэндийн талаар асуулт асууна уу.</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-4 justify-end">
                            <div class="bg-white rounded-lg p-3 max-w-xs shadow-sm">
                                <p class="text-gray-800 text-sm">Толгой өвдөх шалтгаан юу вэ?</p>
                            </div>
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white ml-2">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white mr-2">
                                <i class="fas fa-robot text-sm"></i>
                            </div>
                            <div class="bg-blue-100 rounded-lg p-3 max-w-xs">
                                <p class="text-gray-800 text-sm">Толгой өвдөх нь стресс, ядаргаа, нойргүйдэл, шингэн дутагдах, даралт өөрчлөгдөх зэрэг шалтгаантай байж болно. Та ямар шинж тэмдэг мэдэрч байна?</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t">
                        <div class="flex">
                            <input type="text" placeholder="Асуултаа бичнэ үү..." class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button class="bg-blue-600 text-white rounded-r-lg px-4 hover:bg-blue-700 transition">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured VR Models Section -->
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-center">Онцлох VR загварууд</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto mt-4 mb-8"></div>
            <p class="text-center text-gray-600 max-w-3xl mx-auto">Эрүүл мэндийн салбарт тэргүүлэх хамгийн өндөр чанартай 3D загварууд</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredContent as $content)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-2">
                <div class="relative h-48 bg-gray-900">
                    @if($content->embed_url)
                        <iframe
                            src="{{ $content->getEmbedUrlAttribute() }}"
                            class="absolute w-full h-full border-0"
                            frameborder="0"
                            allow="autoplay; fullscreen; vr"
                            allowfullscreen
                            loading="lazy"
                        ></iframe>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                            </svg>
                        </div>
                    @endif
                    <span class="absolute bottom-0 right-0 bg-blue-600 text-white px-3 py-1 text-sm">{{ $content->category->name }}</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $content->title }}</h3>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                        {{ $content->description }}
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            {{ $content->category->name }}
                        </span>
                        <a href="{{ route('category.vr-content.shows', $content->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300 shadow-md">Дэлгэрэнгүй</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-center">Ангилал</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto mt-4 mb-8"></div>
            <p class="text-center text-gray-600 max-w-3xl mx-auto">Эрүүл мэндийн VR загварууд төрөл бүрээр</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('category.shows', $category->id) }}" class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-lg hover:bg-blue-50 transform hover:-translate-y-1 border-b-4 border-transparent hover:border-blue-600">
                <div class="text-blue-600 text-4xl mb-4">
                    {{ $category->icon }}
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">{{ $category->name }}</h3>
                <p class="text-gray-600">{{ $category->vr_contents_count }} загвар</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

    <!-- Форум хэсэг -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Идэвхтэй хэлэлцүүлгүүд</h2>

            <div class="space-y-6">
                @forelse($topics as $topic)
                    <!-- Сэдэв -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-12 h-12 bg-cyan-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-cyan-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $topic->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($topic->content, 150) }}</p>
                                <div class="flex flex-wrap items-center text-sm text-gray-500">
                                    <div class="mr-6 mb-2">
                                        <i class="fas fa-user mr-1"></i> {{ $topic->user->name ?? 'Хэрэглэгч' }}
                                    </div>
                                    <div class="mr-6 mb-2">
                                        <i class="fas fa-comments mr-1"></i> {{ $topic->replies_count }} хариулт
                                    </div>
                                    <div class="mr-6 mb-2">
                                        <i class="fas fa-eye mr-1"></i> {{ $topic->views }} үзсэн
                                    </div>
                                    <div class="mb-2">
                                        <i class="fas fa-clock mr-1"></i> {{ $topic->time_ago }}
                                    </div>
                                </div>
                                <div class="mt-4 flex">
                                    <span class="bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-xs mr-2">{{ $topic->category->name ?? 'Ерөнхий' }}</span>
                                    @if(Str::contains(strtolower($topic->title), ['витамин']))
                                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs">Витамин</span>
                                    @elseif(Str::contains(strtolower($topic->title), ['вакцин']))
                                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs">Вакцин</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500">Одоогоор идэвхтэй хэлэлцүүлэг байхгүй байна.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('topics.index') }}" class="inline-block bg-cyan-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-cyan-700 transition">Бүх сэдвүүдийг харах</a>
            </div>
        </div>
    </section>

    {{-- <!-- Эрүүл мэндийн нийтлэл -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Эрүүл мэндийн мэдээлэл</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Нийтлэл 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <img src="/api/placeholder/400/200" alt="Нийтлэл зураг" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Сахарын шижингийн эсрэг хооллолт</h3>
                        <p class="text-gray-600 mb-4">Сахарын шижинтэй хүмүүс өдөр тутмын хооллолтондоо анхаарах зүйлс, зөвлөмжүүд.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <div class="mr-4">
                                <i class="fas fa-user mr-1"></i> Д. Отгонбаяр
                            </div>
                            <div>
                                <i class="fas fa-calendar mr-1"></i> 2025.05.01
                            </div>
                        </div>
                        <a href="#" class="block text-cyan-600 mt-4 hover:text-cyan-700">Цааш унших →</a>
                    </div>
                </div>

                <!-- Нийтлэл 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <img src="/api/placeholder/400/200" alt="Нийтлэл зураг" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Хэт ядаргаа ба түүнийг даван туулах</h3>
                        <p class="text-gray-600 mb-4">Ажлын ачаалал, стрессээс үүдэлтэй хэт ядаргаа, түүнийг хэрхэн зөв даван туулах арга замууд.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <div class="mr-4">
                                <i class="fas fa-user mr-1"></i> Б. Золжаргал
                            </div>
                            <div>
                                <i class="fas fa-calendar mr-1"></i> 2025.04.28
                            </div>
                        </div>
                        <a href="#" class="block text-cyan-600 mt-4 hover:text-cyan-700">Цааш унших →</a>
                    </div>
                </div>

                <!-- Нийтлэл 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <img src="/api/placeholder/400/200" alt="Нийтлэл зураг" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Өдөр тутмын дасгал хөдөлгөөн</h3>
                        <p class="text-gray-600 mb-4">Ажлын ачаалалтай хүмүүст зориулсан хурдан, энгийн дасгал хөдөлгөөнүүд.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <div class="mr-4">
                                <i class="fas fa-user mr-1"></i> Н. Пүрэвдорж
                            </div>
                            <div>
                                <i class="fas fa-calendar mr-1"></i> 2025.04.25
                            </div>
                        </div>
                        <a href="#" class="block text-cyan-600 mt-4 hover:text-cyan-700">Цааш унших →</a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center mb-6">
                        <i class="fas fa-heartbeat text-cyan-400 text-3xl mr-2"></i>
                        <span class="text-xl font-bold">Медик</span>
                    </div>
                    <p class="text-gray-400 mb-6">Эрүүл мэндийн асуулт хариултын цогц платформ.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6">Үйлчилгээнүүд</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">Асуулт & Хариулт</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">AI Чатбот</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">Эрүүл мэндийн бүртгэл</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">VR Контент</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">Форум</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6">Холбоос</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">Нүүр хуудас</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">Бидний тухай</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">Үйлчилгээний нөхцөл</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">Нууцлалын бодлого</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-cyan-400 transition">Холбоо барих</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6">Холбоо барих</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-cyan-400"></i>
                            <span class="text-gray-400">Улаанбаатар, Сүхбаатар дүүрэг, Энхтайваны өргөн чөлөө 47</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-cyan-400"></i>
                            <span class="text-gray-400">+976 7700-8899</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-cyan-400"></i>
                            <span class="text-gray-400">info@medic.mn</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 mb-4 md:mb-0">© 2025 Медик. Бүх эрх хуулиар хамгаалагдсан.</p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition">Нууцлалын бодлого</a>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition">Үйлчилгээний нөхцөл</a>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer> --}}

    <!-- Яваандаа буцах товч -->
    <a href="#" class="fixed bottom-8 right-8 bg-cyan-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-cyan-700 transition z-50">
        <i class="fas fa-arrow-up"></i>
    </a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.134.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.134.0/examples/js/loaders/GLTFLoader.js"></script>
<!-- Then your 3D viewer script -->
<script src="{{ asset('js/3d-viewer.js') }}"></script>
@endsection

@push('script')

    <!-- JavaScript -->
    <script>
        // Simple JavaScript for mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.md\\:hidden');
            const mobileMenu = document.querySelector('.md\\:flex.items-center.ml-10');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // For smooth scrolling to sections
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>

@endpush

