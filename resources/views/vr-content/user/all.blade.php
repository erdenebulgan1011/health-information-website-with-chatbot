@extends('vr-content.user.vsapp')

@section('title', 'Шинэ VR Загварууд')

@section('content')
    <section class="relative bg-blue-600 text-white py-24">
        <div class="absolute inset-0 bg-[url('/images/vr-hero.jpg')] bg-cover bg-center opacity-30"></div>
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
                @if($contentType === 'featured')
                    Онцлох VR Загварууд
                @else
                    Шинэ VR Загварууд
                @endif
            </h1>
            <p class="text-lg md:text-xl mb-8">
                @if($contentType === 'featured')
                    Эрүүл мэндийн салбарт тэргүүлэх хамгийн өндөр чанартай 3D загварууд
                @else
                    Саяхан нэмэгдсэн эрүүл мэндийн загварууд
                @endif
            </p>
            @auth
            <a href="{{ route('vr.createSuggest') }}?category={{ request('category') }}"
               class="inline-block bg-white text-blue-600 font-semibold px-8 py-3 rounded-full shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-1">
                Шинэ загвар санал болгох
            </a>
            @endauth
        </div>
    </section>
    <section class="featured-content">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
              <!-- Search Box -->
              <div class="flex-1">
                <!-- Search Form -->
                <form action="{{ route('vr-content.search') }}" method="GET" class="flex items-center bg-gray-50 rounded-full overflow-hidden shadow-inner">
                    <input
                        type="text"
                        name="query"
                        placeholder="Хайлт хийх..."
                        class="flex-grow px-4 py-2 focus:outline-none bg-transparent"
                        value="{{ request('query') }}"
                        style="font-family: 'Mongolian Baiti', Arial, sans-serif;"
                        lang="mn"
                    >
                        <!-- Pass the current content type as a hidden field -->
    <input type="hidden" name="source" value="{{ $contentType }}">

                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    <button type="submit" class="px-4">
                        <i class="fas fa-search text-gray-500"></i>
                    </button>
                </form>
              </div>

              <!-- Filters -->
              <form action="{{ $contentType === 'featured' ? route('vr-content.featured') : route('vr-content.new') }}" method="GET" id="filter-form" class="flex flex-wrap gap-4">
                  @if(request('query'))
                      <input type="hidden" name="query" value="{{ request('query') }}">
                  @endif
                <div class="flex flex-col">
                  <label for="category" class="text-sm font-medium text-gray-700">Ангилал</label>
                  <select
                    name="category"
                    id="category"
                    onchange="document.getElementById('filter-form').submit()"
                    class="mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                  >
                    <option value="">Бүх ангилал</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="flex flex-col">
                  <label for="sort" class="text-sm font-medium text-gray-700">Эрэмбэлэх</label>
                  <select
                    name="sort"
                    id="sort"
                    onchange="document.getElementById('filter-form').submit()"
                    class="mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                  >
                    <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Шинээс хуучин руу</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Хуучнаас шинэ рүү</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Нэрээр (А-Я)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Нэрээр (Я-А)</option>
                  </select>
                </div>

                @if(request('category') || request('sort'))
                  <div class="flex items-end">
                    <a href="{{ $contentType === 'featured' ? route('vr-content.featured') : route('vr-content.new') }}" class="text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                      Шүүлтүүр арилгах
                    </a>
                  </div>
                @endif
              </form>
            </div>

        @if($contents->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-8">
          @foreach($contents as $content)
            <div class="vr-card bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transform hover:-translate-y-1 transition">
              <div class="vr-image h-48 w-full overflow-hidden">
                <iframe class="w-full h-full" src="{{ $content->embed_url }}" loading="lazy"></iframe>
              </div>
              <div class="p-4 flex flex-col flex-grow">
                <h3 class="vr-title text-lg font-semibold mb-2 line-clamp-2">{{ $content->title }}</h3>
                <p class="vr-description text-sm text-gray-600 mb-4 line-clamp-3">{{ Str::limit($content->description, 100) }}</p>
                <div class="mt-auto flex items-center justify-between text-xs text-gray-500">
                  <span>{{ $content->category->name }}</span>
                  <span>{{ $content->created_at->format('Y-m-d') }}</span>
                </div>
                <a href="{{ route('vr-content.show', $content->id) }}"
                    class="btn btn-view mt-4 text-center bg-blue-500 text-white py-2 rounded-full hover:bg-blue-600 transition"
                    >
                  Дэлгэрэнгүй
                </a>
              </div>
            </div>
          @endforeach
        </div>

        <div class="pagination-container mt-10">
          {{ $contents->links('pagination::tailwind') }}
        </div>
        @else
          <div class="text-center py-16">
            <p class="text-lg text-gray-600">Загвар олдсонгүй</p>
          </div>
        @endif
      </div>
    </section>

    {{-- <style>
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
    </style> --}}
    @endsection
