
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Health Information Center')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #1e88e5;
            --secondary-color: #005cb2;
            --accent-color: #43a047;
            --light-color: #f5f5f5;
            --text-color: #333;
            --heading-color: #004d40;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            color: var(--text-color);
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Merriweather', serif;
            color: var(--heading-color);
        }

        .navbar {
            background: linear-gradient(to right, #1e88e5, #1565c0);
            padding: 0.8rem 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-family: 'Merriweather', serif;
            font-weight: 700;
            color: white;
            font-size: 1.5rem;
        }

        .navbar-brand i {
            color: #a5d6a7;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .navbar-nav .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 77, 64, 0.7), rgba(0, 77, 64, 0.7)), url('https://via.placeholder.com/1920x600');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .hero-section p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 1.5rem;
        }

        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 220px);
        }

        .page-title {
            color: var(--heading-color);
            margin-bottom: 1.5rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 0.8rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: rgba(30, 136, 229, 0.05);
            border-bottom: 1px solid rgba(30, 136, 229, 0.1);
            font-weight: 600;
            padding: 1rem 1.25rem;
        }

        .card-header h5 {
            margin: 0;
            color: var(--primary-color);
        }

        .card-body {
            padding: 1.25rem;
        }

        .alphabet-filter {
            margin: 1.5rem 0;
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
        }

        .alphabet-filter .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
            background-color: var(--light-color);
            color: var(--primary-color);
            border: none;
            transition: all 0.2s ease;
        }

        .alphabet-filter .btn:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .alphabet-filter .btn.active {
            background-color: var(--primary-color);
            color: white;
        }

        .alphabet-filter .btn-all {
            width: auto;
            padding: 0 12px;
            border-radius: 18px;
        }

        .disease-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .disease-list li {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s ease;
        }

        .disease-list li:last-child {
            border-bottom: none;
        }

        .disease-list li:hover {
            background-color: rgba(30, 136, 229, 0.05);
        }

        .disease-list li a {
            color: var(--text-color);
            text-decoration: none;
            display: block;
            font-weight: 500;
        }

        .disease-list li a:hover {
            color: var(--primary-color);
        }

        .disease-list li a i {
            color: var(--primary-color);
        }

        .disease-detail {
            background-color: white;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            padding: 0;
            overflow: hidden;
        }

        .disease-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            position: relative;
        }

        .disease-header h1 {
            color: white;
            margin: 0;
            font-size: 2rem;
        }

        .disease-header .back-btn {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .disease-header .back-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .search-bar {
            position: relative;
        }

        .search-bar .form-control {
            padding-left: 2.5rem;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            height: 46px;
        }

        .search-bar .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .search-bar .btn {
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
        }

        .footer {
            background-color: #263238;
            color: white;
            padding: 2rem 0 1rem;
        }

        .footer h5 {
            color: #a5d6a7;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer ul li {
            margin-bottom: 0.5rem;
        }

        .footer ul li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer ul li a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
            margin-top: 1rem;
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .language-selector {
            position: absolute;
            top: 12px;
            right: 15px;
            z-index: 1000;
        }

        /* Badge styling */
        .badge {
            font-weight: 600;
            padding: 0.35em 0.65em;
        }

        .badge-count {
            background-color: var(--accent-color);
            color: white;
        }

        /* Health icon styling */
        .health-icon {
            width: 48px;
            height: 48px;
            background-color: rgba(67, 160, 71, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--accent-color);
        }

        .health-icon i {
            font-size: 1.5rem;
        }

        /* CSS for disease information area */
        .info-header {
            background-color: rgba(30, 136, 229, 0.05);
            padding: 0.8rem 1.25rem;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }

        .info-header i {
            margin-right: 0.5rem;
        }

        .info-content {
            padding: 1.25rem;
            background-color: white;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }

        @media (max-width: 767px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .alphabet-filter {
                gap: 0.2rem;
            }

            .alphabet-filter .btn {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .hero-section {
                padding: 2rem 0;
            }

            .hero-section h1 {
                font-size: 1.8rem;
            }

            .disease-header h1 {
                font-size: 1.5rem;
            }

            .disease-header .back-btn {
                top: 1rem;
                right: 1rem;
            }
        }
    </style>
    @yield('custom-css')
</head>

    @yield('custom-css')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('diseases.index') }}">
                <i class="fas fa-heartbeat me-2"></i>Disease Information
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vr.index') }}">Home</a>
                    </li>
                    <!-- Add more navigation links as needed -->
                </ul>
            </div>
            <div id="google_translate_element" class="language-selector"></div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Disease Information. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Translate -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                {pageLanguage: 'en', includedLanguages: 'en,mn', autoDisplay: false},
                'google_translate_element'
            );
        }

        // Automatically switch to Mongolian
        function setLanguageToMongolian() {
            setTimeout(function() {
                var googleTranslate = document.querySelector('.goog-te-combo');
                if (googleTranslate) {
                    googleTranslate.value = 'mn';
                    googleTranslate.dispatchEvent(new Event('change'));
                }
            }, 2000); // Wait 2 seconds for Google Translate to load
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script>
        window.onload = function() {
            setLanguageToMongolian();
        };
    </script>

    @yield('scripts')
</body>
</html>
{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}
