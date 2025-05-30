<!DOCTYPE html>
<html>
<head>
    <title>Healthcare Facility Finder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3a86ff',
                        secondary: '#4cc9f0',
                        accent: '#7209b7',
                    }
                }
            }
        }
    </script>
        <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-…"
    crossorigin="anonymous"
  />
  <script src="https://unpkg.com/alpinejs" defer></script>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }
        #map-container {
            display: flex;
            height: 100vh;
        }
        #sidebar {
            width: 300px;
            padding: 15px;
            background: #f8f9fa;
            overflow-y: auto;
        }
        #map {
            flex: 1;
        }
        .controls {
            margin-bottom: 20px;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }
        .place-list {
            margin-top: 10px;
        }
        .place-item {
            padding: 10px;
            margin-bottom: 10px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            cursor: pointer;
        }
        .place-item:hover {
            background: #f1f1f1;
        }
        .place-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .place-address {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 5px;
        }
        .place-distance {
            font-size: 0.9em;
            color: #007bff;
            font-weight: bold;
        }
        .place-type {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.8em;
            margin-top: 5px;
        }
        .hospital {
            background: #f8d7da;
            color: #721c24;
        }
        .pharmacy {
            background: #d4edda;
            color: #155724;
        }
        .nearest {
            border: 2px solid #ffc107;
            position: relative;
        }
        .nearest::after {
            content: "NEAREST";
            position: absolute;
            top: 5px;
            right: 5px;
            background: #ffc107;
            color: #000;
            padding: 2px 5px;
            font-size: 0.7em;
            border-radius: 3px;
        }
        .button {
            padding: 8px 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .button:hover {
            background: #0069d9;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            z-index: 1000;
            display: none;
        }








        .container {
        margin-left: 15px;  /* Left space */
        margin-right: 15px;  /* Right space */
    }

    /* Ensure that sidebar and content container don't stretch too wide */
    .content-wrapper {
        display: flex;
        max-width: 1200px; /* Controls the width */
        margin-left: auto;
        margin-right: auto;
        padding-left: 20px;
        padding-right: 20px;
    }



    /* Custom styles */
    .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination li.active span {
            background-color: var(--primary);
            color: white;
        }

        .pagination li a:hover {
            background-color: #f0f0f0;
        }
.nav-btn {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            letter-spacing: 0.02em;
            font-weight: 500;
        }

        .nav-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-btn.active, .mobile-nav-btn.active {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }

   /* Enhanced Dropdown Styles */
   .dropdown-panel {
            position: absolute;
            background-color: rgb(42, 46, 89);
            text-gray-800: #333;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            margin-top: 0.5rem;
            padding: 0.75rem;
            min-width: 240px;
            z-index: 50;
            transform-origin: top;
            transform: scale(0.95);
            opacity: 0;
            transition: transform 0.2s ease, opacity 0.2s ease;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .dropdown-panel.show {
            transform: scale(1);
            opacity: 1;
        }

        .dropdown-panel::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 16px;
            width: 16px;
            height: 16px;
            background-color: white;
            transform: rotate(45deg);
            z-index: -1;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .dropdown-item:hover {
            background-color: #27292e;
        }

        .dropdown-item::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 0;
            background-color: #3a86ff;
            transition: width 0.3s ease;
        }

        .dropdown-item:hover::after {
            width: 100%;
        }
/* Chevron Animation */
.fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Logo Badge Enhancement */
        .p-2.bg-white.rounded-full {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .p-2.bg-white.rounded-full:hover {
            transform: scale(1.05);
        }

        /* Mobile Menu Animation */
        #mobile-menu {
            max-height: 0;
            opacity: 0;
            transition: max-height 0.5s ease, opacity 0.3s ease;
            overflow: hidden;
        }

        #mobile-menu.show {
            max-height: 1000px;
            opacity: 1;
        }

        /* Mobile Navigation Styles */
        .mobile-nav-btn {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .mobile-nav-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .mobile-sub-link {
            display: block;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .mobile-sub-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Sticky Header */
        header {
            position: sticky;
            top: 0;
            z-index: 1001; /* Higher than sidebar to stay on top */
            background-color: #ffffff; /* Default background */

            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        header.scrolled {
            background: linear-gradient(to right, #2563eb, #4f46e5);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Dropdown Positioning */
        @media (max-width: 1200px) {
            .dropdown-panel {
                right: 0;
                left: auto;
            }

            .dropdown-panel::before {
                right: 16px;
                left: auto;
            }
        }



        @keyframes typing-animation {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
    </style>
        <header class="bg-gradient-to-r from-primary to-accent text-white shadow-xl" x-data="{ mobileMenuOpen: false }">
        <nav class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="#" class="flex items-center space-x-3">
                    <div class="p-2 bg-white rounded-full">
                        <i class="fas fa-heartbeat text-2xl text-primary"></i>
                    </div>
                    <span class="text-2xl font-bold tracking-tighter">ЭрүүлМэнд</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <!-- Main Navigation -->
                    <div class="flex items-center space-x-6">
                        <!-- Tests Dropdown -->
                        <div class="relative group" x-data="{ open: false }">
                            <button @click="open = !open" class="nav-btn">
                                <i class="fas fa-clipboard-list mr-2"></i>
                                Тестүүд
                                <i class="fas fa-chevron-down ml-2 text-sm" :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open"
     x-transition
     @click.outside="open = false"
     class="dropdown-panel"
     :class="{'show': open}">
    <a href="{{ route('phq9.index') }}" class="dropdown-item">
        <i class="fas fa-brain text-primary mr-2"></i>
        PHQ-9 Тест
    </a>
    <a href="{{ route('gad7.index') }}" class="dropdown-item">
        <i class="fas fa-head-side-virus text-primary mr-2"></i>
        GAD-7 Тест
    </a>
    <a href="{{ route('auditc.index') }}" class="dropdown-item">
        <i class="fas fa-wine-glass-alt text-primary mr-2"></i>
        AUDIT-C Тест
    </a>
    <a href="{{ route('ptsd-test.index') }}" class="dropdown-item">
        <i class="fas fa-heartbeat text-primary mr-2"></i>
        PTSD Тест
    </a>
    <a href="{{ route('mental-health.gad2') }}" class="dropdown-item">
        <i class="fas fa-dizzy text-primary mr-2"></i>
        GAD2 Тест
    </a>
    <a href="{{ route('mental-health.cage') }}" class="dropdown-item">
        <i class="fas fa-comments text-primary mr-2"></i>
        CAGE Тест
    </a>
    <a href="{{ route('adhd.test') }}" class="dropdown-item">
        <i class="fas fa-child text-primary mr-2"></i>
        ADHD Тест
    </a>
    <a href="{{ route('dass21.index') }}" class="dropdown-item">
        <i class="fas fa-sad-tear text-primary mr-2"></i>
        DASS-21 Тест
    </a>
    <a href="{{ route('ess.index') }}" class="dropdown-item">
        <i class="fas fa-bed text-primary mr-2"></i>
        ESS Тест
    </a>
    <a href="{{ route('parq.index') }}" class="dropdown-item">
        <i class="fas fa-running text-primary mr-2"></i>
        PAR-Q+ Тест
    </a>
    <a href="{{ route('ipaq.index') }}" class="dropdown-item">
        <i class="fas fa-walking text-primary mr-2"></i>
        IPAQ Тест
    </a>
</div>

                        </div>

                        <!-- VR Content Dropdown -->
                        <div class="relative group" x-data="{ open: false }">
                            <button @click="open = !open" class="nav-btn">
                                <i class="fas fa-vr-cardboard mr-2"></i>
                                VR Контент
                                <i class="fas fa-chevron-down ml-2 text-sm" :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open"
     x-transition
     @click.outside="open = false"
     class="dropdown-panel"
     :class="{'show': open}">
    <a href="{{ route('home') }}" class="dropdown-item">
        <i class="fas fa-boxes text-primary mr-2"></i>
        Бүх контент
    </a>
    <a href="{{ route('vr-content.featured') }}" class="dropdown-item">
        <i class="fas fa-star text-primary mr-2"></i>
        Онцлох
    </a>
    <a href="{{ route('vr-content.new') }}" class="dropdown-item">
        <i class="fas fa-certificate text-primary mr-2"></i>
        Шинэ загварууд
    </a>
    <a href="{{ route('vr.createSuggest') }}" class="dropdown-item">
        <i class="fas fa-lightbulb text-primary mr-2"></i>
        Санал оруулах
    </a>
</div>

                        </div>

                        <!-- Other Navigation Buttons -->
                        {{-- <a href="{{ route('topics.index') }}" class="nav-btn active">
                            <i class="fas fa-comments mr-2"></i>
                            Форум
                        </a> --}}
                        <div class="relative group" x-data="{ open: false }">
                            <button @click="open = !open" class="nav-btn">
                                <i class="fas fa-vr-cardboard mr-2"></i>
                                Форум
                                <i class="fas fa-chevron-down ml-2 text-sm" :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open"
     x-transition
     @click.outside="open = false"
     class="dropdown-panel"
     :class="{'show': open}">
    <a href="{{ route('topics.index') }}" class="dropdown-item">
        <i class="fas fa-boxes text-primary mr-2"></i>
        Форум
    </a>
    <a href="{{ route('topics.index') }}" class="dropdown-item">
        <i class="fas fa-star text-primary mr-2"></i>
        Ангилалууд
    </a>
    <a href="{{ route('diseases.index') }}" class="dropdown-item">
        <i class="fas fa-certificate text-primary mr-2"></i>
        Материалууд
    </a>
    <a href="{{ route('topics.index') }}" class="dropdown-item">
        <i class="fas fa-lightbulb text-primary mr-2"></i>
        Мэргэжилтнүүд
    </a>
</div>

                        </div>

                        <a href="{{ route('events.calendar') }}" class="nav-btn">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Календарь
                        </a>

                        <a href="{{ route('vr.map') }}" class="nav-btn">
                            <i class="fas fa-map-marked-alt mr-2"></i>
                            Газрын зураг
                        </a>

                        <a href="{{ route('category.index') }}" class="nav-btn">
                            <i class="fas fa-tags mr-2"></i>
                            Ангилал
                        </a>
                    </div>

                    <!-- Additional Info Dropdown -->
                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open" class="nav-btn">
                            <i class="fas fa-info-circle mr-2"></i>
                            Нэмэлт
                            <i class="fas fa-chevron-down ml-2 text-sm" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open"
                             x-transition
                             @click.outside="open = false"
                             class="dropdown-panel"
                             :class="{'show': open}">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-address-card text-primary mr-2"></i>
                                Бидний тухай
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-phone-alt text-primary mr-2"></i>
                                Холбоо барих
                            </a>
                        </div>
                    </div>
                    <!-- Auth Section -->
                    <div class="h-8 w-[1px] bg-white/20 mx-4"></div>
                <div>
                    @auth
                    <!-- User Dropdown (Logged in) -->
                    <div class="relative group" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center space-x-2">
        <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center">
            <i class="fas fa-user text-sm"></i>
        </div>
        <span>{{ Auth::user()->name }}</span>
        <i class="fas fa-chevron-down text-sm mt-1" :class="{ 'rotate-180': open }"></i>
    </button>
    <div x-show="open"
         x-transition
         @click.outside="open = false"
         class="dropdown-panel right-0 w-48"
         :class="{'show': open}"
         style="display: none;">

        <a href="{{ route('profile.show') }}" class="dropdown-item">
            <i class="fas fa-user-circle text-primary mr-2"></i>
            Профайл
        </a>

        <a class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt text-primary mr-2"></i> Самбар
        </a>

        <a class="dropdown-item {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}" href="{{ route('profile.show') }}">
            <i class="fas fa-user-edit text-primary mr-2"></i> Миний профайл
        </a>

        <a href="{{ route('health.dashboard') }}" class="dropdown-item {{ request()->routeIs('health.dashboard') ? 'active' : '' }}">
            <i class="fas fa-heartbeat text-primary mr-2"></i>
            Эрүүл мэндийн самбар
        </a>

        <a class="dropdown-item {{ request()->routeIs('dashboard.topics') ? 'active' : '' }}" href="{{ route('dashboard.topics') }}">
            <i class="fas fa-list-alt text-primary mr-2"></i> Миний сэдвүүд
        </a>

        <a class="dropdown-item {{ request()->routeIs('dashboard.replies') ? 'active' : '' }}" href="{{ route('dashboard.replies') }}">
            <i class="fas fa-reply-all text-primary mr-2"></i> Миний хариултууд
        </a>

        <a class="dropdown-item {{ request()->routeIs('dashboard.vr.*') ? 'active' : '' }}" href="{{ route('dashboard.vr.index') }}">
            <i class="fas fa-vr-cardboard text-primary mr-2"></i> VR санал
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"  class="dropdown-item text-red-600 w-full text-left">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Гарах
            </button>
        </form>
    </div>
</div>


                    @else

                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="auth-btn bg-white/10 hover:bg-white/20">
                            Нэвтрэх
                        </a>
                        <a href="{{ route('register') }}" class="auth-btn bg-white text-primary hover:bg-opacity-90">
                            Бүртгүүлэх
                        </a>
                    </div>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-3 rounded-full hover:bg-white/10">
                    <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" :class="mobileMenuOpen ? 'show' : ''" class="lg:hidden overflow-hidden">
                <div class="py-4 space-y-4 border-t border-white/10">
                    <!-- Mobile Navigation -->
                    <div class="space-y-2">
                        <!-- Tests Accordion -->
                        <div x-data="{ open: false }" class="space-y-2">
                            <button @click="open = !open" class="mobile-nav-btn">
                                <i class="fas fa-clipboard-list mr-3"></i>
                                Тестүүд
                                <i class="fas fa-chevron-down ml-auto" :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="pl-11 space-y-2">
                                <a href="#" class="mobile-sub-link">PHQ-9 Тест</a>
                                <a href="#" class="mobile-sub-link">GAD-7 Тест</a>
                                <a href="#" class="mobile-sub-link">AUDIT-C Тест</a>
                                <a href="#" class="mobile-sub-link">PTSD Тест</a>
                                <a href="#" class="mobile-sub-link">GAD2 Тест</a>
                                <a href="#" class="mobile-sub-link">CAGE Тест</a>
                                <a href="#" class="mobile-sub-link">ADHD Тест</a>
                                <a href="#" class="mobile-sub-link">DASS-21 Тест</a>
                                <a href="#" class="mobile-sub-link">ESS Тест</a>
                                <a href="#" class="mobile-sub-link">PAR-Q+ Тест</a>
                                <a href="#" class="mobile-sub-link">IPAQ Тест</a>
                            </div>
                        </div>

                        <!-- VR Content Accordion -->
                        <div x-data="{ open: false }" class="space-y-2">
                            <button @click="open = !open" class="mobile-nav-btn">
                                <i class="fas fa-vr-cardboard mr-3"></i>
                                VR Контент
                                <i class="fas fa-chevron-down ml-auto" :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="pl-11 space-y-2">
                                <a href="#" class="mobile-sub-link">Бүх контент</a>
                                <a href="#" class="mobile-sub-link">Онцлох</a>
                                <a href="#" class="mobile-sub-link">Шинэ загварууд</a>
                                <a href="#" class="mobile-sub-link">Санал оруулах</a>
                            </div>
                        </div>

                        <!-- Other Mobile Links -->
                        <a href="#" class="mobile-nav-btn active">
                            <i class="fas fa-comments mr-3"></i>
                            Форум
                        </a>
                        <a href="#" class="mobile-nav-btn">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Календарь
                        </a>
                        <a href="#" class="mobile-nav-btn">
                            <i class="fas fa-map-marked-alt mr-3"></i>
                            Газрын зураг
                        </a>
                        <a href="#" class="mobile-nav-btn">
                            <i class="fas fa-tags mr-3"></i>
                            Ангилал
                        </a>
                        <a href="#" class="mobile-nav-btn">
                            <i class="fas fa-info-circle mr-3"></i>
                            Бидний тухай
                        </a>
                        <a href="#" class="mobile-nav-btn">
                            <i class="fas fa-phone-alt mr-3"></i>
                            Холбоо барих
                        </a>
                    </div>

                    <!-- Mobile Auth Section -->
                    <div class="pt-4 border-t border-white/10">
                        <a href="#" class="mobile-nav-btn">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Самбар
                        </a>
                        <a href="#" class="mobile-nav-btn">
                            <i class="fas fa-user-cog mr-3"></i>
                            Профайл
                        </a>
                        <form method="POST" action="#">
                            <button type="submit" class="mobile-nav-btn text-red-500 w-full text-left">
                                <i class="fas fa-sign-out-alt mr-3"></i>
                                Гарах
                            </button>
                        </form>

                        <!-- If not logged in
                        <div class="grid gap-2">
                            <a href="#" class="mobile-nav-btn bg-white/10">
                                Нэвтрэх
                            </a>
                            <a href="#" class="mobile-nav-btn bg-primary text-white">
                                Бүртгүүлэх
                            </a>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </nav>
    </header>

</head>
<body>
    <div id="map-container">
  <div id="sidebar">
    <h2>Эрүүл мэндийн байгууллагууд</h2>
    <div class="controls">
      <label>
        <input type="checkbox" id="show-hospitals" checked>
        Эмнэлгүүдийг харуулах
      </label><br>
      <label>
        <input type="checkbox" id="show-pharmacies" checked>
        Эмийн санг харуулах
      </label><br>
      <input type="text" id="search-address" placeholder="Байршил эсвэл хаяг оруулна уу">
      <button id="search-button" class="button">Хайх</button>
      <button id="use-my-location" class="button">Миний байршлыг ашиглах</button>
    </div>
    <div class="place-list" id="place-list">
      <!-- Газрууд энд жагсах болно -->
    </div>
  </div>
  <div id="map"></div>
</div>
<div class="loading" id="loading">Ачааллаж байна...</div>


    <!-- Leaflet JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script>
        let map;
        let markers = [];
        let userMarker;
        let currentLocation = [40.7128, -74.0060]; // Default to New York

        // Custom icons
        const hospitalIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            shadowSize: [41, 41],
            shadowAnchor: [12, 41]
        });

        const pharmacyIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            shadowSize: [41, 41],
            shadowAnchor: [12, 41]
        });

        const nearestIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
            iconSize: [30, 49], // Slightly larger to indicate nearest
            iconAnchor: [15, 49],
            popupAnchor: [1, -34],
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            shadowSize: [41, 41],
            shadowAnchor: [12, 41]
        });

        // Initialize the map
        function initMap() {
            map = L.map('map').setView(currentLocation, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Set up event listeners
            document.getElementById("use-my-location").addEventListener("click", getUserLocation);
            document.getElementById("search-button").addEventListener("click", searchLocation);
            document.getElementById("search-address").addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    searchLocation();
                }
            });
            document.getElementById("show-hospitals").addEventListener("change", filterPlaces);
            document.getElementById("show-pharmacies").addEventListener("change", filterPlaces);

            // Try to get user's location right away
            getUserLocation();
        }

        // Calculate distance between two points
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the earth in km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            const d = R * c; // Distance in km
            return d;
        }

        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }

        // Format distance for display
        function formatDistance(distance) {
            if (distance < 1) {
                return (distance * 1000).toFixed(0) + " meters";
            } else {
                return distance.toFixed(2) + " km";
            }
        }

        // Function to get user's location with high accuracy
        function getUserLocation() {
            document.getElementById("loading").style.display = "block";

            if (navigator.geolocation) {
                const options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                };

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        currentLocation = [position.coords.latitude, position.coords.longitude];

                        // Update view to user location with close zoom
                        map.setView(currentLocation, 15);

                        // If user marker exists, remove it
                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }

                        // Add a marker for the user's location
                        userMarker = L.circleMarker(currentLocation, {
                            radius: 10,
                            fillColor: "#4285F4",
                            color: "#FFFFFF",
                            weight: 3,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map).bindPopup("<strong>Your Location</strong>").openPopup();

                        // Search for nearby places
                        searchNearbyPlaces();
                    },
                    (error) => {
                        document.getElementById("loading").style.display = "none";
                        console.error("Geolocation error:", error);
                        alert("Could not get your location. Please enable location services or search for a location manually.");
                        // Use default location
                        searchNearbyPlaces();
                    },
                    options
                );
            } else {
                document.getElementById("loading").style.display = "none";
                alert("Geolocation is not supported by this browser.");
                // Use default location
                searchNearbyPlaces();
            }
        }

        // Function to search for a location
        function searchLocation() {
            const address = document.getElementById("search-address").value;
            if (!address) return;

            document.getElementById("loading").style.display = "block";

            // Use Nominatim API for geocoding (free)
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        currentLocation = [parseFloat(data[0].lat), parseFloat(data[0].lon)];
                        map.setView(currentLocation, 15);

                        // If user marker exists, remove it
                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }

                        // Add a marker for the searched location
                        userMarker = L.circleMarker(currentLocation, {
                            radius: 10,
                            fillColor: "#4285F4",
                            color: "#FFFFFF",
                            weight: 3,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map).bindPopup("<strong>Searched Location</strong>").openPopup();

                        // Search for nearby places
                        searchNearbyPlaces();
                    } else {
                        document.getElementById("loading").style.display = "none";
                        alert("Location not found. Please try a different search.");
                    }
                })
                .catch(error => {
                    document.getElementById("loading").style.display = "none";
                    console.error("Error searching for location:", error);
                    alert("Error searching for location. Please try again.");
                });
        }

        // Function to search for nearby places
        function searchNearbyPlaces() {
            clearMarkers();

            const showHospitals = document.getElementById("show-hospitals").checked;
            const showPharmacies = document.getElementById("show-pharmacies").checked;

            // Use Overpass API (free) to search for hospitals and pharmacies
            // Increase search radius to 10km (10000 meters)
            const overpassQuery = `
                [out:json];
                (
                    ${showHospitals ? `node["amenity"="hospital"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    way["amenity"="hospital"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    relation["amenity"="hospital"](around:10000,${currentLocation[0]},${currentLocation[1]});` : ''}

                    ${showPharmacies ? `node["amenity"="pharmacy"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    way["amenity"="pharmacy"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    relation["amenity"="pharmacy"](around:10000,${currentLocation[0]},${currentLocation[1]});` : ''}
                );
                out body;
                >;
                out skel qt;
            `;

            const overpassUrl = `https://overpass-api.de/api/interpreter?data=${encodeURIComponent(overpassQuery)}`;

            fetch(overpassUrl)
                .then(response => response.json())
                .then(data => {
                    if (data && data.elements) {
                        let nearestHospitalDistance = Infinity;
                        let nearestPharmacyDistance = Infinity;
                        let nearestHospitalMarker = null;
                        let nearestPharmacyMarker = null;

                        data.elements.forEach(element => {
                            if (element.type === "node" && element.tags) {
                                const distance = calculateDistance(
                                    currentLocation[0],
                                    currentLocation[1],
                                    element.lat,
                                    element.lon
                                );

                                if (element.tags.amenity === "hospital" && showHospitals) {
                                    const marker = createMarker(element, "hospital", distance);

                                    if (distance < nearestHospitalDistance) {
                                        nearestHospitalDistance = distance;
                                        nearestHospitalMarker = marker;
                                    }
                                } else if (element.tags.amenity === "pharmacy" && showPharmacies) {
                                    const marker = createMarker(element, "pharmacy", distance);

                                    if (distance < nearestPharmacyDistance) {
                                        nearestPharmacyDistance = distance;
                                        nearestPharmacyMarker = marker;
                                    }
                                }
                            }
                        });

                        // Highlight nearest facilities
                        if (nearestHospitalMarker) {
                            nearestHospitalMarker.setIcon(nearestIcon);
                            nearestHospitalMarker.isNearest = true;
                        }

                        if (nearestPharmacyMarker) {
                            nearestPharmacyMarker.setIcon(nearestIcon);
                            nearestPharmacyMarker.isNearest = true;
                        }

                        updatePlacesList();
                    }
                    document.getElementById("loading").style.display = "none";
                })
                .catch(error => {
                    document.getElementById("loading").style.display = "none";
                    console.error("Error fetching places:", error);
                    alert("Error fetching places. Please try again.");
                });
        }

        // Function to create a marker for a place
        function createMarker(place, type, distance) {
            const placeLatLon = [place.lat, place.lon];
            const marker = L.marker(placeLatLon, {
                icon: type === "hospital" ? hospitalIcon : pharmacyIcon
            }).addTo(map);

            const name = place.tags.name || (type === "hospital" ? "Hospital" : "Pharmacy");
            const address = [
                place.tags["addr:street"],
                place.tags["addr:housenumber"],
                place.tags["addr:city"],
                place.tags["addr:postcode"]
            ].filter(Boolean).join(", ");

            marker.bindPopup(`
                <div>
                    <h3>${name}</h3>
                    <p>${address || "No address available"}</p>
                    <p>Type: ${type.charAt(0).toUpperCase() + type.slice(1)}</p>
                    <p>Distance: ${formatDistance(distance)}</p>
                </div>
            `);

            marker.placeType = type;
            marker.placeData = {
                name: name,
                address: address,
                lat: place.lat,
                lon: place.lon,
                distance: distance
            };

            markers.push(marker);
            return marker;
        }

        // Function to clear all markers
        function clearMarkers() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            document.getElementById("place-list").innerHTML = "";
        }

        // Function to filter places
        function filterPlaces() {
            searchNearbyPlaces();
        }

        // Function to update the places list
        function updatePlacesList() {
            const showHospitals = document.getElementById("show-hospitals").checked;
            const showPharmacies = document.getElementById("show-pharmacies").checked;
            const placesList = document.getElementById("place-list");

            placesList.innerHTML = "";

            const visibleMarkers = markers.filter(marker =>
                (marker.placeType === "hospital" && showHospitals) ||
                (marker.placeType === "pharmacy" && showPharmacies)
            );

            // Sort by distance
            visibleMarkers.sort((a, b) => {
                return a.placeData.distance - b.placeData.distance;
            });

            visibleMarkers.forEach(marker => {
                const place = marker.placeData;
                const div = document.createElement("div");
                div.className = marker.isNearest ? "place-item nearest" : "place-item";
                div.innerHTML = `
                    <div class="place-name">${place.name}</div>
                    <div class="place-address">${place.address || "No address available"}</div>
                    <div class="place-distance">Distance: ${formatDistance(place.distance)}</div>
                    <div class="place-type ${marker.placeType}">${marker.placeType.charAt(0).toUpperCase() + marker.placeType.slice(1)}</div>
                `;
                div.addEventListener("click", () => {
                    map.setView([place.lat, place.lon], 16);
                    marker.openPopup();
                });
                placesList.appendChild(div);
            });
        }

        // Initialize the map when the page loads
        window.onload = initMap;
    </script>
</body>
</html>
