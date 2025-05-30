<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Эрүүл Мэндийн VR Контент')</title>
    <meta name="description" content="Эрүүл мэндийн салбарт зориулсан хамгийн чанартай VR загварууд">

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

    <style>
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
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-gradient-to-r from-primary to-secondary text-white shadow-md">
        <div class="container mx-auto px-4">
            <nav class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold">HealthVR</a>

                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('test.home') }}" class="hover:text-white/80">Нүүр</a>
                    <a href="{{ route('vr-content.featured') }}" class="hover:text-white/80">Онцлох</a>
                    <a href="{{ route('vr-content.new') }}" class="hover:text-white/80">Шинэ загварууд</a>
                    <a href="{{ route('about') }}" class="hover:text-white/80">Тухай</a>
                    <a href="{{ route('contact') }}" class="hover:text-white/80">Холбоо барих</a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-2xl">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </nav>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden py-4 md:hidden">
                <a href="{{ route('home') }}" class="block py-2">Нүүр</a>
                <a href="{{ route('vr-content.featured') }}" class="block py-2">Онцлох</a>
                <a href="{{ route('vr-content.new') }}" class="block py-2">Шинэ загварууд</a>
                <a href="{{ route('about') }}" class="block py-2">Тухай</a>
                <a href="{{ route('contact') }}" class="block py-2">Холбоо барих</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 relative inline-block">
                        HealthVR
                        <span class="absolute bottom-[-8px] left-0 w-1/2 h-[2px] bg-accent"></span>
                    </h3>
                    <p class="text-gray-400 mb-4">Бид эрүүл мэндийн салбарт хэрэглэгддэг 3D VR загваруудыг нэгтгэн хүргэж байна. Оюутан, багш, эмч нар, эрүүл мэндийн мэргэжилтнүүдэд зориулагдсан.</p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4 relative inline-block">
                        Ангилал
                        <span class="absolute bottom-[-8px] left-0 w-1/2 h-[2px] bg-accent"></span>
                    </h3>
                    <div class="space-y-2">
                        @foreach(\App\Models\Category::take(5)->get() as $footerCategory)
                            <a href="{{ route('vr-content.category', $footerCategory->slug) }}" class="block text-gray-400 hover:text-white">{{ $footerCategory->name }}</a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4 relative inline-block">
                        Холбоосууд
                        <span class="absolute bottom-[-8px] left-0 w-1/2 h-[2px] bg-accent"></span>
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="block text-gray-400 hover:text-white">Нүүр</a>
                        <a href="{{ route('vr-content.featured') }}" class="block text-gray-400 hover:text-white">Онцлох</a>
                        <a href="{{ route('vr-content.new') }}" class="block text-gray-400 hover:text-white">Шинэ загварууд</a>
                        <a href="{{ route('about') }}" class="block text-gray-400 hover:text-white">Тухай</a>
                        <a href="{{ route('contact') }}" class="block text-gray-400 hover:text-white">Холбоо барих</a>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4 relative inline-block">
                        Холбоо барих
                        <span class="absolute bottom-[-8px] left-0 w-1/2 h-[2px] bg-accent"></span>
                    </h3>
                    <div class="space-y-2">
                        <a href="mailto:info@healthvr.mn" class="block text-gray-400 hover:text-white">
                            <i class="fas fa-envelope mr-2"></i> info@healthvr.mn
                        </a>
                        <a href="tel:+97699112233" class="block text-gray-400 hover:text-white">
                            <i class="fas fa-phone mr-2"></i> +976 99112233
                        </a>
                        <p class="text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i> Улаанбаатар хот
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} HealthVR - Эрүүл мэндийн VR агуулга. Бүх эрх хуулиар хамгаалагдсан.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
