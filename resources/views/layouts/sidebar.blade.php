{{-- <!-- resources/views/admin/partials/sidebar.blade.php -->
<nav class="bg-dark text-white vh-100 sidebar" style="width: 250px;">
    <div class="p-3">
        <h4>Админ панел</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link text-white">
                    <i class="fas fa-home"></i> Хянах самбар
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vr.index') }}"
                   class="nav-link text-white active">
                    <i class="fas fa-vr-cardboard"></i> VR Контент
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('categories.index') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> VR Төрөл
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.diseases.index') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> Өвчний мэдээлэл
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vr.map') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> Газрын зураг
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('events.index') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> Үйл явдлууд
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vr.admin.suggestions') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> 3D content -ийн санал
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.topics.index') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> Q&A Гарчиг
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.professionals.index') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> Эмчээр бүртгүүлэх хүсэлтүүд
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.user') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> Хэрэглэгч
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/professionalsReport"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> Мэргэжилтэн
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('events.calendarReport') }}"
                   class="nav-link text-white">
                    <i class="fas fa-heartbeat"></i> Үйл явдлуудын тайлан
                </a>
            </li>
        </ul>
    </div>
</nav> --}}
<!-- resources/views/admin/partials/sidebar.blade.php -->
<nav class="sidebar bg-dark d-flex flex-column vh-100 shadow-lg" style="width: 280px;">
    <!-- Header with logo -->
    <div class="sidebar-header p-4 border-bottom border-secondary">
        <h4 class="d-flex align-items-center mb-0">
            <i class="fas fa-shield-alt me-2"></i>
            <span>Админ панел</span>
        </h4>
    </div>

    <!-- Navigation items -->
    <div class="sidebar-content flex-grow-1 py-2 overflow-auto">
        <ul class="nav flex-column px-3">
            <!-- Dashboard -->
            <li class="nav-item my-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('admin.dashboard') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    <span>Хянах самбар</span>
                </a>
            </li>

            <!-- VR Content Section -->

            <li class="nav-item my-1">
                <a href="{{ route('vr.index') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('vr.index') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-vr-cardboard me-3"></i>
                    <span>VR Контент</span>
                </a>
            </li>
            <li class="nav-item my-1">
                <a href="{{ route('categories.index') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('categories.index') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-layer-group me-3"></i>
                    <span>VR Төрөл</span>
                </a>
            </li>
            <li class="nav-item my-1">
                <a href="{{ route('vr.map') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('vr.map') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-map-marked-alt me-3"></i>
                    <span>Газрын зураг</span>
                </a>
            </li>
            <li class="nav-item my-1">
                <a href="{{ route('vr.admin.suggestions') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('vr.admin.suggestions') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-lightbulb me-3"></i>
                    <span>3D content -ийн санал</span>
                </a>
            </li>

            <!-- Health Section -->
            {{-- <li class="nav-section my-3">
                <h6 class="text-uppercase text-muted ms-3 mb-2 small fw-bold"><span>Health Info</span></h6>
            </li> --}}
            <li class="nav-item my-1">
                <a href="{{ route('admin.diseases.index') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('admin.diseases.index') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-viruses me-3"></i>
                    <span>Өвчний мэдээлэл</span>
                </a>
            </li>
            <li class="nav-item my-1">
                <a href="{{ route('admin.topics.index') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('admin.topics.index') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-question-circle me-3"></i>
                    <span>Q&A Гарчиг</span>
                </a>
            </li>

            <!-- Events & Users Section -->

            <li class="nav-item my-1">
                <a href="{{ route('events.index') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('events.index') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-calendar-alt me-3"></i>
                    <span>Үйл явдлууд</span>
                </a>
            </li>
            <li class="nav-item my-1">
                <a href="{{ route('admin.professionals.index') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('admin.professionals.index') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-user-md me-3"></i>
                    <span>Эмчээр бүртгүүлэх хүсэлтүүд</span>
                </a>
            </li>
            <li class="nav-item my-1">
                <a href="{{ route('admin.user') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('admin.user') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-users me-3"></i>
                    <span>Хэрэглэгч</span>
                </a>
            </li>
            <li class="nav-item my-1">
                <a href="/admin/professionalsReport"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::url() == url('/admin/professionalsReport') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-user-tie me-3"></i>
                    <span>Мэргэжилтэн</span>
                </a>
            </li>

            <!-- Reports Section -->

            <li class="nav-item my-1">
                <a href="{{ route('events.calendarReport') }}"
                   class="nav-link rounded text-white d-flex align-items-center py-2 px-3 {{ Request::routeIs('events.calendarReport') ? 'active bg-primary' : 'hover-effect' }}">
                    <i class="fas fa-chart-line me-3"></i>
                    <span>Үйл явдлуудын тайлан</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- User profile section -->
<!-- User profile section -->
<div class="sidebar-footer border-top border-secondary p-3">
    <div class="d-flex align-items-center">
        <!-- Avatar -->
        <div class="avatar bg-light rounded-circle d-flex align-items-center justify-content-center"
             style="width: 40px; height: 40px;">
            <i class="fas fa-user text-secondary"></i>
        </div>

        <!-- User Info -->
        <div class="ms-3 flex-grow-1">
            <!-- Name and Logout -->
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-white small">{{ Auth::user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-link text-white p-0"
                            title="Системээс гарах"
                            aria-label="Logout">
                        <i class="fas fa-sign-out-alt small"></i>
                    </button>
                </form>
            </div>

            <!-- Email -->
            <div class="text-white-50 small mt-1">
                {{ Auth::user()->email }}
            </div>
        </div>
    </div>
</div>
</nav>

<!-- Add these styles to your CSS file -->
<style>
    .sidebar {
        transition: all 0.3s;
    }

    .hover-effect:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .nav-link.active {
        font-weight: 500;
    }

    .sidebar-content {
        scrollbar-width: thin;
        scrollbar-color: #6c757d #343a40;
    }

    .sidebar-content::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar-content::-webkit-scrollbar-track {
        background: #343a40;
    }

    .sidebar-content::-webkit-scrollbar-thumb {
        background-color: #6c757d;
        border-radius: 10px;
    }

    .nav-section {
        position: relative;
    }

    .nav-section h6 {
        position: relative;
        z-index: 1;
    }

    .nav-section h6 span {
        background-color: #bec0c2;
        padding: 0 8px;
    }

    .nav-section:after {
        content: '';
        height: 1px;
        background-color: rgba(108, 117, 125, 0.5);
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        z-index: 0;
    }

.sidebar-footer .btn-link {
    transition: opacity 0.2s;
}

.sidebar-footer .btn-link:hover {
    opacity: 0.8;
    color: #fff !important;
}

</style>
