{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
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
    <title>Нууц үг сэргээх - Laravel Authentication</title>
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
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
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
                    <i class="fas fa-key text-2xl text-indigo-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Нууц үг сэргээх</h1>
                <p class="text-white/80 text-sm">Шинэ нууц үгээ оруулна уу</p>
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

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password reset token -->
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Field (Pre-filled) -->
                <div class="input-container relative mb-6">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $email ?? '') }}"
    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-gray-500 transition-all duration-300"
                        placeholder="Имэйл"
                        required
                        autocomplete="username"
                        readonly
                    >
                    <label for="email" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                        <i class="fas fa-envelope mr-2"></i>Имэйл хаяг
                    </label>
                    @error('email')
                        <div class="text-red-300 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- New Password Field -->
                <div class="input-container relative mb-4">
                    <input
                        id="password"
                        type="password"
                        name="password"
    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-white/40 input-focus transition-all duration-300 @error('password') border-red-500 @enderror"
                        placeholder="Шинэ нууц үг"
                        required
                        autocomplete="new-password"
                    >
                    <label for="password" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                        <i class="fas fa-lock mr-2"></i>Шинэ нууц үг
                    </label>
                    <button type="button" class="absolute right-3 top-3 text-white/70 hover:text-white transition-colors" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="passwordIcon"></i>
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
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-black placeholder-transparent focus:outline-none focus:border-white/40 input-focus transition-all duration-300 @error('password') border-red-500 @enderror"
                        placeholder="Нууц үг баталгаажуулах"
                        required
                        autocomplete="new-password"
                    >
                    <label for="password_confirmation" class="floating-label absolute left-4 top-3 text-white/70 pointer-events-none">
                        <i class="fas fa-lock mr-2"></i>Нууц үг баталгаажуулах
                    </label>
                    <button type="button" class="absolute right-3 top-3 text-white/70 hover:text-white transition-colors" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="password_confirmationIcon"></i>
                    </button>
                    <div class="error-message text-red-300 text-sm mt-1 hidden" id="passwordMismatch">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Нууц үг таарахгүй байна
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="mb-6 p-3 bg-black/20 rounded-lg">
                    <h4 class="text-white/90 text-sm font-medium mb-2">Нууц үгийн шаардлага:</h4>
                    <ul class="text-white/70 text-xs space-y-1">
                        <li class="flex items-center" id="length-req">
                            <i class="fas fa-times text-red-400 mr-2 w-3"></i>
                            Дор хаяж 8 тэмдэгт
                        </li>
                        <li class="flex items-center" id="lowercase-req">
                            <i class="fas fa-times text-red-400 mr-2 w-3"></i>
                            Жижиг үсэг (a-z)
                        </li>
                        <li class="flex items-center" id="uppercase-req">
                            <i class="fas fa-times text-red-400 mr-2 w-3"></i>
                            Том үсэг (A-Z)
                        </li>
                        <li class="flex items-center" id="number-req">
                            <i class="fas fa-times text-red-400 mr-2 w-3"></i>
                            Тоо (0-9)
                        </li>
                        <li class="flex items-center" id="special-req">
                            <i class="fas fa-times text-red-400 mr-2 w-3"></i>
                            Тусгай тэмдэгт (@, #, $, гэх мэт)
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-white text-indigo-600 py-3 rounded-lg font-semibold btn-hover transition-all duration-300 mb-4">
                    <i class="fas fa-save mr-2"></i>
                    Нууц үг шинэчлэх
                </button>

                <!-- Back to Login -->
                <a href="{{ route('login') }}" class="block w-full text-center text-white/80 hover:text-white py-2 text-sm transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Нэвтрэх хэсэг рүү буцах
                </a>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-white/60 text-sm">
            <p>&copy; 2024 Таны компани. Бүх эрх хуулиар хамгаалагдсан.</p>
        </div>
    </div>

    <script>
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

        // Password strength checker and requirements validator
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strength = calculatePasswordStrength(password);

            // Update strength bar
            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = `password-strength ${strength.class}`;

            // Update requirements
            updatePasswordRequirements(password);
        });

        function calculatePasswordStrength(password) {
            let score = 0;
            if (password.length >= 8) score += 20;
            if (/[a-z]/.test(password)) score += 20;
            if (/[A-Z]/.test(password)) score += 20;
            if (/[0-9]/.test(password)) score += 20;
            if (/[^A-Za-z0-9]/.test(password)) score += 20;

            let className = 'bg-red-500';
            if (score >= 80) className = 'bg-green-500';
            else if (score >= 60) className = 'bg-yellow-500';
            else if (score >= 40) className = 'bg-orange-500';

            return { percentage: score, class: className };
        }

        function updatePasswordRequirements(password) {
            const requirements = [
                { id: 'length-req', test: password.length >= 8 },
                { id: 'lowercase-req', test: /[a-z]/.test(password) },
                { id: 'uppercase-req', test: /[A-Z]/.test(password) },
                { id: 'number-req', test: /[0-9]/.test(password) },
                { id: 'special-req', test: /[^A-Za-z0-9]/.test(password) }
            ];

            requirements.forEach(req => {
                const element = document.getElementById(req.id);
                const icon = element.querySelector('i');

                if (req.test) {
                    icon.className = 'fas fa-check text-green-400 mr-2 w-3';
                } else {
                    icon.className = 'fas fa-times text-red-400 mr-2 w-3';
                }
            });
        }

        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = e.target.value;
            const errorMsg = document.getElementById('passwordMismatch');

            if (confirmPassword && password !== confirmPassword) {
                errorMsg.classList.remove('hidden');
            } else {
                errorMsg.classList.add('hidden');
            }
        });

        // Initialize email field label position
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput.value) {
                const label = emailInput.nextElementSibling;
                label.style.transform = 'translateY(-24px) scale(0.85)';
                label.style.color = '#667eea';
            }
        });

        // Smooth animations on load
        window.addEventListener('load', function() {
            document.querySelector('.glass-effect').style.animation = 'fadeIn 0.6s ease-in';
        });
    </script>
</body>
</html>
