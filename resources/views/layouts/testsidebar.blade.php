{{-- <!-- resources/views/components/sidebar.blade.php -->
<div class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h3>Эрүүл мэндийн нийтлэг сорилууд</h3>
    </div>

    <!-- Mental Health Screenings -->
    <div class="sidebar-links">
        <h5>Сэтгэцийн эрүүл мэндийн үзлэг</h5>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link">Сэтгэл түгших: GAD-2</a>
        <a href="{{ route('gad7.index') }}" class="sidebar-link">Сэтгэл түгших: GAD-7</a>
        <a href="{{ route('phq9.index') }}" class="sidebar-link">Сэтгэлийн хямрал: PHQ-9</a>
        <a href="{{ route('ptsd-test.index') }}" class="sidebar-link">PTSD: PC-PTSD-5</a>
        <a href="{{ route('adhd.test') }}" class="sidebar-link">ADHD Cорил</a>
        <a href="{{ route('dass21.index') }}" class="sidebar-link">DASS-21 Depression, Anxiety, Stress</a>
        <a href="{{ route('ess.index') }}" class="sidebar-link">DASS-21 Depression, Anxiety, Stress</a>

    </div>

    <!-- Substance Use Screening -->
    <div class="sidebar-links">
        <h5>Бодисын хэрэглээний скрининг</h5>
        <a href="{{ route('auditc.index') }}" class="sidebar-link">Архи: AUDIT-C</a>
        <a href="{{ route('mental-health.cage') }}" class="sidebar-link">Архи: CAGE</a>
        <a href="{{ route('mental-health.cage') }}" class="sidebar-link">CAGE-AID</a>
        <a href="{{ route('mental-health.cage') }}" class="sidebar-link">Эмний хэрэглээ</a>
    </div>

    <!-- Clinical Calculators -->
    <div class="sidebar-links">
        <h5>Physical тооцоолуур</h5>
        <a href="{{ route('parq.index') }}" class="sidebar-link">PAR-Q Биеийн үйл ажиллагаа</a>
        <a href="{{ route('ipaq.index') }}" class="sidebar-link">IPAQ Олон улсын биеийн тамирын асуулга</a>

        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link">APRI тооцоолуур</a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link">BMI тооцоолуур</a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link">CrCl тооцоолуур</a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link">CTP тооцоолуур</a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link">FIB-4 тооцоолуур</a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link">FEPO4 тооцоолуур</a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link">GFR тооцоолуур</a>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="#">Тусламж</a> | <a href="#">Тохиргоо</a>
    </div>
</div> --}}


