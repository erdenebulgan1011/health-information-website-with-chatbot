{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Сайжруулсан Laravel Баталгаажуулалт</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-in {
            animation: slideIn 0.4s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .floating-label {
            transition: all 0.3s ease;
        }
        .input-container:focus-within .floating-label {
            transform: translateY(-24px) scale(0.85);
            color: #667eea;
        }
        .input-container input:not(:placeholder-shown) + .floating-label {
            transform: translateY(-24px) scale(0.85);
            color: #667eea;
        }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Main Container -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl fade-in">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-user-shield text-2xl text-indigo-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Тавтай морилно уу</h1>
                <p class="text-white/80 text-sm">Өөрийн бүртгэлээр нэвтэрнэ үү</p>
            </div>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Display Success Messages -->
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Tab Navigation -->
            <div class="flex mb-6 bg-black/20 rounded-lg p-1">
                <button id="loginTab" class="tab-btn flex-1 py-2 px-4 text-sm font-medium text-white rounded-md transition-all duration-300 bg-white/20">
                    Нэвтрэх
                </button>
                <button id="registerTab" class="tab-btn flex-1 py-2 px-4 text-sm font-medium text-white/70 rounded-md transition-all duration-300">
                    Бүртгүүлэх
                </button>
                <button id="resetTab" class="tab-btn flex-1 py-2 px-4 text-sm font-medium text-white/70 rounded-md transition-all duration-300">
                    Сэргээх
                </button>
            </div>

            <!-- Forms Container -->
            <div id="formsContainer" class="relative overflow-hidden">
                <!-- Login Form -->
                <form id="loginForm" class="form-panel" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="input-container relative mb-6">
                        <input
                            id="loginEmail"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-gray-500 transition-all duration-300"
                            placeholder="Имэйл"
                            required
                            autocomplete="username"
                            autofocus
                        >
                        <label for="loginEmail" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                            <i class="fas fa-envelope mr-2"></i>Имэйл хаяг
                        </label>
                        @error('email')
                            <div class="text-red-300 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="input-container relative mb-6">
                        <input
                            id="loginPassword"
                            type="password"
                            name="password"
    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-white/40 input-focus transition-all duration-300 @error('password') border-red-500 @enderror"
                            placeholder="Нууц үг"
                            required
                            autocomplete="current-password"
                        >
                        <label for="loginPassword" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                            <i class="fas fa-lock mr-2"></i>Нууц үг
                        </label>
                        <button type="button" class="absolute right-3 top-3 text-white/70 hover:text-white transition-colors" onclick="togglePassword('loginPassword')">
                            <i class="fas fa-eye" id="loginPasswordIcon"></i>
                        </button>
                        @error('password')
                            <div class="text-red-300 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="sr-only" {{ old('remember') ? 'checked' : '' }}>
                            <div class="relative">
                                <div class="checkbox-bg w-5 h-5 bg-white/20 border border-white/40 rounded transition-all duration-300"></div>
                                <div class="checkbox-check absolute inset-0 flex items-center justify-center text-white text-xs opacity-0 transition-opacity duration-300">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <span class="ml-3 text-white/80 text-sm">Намайг санаж үлдээх</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-white/80 hover:text-white text-sm transition-colors">
                                Нууц үгээ мартсан уу?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-white text-indigo-600 py-3 rounded-lg font-semibold btn-hover transition-all duration-300 mb-4">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Нэвтрэх
                    </button>

                    <!-- Social Login (Optional - implement if needed) -->
                    <div class="relative mb-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-transparent text-white/70">Эсвэл үргэлжлүүлэх</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" class="flex items-center justify-center px-4 py-2 border border-white/20 rounded-lg text-white/80 hover:bg-white/10 transition-all duration-300">
                            <i class="fab fa-google mr-2"></i>Google
                        </button>
                        <button type="button" class="flex items-center justify-center px-4 py-2 border border-white/20 rounded-lg text-white/80 hover:bg-white/10 transition-all duration-300">
                            <i class="fab fa-facebook mr-2"></i>Facebook
                        </button>
                    </div>
                </form>

                <!-- Register Form -->
                <form id="registerForm" class="form-panel hidden" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Field -->
                    <div class="input-container relative mb-6">
                        <input
                            id="registerName"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-gray-500 transition-all duration-300"
                            placeholder="Бүтэн нэр"
                            required
                            autocomplete="name"
                        >
                        <label for="registerName" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                            <i class="fas fa-user mr-2"></i>Бүтэн нэр
                        </label>
                        @error('name')
                            <div class="text-red-300 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="input-container relative mb-6">
                        <input
                            id="registerEmail"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-gray-500 transition-all duration-300"
                            placeholder="Имэйл"
                            required
                            autocomplete="username"
                        >
                        <label for="registerEmail" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                            <i class="fas fa-envelope mr-2"></i>Имэйл хаяг
                        </label>
                        @error('email')
                            <div class="text-red-300 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="input-container relative mb-4">
                        <input
                            id="registerPassword"
                            type="password"
                            name="password"
    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-white/40 input-focus transition-all duration-300 @error('password') border-red-500 @enderror"
                            placeholder="Нууц үг"
                            required
                            autocomplete="new-password"
                        >
                        <label for="registerPassword" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                            <i class="fas fa-lock mr-2"></i>Нууц үг
                        </label>
                        <button type="button" class="absolute right-3 top-3 text-white/70 hover:text-white transition-colors" onclick="togglePassword('registerPassword')">
                            <i class="fas fa-eye" id="registerPasswordIcon"></i>
                        </button>
                        @error('password')
                            <div class="text-red-300 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="mb-6">
                        <div class="password-strength bg-gray-300" id="passwordStrength"></div>
                        <div class="flex justify-between text-xs text-white/70 mt-1">
                            <span>Сул</span>
                            <span>Хүчтэй</span>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="input-container relative mb-6">
                        <input
                            id="registerPasswordConfirm"
                            type="password"
                            name="password_confirmation"
    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-white/40 input-focus transition-all duration-300 @error('password') border-red-500 @enderror"
                            placeholder="Нууц үг баталгаажуулах"
                            required
                            autocomplete="new-password"
                        >
                        <label for="registerPasswordConfirm" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                            <i class="fas fa-lock mr-2"></i>Нууц үг баталгаажуулах
                        </label>
                        <div class="error-message text-red-300 text-sm mt-1 hidden" id="passwordMismatch">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Нууц үг таарахгүй байна
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-white text-indigo-600 py-3 rounded-lg font-semibold btn-hover transition-all duration-300">
                        <i class="fas fa-user-plus mr-2"></i>
                        Бүртгэл үүсгэх
                    </button>
                </form>

                <!-- Reset Password Form -->
                <form id="resetForm" class="form-panel hidden" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="text-center mb-6">
                        <i class="fas fa-key text-4xl text-white/80 mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Нууц үг сэргээх</h3>
                        <p class="text-white/70 text-sm">Сэргээх заавар авахын тулд имэйл хаягаа оруулна уу</p>
                    </div>

                    <!-- Email Field -->
                    <div class="input-container relative mb-6">
                        <input
                            id="resetEmail"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-transparent focus:outline-none focus:border-white/40 input-focus transition-all duration-300 @error('email') border-red-500 @enderror"
                            placeholder="Имэйл"
                            required
                            autocomplete="username"
                        >
                        <label for="resetEmail" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                            <i class="fas fa-envelope mr-2"></i>Имэйл хаяг
                        </label>
                        @error('email')
                            <div class="text-red-300 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-white text-indigo-600 py-3 rounded-lg font-semibold btn-hover transition-all duration-300 mb-4">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Сэргээх холбоос илгээх
                    </button>

                    <!-- Back to Login -->
                    <button type="button" class="w-full text-white/80 hover:text-white py-2 text-sm transition-colors" onclick="showLoginForm()">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Нэвтрэх хэсэг рүү буцах
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-white/60 text-sm">
            <p>&copy; 2025 Таны компани. Бүх эрх хуулиар хамгаалагдсан.</p>
        </div>
    </div>

    <script>
        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab-btn');
        const forms = document.querySelectorAll('.form-panel');

        // Initialize based on current route
        document.addEventListener('DOMContentLoaded', function() {
            initializeFormBasedOnRoute();
        });

        function initializeFormBasedOnRoute() {
            const currentPath = window.location.pathname;

            if (currentPath.includes('/register')) {
                switchToForm('registerForm');
                updateActiveTab(document.getElementById('registerTab'));
            } else if (currentPath.includes('/forgot-password')) {
                switchToForm('resetForm');
                updateActiveTab(document.getElementById('resetTab'));
            } else if (currentPath.includes('/reset-password')) {
                // For reset-password route, redirect to separate page
                // This will be handled by a separate view
                switchToForm('loginForm');
                updateActiveTab(document.getElementById('loginTab'));
            } else {
                // Default to login form
                switchToForm('loginForm');
                updateActiveTab(document.getElementById('loginTab'));
            }
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetForm = tab.id.replace('Tab', 'Form');
                switchToForm(targetForm);
                updateActiveTab(tab);

                // Update URL without page reload (optional)
                const newPath = getPathForForm(targetForm);
                if (newPath && window.history && window.history.pushState) {
                    window.history.pushState({}, '', newPath);
                }
            });
        });

        function getPathForForm(formId) {
            switch(formId) {
                case 'loginForm':
                    return '/login';
                case 'registerForm':
                    return '/register';
                case 'resetForm':
                    return '/forgot-password';
                default:
                    return null;
            }
        }

        function switchToForm(formId) {
            forms.forEach(form => {
                form.classList.add('hidden');
            });
            document.getElementById(formId).classList.remove('hidden');
        }

        function updateActiveTab(activeTab) {
            tabs.forEach(tab => {
                tab.classList.remove('bg-white/20');
                tab.classList.add('text-white/70');
            });
            activeTab.classList.add('bg-white/20');
            activeTab.classList.remove('text-white/70');
            activeTab.classList.add('text-white');
        }

        function showResetForm() {
            switchToForm('resetForm');
            updateActiveTab(document.getElementById('resetTab'));
        }

        function showLoginForm() {
            switchToForm('loginForm');
            updateActiveTab(document.getElementById('loginTab'));
        }

        // Password visibility toggle
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + 'Icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        document.getElementById('registerPassword').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strength = calculatePasswordStrength(password);

            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = `password-strength ${strength.class}`;
        });

        function calculatePasswordStrength(password) {
            let score = 0;
            if (password.length >= 8) score += 25;
            if (/[a-z]/.test(password)) score += 25;
            if (/[A-Z]/.test(password)) score += 25;
            if (/[0-9]/.test(password)) score += 12.5;
            if (/[^A-Za-z0-9]/.test(password)) score += 12.5;

            let className = 'bg-red-500';
            if (score >= 75) className = 'bg-green-500';
            else if (score >= 50) className = 'bg-yellow-500';
            else if (score >= 25) className = 'bg-orange-500';

            return { percentage: score, class: className };
        }

        // Password confirmation validation
        document.getElementById('registerPasswordConfirm').addEventListener('input', function(e) {
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = e.target.value;
            const errorMsg = document.getElementById('passwordMismatch');

            if (confirmPassword && password !== confirmPassword) {
                errorMsg.classList.remove('hidden');
            } else {
                errorMsg.classList.add('hidden');
            }
        });

        // Custom checkbox functionality
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkIcon = this.parentElement.querySelector('.checkbox-check');
                const checkBg = this.parentElement.querySelector('.checkbox-bg');

                if (this.checked) {
                    checkIcon.style.opacity = '1';
                    checkBg.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                } else {
                    checkIcon.style.opacity = '0';
                    checkBg.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
                }
            });
        });

        // Initialize checkboxes on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                const checkIcon = checkbox.parentElement.querySelector('.checkbox-check');
                const checkBg = checkbox.parentElement.querySelector('.checkbox-bg');
                if (checkIcon && checkBg) {
                    checkIcon.style.opacity = '1';
                    checkBg.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                }
            });
        });

        // Smooth animations on load
        window.addEventListener('load', function() {
            document.querySelector('.glass-effect').style.animation = 'fadeIn 0.6s ease-in';
        });
    </script>
</body>
</html>
