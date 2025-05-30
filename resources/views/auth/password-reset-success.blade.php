<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нууц үг амжилттай сэргээгдлээ</title>
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
        .success-animation {
            animation: successPulse 2s ease-in-out infinite;
        }
        @keyframes successPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Main Container -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl fade-in text-center">
            <!-- Success Icon -->
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg success-animation">
                <i class="fas fa-check text-3xl text-white"></i>
            </div>

            <!-- Success Message -->
            <h1 class="text-2xl font-bold text-white mb-4">Амжилттай!</h1>
            <p class="text-white/90 text-lg mb-2">Таны нууц үг амжилттай шинэчлэгдлээ</p>
            <p class="text-white/70 text-sm mb-8">Та одоо шинэ нууц үгээрээ нэвтэрч болно</p>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="{{ route('login') }}" class="block w-full bg-white text-indigo-600 py-3 rounded-lg font-semibold btn-hover transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Нэвтрэх хэсэг рүү очих
                </a>

                <a href="{{ url('/') }}" class="block w-full text-white/80 hover:text-white py-2 text-sm transition-colors border border-white/20 rounded-lg hover:bg-white/10">
                    <i class="fas fa-home mr-2"></i>
                    Нүүр хуудас руу буцах
                </a>
            </div>

            <!-- Security Note -->
            <div class="mt-8 p-4 bg-black/20 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-shield-alt text-yellow-400 mr-3 mt-1"></i>
                    <div class="text-left">
                        <h4 class="text-white/90 text-sm font-medium mb-1">Аюулгүй байдлын зөвлөмж</h4>
                        <p class="text-white/70 text-xs">
                            Хэрэв та энэ үйлдлийг хийгээгүй бол нэн даруй манай дэмжлэгийн багтай холбогдоно уу.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-white/60 text-sm">
            <p>&copy; 2024 Таны компани. Бүх эрх хуулиар хамгаалагдсан.</p>
        </div>
    </div>

    <script>
        // Auto redirect to login after 10 seconds (optional)
        let countdown = 10;
        const redirectTimer = setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                window.location.href = "{{ route('login') }}";
                clearInterval(redirectTimer);
            }
        }, 1000);

        // Smooth animations on load
        window.addEventListener('load', function() {
            document.querySelector('.glass-effect').style.animation = 'fadeIn 0.6s ease-in';
        });
    </script>
</body>
</html>