<!-- resources/views/components/sidebar.blade.php -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar" id="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h3>Эрүүл мэндийн нийтлэг сорилууд</h3>
    </div>

    <!-- Mental Health Screenings -->
    <div class="sidebar-category">
        <h5>Сэтгэцийн эрүүл мэндийн үзлэг</h5>
    </div>
    <div class="sidebar-links">
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link {{ request()->routeIs('mental-health.gad2') ? 'active' : '' }}">
            <i class="fas fa-brain"></i> Сэтгэл түгших: GAD-2
        </a>
        <a href="{{ route('gad7.index') }}" class="sidebar-link {{ request()->routeIs('gad7.index') ? 'active' : '' }}">
            <i class="fas fa-brain"></i> Сэтгэл түгших: GAD-7
        </a>
        <a href="{{ route('phq9.index') }}" class="sidebar-link {{ request()->routeIs('phq9.index') ? 'active' : '' }}">
            <i class="fas fa-heart-broken"></i> Сэтгэлийн хямрал: PHQ-9
        </a>
        <a href="{{ route('ptsd-test.index') }}" class="sidebar-link {{ request()->routeIs('ptsd-test.index') ? 'active' : '' }}">
            <i class="fas fa-exclamation-circle"></i> PTSD: PC-PTSD-5
        </a>
        <a href="{{ route('adhd.test') }}" class="sidebar-link {{ request()->routeIs('adhd.test') ? 'active' : '' }}">
            <i class="fas fa-bolt"></i> ADHD Cорил
        </a>
        <a href="{{ route('dass21.index') }}" class="sidebar-link {{ request()->routeIs('dass21.index') ? 'active' : '' }}">
            <i class="fas fa-balance-scale"></i> DASS-21 Depression, Anxiety, Stress
        </a>
        <a href="{{ route('ess.index') }}" class="sidebar-link {{ request()->routeIs('ess.index') ? 'active' : '' }}">
            <i class="fas fa-moon"></i> Эпворт нойрмоглох шкала
        </a>
    </div>

    <!-- Substance Use Screening -->
    <div class="sidebar-category">
        <h5>Бодисын хэрэглээний скрининг</h5>
    </div>
    <div class="sidebar-links">
        <a href="{{ route('auditc.index') }}" class="sidebar-link {{ request()->routeIs('auditc.index') ? 'active' : '' }}">
            <i class="fas fa-wine-glass-alt"></i> Архи: AUDIT-C
        </a>
        <a href="{{ route('mental-health.cage') }}" class="sidebar-link {{ request()->routeIs('mental-health.cage') ? 'active' : '' }}">
            <i class="fas fa-wine-bottle"></i> Архи: CAGE
        </a>
        <a href="{{ route('mental-health.cage') }}" class="sidebar-link {{ request()->routeIs('mental-health.cage-aid') ? 'active' : '' }}">
            <i class="fas fa-pills"></i> CAGE-AID
        </a>
        <a href="{{ route('mental-health.cage') }}" class="sidebar-link {{ request()->routeIs('medication-use') ? 'active' : '' }}">
            <i class="fas fa-prescription-bottle-alt"></i> Эмний хэрэглээ
        </a>
    </div>

    <!-- Clinical Calculators -->
    <div class="sidebar-category">
        <h5>Physical тооцоолуур</h5>
    </div>
    <div class="sidebar-links">
        <a href="{{ route('parq.index') }}" class="sidebar-link {{ request()->routeIs('parq.index') ? 'active' : '' }}">
            <i class="fas fa-running"></i> PAR-Q Биеийн үйл ажиллагаа
        </a>
        <a href="{{ route('ipaq.index') }}" class="sidebar-link {{ request()->routeIs('ipaq.index') ? 'active' : '' }}">
            <i class="fas fa-walking"></i> IPAQ Олон улсын биеийн тамирын асуулга
        </a>
        <a href="{{ route('ipaq.index') }}" class="sidebar-link {{ request()->routeIs('apri.index') ? 'active' : '' }}">
            <i class="fas fa-calculator"></i> APRI тооцоолуур
        </a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link {{ request()->routeIs('bmi.index') ? 'active' : '' }}">
            <i class="fas fa-weight"></i> BMI тооцоолуур
        </a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link {{ request()->routeIs('crcl.index') ? 'active' : '' }}">
            <i class="fas fa-kidneys"></i> CrCl тооцоолуур
        </a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link {{ request()->routeIs('ctp.index') ? 'active' : '' }}">
            <i class="fas fa-calculator"></i> CTP тооцоолуур
        </a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link {{ request()->routeIs('fib4.index') ? 'active' : '' }}">
            <i class="fas fa-liver"></i> FIB-4 тооцоолуур
        </a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link {{ request()->routeIs('fepo4.index') ? 'active' : '' }}">
            <i class="fas fa-vial"></i> FEPO4 тооцоолуур
        </a>
        <a href="{{ route('mental-health.gad2') }}" class="sidebar-link {{ request()->routeIs('gfr.index') ? 'active' : '' }}">
            <i class="fas fa-heartbeat"></i> GFR тооцоолуур
        </a>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="#"><i class="fas fa-question-circle"></i> Тусламж</a>
        <a href="#"><i class="fas fa-cog"></i> Тохиргоо</a>
    </div>
</div>

<script>
    // Toggle sidebar on mobile
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('show');
    });

    // Hide sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        if (window.innerWidth <= 992) {
            if (!sidebar.contains(event.target) && event.target !== sidebarToggle && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Adjust sidebar visibility on window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth > 992) {
            sidebar.classList.remove('show');
        }
    });
</script>
