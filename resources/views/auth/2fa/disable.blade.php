{{-- @extends('vr-content.user.vsapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Disable Two-Factor Authentication') }}</div>

                <div class="card-body">
                    <p>Please confirm your password to disable two-factor authentication:</p>

                    <form method="POST" action="{{ route('2fa.disable') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Disable Two-Factor Authentication') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}



<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Хоёр түвшний баталгаажуулалт унтраах</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
        }

        .disable-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .warning-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .warning-icon::before {
            content: '⚠️';
            font-size: 32px;
        }

        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 40px 30px;
        }

        .warning-section {
            background: linear-gradient(135deg, #fef3c7, #fcd34d);
            border: 2px solid #f59e0b;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .warning-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f59e0b, #d97706, #f59e0b);
            animation: warningPulse 2s infinite;
        }

        @keyframes warningPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .warning-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .warning-title::before {
            content: '🚨';
            margin-right: 10px;
            font-size: 1.4rem;
        }

        .warning-list {
            color: #92400e;
            font-weight: 500;
            line-height: 1.6;
        }

        .warning-list li {
            margin-bottom: 8px;
            position: relative;
            padding-left: 25px;
        }

        .warning-list li::before {
            content: '•';
            color: #f59e0b;
            font-size: 1.5rem;
            position: absolute;
            left: 0;
            top: -2px;
        }

        .confirmation-text {
            text-align: center;
            color: #374151;
            margin-bottom: 30px;
            font-size: 1.1rem;
            line-height: 1.5;
            padding: 20px;
            background: #f3f4f6;
            border-radius: 12px;
            border-left: 4px solid #6b7280;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .form-input.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-message::before {
            content: '⚠️';
            margin-right: 8px;
        }

        .checkbox-container {
            margin: 25px 0;
            padding: 20px;
            background: #fef2f2;
            border: 2px solid #fecaca;
            border-radius: 12px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .checkbox-input {
            margin-top: 4px;
            transform: scale(1.2);
            accent-color: #dc2626;
        }

        .checkbox-label {
            color: #991b1b;
            font-weight: 500;
            line-height: 1.5;
            cursor: pointer;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .cancel-btn {
            flex: 1;
            padding: 16px 24px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cancel-btn:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(107, 114, 128, 0.3);
            color: white;
            text-decoration: none;
        }

        .disable-btn {
            flex: 1;
            padding: 16px 24px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            opacity: 0.5;
            pointer-events: none;
        }

        .disable-btn.enabled {
            opacity: 1;
            pointer-events: auto;
        }

        .disable-btn.enabled:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
        }

        .disable-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .disable-btn.enabled:hover::before {
            left: 100%;
        }

        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .disable-btn.submitting .loading {
            display: inline-block;
        }

        .disable-btn.submitting {
            pointer-events: none;
            opacity: 0.8;
        }

        .security-info {
            background: #eff6ff;
            border: 2px solid #dbeafe;
            border-radius: 12px;
            padding: 20px;
            margin-top: 25px;
            text-align: center;
        }

        .security-info::before {
            content: '💡';
            font-size: 1.5rem;
            display: block;
            margin-bottom: 10px;
        }

        .security-info p {
            color: #1e40af;
            font-weight: 500;
            margin: 0;
        }

        @media (max-width: 480px) {
            .container {
                max-width: 100%;
                margin: 0 10px;
            }

            .card-header {
                padding: 30px 20px;
            }

            .card-body {
                padding: 30px 20px;
            }

            .warning-section {
                padding: 20px 15px;
            }

            .button-group {
                flex-direction: column;
            }

            .cancel-btn, .disable-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="disable-card">
            <div class="card-header">
                <div class="warning-icon"></div>
                <h1>Хоёр түвшний баталгаажуулалт унтраах</h1>
                <p>Аюулгүй байдлын тохиргоог өөрчлөх</p>
            </div>

            <div class="card-body">
                <div class="warning-section">
                    <div class="warning-title">Анхааруулга!</div>
                    <ul class="warning-list">
                        <li>Таны дэнс илүү эмзэг болно</li>
                        <li>Зөвхөн нууц үгээр хамгаалагдана</li>
                        <li>Хулгайлагч илүү амархан нэвтэрч чадна</li>
                        <li>Мэдээллийн аюулгүй байдал буурна</li>
                    </ul>
                </div>

                <div class="confirmation-text">
                    Хоёр түвшний баталгаажуулалтыг унтраахын тулд одоогийн нууц үгээ оруулна уу
                </div>

                <form id="disableForm" method="POST" action="{{ route('2fa.disable') }}">
                    @csrf
                    <div class="form-group">
                        <label for="password" class="form-label">Одоогийн нууц үг</label>
                        <input
                            id="password"
                            type="password"
                            class="form-input"
                            name="password"
                            required
                            placeholder="Нууц үгээ оруулна уу"
                        >
                        <div id="password-error" class="error-message" style="display: none;">
                            Нууц үг оруулна уу
                        </div>
                    </div>

                    <div class="checkbox-container">
                        <div class="checkbox-wrapper">
                            <input
                                type="checkbox"
                                id="confirm-disable"
                                class="checkbox-input"
                                required
                            >
                            <label for="confirm-disable" class="checkbox-label">
                                Би хоёр түвшний баталгаажуулалтыг унтрааснаар миний дэнсний аюулгүй байдал
                                багасахыг ойлгож байгаа бөгөөд үүнтэй холбоотой бүх эрсдэлийг хүлээн зөвшөөрч байна.
                            </label>
                        </div>
                    </div>

                    <div class="button-group">
                        <a href="/security" class="cancel-btn">
                            ↩️ Буцах
                        </a>
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <button type="submit" class="btn btn-primary" id="disableBtn">

                            <span class="loading"></span>
                            <span class="btn-text">🔓 Унтраах</span>
                        </button>
                    </div>
                </form>

                <div class="security-info">
                    <p>
                        <strong>Зөвлөгөө:</strong> Хоёр түвшний баталгаажуулалт нь таны дэнсийг
                        хамгийн сайн хамгаалдаг арга юм. Унтраахын өмнө сайн бодоорой.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        const form = document.getElementById('disableForm');
        const passwordInput = document.getElementById('password');
        const confirmCheckbox = document.getElementById('confirm-disable');
        const disableBtn = document.getElementById('disableBtn');
        const passwordError = document.getElementById('password-error');

        // Enable/disable submit button based on checkbox
        function updateButtonState() {
            if (confirmCheckbox.checked && passwordInput.value.trim().length > 0) {
                disableBtn.classList.add('enabled');
            } else {
                disableBtn.classList.remove('enabled');
            }
        }

        confirmCheckbox.addEventListener('change', updateButtonState);
        passwordInput.addEventListener('input', function() {
            updateButtonState();

            // Clear error state when user starts typing
            if (passwordInput.classList.contains('error')) {
                passwordInput.classList.remove('error');
                passwordError.style.display = 'none';
            }
        });

        // Form submission with double confirmation
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const password = passwordInput.value.trim();

            if (password.length === 0) {
                showError('Нууц үг оруулна уу');
                return;
            }

            if (!confirmCheckbox.checked) {
                alert('Та эрсдэлийг хүлээн зөвшөөрөх ёстой');
                return;
            }

            // Double confirmation dialog
            const confirmMessage = `
Та итгэлтэй байна уу?

Хоёр түвшний баталгаажуулалтыг унтраавал:
• Таны дэнс илүү эмзэг болно
• Зөвхөн нууц үгээр хамгаалагдана
• Аюулгүй байдал мэдэгдэхүйц буурна

Үргэлжлүүлэх үү?`;

            if (!confirm(confirmMessage)) {
                return;
            }

            // Final confirmation
            if (!confirm('Үнэхээр унтраах уу? Энэ үйлдлийг буцааж болно.')) {
                return;
            }

            // Show loading state
            disableBtn.classList.add('submitting');
            disableBtn.querySelector('.btn-text').textContent = '🔄 Унтрааж байна...';

            // Simulate API call
            setTimeout(() => {
                // Simulate random success/failure
                const isSuccess = Math.random() > 0.2;

                if (isSuccess) {
                    // Success
                    disableBtn.querySelector('.btn-text').textContent = '✅ Амжилттай унтраалаа!';
                    disableBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';

                    setTimeout(() => {
                        window.location.href = '/security';
                    }, 1500);
                } else {
                    // Error
                    if (Math.random() > 0.5) {
                        showError('Буруу нууц үг');
                    } else {
                        alert('Серверийн алдаа гарлаа. Дахин оролдоно уу.');
                    }
                    resetSubmitButton();
                }
            }, 2000);
        });

        function showError(message) {
            passwordInput.classList.add('error');
            passwordError.textContent = message;
            passwordError.style.display = 'flex';
            passwordInput.focus();
            passwordInput.select();
        }

        function resetSubmitButton() {
            disableBtn.classList.remove('submitting');
            disableBtn.querySelector('.btn-text').textContent = '🔓 Унтраах';
        }

        // Focus password input on page load
        window.addEventListener('load', function() {
            passwordInput.focus();
        });

        // Add some dramatic effect to warning section
        setInterval(() => {
            const warningSection = document.querySelector('.warning-section');
            warningSection.style.transform = 'scale(1.02)';
            setTimeout(() => {
                warningSection.style.transform = 'scale(1)';
            }, 200);
        }, 5000);
    </script> --}}
</body>
</html>
