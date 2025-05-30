@extends('vr-content.user.vsapp')

@section('title', 'Эрүүл Мэндийн VR Контент')

    <title>Эрүүл Мэндийн VR Контент</title>
    <style>
        :root {
            --primary: #3a86ff;
            /* --secondary: #4cc9f0; */
            --accent: #7209b7;
            --light: #f8f9fa;
            --dark: #1e1e24;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f0f2f5;
            color: var(--dark);
        }

        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/api/placeholder/1200/500') center/cover;
            color: white;
            min-height: 500px;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .hero-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .featured-section, .category-section {
            padding: 4rem 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .section-header h2 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background-color: var(--accent);
            bottom: -10px;
            left: 25%;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .featured-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .featured-card:hover {
            transform: translateY(-10px);
        }

        .card-image {
            height: 200px;
            background: var(--secondary);
            position: relative;
        }

        .card-image iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .card-content {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: #6c757d;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .card-category {
            display: inline-block;
            background-color: var(--light);
            font-size: 0.8rem;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            color: var(--primary);
        }

        .categories-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .category-card {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .category-name {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .category-count {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .vr-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .vr-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .vr-image {
            height: 160px;
            background: var(--secondary);
            position: relative;
        }

        .vr-content {
            padding: 1rem;
        }

        .vr-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        footer {
            background-color: var(--dark);
            color: white;
            padding: 3rem 0;
            margin-top: 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 2px;
            background-color: var(--accent);
            bottom: -8px;
            left: 0;
        }

        .footer-section p {
            margin-bottom: 1rem;
            color: #b3b3b3;
        }

        .footer-links a {
            display: block;
            color: #b3b3b3;
            text-decoration: none;
            margin-bottom: 0.8rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #b3b3b3;
        }

        @media (max-width: 992px) {
            .featured-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .categories-container {
                grid-template-columns: repeat(3, 1fr);
            }

            .vr-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .featured-grid {
                grid-template-columns: 1fr;
            }

            .categories-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .vr-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-content {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }
        }
        .hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 600px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%233498db' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .hero-split {
            display: flex;
            align-items: center;
            min-height: 600px;
            gap: 30px;
        }

        .hero-content {
            flex: 1;
            padding-right: 2rem;
            text-align: left;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
            background: linear-gradient(90deg, #ffffff 0%, #3498db 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 2px 10px rgba(52, 152, 219, 0.3);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            font-weight: 300;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(90deg, #3498db 0%, #2980b9 100%);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.6);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-100%);
            transition: transform 0.3s;
        }

        .btn:hover::after {
            transform: translateX(0);
        }

        .model-container {
            flex: 1;
            height: 500px;
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        #model-viewer {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #0a0a1a 0%, #0f0f2d 100%);
            border-radius: 10px;
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            border-top-color: #3498db;
            animation: spin 1s ease-in-out infinite;
            z-index: 2;
        }

        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .model-info {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            z-index: 3;
        }

        .controls-info {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            z-index: 3;
        }

        @media (max-width: 768px) {
            .hero-split {
                flex-direction: column;
            }

            .hero-content {
                text-align: center;
                padding-right: 0;
                padding-bottom: 2rem;
            }

            .model-container {
                width: 100%;
                max-height: 400px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }
    </style>

</head>
@section('content')

<body>


    {{-- <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Эрүүл мэндийн 3D VR агуулгад тавтай морил</h1>
                <p>Эрүүл мэндийн салбарт зориулсан хамгийн чанартай, хамгийн орчин үеийн VR загваруудыг нэг дороос үзээрэй.</p>
                <a href="#" class="btn">Загварууд үзэх</a>
            </div>
        </div>
    </section> --}}
    <section class="hero">
        <div class="container">
            <div class="hero-split">
                <!-- Left side: Text content -->
                <div class="hero-content">
                    <h1>Эрүүл мэндийн 3D VR агуулгад тавтай морил</h1>
                    <p>Эрүүл мэндийн салбарт зориулсан хамгийн чанартай, хамгийн орчин үеийн VR загваруудыг нэг дороос үзээрэй. Бидний 3D загварууд нь сургалт, судалгаа болон практик хэрэглээнд зориулагдсан.</p>
                    {{-- <a href="#" class="btn">Загварууд үзэх</a> --}}
                </div>

                <!-- Right side: 3D Model -->
                {{-- <div class="model-container">
                    <div id="model-viewer"></div>
                    <div class="loading-spinner" id="loading-spinner"></div>
                    <div class="model-info" id="model-info">Загвар: Медикал VR</div>
                    <div class="controls-info">Эргүүлэх: Хулганы товчлуур барих</div>
                                        <img src="{{ asset('/storage/img/test.jpg') }}" alt="Эрүүл мэндийн зураг" class="relative w-full max-w-lg h-auto rounded-lg shadow-xl mx-auto transform hover:scale-105 transition duration-500">

                </div> --}}
                <div class="model-container" style="position: relative;">
                <!-- Image absolutely positioned to fill container -->
                <img
                    src="{{ asset('/storage/img/vrimages.jpg') }}"
                    alt="Эрүүл мэндийн зураг"
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);"
                    class="transform hover:scale-105 transition duration-500"
                >
                <div class="model-info" id="model-info" style="position: absolute; bottom: 10px; left: 10px; z-index: 10;">Зураг: Эрүүл мэндийн зураг</div>
            </div>
            </div>
        </div>
    </section>



    <section class="featured-section">
        <div class="container">
            <div class="section-header">
                <a href="{{ route('vr-content.featured') }}" class="section-header-link">
                    <h2>Онцлох VR загварууд</h2>
                </a>
                    <p>Эрүүл мэндийн салбарт тэргүүлэх хамгийн өндөр чанартай 3D загварууд</p>
            </div>

            <div class="featured-grid">
                @foreach($featuredContent as $content)
                <div class="featured-card">
                    <div class="card-image">
                        <iframe src="{{ $content->embed_url }}"></iframe>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $content->title }}</h3>
                        <p class="card-description">{{ $content->description }}</p>
                        <span class="card-category">{{ $content->category->name }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="category-section">
        <div class="container">
            <div class="section-header">
                <a href="{{ route('category.index') }}" class="section-header-link">
                    <h2>Ангилал</h2>
                </a>
                    <p>Эрүүл мэндийн VR загварууд төрөл бүрээр</p>
            </div>

            <div class="categories-container">
            @foreach($categories as $category)
    <a href="{{ route('vr-content.category', $category->slug) }}" class="category-card">
        <div class="category-icon">
            {{ $category->icon }}
        </div>
        <h3 class="category-name">{{ $category->name }}</h3>
        <p class="category-count">{{ $category->vr_contents_count }} загвар</p>
    </a>
    @endforeach
            </div>
        </div>
    </section>

    <section class="category-section">
        <div class="container">
            <div class="section-header">
                <a href="{{ route('vr-content.new') }}" class="section-header-link">
                    <h2>Шинэ загварууд</h2>
                </a>
                    <p>Саяхан нэмэгдсэн эрүүл мэндийн загварууд</p>
            </div>

            <div class="vr-grid">
                @foreach($newContent as $content)
                <div class="vr-card">
                    <div class="vr-image">
                        <iframe src="{{ $content->embed_url }}"></iframe>
                    </div>
                    <div class="vr-content">
                        <h3 class="vr-title">{{ $content->title }}</h3>
                        <span class="card-category">{{ $content->category->name }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- <!-- Keep your existing footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>HealthVR</h3>
                    <p>Бид эрүүл мэндийн салбарт хэрэглэгддэг 3D VR загваруудыг нэгтгэн хүргэж байна. Оюутан, багш, эмч нар, эрүүл мэндийн мэргэжилтнүүдэд зориулагдсан.</p>
                </div>

                <div class="footer-section">
                    <h3>Ангилал</h3>
                    <div class="footer-links">
                        <a href="#">Зүрх судасны систем</a>
                        <a href="#">Мэдрэлийн систем</a>
                        <a href="#">Яс булчингийн систем</a>
                        <a href="#">Амьсгалын систем</a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Холбоосууд</h3>
                    <div class="footer-links">
                        <a href="#">Нүүр</a>
                        <a href="#">Ангилал</a>
                        <a href="#">Шинэ загварууд</a>
                        <a href="#">Тухай</a>
                        <a href="#">Холбоо барих</a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Холбоо барих</h3>
                    <div class="footer-links">
                        <a href="#">info@healthvr.mn</a>
                        <a href="#">+976 99112233</a>
                        <a href="#">Улаанбаатар хот</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 HealthVR - Эрүүл мэндийн VR агуулга. Бүх эрх хуулиар хамгаалагдсан.</p>
            </div>
        </div>
    </footer> --}}
<!-- First load libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.134.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.134.0/examples/js/loaders/GLTFLoader.js"></script>
<!-- Then your 3D viewer script -->
<script src="{{ asset('js/3d-viewer.js') }}"></script>
</body>
</html>
@endsection
